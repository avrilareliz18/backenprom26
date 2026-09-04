<?php
require_once "../src/Models/Usuario.php";

class UsuarioController
{
    public function getAll()
    {
        $usuario = Usuario::all();
        echo json_encode($usuario);
    }

    //Actualizar usuario
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

        $usuario = Usuario::update($id, $data);
        if ($usuario) {
            echo json_encode([
                "estado" => true,
                "message" => "Usuario actualizado correctamente",
            ]);
            return;
        }
        echo json_encode($usuario);
    }

    //Adicionar usuario
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

        $usuario = Usuario::add($data);
        if ($usuario) {
            echo json_encode([
                "estado" => true,
                "message" => "Usuario adicionado correctamente",
                "id" => $usuario,
            ]);
            return;
        }
        echo json_encode($usuario);
    }

    //Eliminar usuario
    public function eliminar($id)
    {
        $usuario = Usuario::eliminar($id);
        if ($usuario) {
            echo json_encode([
                "estado" => true,
                "message" => "Usuario eliminado correctamente",
            ]);
            return;
        }
        echo json_encode([
            "estado" => false,
            "message" => "No se pudo eliminar el usuario",
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

        if (!isset($data['email']) || trim($data['email']) == "") {
            $errores["email"] = "El campo email es obligatorio";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errores["email"] = "El campo email debe ser un correo valido";
        }

        if (!isset($data['password_hash']) || trim($data['password_hash']) == "") {
            $errores["password_hash"] = "El campo password_hash es obligatorio";
        }

        if (isset($data['estado_cuenta']) && trim($data['estado_cuenta']) == "") {
            $errores["estado_cuenta"] = "El campo estado_cuenta es obligatorio";
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