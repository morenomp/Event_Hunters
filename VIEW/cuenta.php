<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nameLogin'];
    $mail = $_POST['mailLogin'];
    $passwd = $_POST['passwordLogin'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuenta del usuario de la gestora catalana Event Hunters">
    <meta name="keywords" content="Event Hunters">
    <meta name="author" content="Marc Moreno y Adrian Palma">
    <meta name="copyright" content="propiedades del copyright Event Hunters">
    <title>Cuenta usuario - Event Hunters</title>

    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/fonts.css">
    <!-- <link rel="icon" type="image/png" href="IMG/favicon.png"> -->
</head>

<!-- 
OBJETIVO:

· Debemos hacer una parte para admin y otra para los usuarios normales
    · Admin tendrá una cosa diferente, y es que este tendrá la posibilidad
      de usar una imagen de perfil
-->
<body>

    <!-- Contenedor inicial de "crear una cuenta" -->
    <form action="../VIEW/cuenta.php" method="post" id="contForm">

        <div id="contTitle">

            <div id="contInputs">

                <?php
                    if ($name == "admin" && $mail == "admin@admin.com" && $passwd == "12345aA") {
                ?>

                <!-- IMG admin -->
                <span id="imgProfile">
                    <img src="../IMG/mail.svg" alt="prueba de imagen">
                </span>

                <?php
                        echo '<h1>ERES EL ADMINISTRADOR!</h1>';

                        // Nombre de usuario con el que se le denominará
                        echo "Bienvenido " . $name . "." . '<br>';

                        // Correo electrónico que usará para el registro
                        echo "Email: " . $mail . "." . '<br>';

                        // Contraseña de la cuenta
                        echo "Contraseña: " . $passwd . ".";

                    } else {

                        // Nombre de usuario con el que se le denominará
                        echo "Bienvenido " . $name . "." . '<br>';

                        // Correo electrónico que usará para el registro
                        echo "Email: " . $mail . "." . '<br>';

                        // Contraseña de la cuenta
                        echo "Contraseña: " . $passwd . ".";
                    }
                ?>
            </div>
        </div>

        <!-- ------------------- -->
        <hr class="hrPadding">

        <div id="contSession">
            <!-- Iniciar sesión, si el usuario ya tiene cuenta registrada -->
            <button class="btnNext" name="btnNext">
                Cerrar sesión
            </button>
        </div>
    </form>
</body>

</html>