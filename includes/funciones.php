<?php

//Con el __DIR__ se trae la ruta completa php
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado() {
    session_start();

    //Si no esta autenticado
    if (!$_SESSION['login']) {
        header('Location: /bienesraices/index.php');
    }
    return true;
}

function debuguear($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}

// Escapa / Sanitizar el HTML, para evitar la inyección de código al ingresar datos en los formularios
function s($html) {
    // Asegurarse de que siempre sea una cadena válida, incluso si es null
    $s = htmlspecialchars($html ?? '', ENT_QUOTES, 'UTF-8');
    return $s;
}



