<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Ciente extends Model
{
    protected $table = 'sucursales';
    public $timestamps = false;

    protected $fillable = [
                            'idsucursal',
                            'nombre',
                            'direccion',
                            'telefono', 
                            'linkmapa'
        
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idsucursal = $request->input('id')!= "0" ? $request->input('id') : $this->idsucursal;
        $this->nombre =$request->input('txtNombre');
        $this->direccion = $request->input('txtDireccion');
        $this->telefono = $request->input('txtTelefono');
        $this->linkmapa =  $request->input('txtLinkMapa');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idsucural',
            1 => 'A.nombre',
            2 => 'A.direccion',
            3 => 'A.telefono',
            4 => 'A.linkmapa'
        );
        $sql = "SELECT 
                A.idsucural,
                A.nombre,
                A.direccion,
                A.telefono,
                A.linkmapa
                FROM sucursales A
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.direccion LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO sucursales (
                    nombre,
                    direccion,
                    telefono, 
                    linkmapa
                    ) VALUES (?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    $this->apellido,
                    $this->dni,
                    $this->celular,
                    $this->correo,
                    $this->clave
                    ]);

            return $this->idsucural = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE sucusales SET
            nombre='$this->nombre',
            direccion='$this->direcicon',
            telefono='$this->telefono',
            linkmapa='$this->linkmapa'
            WHERE idsuursal= ?"; 
        $affected = DB::update($sql, [$this->idsucursal]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
        A.idsucural,
        A.nombre,
        A.direccion,
        A.telefono,
        A.linkmapa
        FROM sucursales A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT 
                A.idsucural,
                A.nombre,
                A.direccion,
                A.telefono,
                A.linkmapa
                FROM sucursales A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            $this->direccion=$lstRetorno[0]->direccion;
            $this->telefono=$lstRetorno[0]->telefono;
            $this->limkmapa=$lstRetorno[0]->linkmapa;
            return $lstRetorno[0];
        }
        return null;
    }

  
    public function obtenerPorIdSucursal($idSucursal){
        $sql = "SELECT 
        A.idsucural,
        A.nombre,
        A.direccion,
        A.telefono,
        A.linkmapa
        FROM sucursales A
                WHERE A.idsucursal = '$idSucursal'";
            $lstRetorno = DB::select($sql);
            if(count($lstRetorno)>0){
                $this->nombre=$lstRetorno[0]->nombre;
                $this->direccion=$lstRetorno[0]->direccion;
                $this->telefono=$lstRetorno[0]->telefono;
                $this->limkmapa=$lstRetorno[0]->linkmapa;
                return $lstRetorno[0];
        }
        return null;
        
    }

}

?>
