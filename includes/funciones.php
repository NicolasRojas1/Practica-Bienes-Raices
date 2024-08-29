<?php

require 'app.php';

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado(): bool{
    session_start();

    //variable creada en el login
    $auth = $_SESSION['login'];

    if ($auth) {
        return true;
    }
    return false;
}
