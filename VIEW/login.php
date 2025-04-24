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

    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/fonts.css">
    <!-- <meta name="google-signin-client_id" content="YOUR_CLIENT_ID.apps.googleusercontent.com"> -->
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
    <main>
        <!-- Contenedor inicial de "crear una cuenta" -->
        <!-- <form action="../VIEW/cuenta.php" method="post" id="contForm"> -->
        <form action="../CONTROLLER/userController.php" method="post" id="contForm">

            <div id="contTitle">
                <!-- Título -->
                <span id="titleLogin">
                    <h2>INICIO</h2>
                    <h2>DE</h2>
                    <h2>SESIÓN</h2>
                </span>

                <div id="contInputs">

                    <!-- Correo electrónico que usará para el registro -->
                    <input type="email" name="mailLogin" placeholder="Dirección de correo electrónico" pattern="^[A-Za-z0-9]+@[A-z0-9]+.[A-za-z0-9]{2,3}$" required>

                    <!-- Contraseña de la cuenta -->
                    <input type="password" name="passwordLogin" placeholder="Contraseña" pattern="^[A-za-z0-9]{6,12}$" required>

                    <!-- Guardar y continuar los datos introducidos-->
                    <button class="btnLogin" name="btnLogin">
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
                    <a href="../VIEW/registro.php">
                        Crear cuenta
                    </a>
                </button>
            </div>
        </form>
    </main>

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
    
    <footer>
        <!-- Parte de arriba del footer -->
        <div class="contInitialFooter">
            <!-- Planificar/Organizar eventos -->
            <div class="contSubInitial">
                <h2>Planificar eventos</h2>
                
                <!-- Enlace para organizadores que quieran publicar experiencias -->
                <a href="#">Crea tu evento</a>

                <!-- Paso a paso para publicar y gestionar eventos -->
                <a href="#">Guía para organizadores</a>

                <!-- Info sobre publicidad dentro de la web -->
                <a href="#">Promociona tu evento</a>

                <!-- Información clara sobre costes y condiciones -->
                <a href="#">Tarifas y comisiones</a>
            </div>

            <!-- Síguenos/Redes -->
            <div class="contSubInitial">
                <h2>Síguenos</h2>

                <!-- Instagram -->
                <a class="colRedesFooter" href="#">
                    <img class="imgRedesFooter" src="../IMG/instagram.svg" alt="Instagram de Event Hunters">
                    <p>Instagram</p>
                </a>

                <!-- Linkedin -->
                <a class="colRedesFooter" href="#">
                    <img class="imgRedesFooter" src="../IMG/linkedin.svg" alt="Linkedin de Event Hunters">
                    <p>Linkedin</p>
                </a>

                <!-- Facebook -->
                <a class="colRedesFooter" href="#">
                    <img class="imgRedesFooter" src="../IMG/facebook.svg" alt="Facebook de Event Hunters">
                    <p>Facebook</p>
                </a>
            </div>

            <!-- Soporte/Ayuda -->
            <div class="contSubInitial">
                <h2>Soporte 24/7</h2>

                <!-- Preguntas frecuentes y tutoriales -->
                <a href="#">Centro de ayuda</a>

                <!-- Formulario o chat para soporte directo -->
                <a href="#">Contáctanos </a>

                <!-- Acceso rápido a soporte de compra -->
                <a href="#">Problemas con entradas</a>

                <!-- Enlace al botón o página de configuración para accesibilidad 
                (tipo de daltonismo, modo lectura, etc.) -->
                <a href="#">Accesibilidad web</a>
            </div>
        </div>
        <!-- Parte de abajo del footer -->
        <div class="contFinalFooter">
            <div>
                <a href="#">Términos de uso</a> |
                <a href="#">Política de privacidad</a> |
                <a href="#">Política de cookies</a> |
                <a href="#">Adminitrador de cookies</a>
            </div>

            <p>© 2025 - EventHunters</p>
        </div>
    </footer>
</body>

</html>