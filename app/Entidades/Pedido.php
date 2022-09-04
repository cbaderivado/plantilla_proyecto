<?php

namespace App\Entidades\Sistema;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Ciente extends Model
{
    protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [
                            'idpedido',
                            'fecha',
                            'descripcion',
                            'fk_idsucursal',
                            'fk_idcliente',
                            'fk_idestado',
                            'fk_idestadopago',
                            'total'
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idpedido = $request->input('id')!= "0" ? $request->input('id') : $this->idpedido;
        $this->fecha =$request->input('txtFecha');
        $this->descripcion=$request->input('txtDescripcion');
        $this->fk_idsucursal = $request->input('txtSucursal');
        $this->fk_idcliente =  $request->input('txtCliente');
        $this->fk_idestado = $request->input('txtEstado');
        $this->fk_idestadopago = $request->input('txtEstadoPago');
        $this->total = $request->input('txtTotal');
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpedido',
            1 => 'A.fecha',
            2 => 'A.descripcion',
            3 => 'A.fk_idsucursal',
            4 => 'A.fk_idcliente',
            5 => 'A.fk_idestado',
            5 => 'A.fk_idestadopago',
            6 => 'A.total'
        );
        $sql = "SELECT 
                A.idpedido,
                A.fecha,
                A.descripcion,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado,
                A.fk_idestadopago,
                A.total
                FROM pedidos A
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.descripcion LIKE '%" . $request['search']['value'] . "%' ";
            $sql.=" OR A.total LIKE '%" . $request['search']['value'] . "%' )";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO pedidos (
                    fecha,
                    descripcion,
                    fk_idsucursal,
                    fk_idcliente,
                    fk_idestado,
                    fk_idestadopago,
                    total
                    ) VALUES (?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->fecha,
                    $this->descripcion,
                    $this->fk_idsucursal,
                    $this->fk_idestado,
                    $this->fk_idestadopago,
                    $this->total
                    ]);

            return $this->idpedido = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE pedidos SET
            nombre='$this->fecha',
            descripcion='$this->descripcion',
            fk_idsucursal='$this->fk_idsucursal',
            fk_idestado='$this->fk_idestado',
            fk_idestadopago='$this->fk_idestadopago',
            total='$this->total'
            WHERE idpedido= ?"; 
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idpedido,
                A.fecha,
                A.descripcion,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado,
                A.fk_idestadopago,
                A.total
                FROM pedidos A;";

        $sql .= " ORDER BY A.fecha";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    // public function obtenerPorNombre($nombre) {
    //     $sql = "SELECT
    //             A.nombre,
    //             A.apellido,
    //             A.dni,
    //             A.celular,
    //             A.correo,
    //             A.clave
    //             FROM clientes A
    //             WHERE A.nombre = '$nombre'";
    //     $lstRetorno = DB::select($sql);
    //     if(count($lstRetorno)>0){
    //         $this->nombre=$lstRetorno[0]->nombre;
    //         $this->apellido=$lstRetorno[0]->apellido;
    //         $this->dni=$lstRetorno[0]->dni;
    //         $this->celular=$lstRetorno[0]->celular;
    //         $this->correo=$lstRetorno[0]->correo;
    //         $this->clave=$lstRetorno[0]->clave;
    //         return $lstRetorno[0];
    //     }
    //     return null;
    // }

  
    public function obtenerPorIdPedido($idPedido){
        $sql = "SELECT
                A.idpedido,
                A.fecha,
                A.descripcion,
                A.fk_idsucursal,
                A.fk_idcliente,
                A.fk_idestado,
                A.fk_idestadopago,
                A.total
                FROM pedido A
                WHERE A.idpedido = '$idPedido'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->fecha=$lstRetorno[0]->fecha;
            $this->descripcion=$lstRetorno[0]->descripcion;
            $this->fk_idsucursal=$lstRetorno[0]->fk_idsucursal;
            $this->fk_idcliente=$lstRetorno[0]->fk_idcliente;
            $this->fk_idestado=$lstRetorno[0]->fk_idestado;
            $this->fk_idestadopago=$lstRetorno[0]->fk_idestadopago;
            $this->total=$lstRetorno[0]->total;
            return $lstRetorno[0];
        }
        return null;
        
    }

}

?>
