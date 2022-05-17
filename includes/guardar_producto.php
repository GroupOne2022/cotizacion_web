<?php
if (
    empty($_POST["image"])
    ||
    empty($_POST["valor"])
    ||
    empty($_POST["descripcion"])
    ||
    empty($_POST["tokenCSRF"])
) {
    exit;
}

$check = getimagesize($_FILES["image"]["tmp_name"]);
if($check !== false){
    $image = $_FILES['image']['tmp_name'];
    $imgContent = addslashes(file_get_contents($image));
}else{
    echo "Please select an image file to upload.";
    exit;
}

Utiles::salirSiTokenCSRFNoCoincide($_POST["tokenCSRF"]);
Productos::nuevo($_POST["descripcion"], $_POST["valor"], $_POST["imgContent"]);
Utiles::redireccionar("productos");