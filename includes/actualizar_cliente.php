<?php
if (
    empty($_POST["correo"])
    ||
    empty($_POST["celular"])
    ||
    empty($_POST["direccion"])
    ||
    empty($_POST["razonSocial"])
    ||
    empty($_POST["identificacion"])
    ||
    empty($_POST["id"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit;
}
Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);

Clientes::actualizar($_POST["id"], $_POST["identificacion"], $_POST["razonSocial"],  $_POST["direccion"], $_POST["celular"], $_POST["correo"]);
Utiles::redireccionar("clientes");
