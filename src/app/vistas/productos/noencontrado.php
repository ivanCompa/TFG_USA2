<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<script src="https://cdn.tailwindcss.com"></script>

<main class="px-6 py-16 flex justify-center">

    <div class="bg-[#e8d7ff] border-2 border-[#c7aef5] rounded-xl p-10 shadow-lg text-center w-[500px]">

        <h2 class="text-3xl font-bold mb-4 text-gray-800">
            Producto no encontrado
        </h2>

        <p class="text-lg text-gray-700 mb-8">
            El producto que intentas ver no existe o ha sido eliminado.
        </p>

        <a href="<?= RUTA_URL ?>/paginas/index"
           class="bg-[#0077cc] text-white px-6 py-3 rounded-lg hover:bg-[#005fa3] transition shadow-md text-lg">
            Volver al inicio
        </a>

    </div>

</main>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
