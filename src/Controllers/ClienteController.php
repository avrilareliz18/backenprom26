<?php
require_once "../src/Models/Clientes.php";
class ClienteController{
    public function getAll()
    {
        $clientes=Clientes::all();
        echo json_encode($clientes);
         
    }
}