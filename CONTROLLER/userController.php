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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new userController;

    if (isset($_POST["login"])) {
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