<?php

namespace App\Http\Controllers;

use App\Entidades\Sucursal; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller
{
    public function nuevo()
    {
        $titulo = "Nueva sucursal";
        
        return view('sucursal.sucursal-nuevo', compact('titulo'));
           
    }

}
