<!-- . -->
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    session_start();
    if (isset($_SESSION["rol"]) && $_SESSION["rol"] == "admin") {
        $event = new eventController;

        if (isset($_POST["btnCreateEvent"])) {

            echo "<p>Create event button clicked</p>";
            $event->createEvent();
        } else if (isset($_POST["btnModifyEvent"])) {

            echo "<p>Modify event button clicked</p>";
            $event->editEvent();
        }
    } else {
        echo "You must be an administrator to create a event.";
    }
}


class eventController
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

            $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
            $this->conn->exec($sql);
            echo "Base de datos creada o ya existente.<br>";

            // Ahora conectamos directamente a la base de datos
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // contenido de la creación de un evento
            $sql = "CREATE TABLE IF NOT EXISTS EVENTOS ( 
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(50), 
                place VARCHAR(50),
                date DATE,
                price int,
                usermail VARCHAR(50)
            )";

            $this->conn->exec($sql);
            echo "Tabla usuarios creada o ya existente.<br>";
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    function createEvent()
    {
        try {
            $name = $_POST["nameEvent"];
            $place = $_POST["placeEvent"];
            $date = $_POST["dateEvent"];
            $price = $_POST["priceEvent"];

            $checkSql = "SELECT name FROM EVENTOS WHERE name = :name";

            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([
                ':name' => $name
            ]); //Ejecuta la consulta
            $result = $checkStmt->fetchAll(PDO::FETCH_ASSOC);

            //SI el evento ya existe, muestra mensaje y termina
            if ($result) {

                $_SESSION['mensaje_error'] = "Ya existe un evento con ese nombre.";
                error_log("Evento ya existe"); // Esto se verá en los logs de PHP
                header("Location: ../VIEW/crearEvento.php");
                exit();

                //SI NO existe, inserta un nuevo evento
            } else {

                $sql = "INSERT INTO EVENTOS (name, place, date, price, usermail) VALUES (:name, :place, :date, :price, :usermail)";

                $stmt = $this->conn->prepare($sql);

                $stmt->execute([
                    ':name' => $name,
                    ':place' => $place,
                    ':date' => $date,
                    ':price' => $price,
                    ':usermail' => $_SESSION["email"]
                ]);

                echo "Valores insertados correctamente.";
            }
        } catch (PDOException $e) {
            echo "Error al crear el evento: " . $e->getMessage();
            header("Location: ../VIEW/index.php");
            exit();
        }
    }

    function editEvent()
    {
        try {

            $id = $_SESSION["eventid"];
            $name = $_POST["name"] ?? null;
            $price = $_POST["name"] ?? null;
            $date = $_POST["name"] ?? null;
            $place = $_POST["name"] ?? null;

            //ACABAR CODIGO CUANDO VISTA ESTE LISTA
            $sql = "UPDATE EVENTOS SET name = :name, price = :price, date = :date, place = :place WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':date' => $date,
                ':place' => $place
            ]);
            echo "Evento modificado correctamente";
        } catch (PDOException $e) {
            echo "Error al editar el evento: " . $e->getMessage();
            header("Location: ../VIEW/index.php");
            exit();
        }
    }
}

?>