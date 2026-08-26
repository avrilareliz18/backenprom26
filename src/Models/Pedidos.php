<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class Pedidos

{
   
    public static function all()
    {
        $sql = "SELECT * FROM pedido";
        return ConexionPDO::query($sql);
    }
}