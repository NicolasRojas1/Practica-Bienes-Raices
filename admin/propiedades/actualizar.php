<?php

//Obteniendo el id que paso por la url
$id = $_GET['id'];
//para prevenir que pasen otro elemento que no sea el id (solo enteros)
$id = filter_var($id, FILTER_VALIDATE_INT);

//evito que jueguen con la URL
if (!$id) {
    header('Location: /bienesraices/admin/index.php');
}

//conexion a la DB
require '../../includes/config/database.php';
$db = conectarDB();

//Obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = ${id}";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

// echo "<pre>";
// var_dump($propiedad);
// echo "</pre>";

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo para validar datos de entrada
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedorId'];
$imagenPropiedad = $propiedad['imagen'];

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

    //Asi capturo la informacion del formulario
    $titulo = mysqli_real_escape_string($db,  $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db,  $_POST['vendedor']);
    $creado = date('Y/m/d');

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
        $query = " UPDATE propiedades SET titulo = '${titulo}', precio = ${precio}, imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id}";

        //echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar al usuario, solo funciona si no hay nada de HTML previo
            header('Location: /bienesraices/admin/index.php?resultado=2');
        }
    }
}

//Templates
require '../../includes/funciones.php';
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
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

            <!-- Para ver la imagen cuando se este editando la propiedad -->
            <img src="../../imagenes/<?php echo $imagenPropiedad; ?>" class="imagen-small">

            <label for="descripcion">Descripcion:</label>
            <textarea id="descripcion" name="descripcion"><?php echo $descripcion ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input
                type="number"
                id="habitaciones"
                name="habitaciones"
                placeholder="Ej: 2"
                min="1"
                max="9"
                value="<?php echo $habitaciones ?>">

            <label for="wc">Baños:</label>
            <input
                type="number"
                id="wc"
                name="wc"
                placeholder="Ej: 2"
                min="1"
                max="9"
                value="<?php echo $wc ?>">

            <label for="estacionamiento">Estacionamiento:</label>
            <input
                type="number"
                id="estacionamiento"
                name="estacionamiento"
                placeholder="Ej: 2"
                min="1"
                max="9"
                value="<?php echo $estacionamiento ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>
?>