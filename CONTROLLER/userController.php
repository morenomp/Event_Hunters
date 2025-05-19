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

<?php
session_start();

//--------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new userController;

    if (isset($_POST["btnLogin"])) {

        echo "<p>Login button is clicked</p>";
        $user->login();
    } else if (isset($_POST["btnRegistro"]) || isset($_POST["btnRegistroAdmin"])) {


        echo "<p>Register button is clicked</p>";
        if (isset($_POST["btnRegistro"])) {

            echo "<p>Is NOT admin</p>";
            $admin = false;
            $user->register($admin);
        } else {

            echo "<p>Is admin</p>";
            $admin = true;
            $user->register($admin);
        }
    } else if (isset($_POST["logout"])) {

        echo "<p>Logout button is clicked</p>";
        $user->logout();
    } else if (isset($_POST["btnBorrarUsuario"])) {

        echo "<p>Delete user button is clicked</p>";
        $user->delete();
    } else if (isset($_POST["btnModificar"])) {

        echo "<p>Modify button is clicked</p>";
        $user->modify();
    }
}

class userController
{
    private $conn;

    public function __construct()
    {
        $host = "localhost";
        $user = "root";
        $password = "";
        $dbname = "event_hunters";

        try {
            // Conexión sin base de datos para crearla
            $this->conn = new PDO("mysql:host=$host", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear la base de datos si no existe
            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
            $this->conn->exec($sql);
            echo "Base de datos creada o ya existente.<br>";

            // Ahora conectamos directamente a la base de datos
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Crear la tabla USUARIOS
            $sql = "CREATE TABLE IF NOT EXISTS USUARIOS ( 
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(25), 
                email VARCHAR(50),
                password VARCHAR(255),
                foto VARCHAR(255),
                rol ENUM('admin', 'user') DEFAULT 'user'
            )";

            $this->conn->exec($sql);
            echo "Tabla usuarios creada o ya existente.<br>";
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }


    function login()
    {
        $mail = $_POST['mailLogin'];
        $password = $_POST['passwordLogin'];

        //Dato importante:
        //Los usuarios normales no tienen foto (el campo de foto tendrá null).
        //En cambio los administradores sí tienen una imagen subida, por ende, si
        //que saldrá la imagen.
        $sql = "SELECT email, name, password, rol, foto FROM USUARIOS WHERE email = :email AND password = :password";

        $stmt = $this->conn->prepare($sql);

        //Que hace bind_param?
        //Está pasando cuatro variables ($user, $mail, $password, $rol) a 
        //la consulta, y las "s" le dicen al SQL de qué tipo es cada valor.
        //En este caso son "s" de String, si fueran "i" sería de Integer, etc.
        $stmt->execute([
            ':email' => $mail,
            ':password' => $password
        ]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $row = $result[0] ?? null;

        if ($row) {
            $_SESSION["logged"] = true;
            $_SESSION["email"] = $row['email'];
            $_SESSION["name"] = $row['name'];
            $_SESSION["passwordLogin"] = $row['password'];
            $_SESSION["foto"] = $row['foto'];
            $_SESSION["rol"] = $row['rol'];

            $this->conn = null; // En PDO, así se "cierra" la conexión


            //REDIRECCIÓN SEGÚN EL ROL
            if ($row['rol'] === 'admin') {
                header("Location: ../VIEW/cuentaAdmin.php");
            } else if ($row['rol'] === 'user') {
                header("Location: ../VIEW/cuenta.php");
            }
            exit();
        } else {
            $_SESSION["logged"] = false;
            $_SESSION["email"] = null;
            $_SESSION["name"] = null;
            $_SESSION["passwordLogin"] = null;
            $_SESSION["foto"] = null;
            $_SESSION["rol"] = null;

            echo "Login failed";
        }


        echo __LINE__;
    }

    function register($admin)
    {
        if ($admin) {


            $target_dir = "../upload/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "La imagen " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " ha sido subida.";
            } else {
                echo "Error al subir la imagen.";
                return;
            }

            $user = $_POST['nameRegistro'];
            $mail = $_POST['mailRegistro'];
            $password = $_POST['passwordRegistro'];
            $ruta = "../upload/" . basename($_FILES["fileToUpload"]["name"]);
            $rol = 'admin';

            $sql = "INSERT INTO usuarios (name, email, password, foto, rol) VALUES (:name, :email, :password, :foto, :rol)";
            $stmt = $this->conn->prepare(query: $sql);

            try {
                $stmt = $this->conn->prepare($sql);
            } catch (PDOException $e) {
                die('Error preparando la consulta: ' . $e->getMessage());
            }

            try {
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':name' => $user,
                    ':email' => $mail,
                    ':password' => $password,
                    ':foto' => $ruta,
                    ':rol' => $rol
                ]);

                echo "Administrador registrado correctamente.";
                header("Location: ../VIEW/cuentaAdmin.php"); // Redirigimos tras éxito
                exit();
            } catch (PDOException $e) {
                echo "Error al registrar el administrador: " . $e->getMessage();
                header("Location: ../VIEW/cuentaAdmin.php");
                exit();
            }
        } else {

            var_dump($_POST);
            $user = $_POST['nameRegistro'];
            $mail = $_POST['mailRegistro'];
            $password = $_POST['passwordRegistro'];
            $rol = 'user';

            $checkSql = "SELECT email FROM usuarios WHERE email = :email";

            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([
                ':email' => $mail
            ]); //Ejecuta la consulta
            $result = $checkStmt->fetchAll(PDO::FETCH_ASSOC);

            //SI el correo ya existe, muestra mensaje y termina
            if ($result[0] != null) {

                echo "El correo ya está en uso.";
                return;

                //SI NO existe, inserta un nuevo usuario
            } else {

                $sql = "INSERT INTO usuarios (name, email, password, rol) VALUES (:name, :email, :password, :rol)";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':name' => $user,
                    ':email' => $mail,
                    ':password' => $password,
                    ':rol' => $rol
                ]);

