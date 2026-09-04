<?php
include_once __DIR__ . "/../Config/conexionDB.php";

class Pedidos
{
    //Mostrar Pedido
    public static function all()
    {
        $sql = "SELECT * FROM pedido";
        return ConexionPDO::query($sql);
    }

    //Actualizar Pedido
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
        $sql = "UPDATE pedido SET $stringCampos WHERE id=:id";
        $valores[':id'] = $id;

        return ConexionPDO::execute($sql, $valores, false);
    }

    //Adicionar Pedido
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
        $sql = "INSERT INTO pedido ($stringColumnas) VALUES ($stringParametros)";

        return ConexionPDO::execute($sql, $valores, true);
    }

    //Eliminar Pedido
    public static function eliminar($id)
    {
        $sql = "DELETE FROM pedido WHERE id=:id";
        $valores = [
            ":id" => $id
        ];

        return ConexionPDO::execute($sql, $valores, false);
    }

    private static function filtrarColumnas($data)
    {
        $columnasPermitidas = ['cod_cliente', 'fecha', 'estado'];
        return array_filter(
            $data,
            fn($columna) => in_array($columna, $columnasPermitidas),
            ARRAY_FILTER_USE_KEY
        );
    }
}