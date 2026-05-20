<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<div class="bg-white border-2 border-[#bcd8f0] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto max-w-4xl mt-10">

    <h2 class="text-3xl font-bold text-[#0077cc] mb-6">Mis productos favoritos</h2>

    <?php if (empty($datos['productos'])): ?>

        <p class="text-gray-600 text-lg">Tu lista de favoritos está vacía.</p>

        <a href="<?= RUTA_URL ?>/paginas/inicio"
            class="mt-4 inline-block bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
            Volver a la tienda
        </a>

    <?php else: ?>

        <div class="flex flex-col gap-6">

            <?php foreach ($datos['productos'] as $p): ?>
                <div class="flex items-center gap-6 border-b pb-4">

                    <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>"
                        class="w-24 h-24 object-cover rounded-lg border">

                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-800"><?= $p['titulo'] ?></h3>
                        <p class="text-[#0077cc] font-bold text-xl"><?= $p['precio'] ?> €</p>
                    </div>

                    <a href="<?= RUTA_URL ?>/favoritos/eliminar/<?= $p['producto_id'] ?>"
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition shadow">
                        Eliminar
                    </a>

                </div>
            <?php endforeach; ?>

        </div>

        <a href="<?= RUTA_URL ?>/paginas/inicio"
            class="mt-6 inline-block bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
            Seguir comprando
        </a>

    <?php endif; ?>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>