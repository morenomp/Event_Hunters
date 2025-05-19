<?php
session_start();

if (isset($_SESSION["error"])) {
    echo '<p style="color:red;">' . $_SESSION["error"] . '</p>';
    unset($_SESSION["error"]);
}

if (isset($_SESSION["success"])) {
    echo '<p style="color:green;">' . $_SESSION["success"] . '</p>';
    unset($_SESSION["success"]);
}

// Verificamos que el usuario haya iniciado sesión
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
    $name = $_SESSION["name"];
    $mail = $_SESSION["email"];
    $passwd = $_SESSION["passwordLogin"];
    $rol = $_SESSION["rol"];
} else {
    // Si no ha iniciado sesión, redirigimos al login
    header("Location: login.php");
    exit();
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
    <title>Cuenta Usuario - Event Hunters</title>

    <link rel="stylesheet" href="../CSS/user.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/fonts.css">
    <link rel="icon" type="image/png" href="../IMG/favicon.svg">
</head>

<!-- 
OBJETIVO:

· Debemos hacer una parte para admin y otra para los usuarios normales
    · Admin tendrá una cosa diferente, y es que este tendrá la posibilidad
      de usar una imagen de perfil
-->

<body>
    <!-- ////// -->
    <!-- HEADER -->
    <!-- ////// -->
    <header class="sticky-header notResponsiveH">
        <nav class="header-nav">

            <a id="logoHeader" href="../VIEW/index.php">
                <img src="../IMG/LogotipoMedioColor.svg" alt="Logotipo oficial de Event Hunters" class="logo">
                <span id="hoverLogo">
                    <h2>event</h2>
                    <h2>hunters</h2>
                </span>
            </a>

            <div class="nav-items">
                <a href="../VIEW/index.php" class="nav-link">INICIO</a>
                <a href="../VIEW/eventos.php" class="nav-link">EVENTOS</a>
                <a href="../VIEW/about_us.php" class="nav-link">TRAYECTORIA</a>
            </div>

            <div class="nav-items">
                <span id="contTodoIdiomas">

                    <!-- Idioma seleccionado -->
                    <a class="imgHeaderMenu" id="idioma" href="#">ES</a>

                    <!-- Idiomas disponibles -->
                    <div id="contIdiomas">

                        <a id="selectIdioma" href="#">Español</a>
                        <a class="notSelectIdioma" href="#">Catalán</a>
                        <a class="notSelectIdioma" href="#">English</a>
                    </div>
                </span>

                <!-- Registro en la web -->
                <a class="imgHeaderMenu cta-nav" href="../VIEW/login.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="#000000" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                    </svg>
                </a>

                <!-- Entradas del usuario -->
                <a class="imgHeaderMenu" href="../VIEW/entradas.php">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path fill="#000000" d="M96 32l0 32L48 64C21.5 64 0 85.5 0 112l0 48 448 0 0-48c0-26.5-21.5-48-48-48l-48 0 0-32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 32L160 64l0-32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192L0 192 0 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-272z" />
                    </svg>
                </a>
            </div>
        </nav>
    </header>
    <!-- ////////// -->
    <!--   HEADER   -->
    <!-- RESPONSIVE -->
    <!-- ////////// -->
    <header class="sticky-header responsiveH">
        <nav class="header-nav">

            <a id="logoHeader" href="../VIEW/index.php">
                <img src="../IMG/LogotipoMedioColor.svg" alt="Logotipo oficial de Event Hunters" class="logo">
            </a>

            <section id="contRespNav">

                <input type="checkbox" id="toggleMenu" hidden>
                <label for="toggleMenu" id="burguerButton">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>

                <section id="cols">
                    <ul class="nav-items">
                        <a href="../VIEW/index.php" class="nav-link">INICIO</a>
                        <a href="../VIEW/eventos.php" class="nav-link">EVENTOS</a>
                        <a href="../VIEW/about_us.php" class="nav-link">TRAYECTORIA</a>
                    </ul>

                    <div class="nav-items">
                        <span id="contTodoIdiomas">

                            <!-- Idioma seleccionado -->
                            <a class="imgHeaderMenu" id="idioma" href="#">ES</a>

                            <!-- Idiomas disponibles -->
                            <ul id="contIdiomas">

                                <a id="selectIdioma" href="#">Español</a>
                                <a class="notSelectIdioma" href="#">Catalán</a>
                                <a class="notSelectIdioma" href="#">English</a>
                            </ul>
                        </span>

                        <!-- Registro en la web -->
                        <a class="imgHeaderMenu cta-nav" href="../VIEW/login.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="#000000" d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z" />
                            </svg>
                        </a>

                        <!-- Entradas del usuario -->
                        <a class="imgHeaderMenu" href="../VIEW/entradas.php">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <path fill="#000000" d="M96 32l0 32L48 64C21.5 64 0 85.5 0 112l0 48 448 0 0-48c0-26.5-21.5-48-48-48l-48 0 0-32c0-17.7-14.3-32-32-32s-32 14.3-32 32l0 32L160 64l0-32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192L0 192 0 464c0 26.5 21.5 48 48 48l352 0c26.5 0 48-21.5 48-48l0-272z" />
                            </svg>
                        </a>
                    </div>
                </section>
            </section>
        </nav>
    </header>
    <!-- //// -->
    <!-- MAIN -->
    <!-- //// -->
    <main id="widthCenter">
        <!-- Contenedor inicial de "crear una cuenta" -->
        <div id="contTitle">

            <div id="contInputs2">

                <!-- IMG user -->
                <span id="imgProfile">
                    <img src="../IMG/favicon.svg" alt="Foto por defecto para todos los usuarios">
                </span>

                <div id="contTextTodo">

                    <div id="contModifyButton">
                        <?php
                        echo '<h1>Tu perfil</h1>';
                        ?>
                    </div>

                    <div id="contTextInfo">
                        <form action="../CONTROLLER/eventsController.php" method="post">
                            <label for="name"><b>Tu nombre:</b></label>
                            <input class="inputMod" type="text" id="name" name="name" value="<?php echo $name; ?>" required>

                            <br>

                            <label for="email"><b>Email:</b></label>
                            <input class="inputMod_enable" type="email" id="email" name="email" value="<?php echo $mail; ?>" disabled>

                            <br>

                            <label for="password"><b>Contraseña:</b></label>
                            <input class="inputMod" type="password" id="password" name="password" required>

                            <br>

                            <?php
                            echo "</span>";
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- ------------------- -->
        <hr class="hrPadding">

        <div id="contSessionCount">

            <!-- Guardar cambios tras editarlos -->
            <input class="verifyMod cPointer" type="submit" name="btnModify" value="Guardar cambios">

            <!-- Cerrar sesión -->
            <button class="btnNext cPointer" name="logout">
                <a href="./login.php">Cancelar</a>
            </button>
        </div>
    </main>
    <!-- ////// -->
    <!-- FOOTER -->
    <!-- ////// -->
    <footer>
        <!-- Parte de arriba del footer -->
        <div class="contInitialFooter">
            <!-- Planificar/Organizar eventos -->
            <div class="contSubInitial">
                <h3>Planificar eventos</h3>

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
                <h3>Síguenos</h3>

                <!-- Instagram -->
                <a class="colRedesFooter" href="#">
                    <svg class="imgRedesFooter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M194.4 211.7a53.3 53.3 0 1 0 59.3 88.7 53.3 53.3 0 1 0 -59.3-88.7zm142.3-68.4c-5.2-5.2-11.5-9.3-18.4-12c-18.1-7.1-57.6-6.8-83.1-6.5c-4.1 0-7.9 .1-11.2 .1c-3.3 0-7.2 0-11.4-.1c-25.5-.3-64.8-.7-82.9 6.5c-6.9 2.7-13.1 6.8-18.4 12s-9.3 11.5-12 18.4c-7.1 18.1-6.7 57.7-6.5 83.2c0 4.1 .1 7.9 .1 11.1s0 7-.1 11.1c-.2 25.5-.6 65.1 6.5 83.2c2.7 6.9 6.8 13.1 12 18.4s11.5 9.3 18.4 12c18.1 7.1 57.6 6.8 83.1 6.5c4.1 0 7.9-.1 11.2-.1c3.3 0 7.2 0 11.4 .1c25.5 .3 64.8 .7 82.9-6.5c6.9-2.7 13.1-6.8 18.4-12s9.3-11.5 12-18.4c7.2-18 6.8-57.4 6.5-83c0-4.2-.1-8.1-.1-11.4s0-7.1 .1-11.4c.3-25.5 .7-64.9-6.5-83l0 0c-2.7-6.9-6.8-13.1-12-18.4zm-67.1 44.5A82 82 0 1 1 178.4 324.2a82 82 0 1 1 91.1-136.4zm29.2-1.3c-3.1-2.1-5.6-5.1-7.1-8.6s-1.8-7.3-1.1-11.1s2.6-7.1 5.2-9.8s6.1-4.5 9.8-5.2s7.6-.4 11.1 1.1s6.5 3.9 8.6 7s3.2 6.8 3.2 10.6c0 2.5-.5 5-1.4 7.3s-2.4 4.4-4.1 6.2s-3.9 3.2-6.2 4.2s-4.8 1.5-7.3 1.5l0 0c-3.8 0-7.5-1.1-10.6-3.2zM448 96c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V96zM357 389c-18.7 18.7-41.4 24.6-67 25.9c-26.4 1.5-105.6 1.5-132 0c-25.6-1.3-48.3-7.2-67-25.9s-24.6-41.4-25.8-67c-1.5-26.4-1.5-105.6 0-132c1.3-25.6 7.1-48.3 25.8-67s41.5-24.6 67-25.8c26.4-1.5 105.6-1.5 132 0c25.6 1.3 48.3 7.1 67 25.8s24.6 41.4 25.8 67c1.5 26.3 1.5 105.4 0 131.9c-1.3 25.6-7.1 48.3-25.8 67z" />
                    </svg>
                    <p>Instagram</p>
                </a>

                <!-- Linkedin -->
                <a class="colRedesFooter" href="#">
                    <svg class="imgRedesFooter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z" />
                    </svg>
                    <p>Linkedin</p>
                </a>

                <!-- Facebook -->
                <a class="colRedesFooter" href="#">
                    <svg class="imgRedesFooter" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                        <path d="M64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64h98.2V334.2H109.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H255V480H384c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64z" />
                    </svg>
                    <p>Facebook</p>
                </a>
            </div>

            <!-- Soporte/Ayuda -->
            <div class="contSubInitial">
                <h3>Soporte 24/7</h3>

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