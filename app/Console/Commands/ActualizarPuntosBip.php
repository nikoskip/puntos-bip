<?php

namespace PuntosBip\Console\Commands;

use Illuminate\Console\Command;
use PuntosBip\Services\ApiConsumerService;

class ActualizarPuntosBip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'puntosbip:actualizar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza los Puntos Bip! consultando la API de datos.gob.cl';

    /**
     * Servicio para consumir API que entrega Puntos Bip!
     *
     * @var ApiConsumerService
     */
    protected $apiConsumer;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ApiConsumerService $apiConsumer)
    {
        parent::__construct();
        $this->apiConsumer = $apiConsumer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo $this->apiConsumer->getApiEndpoint();
    }
}
