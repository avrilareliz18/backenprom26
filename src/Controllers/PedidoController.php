<?php
require_once "../src/Models/Pedidos.php";

class PedidoController
{
    public function getAll()
    {
        $pedido = Pedidos::all();
        echo json_encode($pedido);
    }

    //Actualizar pedido
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

        $pedido = Pedidos::update($id, $data);
        if ($pedido) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($pedido);
    }

    //Adicionar pedido
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

        $pedido = Pedidos::add($data);
        if ($pedido) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido adicionado correctamente",
                "id" => $pedido,
            ]);
            return;
        }
        echo json_encode($pedido);
    }

    //Eliminar pedido
    public function eliminar($id)
    {
        $pedido = Pedidos::eliminar($id);
        if ($pedido) {
            echo json_encode([
                "estado" => true,
                "message" => "Pedido eliminado correctamente",
            ]);
            return;
        }
        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el pedido",
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

        if (!isset($data['cod_cliente']) || trim($data['cod_cliente']) == "") {
            $errores["cod_cliente"] = "El campo cod_cliente es obligatorio";
        } elseif (!is_numeric($data['cod_cliente']) || $data['cod_cliente'] <= 0) {
            $errores["cod_cliente"] = "El campo cod_cliente debe ser numerico mayor a 0";
        }

        if (isset($data['fecha']) && trim($data['fecha']) == "") {
            $errores["fecha"] = "El campo fecha es obligatorio";
        }

        if (isset($data['estado']) && trim($data['estado']) == "") {
            $errores["estado"] = "El campo estado es obligatorio";
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