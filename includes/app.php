<?php
// Archivo principal que va a llamar funciones y clases

require 'funciones.php';
require 'config/database.php';
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '../../classes/Propiedad.php';

// Conectarse a la DB
$db = conectarDB();

//Asi utilizo la conexion a la db en la clase activeRecord y esta hereda a las demas
use App\ActiveRecord;

ActiveRecord::setDB($db);