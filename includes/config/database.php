<?php

function conectarDB() : mysqli { //para que retorne una conexion a mysqli
    $db = new mysqli('localhost', 'root', 'admin', 'bienesraices_crud');

    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }

    return $db;
        
}