<?php
require_once "../src/Models/Productos.php";
class ProductoController{
    public function getAll()
    {
        $producto=Productos::all();
        echo json_encode($producto);
         
    }
    //Actualizar producto
       public function update($id)
    {
        $jsonData=file_get_contents('php://input');
        $data= json_decode($jsonData,true);
        if(json_last_error()!=JSON_ERROR_NONE)
        {
            echo json_encode(
                [
                "status"=>"error codificacion",
                "message"=>json_last_error_msg(),
                ]);
                return;
        }
        //"codBarras":"75010013,00326",
    if(!isset($data['codBarras']) || trim($data['codBarras'])=="")
    {
        echo json_encode(
            [
                
                "status"=>"Error",
                "message"=>"El campo Codigo de Barras es obligatorio",
            ]);
            return;
    }
    // "descripcion":"Mouse Óptico Inalámbrico Logitech",
      if(!isset($data['descripcion']) || trim($data['descripcion'])=="")
    {
        echo json_encode(
            [
                
                "status"=>"Error",
                "message"=>"El campo Codigo de Barras es obligatorio"
            ]);
            return;
    }
    // "stock":50,
      if(!isset($data['stock']) || trim($data['stock'])=="")
    {
        echo json_encode(
            [
                
                "status"=>"Error",
                "message"=>"El campo Codigo de Barras es obligatorio"
            ]);
            return;
    }

    // "precio_unitario":22.50
      if(!isset($data['precio_unitario']) || trim($data['precio_unitario'])=="")
    {
        echo json_encode(
            [
                
                "status"=>"Error",
                "message"=>"El campo Codigo de Barras es obligatorio"
            ]);
            return;
    }


        $producto=Productos::update($id,$data);
        echo json_encode($producto);
         
    }
    //Adicionar Producto
    //public function add()
    //{
       // $jsonData=file_get_contents('php://input');
        //die($jsonData);
        //$producto=Productos::update($id);
        //echo json_encode($producto);
         
   // }
}