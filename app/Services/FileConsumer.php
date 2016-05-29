<?php

namespace PuntosBip\Services;

use GuzzleHttp;
use Log;
use Exception;
use Maatwebsite\Excel\Facades\Excel;

class FileConsumer
{
    /**
     * Cliente HTTP para consultar la API
     * @var GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * Nombre del archivo
     * @var string
     */
    protected $fileName;

    /**
     * Ruta del archivo
     * @var string
     */
    protected $filePath;

    /**
     * URL del archivo
     * @var string
     */
    protected $fileURL;


    public function __construct(GuzzleHttp\Client $guzzle) {
        $this->guzzle = $guzzle;
    }

    public function setFileURL($url) {
        $this->fileURL = $url;
    }

    public function setFileName($name) {
        $this->fileName = $name;
    }

    /**
     * Obtiene el recurso y devuelve los registros encontrados
     * @return array|bool
     */
    public function getResource() {
        $this->buildFileName();
        if ($this->downloadFile()) {
            $records = $this->parseFile();
            return count($records) ? $records : false;
        }

        return false;
    }

    /**
     * Verifica que el recurso exista y sea un XLS
     * @return bool
     */
    public function checkResource() {
        try {
            $request = $this->guzzle->request('HEAD', $this->fileURL);
            return $request->getStatusCode() === 200 && $request->getHeaderLine('content-type') === 'application/vnd.ms-excel';
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Descarga el archivo
     * @return bool
     */
    private function downloadFile() {
        try {
            $file = file_get_contents($this->fileURL);
            $this->filePath = storage_path('app/private/' . $this->fileName . '.xls');
            file_put_contents($this->filePath, $file);
        } catch (Exception $e) {
            Log::error('Error al descargar: ' . $this->fileURL . '. ' . $e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Arma el nombre del archivo a guardar
     * @return string
     */
    private function buildFileName() {
        $this->fileName = $this->fileName . '-' . date('Y-m-d');
    }

    /**
     * Parsea el archivo obteniendo los registros existentes
     * @return array
     */
    private function parseFile() {
        $records = array();
        Excel::load($this->filePath, function($reader) use (&$records) {
            $isRecord = false;
            $headers = array();
            foreach ($reader->get()->toArray() as $row) {
                // Vamos a recorrer los datos hasta encontrar la fila con los encabezados
                if ($row[1] === 'CODIGO') {
                    // Almacenamos los nombres de los encabezados
                    $headers = array_filter($row);
                    // Dejamos $isRecord en true ya que la siguiente fila será un registro
                    $isRecord = true;
                    continue;
                }

                // Es un registro mientras $isRecord = true y la fila tenga valores
                $record = array_filter($row);
                if ($isRecord && count($record)) {
                    $record = array_combine($headers, $record);
                    $records[] = array_map(get_class() . '::cleanRecordValue', $record);
                }
            }
        });

        return $records;
    }

    /**
     * Limpia el valor enviado
     * @param $value
     * @return mixed
     */
    public static function cleanRecordValue($value) {
        return preg_replace('/\r|\n/', ' ', $value );
    }

}