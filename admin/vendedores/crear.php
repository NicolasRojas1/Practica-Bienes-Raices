<?php

require '../../includes/app.php';

use App\Vendedor;

//Verifico acceso
estaAutenticado();

//Creo un vendedor
$vendedor = new Vendedor();

//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

//Verifico una solicitud HTTP si es de tipo POST, para el envio de datos al servidor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Crear una nueva instancia, arreglo por que vendedor es un arreglo
    $vendedor = new Vendedor($_POST['vendedor']);

    //Validar que no hayan campos vacios
    $errores = $vendedor->validar();

    //Si no hay errores
    if(empty($errores)) {
        $vendedor->guardar();
    }
}

//Templates
incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Registrar Vendedor</h1>

    <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php }
    ?>

    <form class="formulario" method="POST" action="/bienesraices/admin/vendedores/crear.php">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Registrar Vendedor" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>