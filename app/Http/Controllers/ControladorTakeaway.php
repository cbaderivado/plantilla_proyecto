<?php

namespace App\Http\Controllers;

USE App\Entidades\Producto;
use Illuminate\Http\Request;
use App\Entidades\Carrito;
use App\Entidades\Cliente;


class ControladorTakeaway extends Controller
{
    public function index()
    {
        $producto=new Producto();
        $aProductos=$producto->obtenerTodos();
            return view ("web.takeaway",compact('aProductos'));
    }
   
}
