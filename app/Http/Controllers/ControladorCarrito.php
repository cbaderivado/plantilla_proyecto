<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Cliente;
use App\Entidades\Sucursal;

class ControladorCarrito extends Controller
{
    public function index(Request $request)
    {
       
        if($request->input('txtCliente')!=0){
            $carrito=new Carrito();
            $producto=new Producto();
            $producto=$producto->obtenerPorId($request->input('txtProducto'));
            $cliente=new Cliente();
            $cliente=$cliente->obtenerPorId($request->input('txtCliente'));
            $sucursal=new Sucursal();
            $aSucursales=$sucursal->obtenerTodos();
            $carrito->cargarDesdeRequest($request);
            $carrito->insertar();
            $cantidad=$request->input('txtCantidad');
            $subtotal=$cantidad * $producto->precio;
            $impuestos=$subtotal * 21 / 100;
            $total=$subtotal + $impuestos;
            return view ("web.carrito",compact('carrito','producto','cliente','cantidad','subtotal','impuestos','total','aSucursales'));
        }
        else{ return view('web.carrito');}
    }
    public function guardarPedido(Request $request)
    {
    
    }
}
