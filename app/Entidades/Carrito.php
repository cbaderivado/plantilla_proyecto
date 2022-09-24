<?php

namespace App\Entidades;

use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
require app_path().'/start/constants.php';

class Carrito extends Model
{
    protected $table = 'carritos';
    public $timestamps = false;

    protected $fillable = [
                            'idcarrito',
                            'fk_idproducto',
                            'fk_idcliente',
                            'comentario'
                            ];
    
    function cargarDesdeRequest($request) {
        $this->idcarrito = $request->input('id')!= "0" ? $request->input('id') : $this->idcarrito;
        $this->fk_idproducto =$request->input('txtProducto');
        $this->fk_idcliente =$request->input('txtCliente');
        $this->comentario =$request->input('txtComentarios');
    }

    
     public function insertar() {
            $sql = "INSERT INTO carritos (
                    fk_idproducto,
                    fk_idcliente,
                    comentario
                    ) VALUES (?,?,?);";
            $result = DB::insert($sql, [
            		$this->fk_idproducto,
                    $this->fk_idcliente,
                    $this->comentario
                    ]);

            return $this->idcarrito = DB::getPdo()->lastInsertId();
            
    }

    public function guardar() {
       $sql = "UPDATE carritos SET
            fk_idproducto='$this->fk_idproducto',
            fk_idcliente='$this->fk_idcliente',
            comentario='$this->comentario'
            WHERE idcarrito= ?"; 
        $affected = DB::update($sql, [$this->idcarrito]);
    }
    public function obtenerTodos() {
        $sql = "SELECT 
                A.idcarrito,
                A.fk_idproducto,
                A.fk_idcliente,
                A.comentario
                FROM carrito A";

        $sql .= " ORDER BY A.idcarrito";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }


    public function obtenerPorIdCarrito($idCarrito){
        $sql = "SELECT
                A.idcarrito,
                A.fk_idproducto,
                A.fk_idcliente,
                A.comentario
                FROM carrito A
                WHERE A.idcarrito = '$idCarrito'";
            $lstRetorno = DB::select($sql);
           if(count($lstRetorno)>0){
            $this->idcarrito=$lstRetorno[0]->idcarrito;
            $this->fk_idproducto=$lstRetorno[0]->fk_idproducto;
            $this->fk_idcliente=$lstRetorno[0]->fk_idcliente;
            $this->comentario=$lstRetorno[0]->comentario;
            return $lstRetorno[0];
        }
        return null;
        
    }
    public function eliminar()
    {
        
            $sql = "DELETE FROM carritos WHERE
            idcarrito=?";
            
        DB::delete($sql, [$this->idcarrito]);
        
    }

}

?>

