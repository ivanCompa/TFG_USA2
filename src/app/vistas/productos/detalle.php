<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/detalle.css">

<nav class="ruta text-xl font-semibold py-4 px-6 text-gray-700">
    Detalles del producto
</nav>

<div class="detalle-contenedor bg-white border-2 border-[#bcd8f0] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto">

    <a href="<?= RUTA_URL ?>/paginas/index" class="volver-btn">← Volver</a>

    <div class="flex flex-col lg:flex-row gap-10">

        <!-- COLUMNA IZQUIERDA -->
        <div class="detalle-imagen flex flex-col items-center gap-4">

            <?php $total = count($datos['imagenes']); ?>

            <div class="fila-carrusel flex items-center gap-4">

                <?php if ($total > 1): ?>
                    <button
                        class="flecha bg-[#0077cc] text-white text-3xl px-4 py-2 rounded-lg shadow hover:bg-[#005fa3] transition"
                        id="flechaIzq">◀</button>
                <?php endif; ?>

                <div class="carrusel-detalle">
                    <div class="carrusel-inner" id="carruselInner">

                        <?php if ($total > 0): ?>
                            <?php foreach ($datos['imagenes'] as $img): ?>
                                <img src="<?= RUTA_URL ?>/img/productos/<?= $img['ruta'] ?>" class="img-carrusel">
                            <?php endforeach; ?>
                        <?php else: ?>
                            <img src="<?= RUTA_URL ?>/img/no-image.png" class="img-carrusel">
                        <?php endif; ?>

                    </div>
                </div>

                <?php if ($total > 1): ?>
                    <button
                        class="flecha bg-[#0077cc] text-white text-3xl px-4 py-2 rounded-lg shadow hover:bg-[#005fa3] transition"
                        id="flechaDer">▶</button>
                <?php endif; ?>

            </div>

            <div class="dots" id="dots">
                <?php if ($total > 1): ?>
                    <?php foreach ($datos['imagenes'] as $i => $img): ?>
                        <span class="dot <?= $i === 0 ? 'active' : '' ?>"></span>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

        <!-- COLUMNA DERECHA -->
        <div class="detalle-info flex flex-col gap-6 max-w-[500px]">

            <h2 class="text-3xl font-bold text-gray-800">
                <?= htmlspecialchars($datos['producto']['titulo']) ?>
            </h2>

            <a href="<?= RUTA_URL ?>/usuarios/ver/<?= $datos['usuario']['usuario_id'] ?>"
                class="flex items-center gap-3 mt-1 text-sm text-gray-600 hover:text-[#0077cc] transition">

                <img src="<?= RUTA_URL ?>/img/usuarios/<?= htmlspecialchars($datos['usuario']['imagen']) ?>"
                    class="w-8 h-8 rounded-full border border-gray-300 shadow-sm object-cover">

                <span class="font-medium">
                    <?= htmlspecialchars($datos['usuario']['nombre']) ?>
                </span>

            </a>

            <p class="precio text-3xl font-bold text-[#0077cc]">
                <?= $datos['producto']['precio'] ?> €
            </p>

            <p class="estado text-lg text-gray-700">
                <strong>Estado:</strong> <?= $datos['producto']['estado'] ?>
            </p>

            <p class="descripcion text-lg leading-relaxed text-gray-700">
                <?= nl2br(htmlspecialchars($datos['producto']['descripcion'])) ?>
            </p>

            <?php 
                $esPropietario = isset($_SESSION['usuario_id']) 
                                 && $_SESSION['usuario_id'] == $datos['producto']['usuario_id'];
            ?>

            <?php if ($esPropietario): ?>

                <a href="<?= RUTA_URL ?>/productos/editar/<?= $datos['producto']['producto_id'] ?>"
                   class="bg-green-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-green-700 transition shadow">
                    Editar producto
                </a>

                <a href="<?= RUTA_URL ?>/productos/borrar/<?= $datos['producto']['producto_id'] ?>"
                   class="bg-red-600 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-red-700 transition shadow"
                   onclick="return confirm('¿Seguro que deseas borrar este producto?');">
                    Borrar producto
                </a>

            <?php else: ?>

                <a href="<?= RUTA_URL ?>/favoritos/agregar/<?= $datos['producto']['producto_id'] ?>"
                    class="btn-comprar bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
                    Añadir a favoritos
                </a>

                <?php if (!isset($_SESSION['usuario_id'])): ?>
                    <p class="mensaje-login text-[#0077cc] font-semibold">Inicia sesión para solicitar la compra</p>
                <?php else: ?>
                    <a href="<?= RUTA_URL ?>/solicitudes/crear/<?= $datos['producto']['producto_id'] ?>"
                        class="btn-solicitar bg-[#ff9800] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#e68900] transition shadow">
                        Solicitar compra
                    </a>
                <?php endif; ?>

            <?php endif; ?>

        </div>

    </div>

    <?php if (!empty($datos['productosVendedor'])): ?>
        <h3 class="text-2xl font-bold mt-10 mb-4">Más productos de este vendedor</h3>

        <div class="flex flex-wrap gap-8">
            <?php foreach ($datos['productosVendedor'] as $p): ?>
                <?php if ($p['producto_id'] != $datos['producto']['producto_id']): ?>
                    <a href="<?= RUTA_URL ?>/productos/detalle/<?= $p['producto_id'] ?>"
                       class="producto bg-white border border-gray-300 rounded-xl p-4 shadow-md hover:shadow-xl transition transform hover:scale-105 text-center w-[200px]">

                        <img src="<?= RUTA_URL ?>/img/productos/<?= $p['imagen'] ?>"
                             class="rounded-lg mb-3 w-full h-[180px] object-contain bg-white p-2 shadow-sm">

                        <p class="text-xl font-bold"><?= $p['precio'] ?> €</p>
                        <p class="text-gray-700"><?= htmlspecialchars($p['titulo']) ?></p>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>

<script src="<?= RUTA_URL ?>/js/detalle.js"></script>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
