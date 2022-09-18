<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
USE App\Entidades\Producto;

class ControladorTakeaway extends Controller
{
    public function index()
    {
        $producto=new Producto();
        $aProductos=$producto->obtenerTodos();
            return view ("web.takeaway",compact('aProductos'));
    }
}
