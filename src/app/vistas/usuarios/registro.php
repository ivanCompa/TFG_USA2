<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/login.css">

<main class="flex justify-center px-4 pt-20 pb-10">

    <div class="bg-white shadow-2xl border border-[#bcd8f0] rounded-2xl p-10 w-full max-w-md">

        <h2 class="text-3xl font-bold text-center mb-8 text-[#0077cc]">
            Crear cuenta
        </h2>

        <?php if (!empty($datos['error'])): ?>
            <p class="bg-red-100 text-red-700 border border-red-300 px-4 py-2 rounded mb-4 text-center">
                <?= $datos['error'] ?>
            </p>
        <?php endif; ?>

        <form id="formRegistro" action="<?= RUTA_URL ?>/usuarios/registro" method="POST" class="flex flex-col gap-5">

            <div>
                <label class="text-lg font-semibold">Usuario:</label>
                <input type="text" name="usuario" required
                    class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Email:</label>
                <input type="email" name="email" required
                    class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Contraseña:</label>
                <input type="password" name="password" required minlength="8"
                    class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Código Postal:</label>
                <input type="text" name="codigo_postal" required pattern="[0-9]{5}" title="El código postal debe tener 5 dígitos"
                    class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm"
                    maxlength="5">
            </div>

            <button type="submit"
                class="bg-[#0077cc] text-white py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow-md mt-2">
                Registrarse
            </button>
        </form>

    </div>

</main>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
