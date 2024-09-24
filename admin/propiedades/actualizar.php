<?php

use App\Propiedad;

require '../../includes/app.php';

estaAutenticado();

//Obteniendo el id que paso por la url
$id = $_GET['id'];
//para prevenir que pasen otro elemento que no sea el id (solo enteros)
$id = filter_var($id, FILTER_VALIDATE_INT);

//evito que jueguen con la URL
if (!$id) {
    header('Location: /bienesraices/admin/index.php');
}

//Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);

//Se llena automaticamente por que el template del formulario tiene un echo a cada elemento

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Validar errores
$errores = Propiedad::getErrores();

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los atributos
    $args= $_POST['propiedad'];

    //Sincronizo datos con lo escrito por el usuario a lo que existia en memoria
    $propiedad->sincronizar($args);

    // Recorre el arreglo que esta en memoria y trae los errores que se presenten
    $errores = $propiedad->validar();

    //Revisamos el arreglo de errores, debe estar vacio
    if (empty($errores)) {

        // --- Subir Archivos ---

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        //Pregunta si la carpeta no existe
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        //Reemplazo la imagen en la actualizacion
        if ($imagen['name']) {
            //Para eliminar archivos
            unlink($carpetaImagenes . $propiedad['imagen']);

            //Generar un nombre unico
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Subir la imagen a la carpeta creada
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            //Si no se ingresa una nueva imagen, mantiene la que ya esta en la db
            $nombreImagen = $propiedad['imagen'];
        }

        //Actualizar propiedad en la db
        $query = " UPDATE propiedades SET titulo = '{$titulo}', precio = {$precio}, imagen = '{$nombreImagen}', descripcion = '{$descripcion}', habitaciones = {$habitaciones}, wc = {$wc}, estacionamiento = {$estacionamiento}, vendedorId = {$vendedorId} WHERE id = {$id}";

        //echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar al usuario, solo funciona si no hay nada de HTML previo
            header('Location: /bienesraices/admin/index.php?resultado=2');
        }
    }
}

//Templates
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php }
    ?>

    <!-- Elimino el action, para que se envie en este mismo archivo -->
    <form class="formulario" method="POST" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>
?>