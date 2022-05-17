<?php

class Clientes
{
    public static function nuevo($identificacion, $razonSocial, $direccion, $celular, $correo)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into clientes(correo, celular, direccion, razonSocial, identificacion, idUsuario) VALUES (?, ?, ?, ?, ?, ?);");
        return $sentencia->execute([$correo, $celular, $direccion, $razonSocial, $identificacion, SesionService::obtenerIdUsuarioLogueado()]);
    }

    public static function actualizar($id, $identificacion, $razonSocial, $direccion, $celular, $correo)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update clientes set identificacion = ?, razonSocial = ?, direccion = ?, celular = ?, correo = ? where id = ? and idUsuario = ?;");
        return $sentencia->execute([$identificacion, $razonSocial, $direccion, $celular, $correo, $id, SesionService::obtenerIdUsuarioLogueado()]);
    }

    public static function todos()
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select id, identificacion, razonSocial from clientes where idUsuario = ?;");
        $sentencia->execute([SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function porId($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select id, identificacion, razonSocial, direccion, celular, correo from clientes where id = ? and idUsuario = ?;");
        $sentencia->execute([$id, SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function eliminar($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete from clientes where id = ? and idUsuario = ?;");
        return $sentencia->execute([$id, SesionService::obtenerIdUsuarioLogueado()]);
    }
}
