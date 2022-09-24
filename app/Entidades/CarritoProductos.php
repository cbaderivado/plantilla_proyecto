<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class CarritoProducto extends Model
{
    protected $table = 'carritos_productos';
    

    protected $fillable = [
                            'idcarrito_productos',
                            'fk_idproducto',
                            'fk_idcarrito',
                            'cantidad'
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idcarrito_productos = $request->input('id')!= "0" ? $request->input('id') : $this->idcarrito_productos;
        $this->fk_idproducto =$request->input('txtProducto');
        $this->fk_idcliente =$request->input('txtCliente');
        $this->cantidad =$request->input('txtCantidad');
    }
    
     public function insertar() {
            $sql = "INSERT INTO carrito_productos (
                    fk_idproducto,
                    fk_idcarrito,
                    cantidad
                    ) VALUES (?,?,?);";
            $result = DB::insert($sql, [
            		$this->fk_idproducto,
                    $this->fk_idcarrito,
                    $this->cantidad
                    ]);

            return $this->idcarrito = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE carrito_productos SET
            fk_idproducto='$this->fk_idproducto',
            fk_idcarrito='$this->fk_idcarrito',
            cantidad='$this->cantidad'
            WHERE idcarrito_productos= ?"; 
        $affected = DB::update($sql, [$this->idcarrito_productos]);
    }

    public function obtenerTodos() {
        $sql = "SELECT 
                A.idcarrito_productos,
                A.fk_idproducto,
                A.fk_idcliente,
                A.cantidad
                FROM carrito_productos A";

        $sql .= " ORDER BY A.idcarrito_productos";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorIdCarritoProductos($idCarrito_productos){
        $sql = "SELECT
                A.idcarrito_productos,
                A.fk_idproducto,
                A.fk_idcliente,
                A.cantidad
                FROM carrito_productos A
                WHERE A.idcarrito_productos = '$idCarrito_productos'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->idcarrito_productos=$lstRetorno[0]->idcarrito_productos;
            $this->fk_idproducto=$lstRetorno[0]->fk_idproducto;
            $this->fk_idcliente=$lstRetorno[0]->fk_idcliente;
            $this->cantidad=$lstRetorno[0]->cantidad;
            return $lstRetorno[0];
        }
        return null;
        
    }

    public function eliminar()
    {
        
            $sql = "DELETE FROM carrito_productos WHERE
            idcarrito_productos=?";
            
        DB::delete($sql, [$this->idcarrito]);
        
    }

}

?>

