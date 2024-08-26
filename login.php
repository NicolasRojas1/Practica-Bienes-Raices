<?php
//Require se utiliza para funciones, codigo mas complejo
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <form class="formulario">

        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Email</label>
            <input type="email" placeholder="Ingresa tu email" id="email">

            <label for="password">Password</label>
            <input type="password" placeholder="Ingresa tu contraseña" id="password">
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>