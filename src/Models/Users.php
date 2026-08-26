<?php
include_once __DIR__ . "/../Config/conexionDB.php";
class Users
{

    public static function all()
    {
        $sql = "SELECT * FROM usuarios";
        return ConexionPDO::query($sql); //self::$users;
    }
}
