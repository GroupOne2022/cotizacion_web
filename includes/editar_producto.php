<?php
if (empty($_GET["id"])) exit;
$producto = Productos::porId($_GET["id"]);
if ($producto === null || $producto === FALSE) {
    Utiles::redireccionar("productos");
}
$tokenCSRF = Utiles::obtenerTokenCSRF();
?>
<div class="row">
    <div class="col-sm">
        <h1>Editar Producto</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <form method="post" action="<?php echo BASE_URL ?>/?p=actualizar_producto">
            <input name="id" type="hidden" value="<?php echo $producto->id ?>">
            <input name="tokenCSRF" type="hidden" value="<?php echo $tokenCSRF ?>">
            <div class="form-group">
                <label for="descripcion">Descripción del Producto</label>
                <input value="<?php echo htmlentities($producto->descripcion) ?>" autofocus name="descripcion"
                       autocomplete="off" required type="text" class="form-control" id="descripcion"
                       placeholder="Por ejemplo: Factura">
            </div>
            <div class="form-group">
                <label for="valor">Valor unitario</label>
                <input value="<?php echo htmlentities($producto->valor) ?>" autofocus name="valor"
                       autocomplete="off" required type="text" class="form-control" id="valor"
                       placeholder="0.00">
            </div>
            <div class="form-group">
                <label for="calculaIva">Calcula IVA</label>
                <input value="<?php echo htmlentities($producto->calculaIva) ?>" autofocus name="calculaIva"
                       autocomplete="off" required type="text" class="form-control" id="calculaIva"
                       placeholder="SI/NO">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-success" href="<?php echo BASE_URL ?>/?p=productos">&larr; Volver</a>
        </form>
    </div>
</div>