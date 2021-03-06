<?php
if (empty($_GET["id"])) {
    exit("No se proporcionó un ID");
}

$cotizacion = Cotizaciones::porId($_GET["id"]);
if (!$cotizacion) {
    exit("No existe la cotización");
}
$porc = PORC_IVA;
$detalleProductos = Cotizaciones::productosPorId($_GET["id"]);
$caracteristicas = Cotizaciones::caracteristicasPorId($_GET["id"]);
$ajustes = Ajustes::obtener();
?>
<div id="app">
    <div class="row">
        <div class="col-sm">
            <h1>Cotización para <?php echo htmlentities($cotizacion->descripcion) ?></h1>
            <h3>Cotización número: <?php echo htmlentities($cotizacion->id) ?></h1>
            <h5>Identificación: <?php echo htmlentities($cotizacion->identificacion) ?></h5>
            <h5>Cliente: <?php echo htmlentities($cotizacion->razonSocial) ?></h5>
            <h5>Dirección Cliente: <?php echo htmlentities($cotizacion->direccion) ?></h5>
            <h5>Celular Cliente: <?php echo htmlentities($cotizacion->celular) ?></h5>
            <h5>Correo Cliente: <?php echo htmlentities($cotizacion->correo) ?></h5>
            <span class="badge badge-pill badge-success"><?php echo htmlentities($cotizacion->fecha) ?></span>
            <?php if (!empty($ajustes->mensajePresentacion)): ?>
                <p><?php echo htmlentities($ajustes->mensajePresentacion) ?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <br>
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Costo Unitario</th>
                            <th>Cantidad</th>
                            <th>Costo Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $costoTotal = 0;
                        $baseImponibleIva = 0;
                        $baseImponibleSinIva = 0;
                        foreach ($detalleProductos as $detalleProd) {
                            $costoTotal += $detalleProd->costo_total;
                            if ($detalleProd->calculaIva=="SI") {
                                $baseImponibleIva += $detalleProd->costo_total;
                            }
                            else {
                                $baseImponibleSinIva += $detalleProd->costo_total;
                            }
                            ?>
                            <tr>
                                <td><?php echo htmlentities($detalleProd->descripcion) ?></td>
                                <td>{{<?php echo htmlentities($detalleProd->costo_unitario) ?> | dinero}}</td>
                                <td>{{<?php echo htmlentities($detalleProd->cantidad) ?>}}</td>
                                <td>{{<?php echo htmlentities($detalleProd->costo_total) ?> | dinero}}</td>
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
    <div class="row">
        <div class="col-sm">
            <h2>Características</h2>
            <ul class="list-group">
                <?php foreach ($caracteristicas as $caracteristica) { ?>
                    <li class="list-group-item"><?php echo htmlentities($caracteristica->caracteristica) ?></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm">
            <?php if (!empty($ajustes->mensajeAgradecimiento)): ?>
                <p><?php echo htmlentities($ajustes->mensajeAgradecimiento) ?></p>
            <?php endif ?>

            <?php if (!empty($ajustes->remitente)): ?>
                <p>Atentamente,</p>
                <p><strong><?php echo htmlentities($ajustes->remitente) ?></strong></p>
            <?php endif ?>

            <?php if (!empty($ajustes->mensajePie)): ?>
                <p><?php echo htmlentities($ajustes->mensajePie) ?></p>
            <?php endif ?>
        </div>
    </div>
    <div class="row d-print-block d-sm-none">
        <hr>
        <div class="col-sm">
            Cotización creada en línea por: 
            <strong>GroupOne</strong>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <button @click="imprimir" class="btn btn-success d-print-none">Imprimir</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <br>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        new Vue({
            el: "#app",
            methods: {
                imprimir() {
                    let tituloOriginal = document.title;
                    document.title = "Cotización de <?php echo htmlentities($cotizacion->descripcion) ?> para <?php echo htmlentities($cotizacion->razonSocial) ?>";
                    window.print();
                    document.title = tituloOriginal;
                }
            },
        });
    });
</script>