<?php

function conectarDB() : mysqli { //para que retorne una conexion a mysqli
    $db = mysqli_connect('localhost', 'root', 'admin', 'bienesraices_crud');

    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
        
}