<?php

namespace PuntosBip\Services;

use GuzzleHttp;

class GoogleMapsConsumer
{
    /**
     * Cliente HTTP para consultar la API
     * @var GuzzleHttp\Client
     */
    protected $guzzle;

    private $apiURL = 'http://maps.google.com/maps/api/geocode/json';

    public function __construct(GuzzleHttp\Client $guzzle) {
        $this->guzzle = $guzzle;
    }

    /**
     * Consulta la API de Google Maps para obtener la dirección formateada y las coordenadas
     * @param $address
     * @return array|bool
     */
    public function getAddress($address) {
        try {
            $url = $this->apiURL . '?address=' . $address . '&region=cl&=sensor = false';
            $request = $this->guzzle->request('GET', $url, ['connect_timeout' => config('app.api_timeout'), 'timeout' => config('app.api_timeout')]);

            // Revisamos que la respuesta sea un JSON (application/json, text/json, etc)
            if ($request->getStatusCode() === 200 && strpos($request->getHeaderLine('content-type'), '/json')) {
                $data = json_decode($request->getBody());
                if ($data->status === 'OK') {
                    return array(
                        'formatted_address' => $data->results[0]->formatted_address,
                        'lat' => $data->results[0]->geometry->location->lat,
                        'lon' => $data->results[0]->geometry->location->lng,
                    );
                }
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }
}
