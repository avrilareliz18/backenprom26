<?php
include_once __DIR__ . "/../Config/conexionDB.php";

class Productos
{
    //Mostrar Producto
    public static function all()
    {
        $sql = "SELECT * FROM productos";
        return ConexionPDO::query($sql);
    }

    //Actualizar Producto
    public static function update($id, $data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $campos = [];
        $valores = [];

        foreach ($data as $columna => $valor) {
            $campos[] = "$columna=:$columna";
            $valores[":$columna"] = $valor;
        }

        $stringCampos = implode(",", $campos);
        $sql = "UPDATE productos SET $stringCampos WHERE id=:id";
        $valores[':id'] = $id;

        return ConexionPDO::execute($sql, $valores, false);
    }

    //Adicionar Producto
    public static function add($data)
    {
        if (!is_array($data)) {
            return [
                "estado" => false,
                "error" => "Datos no introducidos bien",
                "errores" => [
                    "data" => "Los datos enviados no son validos",
                ],
            ];
        }

        if (isset($data['codBarras'])) {
            $data['codbarras'] = $data['codBarras'];
            unset($data['codBarras']);
        }

        if (isset($data['id'])) {
            unset($data['id']);
        }

        $columnasPermitidas = ['codbarras', 'descripcion', 'stock', 'precio_unitario'];
        $errores = [];

        foreach ($columnasPermitidas as $columna) {
            if (!isset($data[$columna]) || trim($data[$columna]) == "") {
                $errores[$columna] = "El campo $columna es obligatorio";
            }
        }

        if (isset($data['stock']) && trim($data['stock']) != "" && !is_numeric($data['stock'])) {
            $errores['stock'] = "El campo stock debe ser numerico";
        } elseif (isset($data['stock']) && trim($data['stock']) != "" && $data['stock'] < 0) {
            $errores['stock'] = "El campo stock debe ser mayor o igual a 0";
        }

        if (isset($data['precio_unitario']) && trim($data['precio_unitario']) != "" && !is_numeric($data['precio_unitario'])) {
            $errores['precio_unitario'] = "El campo precio_unitario debe ser numerico";
        } elseif (isset($data['precio_unitario']) && trim($data['precio_unitario']) != "" && $data['precio_unitario'] <= 0) {
            $errores['precio_unitario'] = "El campo precio_unitario debe ser mayor a 0";
        }

        if (!empty($errores)) {
            return [
                "estado" => false,
                "error" => "Datos no introducidos bien",
                "errores" => $errores,
            ];
        }

        $data = array_intersect_key($data, array_flip($columnasPermitidas));

        $campos = [];
        $parametros = [];
        $valores = [];

        foreach ($data as $columna => $valor) {
            $campos[] = $columna;
            $parametros[] = ":$columna";
            $valores[":$columna"] = $valor;
        }

        $stringCampos = implode(",", $campos);
        $stringParametros = implode(",", $parametros);
        $sql = "INSERT INTO productos ($stringCampos) VALUES ($stringParametros)";

        return ConexionPDO::execute($sql, $valores, true);
    }

    //Eliminar Producto
    public static function eliminar($id)
    {
        $sql = "DELETE FROM productos WHERE id=:id";
        $valores = [':id' => $id];

        return ConexionPDO::execute($sql, $valores, false);
    }
}
