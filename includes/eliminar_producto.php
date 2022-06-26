<?php
if (
    empty($_GET["id"])
    ||
    empty($_GET["tokenCSRF"])
) {
    exit;
}

Utiles::salirSiTokenCSRFNoCoincide($_GET["tokenCSRF"]);

Productos::eliminar($_GET["id"]);
Utiles::redireccionar("productos");
