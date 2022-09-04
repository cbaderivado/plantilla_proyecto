<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Ciente extends Model
{
    protected $table = 'estados';
    public $timestamps = false;

    protected $fillable = [
                            'idestado',
                            'nombre'
        
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idestado = $request->input('id')!= "0" ? $request->input('id') : $this->idestado;
        $this->nombre =$request->input('txtNombre');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idestado',
            1 => 'A.nombre'
        );
        $sql = "SELECT 
                A.idestado,
                A.nombre
                FROM estados A
                WHERE 1=1";
        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
     public function insertar() {
            $sql = "INSERT INTO estados (
                    nombre
                    ) VALUES (?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    ]);

            return $this->idestado = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE estados SET
            nombre='$this->nombre',
            WHERE idestado= ?"; 
        $affected = DB::update($sql, [$this->idestado]);
    }
    public function obtenerTodos() {
        $sql = "SELECT 
                A.idestado,
                A.nombre,
                FROM estados A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                A.nombre
                FROM estados A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
    }
    public function obtenerPorIdEstado($idEstado){
        $sql = "SELECT
                A.nombre
                FROM estados A
                WHERE A.idestado = '$idEstado'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
        
    }

}

?>
