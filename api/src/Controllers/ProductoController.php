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
        if($producto){
            echo json_encode([
                "estado"=>true,
                "message" => "Producto actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($producto);
         
    }


    //Adicionar Producto
    public function add()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            echo json_encode([
                "estado" => false,
                "error" => "Datos no introducidos bien",
                "errores" => [
                    "json" => json_last_error_msg(),
                ],
            ]);
            return;
        }

        if (!is_array($data)) {
            echo json_encode([
                "estado" => false,
                "error" => "Datos no introducidos bien",
                "errores" => [
                    "data" => "Los datos enviados no son validos",
                ],
            ]);
            return;
        }

        $errores = [];

        if (!isset($data['codBarras']) || trim($data['codBarras']) == "") {
            $errores['codBarras'] = "El campo Codigo de Barras es obligatorio";
        }

        if (!isset($data['descripcion']) || trim($data['descripcion']) == "") {
            $errores['descripcion'] = "El campo descripcion es obligatorio";
        }

        if (!isset($data['stock']) || trim($data['stock']) == "") {
            $errores['stock'] = "El campo stock es obligatorio";
        } elseif (!is_numeric($data['stock'])) {
            $errores['stock'] = "El campo stock debe ser numerico";
        } elseif ($data['stock'] < 0) {
            $errores['stock'] = "El campo stock debe ser mayor o igual a 0";
        }

        if (!isset($data['precio_unitario']) || trim($data['precio_unitario']) == "") {
            $errores['precio_unitario'] = "El campo precio_unitario es obligatorio";
        } elseif (!is_numeric($data['precio_unitario'])) {
            $errores['precio_unitario'] = "El campo precio_unitario debe ser numerico";
        } elseif ($data['precio_unitario'] <= 0) {
            $errores['precio_unitario'] = "El campo precio_unitario debe ser mayor a 0";
        }

        if (!empty($errores)) {
            echo json_encode([
                "estado" => false,
                "error" => "Datos no introducidos bien",
                "errores" => $errores,
            ]);
            return;
        }

        $producto = Productos::add($data);
        if (is_array($producto) && isset($producto['estado']) && $producto['estado'] == false) {
            echo json_encode($producto);
            return;
        }

        if ($producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Producto adicionado correctamente",
                "id" => $producto,
            ]);
            return;
        }

        echo json_encode([
            "estado" => false,
            "error" => "Datos no introducidos bien",
            "message" => "No se pudo adicionar el producto",
        ]);
    }

    //Eliminar Producto
    public function eliminar($id)
    {
        $producto = Productos::eliminar($id);
        if ($producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Producto eliminado correctamente",
            ]);
            return;
        }

        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el producto",
        ]);
    }
}
