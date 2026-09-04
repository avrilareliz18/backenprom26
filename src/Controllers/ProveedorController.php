<?php
require_once "../src/Models/Proveedores.php";

class ProveedorController
{
    public function getAll()
    {
        $proveedor = Proveedores::all();
        echo json_encode($proveedor);
    }

    //Actualizar proveedor
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

        $proveedor = Proveedores::update($id, $data);
        if ($proveedor) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($proveedor);
    }

    //Adicionar proveedor
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

        $proveedor = Proveedores::add($data);
        if ($proveedor) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor adicionado correctamente",
                "id" => $proveedor,
            ]);
            return;
        }
        echo json_encode($proveedor);
    }

    //Eliminar proveedor
    public function eliminar($id)
    {
        $proveedor = Proveedores::eliminar($id);
        if ($proveedor) {
            echo json_encode([
                "estado" => true,
                "message" => "Proveedor eliminado correctamente",
            ]);
            return;
        }
        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el proveedor",
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

        if (!isset($data['ci']) || trim($data['ci']) == "") {
            $errores["ci"] = "El campo ci es obligatorio";
        }

        if (!isset($data['nombre']) || trim($data['nombre']) == "") {
            $errores["nombre"] = "El campo nombre es obligatorio";
        }

        if (!isset($data['apellidos']) || trim($data['apellidos']) == "") {
            $errores["apellidos"] = "El campo apellidos es obligatorio";
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