<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
        $aPedidos=new Pedido();

        return view('pedido.pedido-nuevo', compact('titulo','aSucursales','aClientes','aEstados','aPedidos'));
           
    }
    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new Pedido();
            $entidad->cargarDesdeRequest($request);
            $_POST["id"]=$entidad->idpedido;
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
        $aPedidos=$cliente->obtenerTodos();
        return view('pedido.pedido-nuevo', compact('titulo','aSucursales','aPedidos','aEstados'));
    }
    public function index()
    {
        $titulo = "Pedido";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pedido.pedido-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedido/nuevo/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fecha . '</a>';
            $row[] = $aPedidos[$i]->descripcion;
            $row[] = $aPedidos[$i]->sucursal;
            $row[] = $aPedidos[$i]->cliente;
            $row[] = $aPedidos[$i]->estado;
            $row[] = $aPedidos[$i]->estadoPago;
            $row[] = $aPedidos[$i]->total;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($id)
    {
        $titulo = "Modificar pedido";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pedido = new pedido();
                $aPedidos=$pedido->obtenerPorId($id);
                $sucursal= new Sucursal();
                $aSucursales=$sucursal->obtenerTodos();
                $estado= new Estado();
                $aEstados=$estado->obtenerTodos();
                $cliente= new Cliente();
                $aClientes=$cliente->obtenerTodos();;
               

                return view('pedido.pedido-nuevo', compact('titulo','aPedidos','aSucursales','aEstados','aClientes'));
            }
        } else {
            return redirect('admin/login');
        }
        
    }
    public function eliminar(Request $request)
    {
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("MENUELIMINAR")) {

                $entidad = new Pedido();
                $entidad->cargarDesdeRequest($request);
                try {
                    $entidad->eliminar();
                    $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
                } catch (QueryException $e) {

                    $aResultado["err"] = $e->getMessage();
                }
            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
}

