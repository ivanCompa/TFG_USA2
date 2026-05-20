<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<div class="bg-white border-2 border-[#bcd8f0] rounded-xl p-10 shadow-lg w-[calc(100%-40px)] mx-auto mt-10">

    <div class="flex items-center gap-4 mb-8">
        <img src="<?= RUTA_URL ?>/img/usuarios/<?= $datos['usuario']['imagen'] ?>"
            class="w-20 h-20 rounded-full border shadow object-cover">

        <div>
            <h1 class="text-3xl font-bold"><?= htmlspecialchars($datos['usuario']['nombre']) ?></h1>
            <p class="text-gray-600"><?= htmlspecialchars($datos['usuario']['email']) ?></p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4">Productos publicados</h2>

    <div class="flex flex-wrap gap-8">
        <?php foreach ($datos['productos'] as $p): ?>
            <a href="<?= RUTA_URL ?>/productos/detalle/<?= $p['producto_id'] ?>"
                class="producto bg-white border border-gray-300 rounded-xl p-4 shadow-md hover:shadow-xl transition transform hover:scale-[1.05] text-center w-[200px]">

                <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>"
                    class="rounded-lg mb-3 w-full h-[180px] object-contain bg-white p-2 shadow-sm">

                <p class="text-xl font-bold"><?= $p['precio'] ?> €</p>
                <p class="text-gray-700"><?= htmlspecialchars($p['titulo']) ?></p>
            </a>

        <?php endforeach; ?>
    </div>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>