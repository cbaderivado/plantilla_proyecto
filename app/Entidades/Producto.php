<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Producto extends Model
{
    protected $table = 'productos';
    public $timestamps = false;

    protected $fillable = [
                            'idproducto',
                            'nombre',
                            'precio',
                            'descripcion',
                            'imagen',
                            'fk_idtipoproducto',
                            'cantidad'
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idproducto = $request->input('id')!= "0" ? $request->input('id') : $this->idproducto;
        $this->nombre=$request->input('txtNombre');
        $this->precio=$request->input('txtPrecio');
        $this->descripcion = $request->input('txtDescripcion');
        $this->imagen =  $request->input('txtImagen');
        $this->fk_idtipoproducto = $request->input('lstTipoProducto');
        $this->cantidad = $request->input('txtCantidad');
        
    }

    public function obtenerFiltrado() {
        $request = $_REQUEST;
        $columns = array(
            0 => 'A.idproducto',
            1 => 'A.nombre',
            2 => 'A.descripcion',
            3 => 'tipoProducto',
            4 => 'A.precio',
            5 => 'A.cantidad',
            6 => 'A.imagen'
        );
        $sql = "SELECT 
                A.idproducto,
                A.nombre,
                A.descripcion,
                B.nombre as tipoProducto,
                A.precio,
                A.cantidad,
                A.imagen
                FROM productos A LEFT JOIN tipo_productos B
                ON A.fk_idtipoproducto=B.idtipoproducto
                WHERE 1=1";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) { 
            $sql.=" AND ( A.nombre LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR ( A.descripcion LIKE '%" . $request['search']['value'] . "%') ";
            $sql.=" OR ( B.nombre LIKE '%" . $request['search']['value'] . "%') ";
        }
        $sql.=" ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }


     public function insertar() {
        $now = new \DateTime();

            $sql = "INSERT INTO productos (
                        nombre,
                        precio,
                        descripcion,
                        imagen,
                        fk_idtipoproducto,
                        cantidad
                    ) VALUES (?, ?, ?, ?, ?, ?);";
            $result = DB::insert($sql, [
            		$this->nombre,
                    $this->precio,
                    $this->descripcion,
                    $this->imagen,
                    $this->fk_idtipoproducto,
                    $this->cantidad
                    ]);

            return $this->idproducto = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE productos SET
            nombre='$this->nombre',
            precio='$this->precio',
            descripcion='$this->descripcion',
            imagen='$this->imagen',
            fk_idtipoproducto='$this->fk_idtipoproducto',
            cantidad='$this->cantidad'
            WHERE idproducto= ?"; 
        $affected = DB::update($sql, [$this->idproducto]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idproducto,
                A.nombre,
                A.precio,
                A.descripcion,
                A.imagen,
                A.fk_idtipoproducto,
                A.cantidad
                FROM productos A";

        $sql .= " ORDER BY A.nombre";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorNombre($nombre) {
        $sql = "SELECT
                .idproducto,
                A.nombre,
                A.precio,
                A.descripcion,
                A.imagen,
                A.fk_idtipoproducto,
                A.cantidad
                FROM productos A
                WHERE A.nombre = '$nombre'";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
            $this->nombre=$lstRetorno[0]->nombre;
            $this->precio=$lstRetorno[0]->precio;
            $this->descripcion=$lstRetorno[0]->descripcion;
            $this->imagen=$lstRetorno[0]->imagen;
            $this->fk_idtipoproducto=$lstRetorno[0]->fk_idtipoproducto;
            $this->cantidad=$lstRetorno[0]->cantidad;
            return $lstRetorno[0];
        }
        return null;
    }

  
    public function obtenerPorId($idProducto){
        $sql = "SELECT
                A.idproducto,
                A.nombre,
                A.precio,
                A.descripcion,
                A.imagen,
                A.fk_idtipoproducto,
                B.nombre as tipoProducto,
                A.cantidad
                FROM productos A LEFT JOIN tipo_productos B
                ON A.fk_idtipoproducto=B.idtipoproducto
                WHERE A.idproducto = '$idProducto'";
        $lstRetorno = DB::select($sql);
        if(count($lstRetorno)>0){
            $this->idproducto=$idProducto;
            $this->nombre=$lstRetorno[0]->nombre;
            $this->precio=$lstRetorno[0]->precio;
            $this->descripcion=$lstRetorno[0]->descripcion;
            $this->imagen=$lstRetorno[0]->imagen;
            $this->fk_idtipoproducto=$lstRetorno[0]->fk_idtipoproducto;
            $this->cantidad=$lstRetorno[0]->cantidad;
                return $lstRetorno[0];
        }
        return null;
        
    }
    public function eliminar()
    {
            $sql = "DELETE FROM productos WHERE
            idproducto=?";
        $affected = DB::delete($sql, [$this->idproducto]);
        
    }

}

?>

