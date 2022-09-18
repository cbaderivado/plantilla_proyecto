<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Postulacion;
use Illuminate\Http\Request;

class ControladorNosotros extends Controller
{
    public function index()
    {
            return view ("web.nosotros");
    }
    public function guardarPostulacion(Request $request)
    {
                
        $postulacion=new Postulacion();
        $postulacion->cargarDesdeRequest($request);
        $postulacion->insertar();
      return redirect()->route('nosotros.gracias');
        
    }
    public function gracias()
    {
            return view ("web.gracias");
    }
}
