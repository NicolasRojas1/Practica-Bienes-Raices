<?php

use App\Propiedad;
use App\Vendedor;
//Para usar intervention
use Intervention\Image\ImageManagerStatic as Image;

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

//Obtener todos los vendedores
$vendedores = Vendedor::all();

//Se llena automaticamente por que el template del formulario tiene un echo a cada elemento

// Arreglo con mensajes de errores
$errores = Propiedad::getErrores();

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Asignar los atributos
    $args = $_POST['propiedad'];

    //Sincronizo datos con lo escrito por el usuario a lo que existia en memoria
    $propiedad->sincronizar($args);

    // Recorre el arreglo que esta en memoria y trae los errores que se presenten
    $errores = $propiedad->validar();

    //Generar un nombre unico, crea un id unico imposible que se repita
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Subida de archivos
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //Realiza un resize a la imagen con Intervention
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);

        //En la db guarda el nombre unico de la imagen
        $propiedad->setImagen($nombreImagen);
    }

    //Revisamos el arreglo de errores, debe estar vacio
    if (empty($errores)) {

        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            //Almacenar la imagen
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }
        //Actualizo el registro
        $propiedad->guardar();
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