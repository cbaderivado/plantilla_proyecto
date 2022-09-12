<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Postulacion extends Model
{
    protected $table = 'postulaciones';
    public $timestamps = false;

    protected $fillable = [
                            'idpostulacion',
                            'nombre',
                            'apellido',
                            'localidad',
                            'documento',
                            'correo',
                            'telefono',
                            'archivo_cv'
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idpostulacion = $request->input('id')!= "0" ? $request->input('id') : $this->idpostulacion;
        $this->nombre=$request->input('txtNombre');
        $this->apellido=$request->input('txtApellido');
        $this->localidad = $request->input('txtLocalidad');
        $this->documento =  $request->input('txtDocumento');
        $this->correo = $request->input('txtCorreo');
        $this->telefono = $request->input('txtTelefono');
        $this->archivo_cv = $request->input('txtArchivoCv');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpostulacion',
            1 => 'A.nombre',
            2 => 'A.apellido',
            3 => 'A.localidad',
            4 => 'A.documento',
            5 => 'A.correo',
            5 => 'A.telefono',
            6 => 'A.archivo_cv'
        );
        $sql = "SELECT 
                A.idpostulacion,
                A.nombre,
                A.apellido,
                A.localidad,
                A.documento,
                A.correo,
                A.telefono,
                A.archivo_cv
                FROM postulaciones A
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR ( A.apellido LIKE '%" . $request['search']['value'] . "%' ) ";
            $sql.=" OR ( A.documento LIKE '%" . $request['search']['value'] . "%' )";
            $sql.=" OR ( A.correo LIKE '%" . $request['search']['value'] . "%' )";
            $sql.=" OR ( A.telefono LIKE '%" . $request['search']['value'] . "%' )";
            
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO postulaciones (
                        nombre,
                        apellido,
                        localidad,
                        documento,
                        correo,
                        telefono,
                        archivo_cv      
                    ) VALUES (?, ?, ?, ?, ?, ?,?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    $this->apellido,
                    $this->localidad,
                    $this->documento,
                    $this->correo,
                    $this->telefono,
                    $this->archivo_cv
                    ]);

            return $this->idpostulacion = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE postulaciones SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            localidad='$this->localidad',
            documento='$this->documento',
            correo='$this->correo',
            archivo_cv='$this->archivo_cv'
            WHERE idpostulacion= ?"; 
        $affected = DB::update($sql, [$this->idpostulacion]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idpostulacion,
                A.nombre,
                A.apellido,
                A.localidad,
                A.documento,
                A.correo,
                A.telefono,
                A.archivo_cv
                FROM postulaciones A;";

        $sql .= " ORDER BY A.apellido";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                A.idpostulacion,
                A.nombre,
                A.apellido,
                A.localidad,
                A.documento,
                A.correo,
                A.telefono,
                A.archivo_cv
                FROM postulaciones A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            $this->apellido=$lstRetorno[0]->apellido;
            $this->localidad=$lstRetorno[0]->localidad;
            $this->documento=$lstRetorno[0]->documento;
            $this->correo=$lstRetorno[0]->correo;
            $this->telefono=$lstRetorno[0]->telefono;
            $this->archivo_cv=$lstRetorno[0]->archivo_cv;
            return $lstRetorno[0];
        }
        return null;
    }

  
    public function obtenerPorId($idPostulacion){
        $sql = "SELECT
                A.idpostulacion,
                A.nombre,
                A.apellido,
                A.localidad,
                A.documento,
                A.correo,
                A.telefono,
                A.archivo_cv
                FROM postulaciones A
                WHERE A.idpostulacion = '$idPostulacion'";
            $lstRetorno = DB::select($sql);
            if(count($lstRetorno)>0){
                $this->idpostulacion=$lstRetorno[0]->idpostulacion;
                $this->nombre=$lstRetorno[0]->nombre;
                $this->apellido=$lstRetorno[0]->apellido;
                $this->localidad=$lstRetorno[0]->localidad;
                $this->documento=$lstRetorno[0]->documento;
                $this->correo=$lstRetorno[0]->correo;
                $this->telefono=$lstRetorno[0]->telefono;
                $this->archivo_cv=$lstRetorno[0]->archivo_cv;
                return $lstRetorno[0];
        }
        return null;
        
    }
    public function eliminar()
    {
            $sql = "DELETE FROM postulaciones WHERE
            idpostulacion=?";
        $affected = DB::delete($sql, [$this->idpostulacion]);
        
    }

}

?>

