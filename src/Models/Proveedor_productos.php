<?php
include_once __DIR__ . "/../Config/conexionDB.php";

class Proveedor_productos
{
    //Mostrar proveedor_producto
    public static function all()
    {
        $sql = "SELECT * FROM proveedor_producto";
        return ConexionPDO::query($sql);
    }

    //Actualizar proveedor_producto
    public static function update($id, $data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $data = self::filtrarColumnas($data);
        if (count($data) == 0) {
            return false;
        }

        $campos = [];
        $valores = [];

        foreach ($data as $columna => $valor) {
            $campos[] = "$columna=:$columna";
            $valores[":$columna"] = $valor;
        }

        $stringCampos = implode(",", $campos);
        $sql = "UPDATE proveedor_producto SET $stringCampos WHERE id=:id";
        $valores[':id'] = $id;

        return ConexionPDO::execute($sql, $valores, false);
    }

    //Adicionar proveedor_producto
    public static function add($data)
    {
        if (isset($data['id'])) {
            unset($data['id']);
        }

        $data = self::filtrarColumnas($data);
        if (count($data) == 0) {
            return false;
        }

        $columnas = array_keys($data);
        $parametros = array_map(fn($columna) => ":$columna", $columnas);
        $valores = [];

        foreach ($data as $columna => $valor) {
            $valores[":$columna"] = $valor;
        }

        $stringColumnas = implode(",", $columnas);
        $stringParametros = implode(",", $parametros);
        $sql = "INSERT INTO proveedor_producto ($stringColumnas) VALUES ($stringParametros)";

        return ConexionPDO::execute($sql, $valores, true);
    }

    //Eliminar proveedor_producto
    public static function eliminar($id)
    {
        $sql = "DELETE FROM proveedor_producto WHERE id=:id";
        $valores = [
            ":id" => $id
        ];

        return ConexionPDO::execute($sql, $valores, false);
    }

    private static function filtrarColumnas($data)
    {
        $columnasPermitidas = ['cod_proveedor', 'cod_producto'];
        return array_filter(
            $data,
            fn($columna) => in_array($columna, $columnasPermitidas),
            ARRAY_FILTER_USE_KEY
        );
    }
}