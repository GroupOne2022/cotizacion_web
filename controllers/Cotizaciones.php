<?php

class Cotizaciones
{
    public static function nueva($idCliente, $descripcion, $fecha)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into cotizaciones(idUsuario, idCliente, descripcion, fecha) VALUES (?, ?, ?, ?);");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idCliente, $descripcion, $fecha]);
    }

    public static function eliminarProducto($idCotizacion, $idProducto)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete cotizaciones_detalle
        from cotizaciones_detalle
       inner join cotizaciones on cotizaciones.id = cotizaciones_detalle.id_cotizacion 
              and cotizaciones.idUsuario = ?
              and cotizaciones_detalle.id_cotizacion = ?
              and cotizaciones_detalle.id_producto = ?");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idCotizacion, $idProducto]);
    }

    public static function eliminarServicio($idServicio)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete servicios_cotizaciones
from servicios_cotizaciones
       inner join cotizaciones on cotizaciones.idUsuario = ?
                                    and
                                  servicios_cotizaciones.id = ?");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idServicio]);
    }

    public static function eliminarCaracteristica($idCaracteristica)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete caracteristicas_cotizaciones 
from caracteristicas_cotizaciones 
inner join cotizaciones on cotizaciones.idUsuario = ? and caracteristicas_cotizaciones.id = ?;");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idCaracteristica]);
    }

    public static function obtenerServicioPorId($idServicio)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select servicios_cotizaciones.id, idCotizacion, servicio, costo, tiempoEnMinutos, multiplicador
from servicios_cotizaciones
       inner join cotizaciones on cotizaciones.idUsuario = ? and servicios_cotizaciones.id = ?");
        $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idServicio]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function obtenerProductoPorId($idCotizacion, $idProducto)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select cotizaciones_detalle.id, cotizaciones_detalle.id_cotizacion, cotizaciones_detalle.id_producto, productos.descripcion, costo_unitario, cantidad, costo_total, productos.calculaIva
