<?php

namespace App\Http\Controllers;


use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
use Session;

class ControladorMiCuenta extends Controller
{
    public function index()
    {
            return view ("web.mi-cuenta");
    }
    public function ingresar(Request $request)
    {
        $cliente=new Cliente();
        $cliente=$cliente->login($request->input('txtCorreo'),$request->input('txtPassword'));
        $pedido=new Pedido();
        $aPedidos=$cliente->idcliente!=false? $pedido->obtenerPorIdCliente($cliente->idcliente):'';
       // print_r($aPedidos);exit;
        if(!$cliente){
                        $titulo = 'Acceso denegado';
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Credenciales incorrectas";
                        return view("web.mi-cuenta", compact('titulo', 'msg'));
                    
        }else{return view ("web.mi-usuario",compact('cliente','aPedidos'));}
        
    }
    
}
