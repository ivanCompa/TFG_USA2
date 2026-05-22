<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/subirProducto.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<nav class="ruta text-xl font-semibold py-4 px-6 text-gray-700">
    Subir producto
</nav>

<div class="bg-white border-2 border-[#bcd8f0] shadow-xl rounded-xl p-10 w-[calc(100%-40px)] mx-auto max-w-3xl">

    <a href="javascript:history.back()" class="text-[#0077cc] font-semibold hover:underline">
        ← Volver
    </a>

    <h2 class="text-3xl font-bold mb-6 text-[#0077cc]">Subir producto</h2>

    <?php if (!empty($datos['error'])): ?>
        <p class="bg-red-100 text-red-700 border border-red-300 px-4 py-2 rounded mb-4">
            <?= $datos['error'] ?>
        </p>
    <?php endif; ?>

    <form id="formSubida" action="<?= RUTA_URL ?>/productos/procesarSubida" method="POST" enctype="multipart/form-data"
        class="flex flex-col gap-6">

        <div>
            <label class="label">Título:</label>
            <input type="text" name="titulo" class="input" required>
        </div>

        <div>
            <label class="label">Descripción:</label>
            <textarea name="descripcion" class="textarea" required></textarea>
        </div>

        <!-- CATEGORÍA (CORREGIDO) -->
        <div>
            <label class="label">Categoría:</label>
            <select name="categoria_id" class="input" required>
                <option value="">Selecciona una categoría</option>

                <?php foreach ($datos['categorias'] as $cat): ?>
                    <option value="<?= $cat['id'] ?>">
                        <?= htmlspecialchars($cat['nombre']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <div>
            <label class="label">Precio (€):</label>
            <input type="number" step="0.01" name="precio" class="input" required>
        </div>

        <div>
            <label class="label">Estado:</label>
            <select name="estado" class="input" required>
                <option value="Como nuevo">Como nuevo</option>
                <option value="Buen estado">Buen estado</option>
                <option value="Usado">Usado</option>
            </select>
        </div>

        <div>
            <label class="label">Imagen principal:</label>
            <input type="file" name="imagen" class="input-file" required onchange="previewMainImage(event)">

            <div id="main-wrapper" class="relative inline-block mt-4 hidden">
                <img id="preview-main" class="w-40 h-40 object-cover rounded-lg border">
                <span onclick="removeMainImage()"
                    class="delete-btn absolute top-1 right-1 bg-red-600 text-white w-6 h-6 flex items-center justify-center rounded-full cursor-pointer opacity-0 transition">
                    ✕
                </span>
            </div>
        </div>

        <div>
            <label class="label">Imágenes adicionales:</label>
            <input type="file" name="imagenes_extra[]" class="input-file" multiple onchange="previewExtraImages(event)">

            <div id="preview-extra" class="flex gap-4 flex-wrap mt-4"></div>
        </div>

        <button type="submit" class="btn-subir">
            Publicar producto
        </button>

    </form>

</div>

<script src="<?= RUTA_URL ?>/js/subir.js"></script>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
