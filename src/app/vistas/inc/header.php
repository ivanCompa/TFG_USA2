<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// IMAGEN DE PERFIL

$imagenUsuario = "pfp_Anonymous.jpg";

if (isset($_SESSION['usuario_id'])) {
    require_once RUTA_APP . "/modelos/UsuarioModelo.php";
    $usuarioModelo = new UsuarioModelo();   // ← CORREGIDO
    $imagenBD = $usuarioModelo->obtenerImagen($_SESSION['usuario_id']);

    $rutaFisica = RUTA_APP . "/../public/img/usuarios/" . $imagenBD;

    if (file_exists($rutaFisica)) {
        $imagenUsuario = $imagenBD;
    }
}


// FAVORITOS

$contadorFavoritos = 0;

if (isset($_SESSION['usuario_id'])) {
    require_once RUTA_APP . "/modelos/FavoritosModelo.php";
    $favoritosModelo = new FavoritosModelo();
    $contadorFavoritos = $favoritosModelo->contarProductos($_SESSION['usuario_id']);
}


// NOTIFICACIONES

$contadorNotificaciones = 0;
$listaNotificaciones = [];

if (isset($_SESSION['usuario_id'])) {

    require_once RUTA_APP . "/librerias/Db.php";
    $db = new Db();

    // CONTADOR
    $db->query("
        SELECT COUNT(*) AS total 
        FROM notificaciones 
        WHERE usuario_id = :id AND leida = 0
    ");
    $db->bind(":id", $_SESSION['usuario_id']);
    $res = $db->registro();

    if ($res && $res['total'] !== null) {
        $contadorNotificaciones = $res['total'];
    }

    // LISTAR ULTIMAS 5 NOTIFICACIONES
    $db->query("
        SELECT mensaje, fecha 
        FROM notificaciones 
        WHERE usuario_id = :id 
        ORDER BY fecha DESC 
        LIMIT 5
    ");
    $db->bind(":id", $_SESSION['usuario_id']);
    $listaNotificaciones = $db->registros();
}
?>


<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<header class="bg-white border-b-2 border-[#bcd8f0] px-6 py-4 flex justify-between items-center shadow-sm">

    <!-- LOGO -->
    <div class="logo flex items-center">
        <a href="<?= RUTA_URL ?>/paginas/index">
            <img src="<?= RUTA_URL ?>/img/Logo.png" alt="Logo USA2" class="h-20 w-auto">
        </a>
    </div>

    <!-- ZONA DE USUARIOS -->
    <div class="header-right flex items-center gap-10 text-lg">

        <?php if (!isset($_SESSION['usuario_id'])): ?>

            <!-- USUARIO NO LOGUEADO -->
            <div class="usuario-menu flex items-center gap-3 cursor-pointer">
                <a href="<?= RUTA_URL ?>/usuarios/login" class="text-[#0077cc] font-semibold hover:underline">
                    Iniciar sesión
                </a>
                <img src="<?= RUTA_URL ?>/img/usuarios/pfp_Anonymous.jpg" class="h-10 w-10 rounded-full border"
                    alt="Usuario">
            </div>

        <?php else: ?>

            <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === "Administrador"): ?>

                <!-- ADMINISTRADOR -->
                <div class="admin-menu relative flex flex-col items-center cursor-pointer ">

                    <div class="relative">
                        <img src="<?= RUTA_URL ?>/img/admin.png" class="w-8" alt="Administrar">
                    </div>

                    <span class="text-[#0077cc] font-semibold">Administrar</span>

                    <!-- MENÚ ADMIN -->
                    <div
                        class="menu-admin absolute top-12 right-0 bg-white border border-[#bcd8f0] rounded-lg shadow-lg p-4 w-48 hidden z-50">

                        <a href="<?= RUTA_URL ?>/admin/usuarios" class="block py-2 hover:bg-[#e6f2ff]">
                            Gestión de usuarios
                        </a>
                        <a href="<?= RUTA_URL ?>/admin/categorias" class="block py-2 hover:bg-[#e6f2ff]">
                            Gestión de categorías
                        </a>
                    </div>
                </div>

            <?php else: ?>

                <!-- FAVORITOS -->
                <a href="<?= RUTA_URL ?>/favoritos/ver" class="favoritos flex flex-col items-center cursor-pointer ">
                    <div class="relative">
                        <img src="<?= RUTA_URL ?>/img/favoritos.png" class="w-8" alt="Favoritos">

                        <?php if ($contadorFavoritos > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                                <?= $contadorFavoritos ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <span class="text-[#0077cc] font-semibold">Favoritos</span>
                </a>

                <!-- NOTIFICACIONES -->
                <div class="notificaciones relative flex flex-col items-center cursor-pointer ">

                    <div class="relative">
                        <img src="<?= RUTA_URL ?>/img/notificaciones.png" class="w-8" alt="Notificaciones">

                        <?php if ($contadorNotificaciones > 0): ?>
                            <span
                                class="notificaciones-numero absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full font-bold">
                                <?= $contadorNotificaciones ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <span class="text-[#0077cc] font-semibold">Notificaciones</span>

                    <!-- MENÚ DE NOTIFICACIONES -->
                    <div
                        class="menu-notificaciones absolute top-12 right-0 bg-white border border-[#bcd8f0] rounded-lg shadow-lg p-4 w-72 hidden z-50">

                        <p class="font-bold mb-2">Notificaciones</p>
                        <hr class="mb-2">

                        <?php if (!empty($listaNotificaciones)): ?>
                            <?php foreach ($listaNotificaciones as $n): ?>
                                <a href="<?= RUTA_URL ?>/notificaciones/ver"
                                    class="block notif-item py-2 border-b last:border-none text-black no-underline">
                                    <p>
                                        <?= htmlspecialchars($n['mensaje']) ?>
                                    </p>
                                    <small class="text-gray-600">
                                        <?= $n['fecha'] ?>
                                    </small>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-gray-600">No hay notificaciones.</p>
                        <?php endif; ?>
                    </div>
                </div>

            <?php endif; ?>

            <!-- MENÚ DE USUARIO LOGUEADO -->
            <div class="usuario-menu relative flex items-center gap-3 cursor-pointer ">

                <span class="usuario-nombre text-[#0077cc] font-semibold">
                    <?= htmlspecialchars($_SESSION['usuario_nombre']) ?>
                </span>

                <img src="<?= RUTA_URL ?>/img/usuarios/<?= $imagenUsuario ?>" class="h-10 w-10 rounded-full border"
                    alt="Usuario">

                <!-- MENÚ DE USUARIO DESPLEGABLE -->
                <div
                    class="menu-desplegable absolute top-12 right-0 bg-white border border-[#bcd8f0] rounded-lg shadow-lg p-4 w-48 hidden">
                    <a href="<?= RUTA_URL ?>/usuarios/perfil" class="block py-2 hover:bg-[#e6f2ff]">Mi perfil</a>
                    <a href="<?= RUTA_URL ?>/usuarios/misproductos" class="block py-2 hover:bg-[#e6f2ff]">Mis productos</a>
                    <a href="<?= RUTA_URL ?>/usuarios/logout" class="block py-2 hover:bg-[#e6f2ff]">Cerrar sesión</a>
                </div>
            </div>

        <?php endif; ?>

    </div>

</header>

<script>
    const RUTA_URL = "<?= RUTA_URL ?>";
</script>

<script src="<?= RUTA_URL ?>/js/header.js"></script>