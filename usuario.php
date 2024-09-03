<?php 

//Importar la conexcion
require 'includes/app.php';
$db = conectarDB();

//Crear un email y password
$email = "correo@correo.com";
$password = "123456";

//Hashear password (siempre son 60 caracteres)
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

//Query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ( '{$email}', '{$passwordHash}'); ";

//echo $query;

//Agregrarlo a la db
mysqli_query($db, $query);