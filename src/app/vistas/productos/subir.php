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

    <form action="<?= RUTA_URL ?>/productos/procesarSubida" method="POST" enctype="multipart/form-data"
        class="flex flex-col gap-6">

        <div>
            <label class="label">Título:</label>
            <input type="text" name="titulo" class="input" required>
        </div>

        <div>
            <label class="label">Descripción:</label>
            <textarea name="descripcion" class="textarea" required></textarea>
        </div>


        <label class="label">Categoría:</label>
        <div>
            <label class="label">Categoría:</label>
            <select name="categoria" class="input" required>
                <option value="">Selecciona una categoría</option>

                <?php foreach ($datos['categorias'] as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['nombre']) ?>">
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


        <script>
            let mainImageFile = null;
            let extraImageFiles = [];

            function previewMainImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                mainImageFile = file;

                const wrapper = document.getElementById("main-wrapper");
                const img = document.getElementById("preview-main");

                img.src = URL.createObjectURL(file);
                wrapper.classList.remove("hidden");
            }

            function removeMainImage() {
                mainImageFile = null;

                document.querySelector("input[name='imagen']").value = "";
                document.getElementById("main-wrapper").classList.add("hidden");
            }

            function previewExtraImages(event) {
                const contenedor = document.getElementById("preview-extra");
                contenedor.innerHTML = "";

                extraImageFiles = Array.from(event.target.files);

                extraImageFiles.forEach((file, index) => {
                    const wrapper = document.createElement("div");
                    wrapper.className = "relative inline-block";

                    const img = document.createElement("img");
                    img.src = URL.createObjectURL(file);
                    img.className = "w-28 h-28 object-cover rounded-lg border";

                    const btn = document.createElement("span");
                    btn.innerHTML = "✕";
                    btn.className = "absolute top-1 right-1 bg-red-600 text-white w-6 h-6 flex items-center justify-center rounded-full cursor-pointer opacity-0 hover:opacity-100 transition";

                    btn.onclick = () => removeExtraImage(index);

                    wrapper.appendChild(img);
                    wrapper.appendChild(btn);
                    contenedor.appendChild(wrapper);
                });
            }

            function removeExtraImage(index) {
                extraImageFiles.splice(index, 1);

                const input = document.querySelector("input[name='imagenes_extra[]']");
                const dataTransfer = new DataTransfer();

                extraImageFiles.forEach(file => dataTransfer.items.add(file));

                input.files = dataTransfer.files;

                previewExtraImages({ target: input });
            }
        </script>



        <button type="submit" class="btn-subir">
            Publicar producto
        </button>

    </form>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>