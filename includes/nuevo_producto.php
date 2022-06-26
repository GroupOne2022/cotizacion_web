<?php
$tokenCSRF = Utiles::obtenerTokenCSRF();
?>
<div class="row">
    <div class="col-sm">
        <h1>Nuevo Producto</h1>
    </div>
</div>
<div class="row">
    <div class="col-sm">
        <form method="post" action="<?php echo BASE_URL ?>/?p=guardar_producto">
            <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
            <div class="form-group">
                <label for="descripcion">Descripcion Producto</label>
                <input autofocus name="descripcion" autocomplete="off" required type="text" class="form-control"
                       id="descripcion" placeholder="Por ejemplo: Facturas">
            </div>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input autofocus name="valor" autocomplete="off" required type="text" class="form-control"
                       id="valor" placeholder="Por ejemplo: 0.00">
            </div>
            <div class="form-group">
                <label for="calculaIva">Calcula IVA</label>
                <select required class="form-control" name="calculaIva" id="calculaIva">
                    <option value=""></option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-success" href="<?php echo BASE_URL ?>/?p=productos">&larr; Volver</a>
        </form>
    </div>
</div>