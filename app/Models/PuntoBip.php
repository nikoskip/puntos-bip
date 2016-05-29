<?php

namespace PuntosBip\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PuntoBip extends Model
{
    const FUENTE_API = 'api';
    const FUENTE_FILE = 'file';

    /**
     * Bitmask-values de tipos de servicio que un Punto Bip! puede ofrecer
     */
    const SERVICE_CARGA = 1;
    const SERVICE_VENTA_TARJETA = 2;
    const SERVICE_CONSULTA_SALDO = 4;
    const SERVICE_CARGA_REMOTA = 8;
    const SERVICE_REMPLAZO_TARJETA = 16;
    const SERVICE_RECUPERACION_TARJETA = 32;

    protected $table = 'punto_bip';

    /**
     * Retorna los Puntos Bip! cercanos a la ubicación enviada y en un radio dado. Se utiliza la formula "Haversine"
     * para obtener los Puntos Bip!.
     * @param $lat
     * @param $lon
     * @param $radius
     * @return mixed
     */
    public static function fintPuntosBipByLocation($lat, $lon, $radius) {
        return DB::table('punto_bip')
            ->select(DB::raw("nombre, direccion, comuna, servicios, ( 6371000 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lon ) - radians($lon) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance"))
            ->having('distance', '<', $radius)
            ->orderBy('distance', 'asc')
            ->get();
    }
}
