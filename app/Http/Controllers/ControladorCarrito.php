<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use app\start\contants;
use App\Entidades\Carrito;
use App\Entidades\Producto;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sucursal;
use Illuminate\Support\Facades\Date;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\List_;

class ControladorCarrito extends Controller
{
    public function index(Request $request)
    {
    
        if(session::get('idcliente')!=NULL){
            $producto=new Producto();
            $cliente=new Cliente();
            $sucursal=new Sucursal();
            $aSucursales=$sucursal->obtenerTodos();
            $carrito=new Carrito();
            if(session::get('idcarrito')!=NULL){
                
                $carrito=$carrito->obtenerPorIdCarrito(session::get('idcarrito'));
                $producto=$producto->obtenerPorId($carrito->fk_idproducto);
                $cliente=$cliente->obtenerPorId($carrito->fk_idcliente);
            }else{
                $producto=$producto->obtenerPorId($request->input('txtProducto'));
                $cliente=$cliente->obtenerPorId($request->input('txtCliente'));
                $carrito->cargarDesdeRequest($request);
                $carrito->insertar();
                session::put('idcarrito',$carrito->idcarrito);
            }
            $totales=$this->calcularTotales($carrito,$producto);
            return view ("web.carrito",compact('carrito','producto','cliente','totales','aSucursales'));
        }
        else{ return view('web.mi-cuenta');}
    }
    public function guardarPedido(Request $request)
    {
        //te debo usar la API de Mercado pago   
        $carrito=new Carrito();
        $carrito=$carrito->obtenerPorIdCarrito($request->input('id'));
     
        $producto=new Producto();
        $producto=$producto->obtenerPorId($carrito->fk_idproducto);
        $cliente=new Cliente();
        $cliente=$cliente->obtenerPorId($carrito->fk_idcliente);
        $totales=$this->calcularTotales($carrito,$producto);
        if($request->input('lstSucursal')==NULL || $request->input('lstMedioDePago')==NULL){
          
            $sucursal=new Sucursal();
            $aSucursales=$sucursal->obtenerTodos();
            $msg["MSG"] = "Debe seleccionar una sucursal de retiro y medio de pago";
            return view("web.carrito", compact( 'msg','carrito','producto','cliente','totales','aSucursales'));}
          

                $pedido=new Pedido();
                $pedido->fecha=Date('Y-m-d H:i:s');
                $pedido->descripcion="Carrito ID: ".$request->input('id');
        $pedido->fk_idsucursal=$request->input('lstSucursal');
        $pedido->fk_idcliente=$carrito->fk_idcliente;
        $pedido->fk_idestado=EN_PREPARACION;
        $pedido->fk_idestadopago=PENDIENTE;
        
        $pedido->total=$totales["total"];
        $pedido->insertar();
        session::forget('idcarrito');
        return view('web.pedido-guardado');
    

    }
    public function cancelarPedido(Request $request)
    {
        
    $carrito=new Carrito();
    $carrito->cargarDesdeRequest($request);
    $carrito->eliminar($request->input('idcarrito'));
    session::forget('idcarrito');
    return view ('web.carrito');
    }
    private function calcularTotales( $carrito, $producto)
    {
        $totales=array();
        $totales['subtotal']=$carrito->cantidad * $producto->precio;
        $totales['impuestos']=$totales['subtotal'] * 21 / 100;
        $totales['total']=$totales['subtotal'] + $totales['impuestos'];
        return $totales;
    }
}