from cotizaciones_detalle
       inner join cotizaciones on cotizaciones.id = cotizaciones_detalle.id_cotizacion
       inner join productos on productos.id = cotizaciones_detalle.id_producto  
       where cotizaciones.id = ?
         and cotizaciones_detalle.id_producto = ?
         and cotizaciones.idUsuario = ?;");
        $sentencia->execute([$idCotizacion, $idProducto, SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function obtenerCaracteristicaPorId($idCaracteristica)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select caracteristicas_cotizaciones.id, idCotizacion, caracteristica
from caracteristicas_cotizaciones
       inner join cotizaciones on cotizaciones.idUsuario = ? and caracteristicas_cotizaciones.id = ?");
        $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idCaracteristica]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function serviciosPorId($idCotizacion)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select servicios_cotizaciones.id, servicio, costo, tiempoEnMinutos, multiplicador
from servicios_cotizaciones
       inner join cotizaciones on cotizaciones.id = servicios_cotizaciones.idCotizacion and cotizaciones.id = ?
                                    and cotizaciones.idUsuario = ?;");
        $sentencia->execute([$idCotizacion, SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function productosPorId($idCotizacion)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select cotizaciones_detalle.id, cotizaciones_detalle.id_producto, productos.descripcion, costo_unitario, cantidad, costo_total, productos.calculaIva
from cotizaciones_detalle
       inner join cotizaciones on cotizaciones.id = cotizaciones_detalle.id_cotizacion
       inner join productos on productos.id = cotizaciones_detalle.id_producto  
       where cotizaciones.id = ?
         and cotizaciones.idUsuario = ?;");
        $sentencia->execute([$idCotizacion, SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function caracteristicasPorId($idCotizacion)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select caracteristicas_cotizaciones.id, idCotizacion, caracteristica
from caracteristicas_cotizaciones
       inner join cotizaciones on cotizaciones.id = caracteristicas_cotizaciones.idCotizacion and cotizaciones.id = ? and cotizaciones.idUsuario = ?;");
        $sentencia->execute([$idCotizacion, SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function agregarServicio($idCotizacion, $servicio, $costo, $tiempoEnMinutos, $multiplicador)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into servicios_cotizaciones (idCotizacion, servicio, costo, tiempoEnMinutos, multiplicador)
        values ((select id from cotizaciones where cotizaciones.idUsuario = ? and cotizaciones.id = ?), ?, ?, ?, ?);");
        return $sentencia->execute([
            SesionService::obtenerIdUsuarioLogueado(),
            $idCotizacion,
            $servicio,
            $costo,
            $tiempoEnMinutos,
            $multiplicador
        ]);
    }

    public static function agregarProducto($idCotizacion, $idProducto, $costo, $cantidad)
    {
        $bd = BD::obtener();
        $total = $costo*$cantidad;
        $sentencia = $bd->prepare("insert into cotizaciones_detalle (id_cotizacion, id_producto, costo_unitario, cantidad, costo_total)
        values ((select id from cotizaciones where cotizaciones.idUsuario = ? and cotizaciones.id = ?), ?, ?, ?, ?);");
        return $sentencia->execute([
            SesionService::obtenerIdUsuarioLogueado(),
            $idCotizacion,
            $idProducto,
            $costo,
            $cantidad,
            $total
        ]);
    }

    public static function agregarCaracteristica($idCotizacion, $caracteristica)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("insert into caracteristicas_cotizaciones
        (idCotizacion, caracteristica)
        values
        ((select id from cotizaciones where cotizaciones.idUsuario = ? and cotizaciones.id = ?), ?);");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $idCotizacion, $caracteristica]);
    }

    public static function actualizarServicio($idServicio, $servicio, $costo, $tiempoEnMinutos, $multiplicador)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update servicios_cotizaciones
        inner join cotizaciones on servicios_cotizaciones.idCotizacion = cotizaciones.id and cotizaciones.idUsuario = ?
        set servicio        = ?,
            costo           = ?,
            tiempoEnMinutos = ?,
            multiplicador   = ?
        where servicios_cotizaciones.id = ?;");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $servicio, $costo, $tiempoEnMinutos, $multiplicador, $idServicio]);
    }

    public static function actualizarProducto($idProducto, $idCotizacion, $costo, $cantidad)
    {
        $bd = BD::obtener();
        $total = $costo*$cantidad;
        $sentencia = $bd->prepare("update cotizaciones_detalle 
        inner join cotizaciones on cotizaciones_detalle.id_cotizacion = cotizaciones.id and cotizaciones.idUsuario = ?
        set costo_unitario  = ?, cantidad = ?, costo_total = ?
        where id_cotizacion = ?
          and id_producto = ?;");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $costo, $cantidad, $total, $idCotizacion, $idProducto]);
    }

    public static function actualizarCaracteristica($idCaracteristica, $caracteristica)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update caracteristicas_cotizaciones
        inner join cotizaciones on caracteristicas_cotizaciones.idCotizacion = cotizaciones.id and cotizaciones.idUsuario = ?
        set
        caracteristica = ?
        where caracteristicas_cotizaciones.id = ?;");
        return $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $caracteristica, $idCaracteristica]);
    }

    public static function todas()
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select
            cotizaciones.id, clientes.razonSocial, cotizaciones.descripcion, cotizaciones.fecha
            from clientes inner join cotizaciones
            on cotizaciones.idCliente = clientes.id and cotizaciones.idUsuario = ?;");
        $sentencia->execute([SesionService::obtenerIdUsuarioLogueado()]);
        return $sentencia->fetchAll(PDO::FETCH_OBJ);
    }

    public static function porId($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("select
            cotizaciones.id, clientes.razonSocial, cotizaciones.descripcion, cotizaciones.fecha, cotizaciones.idCliente,
            clientes.identificacion, clientes.direccion, clientes.celular, clientes.correo
            from clientes inner join cotizaciones
            on cotizaciones.idCliente = clientes.id and cotizaciones.idUsuario = ?
            where cotizaciones.id = ?;");
        $sentencia->execute([SesionService::obtenerIdUsuarioLogueado(), $id]);
        return $sentencia->fetch(PDO::FETCH_OBJ);
    }

    public static function actualizar($id, $idCliente, $descripcion, $fecha)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("update cotizaciones set
        idCliente = ?,
        descripcion = ?,
        fecha = ?
        where id = ? and idUsuario = ?");
        return $sentencia->execute([$idCliente, $descripcion, $fecha, $id, SesionService::obtenerIdUsuarioLogueado()]);
    }

    public static function eliminar($id)
    {
        $bd = BD::obtener();
        $sentencia = $bd->prepare("delete from cotizaciones where id = ? and idUsuario = ?;");
        return $sentencia->execute([$id, SesionService::obtenerIdUsuarioLogueado()]);
    }
}
