<?php
require_once "../src/Models/Proveedor_productos.php";
class Proveedor_productoController{
    public function getAll()
    {
        $proveedor_producto=Proveedor_productos::all();
        echo json_encode($proveedor_producto);
         
    }
}