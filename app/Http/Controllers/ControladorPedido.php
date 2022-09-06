<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo pedido";
        $sucursal= new Sucursal();
        $aSucursales=$sucursal->obtenerTodos();
        $estado= new Estado();
        $aEstados=$estado->obtenerTodos();
        $cliente= new Cliente();
        $aClientes=$cliente->obtenerTodos();

        return view('pedido.pedido-nuevo', compact('titulo','aSucursales','aClientes','aEstados'));
           
    }
    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->descripcion == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }

                $_POST["id"] = $entidad->idcliente;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        $titulo = "Nuevo pedido";
        $sucursal= new Sucursal();
        $aSucursales=$sucursal->obtenerTodos();
        $estado= new Estado();
        $aEstados=$estado->obtenerTodos();
        $cliente= new Cliente();
        $aClientes=$cliente->obtenerTodos();
        return view('pedido.pedido-nuevo', compact('titulo','aSucursales','aClientes','aEstados'));
    }

}

