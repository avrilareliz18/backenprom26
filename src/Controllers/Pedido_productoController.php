<?php
require_once "../src/Models/Pedido_productos.php";
class Pedido_productoController{
    public function getAll()
    {
        $pedido_producto=Pedido_productos::all();
        echo json_encode($pedido_producto);
         
    }
}