<?php

function event_hunters_boot_i18n(): void
{
    $allowedLanguages = ['es', 'ca', 'en'];

    if (isset($_GET['lang']) && in_array($_GET['lang'], $allowedLanguages, true)) {
        setcookie('site_lang', $_GET['lang'], time() + 31536000, '/');
        $_COOKIE['site_lang'] = $_GET['lang'];

        $cleanUrl = event_hunters_clean_current_url();

        if (!headers_sent()) {
            header('Location: ' . $cleanUrl);
            exit();
        }
    }

    if (!isset($_COOKIE['site_lang'])) {
        $detectedLanguage = event_hunters_detect_device_lang();
        setcookie('site_lang', $detectedLanguage, time() + 31536000, '/');
        $_COOKIE['site_lang'] = $detectedLanguage;
    }

    ob_start('event_hunters_translate_output');
}

function event_hunters_current_lang(): string
{
    $lang = $_COOKIE['site_lang'] ?? 'es';
    return in_array($lang, ['es', 'ca', 'en'], true) ? $lang : 'es';
}

function event_hunters_detect_device_lang(): string
{
    $acceptLanguage = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '');

    if (str_contains($acceptLanguage, 'ca')) {
        return 'ca';
    }

    if (str_contains($acceptLanguage, 'en')) {
        return 'en';
    }

    if (str_contains($acceptLanguage, 'es')) {
        return 'es';
    }

    return 'es';
}

function event_hunters_translate_output(string $buffer): string
{
    $lang = event_hunters_current_lang();

    $buffer = preg_replace('/<html lang="[^"]+">/', '<html lang="' . $lang . '">', $buffer, 1);

    if ($lang !== 'es') {
        $buffer = strtr($buffer, event_hunters_translation_map($lang));
    }

    $buffer = preg_replace_callback(
        '/<a class="imgHeaderMenu" id="idioma" href="[^"]*">.*?<\/a>/s',
        static function (): string {
            return '<a class="imgHeaderMenu" id="idioma" href="#" data-lang-toggle aria-haspopup="true" aria-expanded="false">' .
                strtoupper(event_hunters_current_lang()) . '</a>';
        },
        $buffer
    );

    $buffer = preg_replace_callback(
        '/<(div|ul) id="contIdiomas">.*?<\/\1>/s',
        static function (array $matches): string {
            return event_hunters_language_options_markup($matches[1]);
        },
        $buffer
    );

    $buffer = preg_replace('/#contTodoIdiomas:hover #contIdiomas \{\s*display: flex;\s*\}/', "#contTodoIdiomas:hover #contIdiomas,\n#contTodoIdiomas:focus-within #contIdiomas,\n#contTodoIdiomas.is-open #contIdiomas {\n    display: flex;\n}", $buffer, 1);

    if (str_contains($buffer, '</body>')) {
        $buffer = str_replace('</body>', event_hunters_language_script() . '</body>', $buffer);
    }

    return $buffer;
}

function event_hunters_lang_url(string $lang): string
{
    return event_hunters_clean_current_url();
}

function event_hunters_language_options_markup(string $tagName): string
{
    $current = event_hunters_current_lang();
    $cleanUrl = event_hunters_clean_current_url();
    $labels = [
        'es' => 'Español',
        'ca' => 'Català',
        'en' => 'English',
    ];

    $items = [];

    foreach ($labels as $lang => $label) {
        $class = $lang === $current ? 'id="selectIdioma"' : 'class="notSelectIdioma"';
        $items[] = '<a ' . $class . ' href="' .
            htmlspecialchars($cleanUrl, ENT_QUOTES, 'UTF-8') .
            '" data-lang-option="' . htmlspecialchars($lang, ENT_QUOTES, 'UTF-8') .
            '">' . $label . '</a>';
    }

    return '<' . $tagName . ' id="contIdiomas" data-lang-menu>' . implode('', $items) . '</' . $tagName . '>';
}

function event_hunters_clean_current_url(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $queryString = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_QUERY) ?: '';
    parse_str($queryString, $query);
    unset($query['lang']);

    if ($query === []) {
        return $path;
    }

    return $path . '?' . http_build_query($query);
}

