<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Cliente extends Model
{
    protected $table = 'clientes';
    public $timestamps = false;

    protected $fillable = [
                            'idcliente',
                            'nombre',
                            'apellido',
                            'dni', 
                            'celular',
                            'correo', 
                            'clave'
        
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idcliente = $request->input('id')!= "0" ? $request->input('id') : $this->idcliente;
        $this->nombre =$request->input('txtNombre');
        $this->apellido = $request->input('txtApellido');
        $this->dni = $request->input('txtDni');
        $this->celular =  $request->input('txtCelular');
        $this->correo = $request->input('txtCorreo');
        $this->clave = $request->input('txtClave');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idusuario',
            1 => 'A.nombre',
            2 => 'A.apellido',
            3 => 'A.dni',
            4 => 'A.celular',
            5 => 'A.correo',
            6 => 'A.clave'
        );
        $sql = "SELECT 
                A.idusuario,
                A.nombre,
                A.apellido,
                A.dni,
                A.celular,
                A.correo,
                A.clave
                FROM clientes A
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.apellido LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.dni LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


    public function encriptarClave($clave){
        $claveEncriptada = password_hash($clave, PASSWORD_DEFAULT);
        return $claveEncriptada;
    }

    public function validarClave($claveIngresada, $claveBBDD){
        return password_verify($claveIngresada, $claveBBDD);
    }

     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO clientes (
                    nombre,
                    apellido,
                    dni, 
                    celular,
                    correo, 
                    clave
                    ) VALUES (?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    $this->apellido,
                    $this->dni,
                    $this->celular,
                    $this->correo,
                    $this->clave
                    ]);

            return $this->idcliente = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE clientes SET
            nombre='$this->nombre',
            apellido='$this->apellido',
            dni='$this->dni',
            celular='$this->celular',
            correo='$this->corre',
            clave='$this->clave'
            WHERE idcliente= ?"; 
        $affected = DB::update($sql, [$this->idcliente]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idcliente,
                A.nombre,
                A.apellido,
                A.dni,
                A.celular,
                A.correo,
                A.clave
                FROM clientes A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                A.nombre,
                A.apellido,
                A.dni,
                A.celular,
                A.correo,
                A.clave
                FROM clientes A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);

        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            $this->apellido=$lstRetorno[0]->apellido;
            $this->dni=$lstRetorno[0]->dni;
            $this->celular=$lstRetorno[0]->celular;
            $this->correo=$lstRetorno[0]->correo;
            $this->clave=$lstRetorno[0]->clave;
            return $lstRetorno[0];
        }
        return null;
    }

  
    public function obtenerPorIdcliente($idCliente){
        $sql = "SELECT
                A.nombre,
                A.apellido,
                A.dni,
                A.celular,
                A.correo,
                A.clave
                FROM clientes A
                WHERE A.idcliente = '$idCliente'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            $this->apellido=$lstRetorno[0]->apellido;
            $this->dni=$lstRetorno[0]->dni;
            $this->celular=$lstRetorno[0]->celular;
            $this->correo=$lstRetorno[0]->correo;
            $this->clave=$lstRetorno[0]->clave;
            return $lstRetorno[0];
        }
        return null;
        
    }

}

?>