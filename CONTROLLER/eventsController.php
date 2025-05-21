<!-- . -->
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $event = new eventController;

    if (isset($_POST["btnCreateEvent"])) {

        echo "<p>Create event button clicked</p>";
        $event->createEvent();
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
                price int
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
            $name = $_POST["name"];
            $place = $_POST["place"];
            $date = $_POST["date"];
            $price = $_POST["price"];


            $checkSql = "SELECT name FROM EVENTOS WHERE name = :name";

            $checkStmt = $this->conn->prepare($checkSql);
            $checkStmt->execute([
                ':name' => $name
            ]); //Ejecuta la consulta
            $result = $checkStmt->fetchAll(PDO::FETCH_ASSOC);

            //SI el evento ya existe, muestra mensaje y termina
            if ($result[0] != null) {

                echo "El correo ya está en uso.";
                return;

                //SI NO existe, inserta un nuevo evento
            } else {

                $sql = "INSERT INTO EVENTOS (name, place, date, price) VALUES (:name, :place, :date, :price)";

                $stmt = $this->conn->prepare($sql);

                $stmt->execute([
                    ':name' => $name,
                    ':place' => $place,
                    ':date' => $date,
                    ':price' => $price
                ]);

                echo "Valores insertados correctamente.";
            }
        } catch (PDOException $e) {
            echo "Error al crear el evento: " . $e->getMessage();
            header("Location: ../VIEW/index.php");
            exit();
        }
    }
}

?>