function event_hunters_translation_map(string $lang): array
{
    $maps = [
        'ca' => [
            'Inicio de la gestora catalana Event Hunters' => 'Inici de la gestora catalana Event Hunters',
            'Login de la gestora catalana Event Hunters' => 'Inici de sessió de la gestora catalana Event Hunters',
            'Registro de la gestora catalana Event Hunters' => 'Registre de la gestora catalana Event Hunters',
            'Cuenta del usuario de la gestora catalana Event Hunters' => "Compte de l'usuari de la gestora catalana Event Hunters",
            'Cuenta del administrador de la gestora catalana Event Hunters' => "Compte de l'administrador de la gestora catalana Event Hunters",
            'Cuenta del admin de la gestora catalana Event Hunters' => "Compte de l'administrador de la gestora catalana Event Hunters",
            'Registro administrador - Event Hunters' => 'Registre administrador - Event Hunters',
            'Registro - Event Hunters' => 'Registre - Event Hunters',
            'Login - Event Hunters' => 'Inici de sessió - Event Hunters',
            'Cuenta Usuario - Event Hunters' => 'Compte Usuari - Event Hunters',
            'Cuenta Adminitrador - Event Hunters' => 'Compte Administrador - Event Hunters',
            'INICIO' => 'INICI',
            'EVENTOS' => 'ESDEVENIMENTS',
            'TRAYECTORIA' => 'TRAJECTORIA',
            'Español' => 'Espanyol',
            'Catalán' => 'Català',
            'SOBRE NOSOTROS' => 'SOBRE NOSALTRES',
            'Ver mas' => 'Veure més',
            'Ver más' => 'Veure més',
            'Event Hunters es una aplicación web diseñada para descubrir, comparar y reservar eventos de experiencias inmersivas en Cataluña. Nuestro objetivo es ofrecer a los usuarios las mejores ofertas, reseñas transparentes y la posibilidad de crear grupos para disfrutar de aventuras únicas.' => 'Event Hunters és una aplicació web dissenyada per descobrir, comparar i reservar esdeveniments d’experiències immersives a Catalunya. El nostre objectiu és oferir als usuaris les millors ofertes, ressenyes transparents i la possibilitat de crear grups per gaudir d’aventures úniques.',
            'EVENTOS <br /> DISPONIBLES' => 'ESDEVENIMENTS <br /> DISPONIBLES',
            'Lo más buscado' => 'El més buscat',
            'Ver evento' => 'Veure esdeveniment',
            'Eventos gratuitos' => 'Esdeveniments gratuïts',
            'Mejores precios' => 'Millors preus',
            'Experiencia inmersiva IKONO Barcelona' => 'Experiència immersiva IKONO Barcelona',
            'Candlelight: <br> Tributo a ABBA' => 'Candlelight: <br> Tribut a ABBA',
            'VR World Lab: experiencia de realidad virtual' => 'VR World Lab: experiència de realitat virtual',
            'Dinos Alive: una experiencia inmersiva' => 'Dinos Alive: una experiència immersiva',
            'Exposición interactiva sobre Antártida por Sergei Potetiunin' => 'Exposició interactiva sobre l’Antàrtida per Sergei Potetiunin',
            'Petra: La Gloria de Los Nabateos' => 'Petra: La glòria dels nabateus',
            'Experiencia de Realidad Virtual en Aventurico Tetuan' => 'Experiència de realitat virtual a Aventurico Tetuan',
            'Simracing - El horizonte del circuito' => 'Simracing - L’horitzó del circuit',
            'Magia y Comedia en el Bosc de les Fades' => 'Màgia i comèdia al Bosc de les Fades',
            'DESCUBRE EL ALMA DE' => "DESCOBREIX L'ÀNIMA DE",
            'Nuestra Misión' => 'La nostra missió',
            'Nuestros Valores' => 'Els nostres valors',
            'NUESTRA MISIÓN' => 'LA NOSTRA MISSIÓ',
            'FUNDADORES' => 'FUNDADORS',
            'Crear experiencias memorables que conecten comunidades a través de eventos únicos' => 'Crear experiències memorables que connectin comunitats a través d’esdeveniments únics',
            'Innovación, pasión y compromiso con la excelencia en cada detalle' => 'Innovació, passió i compromís amb l’excel·lència en cada detall',
            'Somos pioneros en la creación de experiencias inmersivas. Con más de una década de trayectoria, hemos transformado la industria de eventos en Cataluña mediante:' => 'Som pioners en la creació d’experiències immersives. Amb més d’una dècada de trajectòria, hem transformat la indústria dels esdeveniments a Catalunya mitjançant:',
            'Eventos realizados' => 'Esdeveniments realitzats',
            'Satisfacción clientes' => 'Satisfacció clients',
            'Asistentes anuales' => 'Assistents anuals',
            'INICIO</h2>' => 'INICI</h2>',
            'DE</h2>' => 'DE</h2>',
            'SESIÓN</h2>' => 'SESSIÓ</h2>',
            'Dirección de correo electrónico' => 'Adreça de correu electrònic',
            'Contraseña' => 'Contrasenya',
            'Continuar' => 'Continuar',
            'Continuar con Google' => 'Continuar amb Google',
            'Crear cuenta' => 'Crear compte',
            'CREA' => 'CREA',
            'UNA' => 'UN',
            'CUENTA' => 'COMPTE',
            'Nombre & Apellido' => 'Nom i cognom',
            'Cuenta de Adminitrador' => "Compte d'administrador",
            'Iniciar sesión' => 'Iniciar sessió',
            'DE ADMINISTRADOR' => "D'ADMINISTRADOR",
            'Subir imagen de perfil' => 'Pujar imatge de perfil',
            'Tu perfil' => 'El teu perfil',
            'Bienvenido' => 'Benvingut',
            'Usted es un:' => 'Vostè és un:',
            'Eliminar cuenta' => 'Eliminar compte',
            'Cerrar sesión' => 'Tancar sessió',
            'Crear evento' => 'Crear esdeveniment',
            'Ver evento' => 'Veure esdeveniment',
            'Planificar eventos' => 'Planificar esdeveniments',
            'Crea tu evento' => 'Crea el teu esdeveniment',
            'Guía para organizadores' => 'Guia per a organitzadors',
            'Promociona tu evento' => 'Promociona el teu esdeveniment',
            'Tarifas y comisiones' => 'Tarifes i comissions',
            'Síguenos' => 'Segueix-nos',
            'Soporte 24/7' => 'Suport 24/7',
            'Centro de ayuda' => "Centre d'ajuda",
            'Contáctanos ' => "Contacta'ns ",
            'Problemas con entradas' => 'Problemes amb entrades',
            'Accesibilidad web' => 'Accessibilitat web',
            'Términos de uso' => "Termes d'ús",
            'Política de privacidad' => 'Política de privacitat',
            'Política de cookies' => 'Política de galetes',
            'Adminitrador de cookies' => 'Administrador de galetes',
            'Correo o contraseña incorrectos.' => 'Correu o contrasenya incorrectes.',
        ],
        'en' => [
            'Inicio de la gestora catalana Event Hunters' => 'Home of the Catalan event manager Event Hunters',
            'Login de la gestora catalana Event Hunters' => 'Login for the Catalan event manager Event Hunters',
            'Registro de la gestora catalana Event Hunters' => 'Registration for the Catalan event manager Event Hunters',
            'Cuenta del usuario de la gestora catalana Event Hunters' => 'User account for the Catalan event manager Event Hunters',
            'Cuenta del administrador de la gestora catalana Event Hunters' => 'Administrator account for the Catalan event manager Event Hunters',
            'Cuenta del admin de la gestora catalana Event Hunters' => 'Administrator account for the Catalan event manager Event Hunters',
            'Registro administrador - Event Hunters' => 'Administrator registration - Event Hunters',
            'Registro - Event Hunters' => 'Register - Event Hunters',
            'Login - Event Hunters' => 'Login - Event Hunters',
            'Cuenta Usuario - Event Hunters' => 'User Account - Event Hunters',
            'Cuenta Adminitrador - Event Hunters' => 'Administrator Account - Event Hunters',
            'INICIO' => 'HOME',
            'EVENTOS' => 'EVENTS',
            'TRAYECTORIA' => 'JOURNEY',
            'SOBRE NOSOTROS' => 'ABOUT US',
            'Ver mas' => 'See more',
            'Ver más' => 'See more',
            'Event Hunters es una aplicación web diseñada para descubrir, comparar y reservar eventos de experiencias inmersivas en Cataluña. Nuestro objetivo es ofrecer a los usuarios las mejores ofertas, reseñas transparentes y la posibilidad de crear grupos para disfrutar de aventuras únicas.' => 'Event Hunters is a web application designed to discover, compare and book immersive experience events in Catalonia. Our goal is to offer users the best deals, transparent reviews and the possibility of creating groups to enjoy unique adventures.',
            'EVENTOS <br /> DISPONIBLES' => 'AVAILABLE <br /> EVENTS',
            'Lo más buscado' => 'Most searched',
            'Ver evento' => 'View event',
            'Eventos gratuitos' => 'Free events',
            'Mejores precios' => 'Best prices',
            'Experiencia inmersiva IKONO Barcelona' => 'IKONO Barcelona immersive experience',
            'Candlelight: <br> Tributo a ABBA' => 'Candlelight: <br> Tribute to ABBA',
            'VR World Lab: experiencia de realidad virtual' => 'VR World Lab: virtual reality experience',
            'Dinos Alive: una experiencia inmersiva' => 'Dinos Alive: an immersive experience',
            'Exposición interactiva sobre Antártida por Sergei Potetiunin' => 'Interactive exhibition about Antarctica by Sergei Potetiunin',
            'Petra: La Gloria de Los Nabateos' => 'Petra: The Glory of the Nabataeans',
            'Experiencia de Realidad Virtual en Aventurico Tetuan' => 'Virtual Reality Experience at Aventurico Tetuan',
            'Simracing - El horizonte del circuito' => 'Simracing - The horizon of the circuit',
            'Magia y Comedia en el Bosc de les Fades' => 'Magic and Comedy at Bosc de les Fades',
            'DESCUBRE EL ALMA DE' => 'DISCOVER THE SOUL OF',
            'Nuestra Misión' => 'Our Mission',
            'Nuestros Valores' => 'Our Values',
            'NUESTRA MISIÓN' => 'OUR MISSION',
            'FUNDADORES' => 'FOUNDERS',
            'Crear experiencias memorables que conecten comunidades a través de eventos únicos' => 'Create memorable experiences that connect communities through unique events',
            'Innovación, pasión y compromiso con la excelencia en cada detalle' => 'Innovation, passion and commitment to excellence in every detail',
            'Somos pioneros en la creación de experiencias inmersivas. Con más de una década de trayectoria, hemos transformado la industria de eventos en Cataluña mediante:' => 'We are pioneers in creating immersive experiences. With more than a decade of experience, we have transformed the event industry in Catalonia through:',
            'Eventos realizados' => 'Events delivered',
            'Satisfacción clientes' => 'Client satisfaction',
            'Asistentes anuales' => 'Annual attendees',
            'SESIÓN' => 'SESSION',
            'Dirección de correo electrónico' => 'Email address',
            'Contraseña' => 'Password',
            'Continuar' => 'Continue',
            'Continuar con Google' => 'Continue with Google',
            'Crear cuenta' => 'Create account',
            'CREA' => 'CREATE',
            'UNA' => 'AN',
            'CUENTA' => 'ACCOUNT',
            'Nombre & Apellido' => 'Name & Surname',
            'Cuenta de Adminitrador' => 'Administrator account',
            'Iniciar sesión' => 'Sign in',
            'DE ADMINISTRADOR' => 'ADMINISTRATOR',
            'Subir imagen de perfil' => 'Upload profile image',
            'Tu perfil' => 'Your profile',
            'Bienvenido' => 'Welcome',
            'Usted es un:' => 'You are a:',
            'Eliminar cuenta' => 'Delete account',
            'Cerrar sesión' => 'Log out',
            'Crear evento' => 'Create event',
            'Planificar eventos' => 'Plan events',
            'Crea tu evento' => 'Create your event',
            'Guía para organizadores' => 'Organizer guide',
            'Promociona tu evento' => 'Promote your event',
            'Tarifas y comisiones' => 'Fees and commissions',
            'Síguenos' => 'Follow us',
            'Soporte 24/7' => '24/7 support',
            'Centro de ayuda' => 'Help center',
            'Contáctanos ' => 'Contact us ',
            'Problemas con entradas' => 'Ticket issues',
            'Accesibilidad web' => 'Web accessibility',
            'Términos de uso' => 'Terms of use',
            'Política de privacidad' => 'Privacy policy',
            'Política de cookies' => 'Cookie policy',
            'Adminitrador de cookies' => 'Cookie manager',
            'Correo o contraseña incorrectos.' => 'Incorrect email or password.',
        ],
    ];

    return $maps[$lang] ?? [];
}

