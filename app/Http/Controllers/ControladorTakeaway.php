<?php

namespace App\Http\Controllers;

USE App\Entidades\Producto;
use Illuminate\Http\Request;
use App\Entidades\Carrito;


class ControladorTakeaway extends Controller
{
    public function index()
    {
        $producto=new Producto();
        $aProductos=$producto->obtenerTodos();
            return view ("web.takeaway",compact('aProductos'));
    }
    public function llenarCarrito(Request $request)
    {
        if($request->input('txtCliente')!=0){
            $carrito=new Carrito();
            $carrito->cargarDesdeRequest($request);
            $carrito->insertar();
            return view ("web.carrito",compact('carrito'));
        }
        else{ return view('web.mi-cuenta');}
        
    }

}
