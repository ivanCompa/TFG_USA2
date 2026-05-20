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

                <!-- Flecha izquierda -->
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

                <!-- Flecha derecha -->
                <?php if ($total > 1): ?>
                    <button
                        class="flecha bg-[#0077cc] text-white text-3xl px-4 py-2 rounded-lg shadow hover:bg-[#005fa3] transition"
                        id="flechaDer">▶</button>
                <?php endif; ?>

            </div>

            <!-- DOTS (PUNTOS DE IMAGEN) -->
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

            <!-- TITULO DEL PRODUCTO -->
            <h2 class="text-3xl font-bold text-gray-800">
                <?= htmlspecialchars($datos['producto']['titulo']) ?>
            </h2>

            <!-- USUARIO QUE SUBIÓ EL PRODUCTO -->
            <a href="<?= RUTA_URL ?>/usuarios/ver/<?= $datos['usuario']['usuario_id'] ?>"
                class="flex items-center gap-3 mt-1 text-sm text-gray-600 hover:text-[#0077cc] transition">

                <img src="<?= RUTA_URL ?>/img/usuarios/<?= htmlspecialchars($datos['usuario']['imagen']) ?>"
                    class="w-8 h-8 rounded-full border border-gray-300 shadow-sm object-cover">

                <span class="font-medium">
                    <?= htmlspecialchars($datos['usuario']['nombre']) ?>
                </span>

            </a>

            <!-- PRECIO -->
            <p class="precio text-3xl font-bold text-[#0077cc]">
                <?= $datos['producto']['precio'] ?> €
            </p>

            <!-- ESTADO -->
            <p class="estado text-lg text-gray-700">
                <strong>Estado:</strong> <?= $datos['producto']['estado'] ?>
            </p>

            <!-- DESCRIPCION -->
            <p class="descripcion text-lg leading-relaxed text-gray-700">
                <?= nl2br(htmlspecialchars($datos['producto']['descripcion'])) ?>
            </p>

            <!-- BOTON AÑADIR AL CARRITO -->
            <a href="<?= RUTA_URL ?>/favoritos/agregar/<?= $datos['producto']['producto_id'] ?>"
                class="btn-comprar bg-[#0077cc] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#005fa3] transition shadow">
                Añadir a favoritos
            </a>

            <!-- BOTON SOLICITAR COMPRA -->
            <?php if (!isset($_SESSION['usuario_id'])): ?>
                <p class="mensaje-login text-[#0077cc] font-semibold">Inicia sesión para solicitar la compra</p>
            <?php else: ?>
                <a href="<?= RUTA_URL ?>/solicitudes/crear/<?= $datos['producto']['producto_id'] ?>"
                    class="btn-solicitar bg-[#ff9800] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-[#e68900] transition shadow">
                    Solicitar compra
                </a>
            <?php endif; ?>

        </div>

    </div>

    <!-- MÁS PRODUCTOS DEL VENDEDOR -->
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

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const inner = document.getElementById("carruselInner");
        const imgs = inner.querySelectorAll(".img-carrusel");
        const dots = document.querySelectorAll("#dots .dot");

        const flechaIzq = document.getElementById("flechaIzq");
        const flechaDer = document.getElementById("flechaDer");

        let index = 0;
        const width = 350;

        if (imgs.length <= 1) return;

        function actualizar() {
            inner.style.transform = `translateX(-${index * width}px)`;
            dots.forEach((d, i) => d.classList.toggle("active", i === index));
        }

        flechaDer?.addEventListener("click", () => {
            index = (index + 1) % imgs.length;
            actualizar();
        });

        flechaIzq?.addEventListener("click", () => {
            index = (index - 1 + imgs.length) % imgs.length;
            actualizar();
        });

        dots.forEach((dot, i) => {
            dot.addEventListener("click", () => {
                index = i;
                actualizar();
            });
        });

    });
</script>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
