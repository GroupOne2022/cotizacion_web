<?php

class Productos
{
    public static function nuevo($descripcion, $valor, $calculaIva)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into productos(descripcion, valor, calculaIva) VALUES (?, ?, ?);");
        return $sentencia->execute([$descripcion, $valor, $calculaIva]);
    }

    public static function actualizar($id, $descripcion, $valor, $calculaIva)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update productos set descripcion = ?, valor = ?, calculaIva = ? where id = ?;");
        return $sentencia->execute([$descripcion, $valor, $calculaIva, $id]);
    }

    public static function todos()
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select id, descripcion, valor from productos where 1 = ?;");
        $sentencia->execute(["1"]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function porId($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select id, descripcion, valor, calculaIva from productos where id = ?;");
        $sentencia->execute([$id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function eliminar($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete from productos where id = ?;");
        return $sentencia->execute([$id]);
    }
}