function event_hunters_language_script(): string
{
    return <<<'HTML'
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-lang-toggle]').forEach(function (toggle) {
        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            var container = toggle.closest('#contTodoIdiomas');
            if (!container) {
                return;
            }

            document.querySelectorAll('#contTodoIdiomas.is-open').forEach(function (openContainer) {
                if (openContainer !== container) {
                    openContainer.classList.remove('is-open');
                    var openToggle = openContainer.querySelector('[data-lang-toggle]');
                    if (openToggle) {
                        openToggle.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            var isOpen = container.classList.toggle('is-open');
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });
    });

    document.querySelectorAll('[data-lang-option]').forEach(function (option) {
        option.addEventListener('click', function (event) {
            event.preventDefault();

            var lang = option.getAttribute('data-lang-option');
            var targetUrl = option.getAttribute('href') || window.location.pathname;

            if (!lang) {
                window.location.href = targetUrl;
                return;
            }

            document.cookie = 'site_lang=' + encodeURIComponent(lang) + '; path=/; max-age=31536000';
            window.location.href = targetUrl;
        });
    });

    document.addEventListener('click', function (event) {
        if (event.target.closest('#contTodoIdiomas')) {
            return;
        }

        document.querySelectorAll('#contTodoIdiomas.is-open').forEach(function (container) {
            container.classList.remove('is-open');
            var toggle = container.querySelector('[data-lang-toggle]');
            if (toggle) {
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
});
</script>
HTML;
}
