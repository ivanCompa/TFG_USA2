<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<!-- TAILWIND -->
<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/perfil.css">

<main class="flex justify-center px-4 pt-12 pb-10">

    <div class="bg-white shadow-2xl border border-[#bcd8f0] rounded-2xl p-10 w-full max-w-xl">

        <a href="javascript:history.back()" 
           class="text-[#0077cc] font-semibold hover:underline text-sm">
            ← Volver
        </a>

        <h2 class="text-3xl font-bold text-center mb-8 text-[#0077cc]">
            Mi perfil
        </h2>

        <?php if ($datos['ok']): ?>
            <p class="bg-green-100 text-green-700 border border-green-300 px-4 py-2 rounded mb-4 text-center">
                Datos actualizados correctamente
            </p>
        <?php endif; ?>

        <form action="<?= RUTA_URL ?>/usuarios/actualizarPerfil" 
              method="POST" 
              enctype="multipart/form-data" 
              class="flex flex-col gap-6">

            <div>
                <label class="text-lg font-semibold">Nombre de usuario:</label>
                <input type="text" name="nombre" 
                       value="<?= $datos['usuario']['nombre'] ?>" required
                       class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full 
                              focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Email:</label>
                <input type="email" name="email" 
                       value="<?= $datos['usuario']['email'] ?>" required
                       class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full 
                              focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Código Postal:</label>
                <input type="text" name="codigo_postal"
                       value="<?= $datos['usuario']['codigo_postal'] ?>"
                       class="mt-1 border border-gray-400 rounded-lg px-4 py-2 w-full 
                              focus:outline-none focus:ring-2 focus:ring-[#0077cc] shadow-sm">
            </div>

            <div>
                <label class="text-lg font-semibold">Foto de perfil:</label>

                <img src="<?= RUTA_URL ?>/img/usuarios/<?= $datos['usuario']['imagen'] ?>" 
                     class="w-32 h-32 object-cover rounded-full border shadow-md mt-2 mb-3">

                <input type="file" name="imagen"
                       class="block text-sm text-gray-700 mt-1">
            </div>

            <button type="submit"
                    class="bg-[#0077cc] text-white py-3 rounded-lg text-lg font-semibold 
                           hover:bg-[#005fa3] transition shadow-md">
                Guardar cambios
            </button>

        </form>

    </div>

</main>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
