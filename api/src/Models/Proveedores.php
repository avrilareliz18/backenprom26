<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class proveedor
{
   
    public static function all()
    {
        $sql = "SELECT * FROM proveedor";
        return ConexionPDO::query($sql);
    }
}