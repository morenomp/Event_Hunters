<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login de la gestora catalana Event Hunters">
    <meta name="keywords" content="Event Hunters">
    <meta name="author" content="Marc Moreno y Adrian Palma">
    <meta name="copyright" content="propiedades del copyright Event Hunters">
    <title>Login - Event Hunters</title>

    <link rel="stylesheet" href="CSS/style.css">
    <link rel="stylesheet" href="CSS/fonts.css">

    <!-- <link rel="icon" type="image/png" href="IMG/favicon.png"> -->
</head>

<!-- 
OBJETIVO:

· Maquetació responsiva del front-end amb tècniques SEO.
    · Utilitzar marques estructurals correctament en tot el codi.
    · Utilitzar atributs per informar del contingut de les imatges.
    · Utilitzar atributs per informar del contingut dels links.
    · Validar formularis amb codi HTML.
· Codificar un disseny responsiu amb CSS.
-->
<body>
    
    <!-- Contenedor inicial de "crear una cuenta" -->
    <form action="eh_logica.php" method="post">
    
    <!-- Título -->
        <span id="titleLogin">
            <h2>CREA</h2>
            <h2>UNA</h2>
            <h2>CUENTA</h2>
        </span>

    <!-- Nombre de usuario con el que se le denominará -->
        <input type="text">

    <!-- Correo electrónico que usará para el registro -->
        <input type="text">

    <!-- Contraseña de la cuenta -->
        <input type="text">

    <!-- Guardar y continuar los datos introducidos-->
        <button>
            Continuar
        </button>

    <!-- ------------------- -->
        <hr class="cl-black ">

    <!-- Continuar con Google, si el usuario tiene esa clase de correo -->
        <button>
            Continuar con Google
        </button>

    <!-- Iniciar sesión, si el usuario ya tiene cuenta registrada -->
        <button>
            Iniciar sesión
        </button>
    </form>

</body>
</html>