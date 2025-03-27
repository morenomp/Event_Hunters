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
</head>

<body>

<?php

if ($name == "admin" && $mail == "admin@admin.com" && $passwd == "12345aA") {
    echo '<h1>ERES EL ADMINISTRADOR!</h1>';
    echo "Bienvenido " . $name . "." . '<br>';
    echo "Email: " . $mail . ".";
} else {
    echo "Bienvenido " . $name . "." . '<br>';
    echo "Email: " . $mail . ".";
}

?>

</body>

</html>