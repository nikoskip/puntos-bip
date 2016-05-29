<?php

namespace PuntosBip\Console\Commands;

use Illuminate\Console\Command;
use Log;
use DB;
use PuntosBip\Services\ApiConsumer;
use PuntosBip\Models\PuntoBip;

class ActualizarPuntosBipApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'puntosbip:actualizar-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los Puntos Bip! consultando la API';

    /**
     * Servicio para consumir API que entrega Puntos Bip!
     *
     * @var ApiConsumer
     */
    protected $apiConsumer;

    /**
     * Listado de recursos desde donde se obtienen los Puntos Bip! en la API
     *
     * @var array
     */
    protected $apiResources;

    /**
     * Create a new command instance.
     *
     * @param ApiConsumer $apiConsumer
     */
    public function __construct(ApiConsumer $apiConsumer)
    {
        parent::__construct();

        $this->apiConsumer = $apiConsumer;
        $this->apiResources = config('app.api_resources');
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

        // Verificamos que la API sea accesible
        $this->info('Verificando conectividad con API...');
        if (!$this->apiConsumer->checkApiConnection()) {
            $this->error('No es posible comunicarse con la API, finaliza proceso.');
            die;
        }

        $this->info('Existe conectividad con la API!');

        foreach ($this->apiResources as $resource) {
            $this->info('Consultando: ' . $resource['name']);
            if (($puntosBip = $this->apiConsumer->getResource($resource['resource_id'])) !== false) {
                $this->info('Actualizando Puntos Bip! de ' . $resource['name'] . '. Registros en API ' . $this->apiConsumer->getTotal() . '. Registros obtenidos: ' . count($puntosBip));
                foreach ($puntosBip as $punto) {
                    $punto = (array) $punto;

                    // Hay casos en que un registro viene casi vacío, basta preguntar si tiene código para validarlo
                    if (empty($punto['CODIGO'])) {
                        continue;
                    }

                    $PuntoBip = new PuntoBip();
                    $PuntoBip->codigo = $punto['CODIGO'];
                    $PuntoBip->nombre = isset($punto['NOMBRE FANTASIA']) ? $punto['NOMBRE FANTASIA'] : null;
                    $PuntoBip->entidad = $punto['ENTIDAD'];
                    $PuntoBip->direccion = $punto['DIRECCION'];
                    $PuntoBip->comuna = $punto['COMUNA'];
                    $PuntoBip->horario = isset($punto['HORARIO REFERENCIAL']) ? $punto['HORARIO REFERENCIAL'] : null;
                    $PuntoBip->lat = $punto['LATITUD'];
                    $PuntoBip->lon = $punto['LONGITUD'];
                    $PuntoBip->servicios = array_sum($resource['services']);
                    $PuntoBip->fuente = PuntoBip::FUENTE_API;
                    $PuntoBip->save();
                }
            } else {
                $this->warn('Ocurrió un problema al obtener los datos del recurso "' . $resource['name'] . '". Lo más seguro por timeout esperando a la API.');
            }
        }

        // Ahora eliminamos todos los Puntos Bip! creados antes de la fecha en que se ejecutó el proceso y sean importados
        // mediante la API.
        $this->info('Eliminando Puntos Bip! antiguos (< ' . $date . ').');
        // Todo: controlar casos en que se obtenga Puntos Bip! de manera incompleta, por pérdida de conexión con la API
        DB::table('punto_bip')->where('created_at', '<', $date)->where('fuente', '=', PuntoBip::FUENTE_API)->delete();

        $this->info('Finaliza proceso para actualizar Puntos Bip!');
    }
}
