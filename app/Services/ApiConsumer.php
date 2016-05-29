<?php

namespace PuntosBip\Services;

use GuzzleHttp;
use Log;
use Exception;

class ApiConsumer
{

    /**
     * Cliente HTTP para consultar la API
     * @var GuzzleHttp\Client
     */
    protected $guzzle;

    /**
     * @var string
     */
    protected $apiEndpoint;

    /**
     * Resultados de Puntos Bip! obtenidos desde la API
     * @var array
     */
    private $records = array();

    /**
     * Cantidad de Puntos Bip! obtenidos
     * @var int
     */
    private $total;

    /**
     * Define cuantos items entrega por página la API
     * @var int
     */
    private $offset;

    public function __construct(GuzzleHttp\Client $guzzle) {
        $this->guzzle = $guzzle;
        $this->apiEndpoint = config('app.api_endpoint');
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }

    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Verifica que la URL de la API sea accesible
     * @return bool
     */
    public function checkApiConnection()
    {
        try {
            $request = $this->guzzle->request('GET', $this->apiEndpoint, ['connect_timeout' => config('app.api_timeout'), 'timeout' => config('app.api_timeout')]);
            return $request->getStatusCode() === 200;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Llama al recurso indicado y retorna un JSON con los datos obtenidos o false en caso de error. Si existe
     * paginación para el recurso, este método se llama de forma recursiva hasta obtener todos los registros.
     *
     * @param $resource
     * @param int $offset
     * @return bool
     */
    public function getResource($resource, $offset = 0) {
        $resourceUrl = $this->apiEndpoint . '/action/datastore_search?resource_id=' . $resource;

        // Si existe un offset lo agregamos a la llamada
        if ($offset > 0) {
            $resourceUrl .= '&offset=' . $offset;
        } else {
            // Si el offset es 0 significa que es la primera llamada a un recurso, aprovechamos esta instancia
            // para resetear valores de paginacion y dejar en 0 los registros que pudieron haber quedado de llamadas
            // a recursos anteriores
            $this->resetConsumer();
        }

        // Si por algún motivo el $offset es mayor que el total de registros a obtener, entramos en un loop. No debería
        // suceder, pero mejor prevenir
        if ($offset > $this->total) {
            Log::error('Se entró en un loop al obtener Puntos Bip!. ¿Cambió la respuesta de la API?. Total: ' . $this->total . ' URL: ' . $resourceUrl);
            return false;
        }

        try {
            Log::info('Llamando ' . $resourceUrl);
            $request = $this->guzzle->request('GET', $resourceUrl, ['connect_timeout' => config('app.api_timeout'), 'timeout' => config('app.api_timeout')]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        // Revisamos que la respuesta sea un JSON (application/json, text/json, etc)
        if ($request->getStatusCode() === 200 && strpos($request->getHeaderLine('content-type'), '/json')) {
            $data = json_decode($request->getBody());

            // Comprobamos que la respuesta es exitosa desde la API
            if (isset($data->success) && $data->success) {
                if ($this->total === null) {
                    $this->configurePagination($data->result);
                }

                // Guardamos los registros obtenidos
                $this->records = array_merge($this->records, $data->result->records);

                // Si la cantidad de registros que tenemos es menor al total existente en la API debemos volver
                // a llamar a la API de manera recursiva hasta obtenerlos todos, ya que la API pagina los resultados
                if (count($this->records) < $this->total) {
                    // Al parecer si realizo muchas llamadas seguidas a la API se atora o me bloquea
                    sleep(1);
                    $this->getResource($resource, $offset + $this->offset);
                }
            }
        }

        return count($this->records) ? $this->records : false;
    }

    /**
     * Hace un reset de los valores de paginación para que las futuras llamadas
     * en la misma instancia funcionen desde 0
     * @return array
     */
    private function resetConsumer() {
        $this->total = null;
        $this->offset = null;
        $this->records = array();
    }

    /**
     * Se encarga de configurar las variables necesarias para poder obtener resultados que son paginados
     *
     * @param $result
     */
    private function configurePagination($result) {
        // Guardamos el total si existe en la respuesta. Solo existe en llamadas sin offset
        $this->total = isset($result->total) ? $result->total : $this->total;

        // Guardamos el offset que define la API para paginar resultados
        parse_str(parse_url($result->_links->next)['query'], $query);
        $this->offset = $this->offset === null ? $query['offset'] : $this->offset;
    }

}