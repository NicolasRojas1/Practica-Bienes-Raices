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

//Arreglo para validar datos de entrada
$errores = [];

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los atributos
    $args= $_POST['propiedad'];

    //Sincronizo datos con lo escrito por el usuario a lo que existia en memoria
    $propiedad->sincronizar($args);

    debuguear($propiedad);

    //Asigno files hacia una variable
    $imagen = $_FILES['imagen'];


    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripcion y debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "El numero de habitaciones es obligatorio";
    }

    if (!$wc) {
        $errores[] = "El numero de baños es obligatorio";
    }

    if (!$estacionamiento) {
        $errores[] = "El numero de estacionamiento es obligatorio";
    }

    if (!$vendedorId) {
        $errores[] = "Elige un vendedor";
    }

    //Valido por el tamaño (màximo de 1 mb) 
    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = 'La imagen es muy pesada';
    }

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