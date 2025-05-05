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

//--------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new userController;

    if (isset($_POST["btnLogin"])) {

        echo "<p>Login button is clicked</p>";
        $user->login();
    } else if (isset($_POST["btnRegistro"])) {

        echo "<p>Register button is clicked</p>";
        $user->register();
    } else if (isset($_POST["logout"])) {

        echo "<p>Logout button is clicked</p>";
        $user->logout();
    }
}

class userController
{
    private $conn;

    public function __construct()
    {
        // Le pasamos los datos que vamos a usar para crear la base de datos:
        $server = "localhost";
        $user = "root";
        $password = "";
        $dbname = "event_hunters";

        // Iniciamos la conexion a traves de un objeto que iremos llamando en el código.
        // A este objeto le pasaremos el server, user y la password, ya que nos servirá de conexión.
        $this->conn = new mysqli($server, $user, $password);

        // Creamos la base de datos,...
        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

        //...y hacemos la comprobacion de que funciona correctamente,...
        if ($this->conn->query($sql) === TRUE) {

            echo "Base de datos creada o ya existente.<br>";
        } else {

            // ...en el caso de que no funcione, no sigue leyendo el script.
            // Usaremos la propiedad "die", la cual se utiliza para finalizar inmediatamente 
            // la ejecución de un script y mostrar un mensaje
            die("Error creando la base de datos: " . $this->conn->error);
        }

        // Seleccionaremos la base de datos que vamos a usar.
        $this->conn->select_db($dbname);

        // Le pasamos la tabla que queremos crear, y comprobamos de nuevo si funciona correctamente,...
        $sql = "CREATE TABLE IF NOT EXISTS USUARIOS ( 
                id INT PRIMARY KEY AUTO_INCREMENT,
                name varchar(25), 
                email varchar(50),
                password varchar(50));";

        //...y hacemos la comprobacion de que funciona correctamente,...
        if ($this->conn->query($sql) === TRUE) {

            echo "Tabla creada o ya existente.<br>";
        } else {

            // ...si no pasamos un die al script.
            die("Error creando la tabla: " . $this->conn->error);
        }
    }

    function login()
    {
        $mail = $_POST['mailLogin'];
        $password = $_POST['passwordLogin'];

        $sql = "SELECT email, name, password FROM USUARIOS WHERE email = ? AND password = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $mail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $_SESSION["logged"] = true;
            $_SESSION["email"] = $row['email'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["passwordLogin"] = $row['password'];

            $this->conn->close();

            header("Location: ../VIEW/cuenta.php");
            exit();
        } else {
            $_SESSION["logged"] = false;
            $_SESSION["email"] = null;
            $_SESSION["name"] = null;
            $_SESSION["passwordLogin"] = null;

            echo "Login failed";
        }


        echo __LINE__;
    }

    function register()
    {
        var_dump($_POST);
        $user = $_POST['nameRegistro'];
        $mail = $_POST['mailRegistro'];
        $password = $_POST['passwordRegistro'];

        $checkSql = "SELECT email FROM usuarios WHERE email = ?";

        $checkStmt = $this->conn->prepare($checkSql);
        $checkStmt->bind_param("s", $mail);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {

            echo "El correo ya está en uso.";
            echo __LINE__;
            return;
        } else {

            $sql = "INSERT INTO usuarios (name, email, password) VALUES (?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("sss", $user, $mail, $password);
            $stmt->execute();

            echo __LINE__;
        }
    }

    function logout()
    {

        $_SESSION["logged"] = false;
        header("Location: ../VIEW/cuenta.php");
        exit();
    }
}
?>