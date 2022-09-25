<?php

namespace App\Http\Controllers;


use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ControladorCliente;


class ControladorMiCuenta extends Controller
{
    public function index()
    {
        $cliente=new Cliente();
        if($this->clienteLogueado()){
            $cliente=new Cliente();
            $cliente=$cliente->obtenerPorId(session::get('idcliente'));
            $pedido=new Pedido();
            $aPedidos=$cliente!=false? $pedido->obtenerPorIdCliente(session::get('idcliente')):'';
            return view ("web.mi-usuario",compact('cliente','aPedidos'));
        }else{
            
            return view ("web.mi-cuenta",compact('cliente'));
        }
        
        
    }
    public function ingresar(Request $request)
    {
        
        $cliente=new Cliente();
        $cliente=$cliente->login($request->input('txtCorreo'),$request->input('txtPassword'));
        $pedido=new Pedido();
        $aPedidos=$cliente!=false? $pedido->obtenerPorIdCliente($cliente->idcliente):'';
        
        if(!$cliente){
                        $titulo = 'Acceso denegado';
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "Credenciales incorrectas";
                        return view("web.mi-cuenta", compact('titulo', 'msg'));
                    
        }elseif($request->input('paginaPrevia')=='/takeaway'){
            session::put('idcliente',$cliente->idcliente);
            $producto=new Producto();
            $aProductos=$producto->obtenerTodos();
        
            return view ("web.takeaway",compact('cliente','aProductos'));
        }
        
        else {
            session::put('idcliente',$cliente->idcliente);
            return view ("web.mi-usuario",compact('cliente','aPedidos'));
        }
        
        
        
    }
    public function salir()
    {
        if($this->clienteLogueado()){
            session::forget('idcliente');
        }
        return view ("web.sesionCerrada");
        
    }
    private function clienteLogueado()
        {
            if(session::get('idcliente')!=NULL){
                return true;
            
            }else{
                return false;
            }
        }
    public function actualizarClave(Request $request)
    {
        $cliente=new Cliente();
        $cliente->obtenerPorId(session::get('idcliente'));
        //print_r($cliente); exit;
        $claveValida=$cliente->validarClave($request->input('txtClaveActual'), $cliente->clave);
        
        if(!$claveValida){
                        $titulo = 'Datos incorrectos';
                        $msg["ESTADO"] = MSG_ERROR;
                        $msg["MSG"] = "La clave actual es incorrecta";
                        return view("web.cambiar-contraseña", compact('titulo', 'msg'));
                    
        }else{
            $cliente->clave=$cliente->encriptarClave($request->input('txtClaveNueva'));
            $cliente->guardar();
            session::forget('idcliente');
            return view ("web.clave-actualizada");
        }

    }
    public function indexActualizarDatos(){
        $cliente=new Cliente();
        $cliente=$cliente->obtenerPorId(session::get('idcliente'));         
        return view('web.actualizar-datos',compact('cliente'));
    }
    public function actualizarDatos(Request $request)
    {
        $cliente=new Cliente();
        $cliente->cargarDesdeRequest($request);
        
        if ($cliente->nombre == "" ) {
        
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
        } elseif($cliente->correoDuplicado($cliente->correo)){
            
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "El correo ya fue registrado";}
        else{
            $cliente->guardarDatos();
            session::forget('idcliente');
            return view ("web.datos-actualizados");
            
        }
        return view ("web.actualizar-datos",compact('cliente', 'msg'));

    }

    public function cambiarContraseña(){
        return view('web.cambiar-contraseña');
    }
}


