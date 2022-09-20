<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorRegistracion extends Controller
{
    public function index()
    {
            return view ("web.alta-cliente");
    }
    public function guardarCliente(Request $request)
    {
            $controladorCliente=new ControladorCliente();
            $controladorCliente->guardar($request);
            return redirect()->route('registracion.nuevoCliente');
    }
        
    public function nuevocliente()
    {
            return view ("web.nuevoCliente");
    }
}

