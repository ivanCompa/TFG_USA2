<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">

<div class="bg-white border-2 border-[#bcd8f0] shadow-xl rounded-xl p-10 w-[calc(100%-40px)] mx-auto max-w-4xl">

    <h2 class="text-3xl font-bold mb-6 text-[#0077cc]">Gestión de categorías</h2>

    <!-- FORMULARIO CREAR -->
    <form action="<?= RUTA_URL ?>/admincategorias/crear" method="POST" class="flex gap-4 mb-8">
        <input type="text" name="nombre" placeholder="Nueva categoría"
            class="border border-gray-400 rounded-lg px-4 py-2 w-64 focus:outline-none focus:ring-2 focus:ring-[#0077cc]"
            required>

        <button type="submit"
            class="bg-[#0077cc] text-white px-6 py-2 rounded-lg hover:bg-[#005fa3] transition shadow-md">
            Crear
        </button>
    </form>

    <!-- LISTADO -->
    <table class="w-full border-collapse">
        <tr class="bg-[#e6f2ff] text-left">

            <!-- ORDEN POR ID -->
            <th class="border p-3">
                <?php
                $flecha = "";
                if ($datos['orden'] === 'id_asc') $flecha = "▲";
                if ($datos['orden'] === 'id_desc') $flecha = "▼";

                $siguiente = "id_asc";
                if ($datos['orden'] === 'id_asc') $siguiente = "id_desc";
                if ($datos['orden'] === 'id_desc') $siguiente = "";
                ?>
                <a href="<?= RUTA_URL ?>/admincategorias/index<?= $siguiente ? '?orden=' . $siguiente : '' ?>"
                    class="font-bold hover:underline flex items-center gap-1">
                    ID <?= $flecha ?>
                </a>
            </th>

            <!-- ORDEN POR NOMBRE -->
            <th class="border p-3">
                <?php
                $flecha = "";
                if ($datos['orden'] === 'nombre_asc') $flecha = "▲";
                if ($datos['orden'] === 'nombre_desc') $flecha = "▼";

                $siguiente = "nombre_asc";
                if ($datos['orden'] === 'nombre_asc') $siguiente = "nombre_desc";
                if ($datos['orden'] === 'nombre_desc') $siguiente = "";
                ?>
                <a href="<?= RUTA_URL ?>/admincategorias/index<?= $siguiente ? '?orden=' . $siguiente : '' ?>"
                    class="font-bold hover:underline flex items-center gap-1">
                    Nombre <?= $flecha ?>
                </a>
            </th>

            <th class="border p-3">Acciones</th>

        </tr>

        <?php foreach ($datos['categorias'] as $cat): ?>
            <tr>
                <td class="border p-3"><?= $cat['id'] ?></td>
                <td class="border p-3"><?= htmlspecialchars($cat['nombre']) ?></td>
                <td class="border p-3">
                    <a href="<?= RUTA_URL ?>/admincategorias/eliminar/<?= $cat['id'] ?>"
                        class="text-red-600 font-semibold hover:underline"
                        onclick="return confirm('¿Eliminar categoría?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
