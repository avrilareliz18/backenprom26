<?php
require_once "../src/Models/Pedido_productos.php";

class Pedido_productoController
{
    public function getAll()
    {
        $pedido_producto = Pedido_productos::all();
        echo json_encode($pedido_producto);
    }

    //Actualizar pedido_producto
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

        $pedido_producto = Pedido_productos::update($id, $data);
        if ($pedido_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido_producto actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($pedido_producto);
    }

    //Adicionar pedido_producto
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

        $pedido_producto = Pedido_productos::add($data);
        if ($pedido_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido_producto adicionado correctamente",
                "id" => $pedido_producto,
            ]);
            return;
        }
        echo json_encode($pedido_producto);
    }

    //Eliminar pedido_producto
    public function eliminar($id)
    {
        $pedido_producto = Pedido_productos::eliminar($id);
        if ($pedido_producto) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido_producto eliminado correctamente",
            ]);
            return;
        }
        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el pedido_producto",
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

        if (!isset($data['cod_pedido']) || trim($data['cod_pedido']) == "") {
            $errores["cod_pedido"] = "El campo cod_pedido es obligatorio";
        } elseif (!is_numeric($data['cod_pedido']) || $data['cod_pedido'] <= 0) {
            $errores["cod_pedido"] = "El campo cod_pedido debe ser numerico mayor a 0";
        }

        if (!isset($data['cod_producto']) || trim($data['cod_producto']) == "") {
            $errores["cod_producto"] = "El campo cod_producto es obligatorio";
        } elseif (!is_numeric($data['cod_producto']) || $data['cod_producto'] <= 0) {
            $errores["cod_producto"] = "El campo cod_producto debe ser numerico mayor a 0";
        }

        if (!isset($data['cantidad']) || trim($data['cantidad']) == "") {
            $errores["cantidad"] = "El campo cantidad es obligatorio";
        } elseif (!is_numeric($data['cantidad']) || $data['cantidad'] <= 0) {
            $errores["cantidad"] = "El campo cantidad debe ser numerico mayor a 0";
        }

        if (!isset($data['precio_unitario']) || trim($data['precio_unitario']) == "") {
            $errores["precio_unitario"] = "El campo precio_unitario es obligatorio";
        } elseif (!is_numeric($data['precio_unitario']) || $data['precio_unitario'] <= 0) {
            $errores["precio_unitario"] = "El campo precio_unitario debe ser numerico mayor a 0";
        }

        if (isset($data['descuento']) && trim($data['descuento']) != "" && !is_numeric($data['descuento'])) {
            $errores["descuento"] = "El campo descuento debe ser numerico";
        } elseif (isset($data['descuento']) && trim($data['descuento']) != "" && $data['descuento'] < 0) {
            $errores["descuento"] = "El campo descuento debe ser mayor o igual a 0";
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