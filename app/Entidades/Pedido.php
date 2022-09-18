<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Pedido extends Model
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
        //tomo el date que da el formulario, lo paso al formato de la base de datos y de ahi a string
        $this->fecha=date_format(date_create_from_format('Y-m-d',($request->input('txtfecha'))),'Y-m-d H:m:i');
        
        $this->descripcion=$request->input('txtDescripcion');
        $this->fk_idsucursal = $request->input('lstSucursal');
        $this->fk_idcliente =  $request->input('lstCliente');
        $this->fk_idestado = $request->input('lstEstado');
        $this->fk_idestadopago = $request->input('txtEstadoPago');
        $this->total = $request->input('txtTotal');
        
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idpedido',
            1 => 'A.fecha',
            2 => 'A.descripcion',
            3 => 'A.sucursal',
            4 => 'A.cliente',
            5 => 'A.estado',
            5 => 'A.estadopago',
            6 => 'A.total'
        );
        $sql = "SELECT 
                A.idpedido,
				DATE_FORMAT(A.fecha, '%d/%m/%Y') AS fecha,
                A.descripcion,
                B.nombre AS sucursal,
                CONCAT(C.nombre,' ',C.apellido) AS cliente,
                D.nombre AS estado,
                E.nombre AS estadoPago,
                A.total
                FROM pedidos A
                LEFT JOIN sucursales B ON A.fk_idsucursal=B.idsucursal
                LEFT JOIN clientes C ON A.fk_idcliente=C.idcliente
                LEFT JOIN estados D ON A.fk_idestado=D.idestado
                LEFT JOIN estado_pagos E ON A.fk_idestadopago=E.idestadopago
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( DATE_FORMAT(A.fecha, '%d/%m/%Y') LIKE '%" . $request['search']['value'] . "%' )";
            $sql.=" OR (A.descripcion LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (B.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (C.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (C.apellido LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (D.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (E.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR (A.total LIKE '%" . $request['search']['value'] . "%' )";
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
                    ) VALUES (?, ?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->fecha,
                    $this->descripcion,
                    $this->fk_idsucursal,
                    $this->fk_idcliente,
                    $this->fk_idestado,
                    $this->fk_idestadopago,
                    $this->total
                    ]);
           

            return $this->idpedido = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE pedidos SET
            fecha='$this->fecha',
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

    
  
    public function obtenerPorId($idPedido){
        $sql = "SELECT
                A.idpedido,
				A.fecha,
                A.descripcion,
                A.fk_idsucursal,
                B.nombre AS sucursal,
                A.fk_idcliente,
                CONCAT(C.nombre,' ',C.apellido) AS cliente,
                A.fk_idestado,
                D.nombre AS estado,
                A.fk_idestadopago,
                E.nombre AS estadoPago,
                A.total
                FROM pedidos A
                LEFT JOIN sucursales B ON A.fk_idsucursal=B.idsucursal
                LEFT JOIN clientes C ON A.fk_idcliente=C.idcliente
                LEFT JOIN estados D ON A.fk_idestado=D.idestado
                LEFT JOIN estado_pagos E ON A.fk_idestadopago=E.idestadopago
                
                WHERE A.idpedido = '$idPedido'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->idpedido=$idPedido;
            //Leo lo de la base y lo paso a formato que acepta el formulario
            $lstRetorno[0]->fecha=(date_create_from_format('Y-m-d H:m:s',$lstRetorno[0]->fecha))->format('Y-m-d');
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
    public function obtenerPorIdCliente($idCliente){
        $sql = "SELECT
				A.fecha,
                A.descripcion,
                B.nombre AS sucursal,
                D.nombre AS estado,
                E.nombre AS estadoPago,
                A.total
                FROM pedidos A
                LEFT JOIN sucursales B ON A.fk_idsucursal=B.idsucursal
                LEFT JOIN clientes C ON A.fk_idcliente=C.idcliente
                LEFT JOIN estados D ON A.fk_idestado=D.idestado
                LEFT JOIN estado_pagos E ON A.fk_idestadopago=E.idestadopago
                
                WHERE A.fk_idcliente = '$idCliente'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            //Leo lo de la base y lo paso a formato que acepta el formulario
            $lstRetorno[0]->fecha=(date_create_from_format('Y-m-d H:m:s',$lstRetorno[0]->fecha))->format('d-m-Y');
           // print_r($lstRetorno);exit;
            return $lstRetorno;
        }
        return null;
        
    }
    public function eliminar()
    {
            $sql = "DELETE FROM pedidos WHERE
            idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
        
    }

}
