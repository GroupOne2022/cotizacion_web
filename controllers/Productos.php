<?php

class Productos
{
    public static function nuevo($descripcion, $valor, $image)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into productos(descripcion, valor, image) VALUES (?, ?, ?);");
        return $sentencia->execute([$descripcion, $valor, $image]);
    }

    public static function actualizar($id, $descripcion, $valor, $image)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update productos set descripcion = ?, valor = ?, image = ? where id = ?;");
        return $sentencia->execute([$descripcion, $valor, $image, $id]);
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
        $sentencia = $bd->prepare("select id, descripcion, valor, image from productos where id = ?;");
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
