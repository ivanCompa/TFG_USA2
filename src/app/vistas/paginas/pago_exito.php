<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<div class="p-10 text-center">
    <h1 class="text-3xl font-bold text-[#0077cc] mb-4">
        Pago completado
    </h1>

    <p class="text-lg text-gray-700 mb-6">
        Gracias por tu compra. El pago se ha procesado correctamente.
    </p>

    <a href="<?= RUTA_URL ?>/paginas/inicio"
       class="mt-6 inline-block bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
        Volver al inicio
    </a>
</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
