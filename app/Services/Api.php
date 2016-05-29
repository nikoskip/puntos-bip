<?php

namespace PuntosBip\Services;

use PuntosBip\Models\PuntoBip;

class Api
{

    /**
     * Obtiene los Puntos Bip! de acuerdo ciertas coordenadas
     * @param $lat
     * @param $lon
     * @return mixed
     */
    public function getPuntosBipByLocation($lat, $lon) {
        $records = PuntoBip::getPuntosBipByLocation($lat, $lon, config('app.radio_busqueda'));
        foreach ($records as &$record) {
            $record->servicios = $this->resolveServiciosBitmask($record->servicios);
        }
        return $records;
    }

    /**
     * Retorna los servicios asociados al valor bitmask del Punto Bip!
     * @param $serviceValue
     * @return array
     */
    private function resolveServiciosBitmask($serviceValue) {
        $services = array();
        foreach (PuntoBip::$servicesBitmask as $bit => $service) {
            if ($serviceValue & $bit) {
                $services[] = $service;
            }
        }
        return $services;
    }
}