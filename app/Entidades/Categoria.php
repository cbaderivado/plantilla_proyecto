<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Exception;
use Session;
require app_path().'/start/constants.php';

class Categoria extends Model
{
    protected $table = 'categorias';
    public $timestamps = false;

    protected $fillable = [
                            'idcategoria',
                            'nombre'
        
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idcategoria = $request->input('id')!= "0" ? $request->input('id') : $this->idcategoria;
        $this->nombre =$request->input('txtNombre');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idcategoria',
            1 => 'A.nombre'
        );
        $sql = "SELECT 
                A.idcategoria,
                A.nombre
                FROM categorias A
                WHERE 1=1";
        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }
     public function insertar() {
            $sql = "INSERT INTO categorias (
                    nombre
                    ) VALUES (?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    ]);

            return $this->idcategoria = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE categorias SET
            nombre='$this->nombre'
            WHERE idcategoria= ?"; 
        $affected = DB::update($sql, [$this->idcategoria]);
    }
    public function obtenerTodos() {
        $sql = "SELECT 
                A.idcategoria,
                A.nombre,
                FROM categorias A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                A.nombre
                FROM categorias A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
    }
    public function obtenerPorId($idCategoria){
        $sql = "SELECT
              
                A.nombre
                FROM categorias A
                WHERE A.idcategoria = '$idCategoria'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->idcategoria=$idCategoria;
            $this->nombre=$lstRetorno[0]->nombre;
            return $lstRetorno[0];
        }
        return null;
        
    }
    public function eliminar()
    {
        
            $sql = "DELETE FROM categorias WHERE
            idcategoria=?";
            
        DB::delete($sql, [$this->idcategoria]);
        
    }

}
