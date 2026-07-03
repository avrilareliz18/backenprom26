<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class usuario
{
   
    public static function all()
    {
        $sql = "SELECT * FROM usuario";
        return ConexionPDO::query($sql);
    }
}