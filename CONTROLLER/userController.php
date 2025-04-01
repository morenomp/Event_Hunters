<!-- 
OBJETIVOS:

· Un único formulario de login
· Comprobar los datos (si son correctos en la base de datos)
· Usaremos MySQLI
· Si no funciona/es incorrecto, nos quedaremos en la misma página y saldrá un mesanje de error
· Si estas logueado puedes hacer logout, si no (en incognito por ejemplo) no dejará
· Tenemnos que hacer que el usuario admin pueda ver cosas que un usuario normal no puede

· Deben haber dos formularios diferentes para un admin y para un usuario normal
· Si registramos un usuario que ya existe debe dar error
· Solo el admin puede subir una imagen de perfil
· Al darle a logout limpiaremos todo

· Toda la información se debe guardar en MySQL
· Se debe usar un único php llamado userController, que hará registro, login y logout
· Añadir validaciones
-->
<!-- 
Este php no se usará todavía, ya que es el controlador que haremos con Jose
-->

<?php
session_start();

// Le pasamos los datos que vamos a usar para crear la base de datos:
$server = "localhost";
$user = "root";
$password = "";
$dbname = "event_hunters";

// Iniciamos la conexion a traves de un objeto que iremos llamando en el código.
// A este objeto le pasaremos el server, user y la password, ya que nos servirá de conexión.
$conn = new mysqli($server, $user, $password); 

// Creamos la base de datos,...
$sql = "CREATE DATABASE IF NOT EXISTS $dbname"; 

//...y hacemos la comprobacion de que funciona correctamente,...
if ($conn->query($sql) === TRUE) {

    echo "Base de datos creada o ya existente.<br>";

} else {

// ...en el caso de que no funcione, no sigue leyendo el script.
// Usaremos la propiedad "die", la cual se utiliza para finalizar inmediatamente 
// la ejecución de un script y mostrar un mensaje
    die("Error creando la base de datos: " . $conn->error);
}

// Seleccionaremos la base de datos que vamos a usar.
$conn->select_db($dbname); 

// Le pasamos la tabla que queremos crear, y comprobamos de nuevo si funciona correctamente,...
$sql = "CREATE TABLE IF NOT EXISTS USUARIOS ( 
    id INT PRIMARY KEY AUTO_INCREMENT,
    name varchar(25), 
    email varchar(50),
    password varchar(50));"; 

//...y hacemos la comprobacion de que funciona correctamente,...
if ($conn->query($sql) === TRUE) {

    echo "Tabla creada o ya existente.<br>";

} else {

    // ...si no pasamos un die al script.
    die("Error creando la tabla: " . $conn->error);
}

//--------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new userController;

    if (isset($_POST["btnLogin"])) {

        echo "<p>Login button is clicked</p>";
        $user->login();

    } else if (isset($_POST["register"])) {

        echo "<p>Register button is clicked</p>";
        $user->register();

    } else if (isset($_POST["logout"])) {

        echo "<p>Logout button is clicked</p>";
        $user->logout();
    }
}

class userController
{
    private $connect;


    function login()
    {

        echo __LINE__;
    }

    function register()
    {

        echo __LINE__;
    }

    function logout()
    {

        echo __LINE__;
    }
}
?>