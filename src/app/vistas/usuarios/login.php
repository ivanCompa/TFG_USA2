<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/login.css">

<main class="flex justify-center px-4 pt-20 pb-10">

    <div class="bg-white shadow-2xl border border-[#bcd8f0] rounded-2xl p-10 w-full max-w-md">

        <h2 class="text-3xl font-bold text-center mb-8 text-[#0077cc]">
            Iniciar sesión
        </h2>

        <?php if (!empty($datos['error'])): ?>
            <p class="bg-red-100 text-red-700 border border-red-300 px-4 py-2 rounded mb-4 text-center">
                <?= $datos['error'] ?>
            </p>
        <?php endif; ?>

        <form action="<?= RUTA_URL ?>/usuarios/login" method="POST" class="flex flex-col gap-5">

            <div>
                <label class="text-lg font-semibold">Usuario:</label>
                <input type="text" name="usuario" required
                       class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Contraseña:</label>
                <input type="password" name="password" required
                       class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <button type="submit"
                    class="bg-[#0077cc] text-white py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow-md mt-2">
                Entrar
            </button>
        </form>

        <p class="text-center mt-6 text-lg">
            ¿No tienes cuenta?
            <a href="<?= RUTA_URL ?>/usuarios/registro" class="text-[#0077cc] font-semibold hover:underline">
                Regístrate aquí
            </a>
        </p>

    </div>

</main>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
