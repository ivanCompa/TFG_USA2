<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<div class="p-10 text-center">
    <h1 class="text-3xl font-bold text-red-600 mb-4">
        Pago cancelado
    </h1>

    <p class="text-lg text-gray-700 mb-6">
        El proceso de pago fue cancelado. No se ha realizado ningún cargo.
    </p>

    <div class="flex justify-center gap-4 mt-6">
        <a href="<?= RUTA_URL ?>/favoritos/ver"
           class="bg-red-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-red-700 transition shadow">
            Volver a la lista de favoritos
        </a>

        <a href="<?= RUTA_URL ?>/paginas/inicio"
           class="bg-gray-700 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-gray-800 transition shadow">
            Ir al inicio
        </a>
    </div>
</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
