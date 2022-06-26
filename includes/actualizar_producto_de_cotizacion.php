<?php
if (
    empty($_POST["idProducto"])
    ||
    empty($_POST["idCotizacion"])
    ||
    empty($_POST["costo"])
    ||
    empty($_POST["cantidad"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit("Uno o más datos no fueron enviados");
}
Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);

Cotizaciones::actualizarProducto(
    $_POST["idProducto"],
    $_POST["idCotizacion"],
    $_POST["costo"],
    $_POST["cantidad"]
);
Utiles::redireccionar("detalles_caracteristicas_cotizacion&id=" . $_POST["idCotizacion"]);