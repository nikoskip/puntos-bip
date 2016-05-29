<?php

namespace PuntosBip\Http\Controllers\Api;

use Illuminate\Http\Request;

use PuntosBip\Http\Requests;
use PuntosBip\Http\Controllers\Controller;
use PuntosBip\Models\PuntoBip;
use PuntosBip\Services\GoogleMapsConsumer;
use Response;

class PuntosBipApiController extends Controller {

    /**
     * Request
     * @var Request
     */
    protected $request;

    /**
     * @var GoogleMapsConsumer
     */
    protected $gMapsConsumer;

    protected $dataResponse = array('status' => 'ok', 'results' => array());

    public function __construct(Request $request, GoogleMapsConsumer $gMapsConsumer) {
        $this->request = $request;
        $this->gMapsConsumer = $gMapsConsumer;
    }

    /**
     * Retorna Puntos Bip! para una dirección dada
     * @return mixed
     */
    public function getByAddress() {
        // Validamos que venga "address" como parámetro
        $address = $this->validateRequiredParamater('address');

        // Consultamos la dirección a la API de Google Maps
        $data = $this->gMapsConsumer->getAddress($address);

        // Si retorna false, se puede deber a muchos motivos, pero vamos a encapsular por el momento el error
        // como que la dirección no fue encontrada
        if ($data === false) {
            $this->dataResponse['status'] = 'invalid';
            $this->dataResponse['error_message'] = 'La dirección no fue encontrada';
            return Response::json($this->dataResponse, 400);
        }

        // Obtenemos los Puntos Bip!
        return $this->getByLocation($data['lat'], $data['lon']);
    }

    /**
     * Retorna Puntos Bip! para las cordenadas dadas
     * @param decimal $lat
     * @param decmial $lon
     * @return mixed
     */
    public function getByLocation($lat = null, $lon = null) {
        // Validamos que venga "lat" como parámetro
        $lat = $this->validateRequiredParamater('lat', $lat);
        // Validamos que venga "lat" como parámetro
        $lon = $this->validateRequiredParamater('lon', $lon);

        // Obtenemos los Puntos Bip!
        $this->dataResponse['results'] = PuntoBip::fintPuntosBipByLocation($lat, $lon, config('app.radio_busqueda'));

        return Response::json($this->dataResponse, 200);
    }

    /**
     * Valida que el parámetro enviado exista
     * @param $parameter
     * @param null $default
     * @return array|null|string
     */
    private function validateRequiredParamater($parameter, $default = null) {
        $parameter = $this->request->input($parameter) !== null ? $this->request->input($parameter) : $default;
        if (empty($parameter)) {
            $this->dataResponse['status'] = 'invalid';
            $this->dataResponse['error_message'] = 'Parámetro "' . $parameter . '" no encontrado';
            Response::json($this->dataResponse, 400)->send();
        }
        return $parameter;
    }

}