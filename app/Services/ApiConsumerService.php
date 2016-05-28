<?php

namespace PuntosBip\Services;

use GuzzleHttp;
Use Illuminate\Contracts\Config\Repository;

class ApiConsumerService
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

    public function __construct(GuzzleHttp\Client $guzzle) {
        $this->apiEndpoint = config('app.api_endpoint');
    }

    public function getApiEndpoint()
    {
        return $this->apiEndpoint;
    }
}