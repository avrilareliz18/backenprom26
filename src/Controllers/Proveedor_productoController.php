<?php
require_once "../src/Models/Proveedor_productos.php";

class Proveedor_productoController
{
    public function getAll()
    {
        $proveedor_producto = Proveedor_productos::all();
        echo json_encode($proveedor_producto);
    }

    //Actualizar proveedor_producto
    public function update($id)
    {
        $data = $this->getJsonData();
        if ($data === null) {
            return;
        }

        $errores = $this->validar($data);
        if (count($errores) > 0) {
            $this->respuestaErrores($errores);
            return;
        }

        $proveedor_producto = Proveedor_productos::update($id, $data);
        if ($proveedor_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor_producto actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($proveedor_producto);
    }

    //Adicionar proveedor_producto
    public function add()
    {
        $data = $this->getJsonData();
        if ($data === null) {
            return;
        }

        $errores = $this->validar($data);
        if (count($errores) > 0) {
            $this->respuestaErrores($errores);
            return;
        }

        $proveedor_producto = Proveedor_productos::add($data);
        if ($proveedor_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor_producto adicionado correctamente",
                "id" => $proveedor_producto,
            ]);
            return;
        }
        echo json_encode($proveedor_producto);
    }

    //Eliminar proveedor_producto
    public function eliminar($id)
    {
        $proveedor_producto = Proveedor_productos::eliminar($id);
        if ($proveedor_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor_producto eliminado correctamente",
            ]);
            return;
        }
        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el proveedor_producto",
        ]);
    }

    private function getJsonData()
    {
        $jsonData = file_get_contents('php://input');
        $data = json_decode($jsonData, true);

        if (json_last_error() != JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode([
                "estado" => false,
                "errores" => [
                    "json" => json_last_error_msg()
                ],
            ]);
            return null;
        }

        if (!is_array($data)) {
            http_response_code(400);
            echo json_encode([
                "estado" => false,
                "errores" => [
                    "datos" => "Debe enviar un objeto JSON valido"
                ],
            ]);
            return null;
        }

        return $data;
    }

    private function validar($data)
    {
        $errores = [];

        if (!isset($data['cod_proveedor']) || trim($data['cod_proveedor']) == "") {
            $errores["cod_proveedor"] = "El campo cod_proveedor es obligatorio";
        } elseif (!is_numeric($data['cod_proveedor']) || $data['cod_proveedor'] <= 0) {
            $errores["cod_proveedor"] = "El campo cod_proveedor debe ser numerico mayor a 0";
        }

        if (!isset($data['cod_producto']) || trim($data['cod_producto']) == "") {
            $errores["cod_producto"] = "El campo cod_producto es obligatorio";
        } elseif (!is_numeric($data['cod_producto']) || $data['cod_producto'] <= 0) {
            $errores["cod_producto"] = "El campo cod_producto debe ser numerico mayor a 0";
        }

        return $errores;
    }

    private function respuestaErrores($errores)
    {
        http_response_code(400);
        echo json_encode([
            "estado" => false,
            "errores" => $errores,
        ]);
    }
}