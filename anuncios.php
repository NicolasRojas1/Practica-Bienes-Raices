<?php
//Require se utiliza para funciones, codigo mas complejo
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <section class="seccion contenedor">
        <h2>Casas y Apartamentos en Venta</h2>

        <?php
        $limite = 9;
        include 'includes/templates/anuncios.php';
        ?>

</main>

<?php
incluirTemplate('footer');
?>