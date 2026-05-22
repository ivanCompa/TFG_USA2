<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/editarProducto.css">

<nav class="ruta text-xl font-semibold py-4 px-6 text-gray-700">
    Editar producto
</nav>

<div class="editar-contenedor bg-white border-2 border-[#bcd8f0] rounded-xl p-8 shadow-lg w-[calc(100%-40px)] mx-auto">

    <a href="<?= RUTA_URL ?>/usuarios/misproductos" class="volver-btn">← Volver</a>

    <h2 class="text-3xl font-bold mb-6 text-gray-800">Editar producto</h2>

    <form action="<?= RUTA_URL ?>/productos/procesarEditar" method="POST" enctype="multipart/form-data"
          class="editar-form flex flex-col gap-6">

        <input type="hidden" name="producto_id" value="<?= $datos['producto']['producto_id'] ?>">

        <!-- TITULO -->
        <div>
            <label class="label">Título:</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($datos['producto']['titulo']) ?>"
                   class="input" required>
        </div>

        <!-- DESCRIPCION -->
        <div>
            <label class="label">Descripción:</label>
            <textarea name="descripcion" class="textarea" required><?= htmlspecialchars($datos['producto']['descripcion']) ?></textarea>
        </div>

        <!-- PRECIO -->
        <div>
            <label class="label">Precio (€):</label>
            <input type="number" step="0.01" name="precio" value="<?= $datos['producto']['precio'] ?>"
                   class="input" required>
        </div>

        <!-- ESTADO -->
        <div>
            <label class="label">Estado:</label>
            <select name="estado" class="input" required>
                <?php
                $estados = ["Nuevo", "Como nuevo", "Buen estado", "Usado"];
                foreach ($estados as $estado):
                ?>
                    <option value="<?= $estado ?>" <?= $datos['producto']['estado'] === $estado ? "selected" : "" ?>>
                        <?= $estado ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- CATEGORÍA (AÑADIDO) -->
        <div>
            <label class="label">Categoría:</label>
            <select name="categoria_id" class="input" required>
                <?php foreach ($datos['categorias'] as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= $cat['id'] == $datos['producto']['categoria_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- IMAGEN PRINCIPAL -->
        <div>
            <label class="label">Imagen principal actual:</label>
            <img src="<?= RUTA_URL ?>/img/productos/<?= $datos['producto']['imagen'] ?>" class="preview-img">

            <label class="label mt-3">Cambiar imagen principal:</label>
            <input type="file" name="imagen_principal" class="input-file">
        </div>

        <hr class="my-4">

        <!-- IMAGENES EXTRA -->
        <h3 class="text-2xl font-bold mb-2">Imágenes adicionales</h3>

        <div class="imagenes-extra flex flex-wrap gap-6">
            <?php foreach ($datos['imagenes'] as $img): ?>
                <div class="extra-item flex flex-col items-center gap-2">

                    <img src="<?= RUTA_URL ?>/img/productos/<?= $img['ruta'] ?>" class="extra-img">

                    <a class="btn-eliminar"
                       href="<?= RUTA_URL ?>/productos/eliminarImagen/<?= $img['imagen_id'] ?>/<?= $datos['producto']['producto_id'] ?>"
                       onclick="return confirm('¿Eliminar esta imagen?')">
                        Eliminar
                    </a>

                    <input type="file" name="reemplazar_<?= $img['imagen_id'] ?>" class="input-file">
                </div>
            <?php endforeach; ?>
        </div>

        <!-- NUEVAS IMAGENES -->
        <div>
            <label class="label">Añadir nuevas imágenes:</label>
            <input type="file" name="nuevas_imagenes[]" multiple class="input-file">
        </div>

        <!-- BOTÓN GUARDAR -->
        <button type="submit" class="btn-guardar">
            Guardar cambios
        </button>

    </form>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
