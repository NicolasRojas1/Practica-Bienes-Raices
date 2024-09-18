<?php
require '../../includes/app.php';

use App\Propiedad;

estaAutenticado();

//DB
$db = conectarDB();

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo para validar datos de entrada, este se encuentra en la clase
$errores = Propiedad::getErrores();
//debuguear($errores);

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamiento = '';
$vendedorId = '';

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Nueva instancia de propiedad, la clase propiedad toma un arreglo y el metodo post tambien es un arreglo
    $propiedad = new Propiedad($_POST);

    //Si existen errores se guardan en este arreglo
    $errores = $propiedad->validar();

    //Revisamos el arreglo de errores, debe estar vacio para guardar
    if (empty($errores)) {

        $propiedad->guardar();

        //Asigno files hacia una variable
        $imagen = $_FILES['imagen'];

        // --- Subir Archivos ---

        //Crear carpeta
        $carpetaImagenes = '../../imagenes/';

        //Pregunta si la carpeta no existe
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        //Generar un nombre unico, crea un id unico imposible que se repita cuyo nombre sera de la imagen
        $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

        //Subir la imagen a la carpeta creada
        //primer parametro la ruta temporal, segundo la carpeta 
        move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);



        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar al usuario, solo funciona si no hay nada de HTML previo
            header('Location: /bienesraices/admin/index.php?resultado=1');
        }
    }
}

//Templates
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>

    <a href="/bienesraices/admin/index.php" class="boton boton-verde">Volver</a>

    <?php
    foreach ($errores as $error) { ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php }
    ?>

    <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php" enctype="multipart/form-data">
        <fieldset>
            <legend>Informacion General</legend>

            <label for="titulo">Titulo:</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo ?>">

            <label for="precio">Precio:</label>
            <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

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

            <select name="vendedorId">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?> value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>