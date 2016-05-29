<?php

namespace PuntosBip\Http\Controllers;

use Illuminate\Http\Request;

use PuntosBip\Http\Requests;

class PuntosBipController extends Controller
{
    public function home() {
        return view('home');
    }
}
