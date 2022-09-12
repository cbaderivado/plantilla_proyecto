<?php

namespace App\Http\Controllers;

use App\Entidades\Estado; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

require app_path() . '/start/constants.php';

class ControladorEstado extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo estado";
        $estado=new Estado();
        
        return view('estado.estado-nuevo', compact('titulo','estado'));
           
    }
    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Estado";
            $entidad = new Estado();
            $entidad->cargarDesdeRequest($request);
            $_POST["id"] = $entidad->idestado;
            //validaciones
            if ($entidad->nombre == "") {
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

               
                return view('estado.estado-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }


        return view('estado.estado-nuevo', compact('titulo'));
    }
    public function index()
    {
        $titulo = "Estado";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('estado.estado-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Estado();
        $aEstados = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aEstados) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/estado/nuevo/' . $aEstados[$i]->idestado . '">' . $aEstados[$i]->nombre. '</a>';
            
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aEstados), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aEstados), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($id)
    {
        $titulo = "Modificar estado";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $estado = new estado();
                $estado->obtenerPorId($id);

                return view('estado.estado-nuevo', compact('estado', 'titulo'));
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

                $entidad = new Estado();
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
