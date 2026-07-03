<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class Clientes
{
   
    public static function all()
    {
        $sql = "SELECT * FROM clientes";
        return ConexionPDO::query($sql);
    }
}