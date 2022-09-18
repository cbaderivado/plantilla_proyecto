<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;

class ControladorRecuperar extends Controller
{
    public function index()
    {
            return view ("web.recuperar");
    }
    public function recuperar()
    {
            return view ("web.accesoNuevo");
    }
    
}
