<?php
//Siempre debo iniciar la sesion para poder trabajar con sus propiedades
session_start();

//Para cerrarla solo se vuelve a dejar el arreglo vacio
$_SESSION = [];

//Redirijo
header('Location: /bienesraices/index.php');

?>