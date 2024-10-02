<?php

require '../../includes/app.php';

use App\Vendedor;

//Verifico acceso
estaAutenticado();

//Validar que sea un ID válido
$id = $_GET['id'];
//Filter es similar a una expresion regular, que verifica que sea un id válido
$id = filter_var($id, FILTER_VALIDATE_INT);  

//Compruebo si existe el id
if (!$id) {
    header('Location: /bienesraices/admin/index.php');
}

//Obtener el arreglo del vendedor de la db
$vendedor = Vendedor::find($id);

//Arreglo con mensajes de errores
$errores = Vendedor::getErrores();

//Verifico una solicitud HTTP si es de tipo POST, para el envio de datos al servidor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Sincronizo el objeto en memoria, con los nuevos datos que se envian (para no tener que reescribir todo el formulario al editar)
    $args = $_POST['vendedor'];

    //Ya con esto los cambios en el formulario los toma
    $vendedor->sincronizar($args);

    //Validacion de errores
    $errores = $vendedor->validar();

    //En caso de que no hayan errores
    if (empty($errores)) {
        $vendedor->guardar();
    }
}

//Templates
incluirTemplate('header');

?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor</h1>

    <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php }
    ?>

    <form class="formulario" method="POST">
        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>