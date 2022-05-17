<?php
if (
    empty($_POST["username"])
    ||
    empty($_POST["correo"])
    ||
    empty($_POST["pass"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit("Uno o más datos no fueron enviados");
}

Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);
Usuarios::nuevo($_POST["correo"], $_POST["username"], $_POST["pass"]);
Utiles::redireccionar("login");
