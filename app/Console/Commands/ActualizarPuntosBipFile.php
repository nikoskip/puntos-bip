<?php

namespace PuntosBip\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;
use PuntosBip\Services\FileConsumer;
use PuntosBip\Models\PuntoBip;

class ActualizarPuntosBipFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'puntosbip:actualizar-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los Puntos Bip! descargando e importando archivos XLS';

    /**
     * Servicio para consumir archivos XLS con Puntos Bip!
     *
     * @var
     */
    protected $fileConsumer;

    /**
     * Listado de recursos desde donde se obtienen los archivos Puntos Bip!
     *
     * @var array
     */
    protected $fileResources;


    /**
     * Create a new command instance.
     *
     * @param FileConsumer $fileConsumer
     */
    public function __construct(FileConsumer $fileConsumer)
    {
        parent::__construct();
        $this->fileConsumer = $fileConsumer;
        $this->fileResources = config('app.file_resources');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Almacenamos la hora actual en que se ejecutó el proceso
        $date = date('Y-m-d H:i:s');

        $this->info('Se inicia proceso para actualizar Puntos Bip!');

        foreach ($this->fileResources as $key =>$resource) {
            $this->fileConsumer->setFileURL($resource['resource_file']);
            $this->fileConsumer->setFileName($key);
            $this->info('Descargando: ' . $resource['name'] . ' - ' . $resource['resource_file']);
            if ($this->fileConsumer->checkResource()) {
                if (($puntosBip = $this->fileConsumer->getResource()) !== false) {
                    $this->info('Actualizando Puntos Bip! de ' . $resource['name'] . '. Registros obtenidos: ' . count($puntosBip));
                    foreach ($puntosBip as $punto) {
                        $PuntoBip = new PuntoBip();
                        $PuntoBip->codigo = $punto['CODIGO'];
                        $PuntoBip->entidad = $punto['ENTIDAD'];
                        $PuntoBip->direccion = $punto['DIRECCION'];
                        $PuntoBip->comuna = $punto['COMUNA'];
                        $PuntoBip->horario = isset($punto['HORARIO']) ? $punto['HORARIO'] : null;
                        $PuntoBip->lat = $punto['LATITUD'];
                        $PuntoBip->lon = $punto['LONGITUD'];
                        $PuntoBip->servicios = array_sum($resource['services']);
                        $PuntoBip->fuente = PuntoBip::FUENTE_FILE;
                        $PuntoBip->save();
                    }
                } else {
                    $this->warn('Ocurrió un problema al obtener los datos del recurso "' . $resource['name'] . '".');
                }
            }
        }

        // Ahora eliminamos todos los Puntos Bip! creados antes de la fecha en que se ejecutó el proceso y sean importados
        // mediante un archivo
        $this->info('Eliminando Puntos Bip! antiguos (< ' . $date . ').');
        // Todo: controlar casos en que se obtenga Puntos Bip! de manera incompleta
        DB::table('punto_bip')->where('created_at', '<', $date)->where('fuente', '=', PuntoBip::FUENTE_FILE)->delete();

        $this->info('Finaliza proceso para actualizar Puntos Bip!');
    }
}
