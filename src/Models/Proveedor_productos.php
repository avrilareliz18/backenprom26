<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class Proveedor_productos

{
   
    public static function all()
    {
        $sql = "SELECT * FROM proveedor_producto";
        return ConexionPDO::query($sql);
    }
}