                header("Location: ../VIEW/cuenta.php");  // O la página que desees
                exit();
            }
        }
    }

    function logout()
    {
        session_unset();
        session_destroy();
        header("Location: ../VIEW/cuenta.php");
        exit();
    }

    function delete()
    {
        if ($_SESSION["logged"]) { // si no esta loggeado, directamente hace un echo
            try { // intenta borrar el usuario, si no pasa al catch que muestra un error
                $sql = "DELETE FROM USUARIOS WHERE email = :email";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':email' => $_SESSION["email"] // preparamos la sentencia sql
                ]);
                session_unset();
                session_destroy(); // eliminamos la session entera para que no hayan conflictos mas adelante
                header("Location: ../VIEW/cuentaAdmin.php");
                exit();
            } catch (PDOException $e) {
                echo "Error al borrar el usuario: " . $e->getMessage();
                header("Location: ../VIEW/index.php");
                exit();
            }
        } else {
            echo "The user is not logged";
        }
    }

    function modify()
    {
        if ($_SESSION["logged"]) {
            try {
                $name = $_POST["name"] ?? null;
                $pswd = $_POST["password"] ?? null;
                if ($pswd == null) {
                    $pswd = $_SESSION["password"];
                }
                if ($name == null) {
                    $name = $_SESSION["name"];
                }
                $sql = "UPDATE USUARIOS SET name = :name, password = :password WHERE email = :email";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':email' => $_SESSION["email"],
                    ':name' => $name,
                    ':password' => $pswd
                ]);
                echo "modificado correctamente";
            } catch (PDOException $e) {
                echo "Error al modificar el usuario: " . $e->getMessage();
                header("Location: ../VIEW/index.php");
                exit();
            }
        } else {
            echo "The user is not logged";
        }
    }
}
?>