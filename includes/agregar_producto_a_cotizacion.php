<?php
if (
    empty($_POST["idCotizacion"])
    ||
    empty($_POST["idProducto"])
    ||
    empty($_POST["costo"])
    ||
    empty($_POST["cantidad"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit;
}
Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);

Cotizaciones::agregarProducto($_POST["idCotizacion"], $_POST["idProducto"], $_POST["costo"], $_POST["cantidad"]);
Utiles::redireccionar("detalles_caracteristicas_cotizacion&id=" . $_POST["idCotizacion"]);
