<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class proveedor_producto

{
   
    public static function all()
    {
        $sql = "SELECT * FROM proveedor_producto";
        return ConexionPDO::query($sql);
    }
}