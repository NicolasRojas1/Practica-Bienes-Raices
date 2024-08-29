<?php
//Conexion a la db
require 'includes/config/database.php';
$db = conectarDB();

//Capturando errores
$errores = [];

//Autenticas el usuario
//Se ejecuta al darle clic a iniciar sesion, ahi si aparece la informacion por var dump
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //var_dump($_POST); 

    //Asignando las variables de POST  a las variables y con mysqli evito la inyeccion SQL
    $email = mysqli_real_escape_string( $db, filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL) );

    $password = mysqli_real_escape_string( $db, $_POST['password'] );

    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El password es obligatorio";
    }

    if (empty($errores)) {
        
        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
        $resultado = mysqli_query($db, $query);

        

        //Num rows me permite saber si un registro existe
        if ( $resultado -> num_rows) {
            //Ahora si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado);
            var_dump($usuario);

            //Verificar si el password es correcto o no
            $auth= password_verify($password, $usuario['password']);
            
            if ($auth) {
                //El usuario esta autenticado
                session_start();

                //Arreglo del usuario que inicia sesion
                $_SESSION['usuario'] = $usuario['email'];
                //variable para acceder al panel de admin
                $_SESSION['login'] = true;

            } else {
                $errores[] = "El password es incorrecto";
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

}


//Incluye el header
require 'includes/funciones.php';
incluirTemplate('header');
?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach($errores as $error):?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form class="formulario" method="POST">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Ingresa tu email" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Ingresa tu contraseña" id="password">
        </fieldset>

        <input type="submit" value="Iniciar Sesión" class="boton-verde">
    </form>

</main>

<?php
incluirTemplate('footer');
?>