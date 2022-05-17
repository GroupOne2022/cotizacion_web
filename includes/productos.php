<?php
$productos = Productos::todos();
$tokenCSRF = Utiles::obtenerTokenCSRF();
?>

<div class="row">
    <div class="col-sm">
        <h1>Productos</h1>
        <p>Detalle de Productos de la Imprenta</p>
    </div>
</div>


<div class="row">
    <div class="col-sm">
        <p>
            <a href="<?php echo BASE_URL ?>/?p=nuevo_producto" class="btn btn-success">
                <i class="fa fa-plus"></i> Nuevo Producto
            </a>
        </p>
    </div>
    <?php include_once BASE_PATH . "/includes/publicidad.php" ?>
</div>

<div class="row">
    <div class="col-sm">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Descripción Producto</th>
                    <th>Valor</th>
                    <th>Imagen</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($productos as $producto) { ?>
                    <tr>
                        <td><?php echo $producto->id ?></td>
                        <td><?php echo htmlentities($producto->descripcion) ?></td>
                        <td><?php echo htmlentities($producto->valor) ?></td>
                        <td><?php echo htmlentities($producto->image)['image']; "Content-type: image/jpg"?></td>
                        <td>
                            <a class="btn btn-warning"
                               href="<?php echo BASE_URL ?>/?p=editar_producto&id=<?php echo $producto->id ?>">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger"
                               href="<?php echo BASE_URL ?>/?p=eliminar_producto&id=<?php echo $producto->id ?>&tokenCSRF=<?php echo $tokenCSRF ?>">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>