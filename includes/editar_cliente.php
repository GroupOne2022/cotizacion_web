<?php
if (empty($_GET["id"])) exit;
$cliente = Clientes::porId($_GET["id"]);
if ($cliente === null || $cliente === FALSE) {
    Utiles::redireccionar("clientes");
}
$tokenCSRF = Utiles::obtenerTokenCSRF();
?>
<div class="row">
    <div class="col-sm">
        <h1>Editar cliente</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <form method="post" action="<?php echo BASE_URL ?>/?p=actualizar_cliente">
            <input name="id" type="hidden" value="<?php echo $cliente->id ?>">
            <input name="tokenCSRF" type="hidden" value="<?php echo $tokenCSRF ?>">
            <div class="form-group">
                <label for="identificacion">Identificación del Cliente</label>
                <input value="<?php echo htmlentities($cliente->identificacion) ?>" autofocus name="identificacion"
                       autocomplete="off" required type="text" class="form-control" id="identificacion"
                       placeholder="Por ejemplo: 0900457896">
            </div>
            <div class="form-group">
                <label for="razonSocial">Nombre o razón social</label>
                <input value="<?php echo htmlentities($cliente->razonSocial) ?>" autofocus name="razonSocial"
                       autocomplete="off" required type="text" class="form-control" id="razonSocial"
                       placeholder="Por ejemplo: Fabián Andrade Espinoza">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input value="<?php echo htmlentities($cliente->direccion) ?>" autofocus name="direccion"
                       autocomplete="off" required type="text" class="form-control" id="direccion"
                       placeholder="Por ejemplo: Victor Emilio Estrada y las Monjas">
            </div>
            <div class="form-group">
                <label for="celular">Celular Cliente</label>
                <input value="<?php echo htmlentities($cliente->celular) ?>" autofocus name="celular"
                       autocomplete="off" required type="text" class="form-control" id="celular"
                       placeholder="Por ejemplo: 0963293359">
            </div>
            <div class="form-group">
                <label for="correo">Correo Cliente</label>
                <input value="<?php echo htmlentities($cliente->correo) ?>" autofocus name="correo"
                       autocomplete="off" required type="text" class="form-control" id="correo"
                       placeholder="Por ejemplo: nombre@dominio.com">
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-success" href="<?php echo BASE_URL ?>/?p=clientes">&larr; Volver</a>
        </form>
    </div>
</div>