<?php
if (
    empty($_POST["calculaIva"])
    ||
    empty($_POST["descripcion"])
    ||
    empty($_POST["valor"])
    ||
    empty($_POST["id"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit;
}
Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);

Productos::actualizar($_POST["id"], $_POST["descripcion"], $_POST["valor"], $_POST["calculaIva"]);
Utiles::redireccionar("productos");
