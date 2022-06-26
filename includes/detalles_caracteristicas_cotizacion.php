<?php
if (empty($_GET["id"])) {
    exit;
}

$cotizacion = Cotizaciones::porId($_GET["id"]);
if (!$cotizacion) {
    exit("No existe la cotización");
}

$productos = Productos::todos();
$detalleProductos = Cotizaciones::productosPorId($_GET["id"]);
$caracteristicas = Cotizaciones::caracteristicasPorId($_GET["id"]);
$tokenCSRF = Utiles::obtenerTokenCSRF();
$porc = PORC_IVA;
?>
<div id="app">
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <div class="col-sm-8">
                    <h3>Productos</h3>
                    <div class="alert alert-info">
                        <p>Añada Productos que tienen un costo y precio, al final se calcularán los totales</p>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                        <th>Editar</th>
                                        <th>Eliminar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $costoTotal = 0;
                                    $tiempoTotal = 0;
                                    $baseImponibleIva = 0;
                                    $baseImponibleSinIva = 0;
                                    ?>
                                    <?php
                                    foreach ($detalleProductos as $detalleProd) {
                                        $costoTotal += $detalleProd->costo_total;
                                        if ($detalleProd->calculaIva=="SI") {
                                            $baseImponibleIva += $detalleProd->costo_total;
                                        }
                                        else {
                                            $baseImponibleSinIva += $detalleProd->costo_total;
                                        }
                                        /*$cantidadTotal += $detalleProd->cantidad;*/
                                        ?>
                                        <tr>
                                            <td><?php echo htmlentities($detalleProd->descripcion) ?></td>
                                            <td class="text-nowrap">{{<?php echo htmlentities($detalleProd->costo_unitario) ?> |
                                                dinero}}
                                            </td>
                                            <td>
                                                {{<?php echo htmlentities($detalleProd->cantidad) ?>
                                                }}
                                            </td>
                                            <td>
                                                {{<?php echo htmlentities($detalleProd->costo_total) ?> |
                                                dinero}}
                                            </td>
                                            <td>
                                                <a
                                                        class="btn btn-warning"
                                                        href="<?php printf('%s/?p=editar_producto_de_cotizacion&idCotizacion=%s&idDetProducto=%s', BASE_URL, $cotizacion->id, $detalleProd->id_producto) ?>">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a
                                                        class="btn btn-danger"
                                                        href="<?php printf('%s/?p=eliminar_producto_de_cotizacion&idCotizacion=%s&tokenCSRF=%s&idProducto=%s', BASE_URL, $cotizacion->id, $tokenCSRF, $detalleProd->id_producto) ?>">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <?php
                                            $valorIva = $baseImponibleIva * $porc / 100;
                                            $totalCotizacion = $baseImponibleIva + $baseImponibleSinIva + $valorIva;
                                        ?>
                                        <tr>
                                            <td><strong>Base Imponible Iva <?php echo $porc ?>%</strong></td>
                                            <td class="text-nowrap"><strong>{{<?php echo htmlentities($baseImponibleIva) ?> |
                                                    dinero}}</strong></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Base Imponible Iva 0%</strong></td>
                                            <td class="text-nowrap"><strong>{{<?php echo htmlentities($baseImponibleSinIva) ?> |
                                                    dinero}}</strong></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>IVA <?php echo $porc ?>%</strong></td>
                                            <td class="text-nowrap"><strong>{{<?php echo htmlentities($valorIva) ?> |
                                                    dinero}}</strong></td>
                                            <td colspan="2"></td>
                                        </tr>
                                        <tr>
                                            <td><strong>Total Cotización</strong></td>
                                            <td class="text-nowrap"><strong>{{<?php echo htmlentities($totalCotizacion) ?> |
                                                    dinero}}</strong></td>
                                            <td colspan="2"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h3>Agregar nuevo Producto</h3>
                    <form method="post" action="<?php echo BASE_URL ?>/?p=agregar_producto_a_cotizacion">
                        <input type="hidden" name="idCotizacion" value="<?php echo $_GET["id"] ?>">
                        <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
                        <div class="form-group">
                            <label for="idProducto">Producto</label>
                            <select required class="form-control" name="idProducto" id="idProducto">
                            <option value="-1"></option>
                                <?php foreach ($productos as $producto) { ?>
                                    <option value="<?php echo $producto->id ?>"><?php echo htmlentities($producto->descripcion) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="costo">Precio Unitario</label>
                            <input name="costo" autocomplete="off" required type="decimal" class="form-control"
                                   id="costo" placeholder="Costo">
                        </div>
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input name="cantidad" autocomplete="off" required type="number" class="form-control"
                                   id="cantidad" placeholder="Cantidad">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
            <hr>
            <div class="row">
                <?php include_once BASE_PATH . "/includes/publicidad.php" ?>                
            </div>
            <div class="row">
                <div class="col-sm-8">
                    <h3>Características</h3>
                    <div class="alert alert-info">
                        <p>Las cosas que ayudan a describir la cotización</p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Característica</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($caracteristicas as $caracteristica) {
                                ?>
                                <tr>
                                    <td><?php echo htmlentities($caracteristica->caracteristica); ?></td>
                                    <td>
                                        <a
                                                class="btn btn-warning"
                                                href="<?php printf('%s/?p=editar_caracteristica_de_cotizacion&idCotizacion=%s&idCaracteristica=%s', BASE_URL, $cotizacion->id, $caracteristica->id) ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a
                                                class="btn btn-danger"
                                                href="<?php printf('%s/?p=eliminar_caracteristica_de_cotizacion&idCotizacion=%s&tokenCSRF=%s&idCaracteristica=%s', BASE_URL, $cotizacion->id, $tokenCSRF, $caracteristica->id) ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-sm-4">
                    <h3>Agregar característica</h3>
                    <form method="post" action="<?php echo BASE_URL ?>/?p=agregar_caracteristica_a_cotizacion">
                        <input type="hidden" name="idCotizacion" value="<?php echo $_GET["id"] ?>">
                        <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
                        <div class="form-group">
                            <label for="caracteristica">Característica</label>
                            <input name="caracteristica" autocomplete="off" required type="text" class="form-control"
                                   id="caracteristica" placeholder="Algo que ayude a describir la cotización">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new Vue({
            el: "#app",
        });
    });
</script>
