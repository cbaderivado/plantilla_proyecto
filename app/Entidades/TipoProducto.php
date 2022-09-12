<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class TipoProducto extends Model
{
    protected $table = 'tipo_productos';
    public $timestamps = false;

    protected $fillable = [
                            'idtiproducto',
                            'nombre'
        
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idtiproducto = $request->input('id')!= "0" ? $request->input('id') : $this->idtipoproducto;
        $this->nombre =$request->input('txtNombre');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idtiporpoducto',
            1 => 'A.nombre'
        );
        $sql = "SELECT 
                A.idtipoproducto,
                A.nombre
                FROM tipo_productos A
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
            $sql = "INSERT INTO tipo_productos (
                    nombre
                    ) VALUES (?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    ]);

            return $this->idestado = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE tipo_productos SET
            nombre='$this->nombre',
            WHERE idtipoproducto= ?"; 
        $affected = DB::update($sql, [$this->idtipoproducto]);
    }
    public function obtenerTodos() {
        $sql = "SELECT 
                A.idtipoproducto,
                A.nombre
                FROM tipo_productos A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                A.nombre
                FROM tipo_productos A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
    }
    public function obtenerPorId($idTipoProducto){
        $sql = "SELECT
                A.nombre
                FROM tipo_productos A
                WHERE A.idestado = '$idTipoProducto'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
        
    }

}

?>
