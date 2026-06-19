<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class Pedido_producto

{
   
    public static function all()
    {
        $sql = "SELECT * FROM pedido_producto";
        return ConexionPDO::query($sql);
    }
}