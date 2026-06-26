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
        if (isset($data['codBarras'])) {
            $data['codbarras'] = $data['codBarras'];
            unset($data['codBarras']);
        }

        if (isset($data['id'])) {
            unset($data['id']);
        }

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
}
