<?php

namespace App\Http\Controllers;

use App\Entidades\Categoria; //include_once "app/Entidades/Sistema/Menu.php";
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller
{
    public function nuevo()
    {
        $titulo = "Nueva categoria";
        
        return view('categoria.categoria-nuevo', compact('titulo'));
           
    }

}
