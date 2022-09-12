<?php

namespace App\Http\Controllers;

use App\Entidades\Producto; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\TipoProducto; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo producto";
        $tipoproducto = new TipoProducto();
        $aTipoProductos=$tipoproducto->obtenerTodos();
        $producto=new Producto();
        
        return view('producto.producto-nuevo', compact('titulo','aTipoProductos','producto'));
           
    }
    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar producto";
            $entidad = new Producto();
            $entidad->cargarDesdeRequest($request);
            $_POST["id"] = $entidad->idproducto;
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

             
                return view('producto.producto-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }
        return view('producto.producto-nuevo', compact('titulo'));
    }
    public function index()
    {
        $titulo = "Producto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUCONSULTA")) {
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.producto-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }
    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Producto();
        $aProductos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/producto/nuevo/' . $aProductos[$i]->idproducto . '">' . $aProductos[$i]->nombre . '</a>';
            $row[] = $aProductos[$i]->descripcion;
            $row[] = $aProductos[$i]->tipoProducto;
            $row[] = $aProductos[$i]->precio;
            $row[] = $aProductos[$i]->cantidad;
            $row[] = $aProductos[$i]->imagen;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
    public function editar($id)
    {
        $titulo = "Modificar producto";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("MENUMODIFICACION")) {
                $codigo = "MENUMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto = new producto();
                $aProductos=$producto->obtenerPorId($id);
                
                $tipoproducto = new TipoProducto();
                $aTipoProductos=$tipoproducto->obtenerTodos();

                return view('producto.producto-nuevo', compact('producto', 'titulo','aProductos','aTipoProductos'));
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

                $entidad = new Producto();
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
