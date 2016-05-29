<?php

namespace PuntosBip\Models;

use Illuminate\Database\Eloquent\Model;

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
}
