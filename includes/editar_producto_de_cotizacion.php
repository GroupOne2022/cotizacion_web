<?php

if (empty($_GET["idDetProducto"])) {
    exit("No proporcionaste un id de producto");
}
if (empty($_GET["idCotizacion"])) {
    exit("No proporcionaste un id de cotización");
}
$productos = Productos::todos();
$detalleProducto = Cotizaciones::obtenerProductoPorId($_GET["idCotizacion"], $_GET["idDetProducto"]);
/*$servicio = Cotizaciones::obtenerServicioPorId($_GET["idServicio"]);*/
if (!$detalleProducto) {
    exit("No existe el Producto");
}
$tokenCSRF = Utiles::obtenerTokenCSRF();
?>


<div class="col-sm-4">
    <h3>Editar servicio</h3>
    <form method="post" action="<?php echo BASE_URL ?>/?p=actualizar_producto_de_cotizacion">
        <input type="hidden" name="idCotizacion" value="<?php echo $detalleProducto->id_cotizacion ?>">
        <input type="hidden" name="idProducto" value="<?php echo $detalleProducto->id_producto ?>">
        <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
        <div class="form-group">
            <label for="servicio">Producto</label>
            <input value="<?php echo $detalleProducto->descripcion; ?>" autofocus name="producto" autocomplete="off" required
                   type="text" class="form-control" id="producto" placeholder="Por ejemplo: Facturas">
        </div>
        <div class="form-group">
            <label for="costo">Costo</label>
            <input value="<?php echo $detalleProducto->costo_unitario; ?>" name="costo" autocomplete="off" required type="number"
                   class="form-control" id="costo" placeholder="Costo especificado en USD">
        </div>
        <div class="form-group">
            <label for="cantidad">cantidad</label>
            <input value="<?php echo $detalleProducto->cantidad; ?>" name="cantidad" autocomplete="off" required
                   type="number" class="form-control" id="cantidad"
                   placeholder="Cantidad de tiempo que tomará el servicio">
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a class="btn btn-success"
           href="<?php echo BASE_URL ?>/?p=detalles_caracteristicas_cotizacion&id=<?php echo $_GET["idCotizacion"] ?>">&larr;
            Volver</a>
    </form>
</div>