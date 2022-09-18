<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Sucursal;
use GrahamCampbell\ResultType\Success;

class ControladorWebHome extends Controller
{
    public function index()
    {
        $asucursal=new Sucursal()    ;
        $aSucursales=$asucursal->obtenerTodos();
        return view ("web.inicio",compact('aSucursales'));
    }
}
