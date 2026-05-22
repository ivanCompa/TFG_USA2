<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/misproductos.css">

<main class="flex justify-center px-4 pt-20 pb-10">

    <div class="bg-white shadow-2xl border border-[#bcd8f0] rounded-2xl p-10 w-full max-w-3xl">

        <a href="javascript:history.back()" 
           class="text-[#0077cc] font-semibold hover:underline text-sm">
            ← Volver
        </a>

        <h2 class="text-3xl font-bold text-center mb-8 text-[#0077cc]">
            Mis productos
        </h2>

        <a href="<?= RUTA_URL ?>/productos/crear" 
           class="bg-[#0077cc] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#005fa3] transition shadow-md mb-6 inline-block">
            + Subir nuevo producto
        </a>

        <div class="flex flex-col gap-6">

            <?php if (empty($datos['productos'])): ?>

                <p class="text-center text-gray-600">No has subido ningún producto todavía.</p>

            <?php else: ?>

                <?php foreach ($datos['productos'] as $p): ?>
                    <div class="flex items-center gap-6 border border-gray-300 rounded-xl p-4 shadow-sm">

                        <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>" 
                             class="w-28 h-28 object-cover rounded-lg border">

                        <div class="flex-1">
                            <h3 class="text-xl font-semibold"><?= htmlspecialchars($p['titulo']) ?></h3>
                            <p class="text-lg font-medium"><?= $p['precio'] ?> €</p>
                            <p class="text-sm text-gray-600">Estado: <?= htmlspecialchars($p['estado']) ?></p>
                        </div>

                        <div class="flex flex-col gap-2">
                            <a href="<?= RUTA_URL ?>/productos/editar/<?= $p['producto_id'] ?>" 
                               class="bg-yellow-400 text-black px-3 py-1 rounded-lg text-sm font-semibold hover:bg-yellow-500 transition">
                                Editar
                            </a>

                            <a href="<?= RUTA_URL ?>/productos/eliminar/<?= $p['producto_id'] ?>" 
                               class="bg-red-600 text-white px-3 py-1 rounded-lg text-sm font-semibold hover:bg-red-700 transition"
                               onclick="return confirm('¿Seguro que quieres eliminar este producto?')">
                                Eliminar
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>

</main>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
