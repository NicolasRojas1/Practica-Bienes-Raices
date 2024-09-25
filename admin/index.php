<?php

require '../includes/app.php';
estaAutenticado();

use App\Propiedad;

//asigno el arreglo de objetos a propiedades
$propiedades = Propiedad::all();

//Mostrar mensaje condicional
$resultado = $_GET['resultado'] ?? null;

//Por que se envia el formulario de eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {

        //Obtener los datos de la propiedad
        $propiedad = Propiedad::find($id);

        $propiedad->eliminar();


    }
}

//Incluir template
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if (intval($resultado) === 1): ?>
        <p class="alerta exito">Anuncio creado correctamente</p>
    <?php elseif (intval($resultado) === 2): ?>
        <p class="alerta exito">Propiedad actualizada correctamente</p>
    <?php elseif (intval($resultado) === 3): ?>
        <p class="alerta exito">Anuncio eliminado correctamente</p>
    <?php endif; ?>

    <a href="/bienesraices/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody> <!-- Mostrar los resultados de la db -->
            <?php foreach( $propiedades as $propiedad): ?>
                <tr>
                    <td> <?php echo $propiedad->id; ?> </td>
                    <td> <?php echo $propiedad->titulo; ?> </td>
                    <td> <img src="../imagenes/<?php echo $propiedad->imagen ?>" class="imagen-tabla"> </td>
                    <td> $ <?php echo $propiedad->precio; ?> </td>
                    <td>
                        <!-- De este modo envio el id para poder eliminar el registro-->
                        <form method="POST" class="w-100">

                            <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">

                            <input type="submit" class="boton-rojo-block" value="Eliminar"></input>

                        </form>
                        <a href="propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<?php
//Cerrar la conexion de la db
mysqli_close($db);

incluirTemplate('footer');
?>