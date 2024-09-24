<?php
require '../../includes/app.php';

use App\Propiedad;
//Para usar intervention
use Intervention\Image\ImageManagerStatic as Image;

// Verificar el logueo
estaAutenticado();

//DB
$db = conectarDB();

$propiedad = new Propiedad();

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo para validar datos de entrada, este se encuentra en la clase
$errores = Propiedad::getErrores();
//debuguear($errores);

//Si se usa el formulario imprima en var dump esa informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Nueva instancia de propiedad, la clase propiedad toma un arreglo y el metodo post tambien es un arreglo
    $propiedad = new Propiedad($_POST['propiedad']);

    //Crear carpeta
    $carpetaImagenes = '../../imagenes/';

    //Generar un nombre unico, crea un id unico imposible que se repita
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Si existe esa imagen, se setea
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        //Realiza un resize a la imagen con Intervention
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);

        //En la db guarda el nombre unico de la imagen
        $propiedad->setImagen($nombreImagen);
    }

    //Valida errores, si existen se guardan en este arreglo
    $errores = $propiedad->validar();

    //Revisamos el arreglo de errores, debe estar vacio para guardar
    if (empty($errores)) {

        //Si no existe la carpeta la crea
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guarda la imagen en el servidor (la ubicacion y su nombre)
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        //Guarda en la db
        $resultado = $propiedad->guardar();

        //Mensaje de exito
        if ($resultado) {
            // Redireccionar al usuario
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

    <form class="formulario" method="POST" action="/bienesraices/admin/propiedades/crear.php"
        enctype="multipart/form-data">
        
        <?php include '../../includes/templates/formulario_propiedades.php'; ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>