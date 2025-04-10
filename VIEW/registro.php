<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Registro de la gestora catalana Event Hunters">
    <meta name="keywords" content="Event Hunters">
    <meta name="author" content="Marc Moreno y Adrian Palma">
    <meta name="copyright" content="propiedades del copyright Event Hunters">
    <title>Registro - Event Hunters</title>

    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/fonts.css">

    <!-- <link rel="icon" type="image/png" href="IMG/favicon.png"> -->
</head> 

<!-- 
OBJETIVO:

· Maquetació responsive del front-end amb tècniques SEO.
    · Utilitzar marques estructurals correctament en tot el codi.
    · Utilitzar atributs per informar del contingut de les imatges.
    · Utilitzar atributs per informar del contingut dels links.
    · Validar formularis amb codi HTML.
· Codificar un disseny responsiu amb CSS.
-->

<body>

    <!-- Contenedor inicial -->
    <form action="../CONTROLLER/userController.php" method="post" id="contForm">

        <div id="contTitle">
            <!-- Título -->
            <span id="titleRegistro">
                <h2>CREA</h2>
                <h2>UNA</h2>
                <h2>CUENTA</h2>
            </span>

            <div id="contInputs">

                <!-- Nombre de usuario con el que se le denominará -->
                <input type="text" name="nameRegistro" placeholder="Nombre & Apellido" pattern="^[A-Za-z]+$" required>

                <!-- Correo electrónico que usará para el registro -->
                <input type="email" name="mailRegistro" placeholder="Dirección de correo electrónico" pattern="^[A-Za-z0-9]+@[A-z0-9]+.[A-za-z0-9]{2,3}$" required>

                <!-- Contraseña de la cuenta -->
                <input type="password" name="passwordRegistro" placeholder="Contraseña" pattern="^[A-za-z0-9]{6,12}$" required>

                <!-- Guardar y continuar los datos introducidos-->
                <button class="btnRegistro" name="btnRegistro">
                    Continuar
                </button>
            </div>
        </div>

        <!-- ------------------- -->
        <hr class="hrPadding">

        <div id="contSession">
            <!-- Continuar con Google, si el usuario tiene esa clase de correo -->
            <button class="btnGoogle" name="btnGoogle">
                <img class="imgSize" src="../IMG/google-icon.svg" alt="logotipo identificativo de google">
                Continuar con Google
            </button>

            <!-- Iniciar sesión, si el usuario ya tiene cuenta registrada -->
            <button class="btnNext" name="btnNext">
                <a href="../VIEW/login.php">
                    Iniciar sesión
                </a>
            </button>
        </div>
    </form>

<!-- 
Prueba "Continuar con Google"

Hemos añadido el script para iniciar sesion con google, pero 
no sabemos como implementarlo correctamente.
-->
<!--    <div id="my-signin2"></div>
     <script>
        function onSuccess(googleUser) {
            console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
        }

        function onFailure(error) {
            console.log(error);
        }

        function renderButton() {
            gapi.signin2.render('my-signin2', {
                'scope': 'profile email',
                'width': 240,
                'height': 50,
                'longtitle': true,
                'theme': 'dark',
                'onsuccess': onSuccess,
                'onfailure': onFailure
            });
        }
    </script>

    <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script> -->

</body>

</html>