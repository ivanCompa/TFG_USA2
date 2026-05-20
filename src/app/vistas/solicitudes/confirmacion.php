<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<div class="w-[calc(100%-40px)] mx-auto max-w-3xl bg-white border-2 border-[#bcd8f0] rounded-xl p-10 shadow-lg mt-10 text-center">

    <h2 class="text-3xl font-bold text-[#0077cc] mb-4">Solicitud enviada</h2>

    <p class="text-lg text-gray-700 mb-6">
        El vendedor ha recibido tu solicitud de compra.
    </p>

    <a href="<?= RUTA_URL ?>/paginas/index"
       class="mt-6 inline-block bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
        Volver al inicio
    </a>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
