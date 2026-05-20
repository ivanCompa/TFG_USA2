<?php require RUTA_APP . "/vistas/inc/header.php"; ?>
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">


<div class="bg-white border-2 border-[#bcd8f0] shadow-xl rounded-xl p-10 w-[calc(100%-40px)] mx-auto max-w-5xl">

    <h2 class="text-3xl font-bold mb-6 text-[#0077cc]">Gestión de usuarios</h2>

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
                <a href="<?= RUTA_URL ?>/adminUsuarios/index<?= $siguiente ? '?orden='.$siguiente : '' ?>"
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
                <a href="<?= RUTA_URL ?>/adminUsuarios/index<?= $siguiente ? '?orden='.$siguiente : '' ?>"
                   class="font-bold hover:underline flex items-center gap-1">
                    Nombre <?= $flecha ?>
                </a>
            </th>

            <!-- ORDEN POR EMAIL -->
            <th class="border p-3">
                <?php
                    $flecha = "";
                    if ($datos['orden'] === 'email_asc') $flecha = "▲";
                    if ($datos['orden'] === 'email_desc') $flecha = "▼";

                    $siguiente = "email_asc";
                    if ($datos['orden'] === 'email_asc') $siguiente = "email_desc";
                    if ($datos['orden'] === 'email_desc') $siguiente = "";
                ?>
                <a href="<?= RUTA_URL ?>/adminUsuarios/index<?= $siguiente ? '?orden='.$siguiente : '' ?>"
                   class="font-bold hover:underline flex items-center gap-1">
                    Email <?= $flecha ?>
                </a>
            </th>

            <!-- ORDEN POR TIPO -->
            <th class="border p-3">
                <?php
                    $flecha = "";
                    if ($datos['orden'] === 'tipo_asc') $flecha = "▲";
                    if ($datos['orden'] === 'tipo_desc') $flecha = "▼";

                    $siguiente = "tipo_asc";
                    if ($datos['orden'] === 'tipo_asc') $siguiente = "tipo_desc";
                    if ($datos['orden'] === 'tipo_desc') $siguiente = "";
                ?>
                <a href="<?= RUTA_URL ?>/adminUsuarios/index<?= $siguiente ? '?orden='.$siguiente : '' ?>"
                   class="font-bold hover:underline flex items-center gap-1">
                    Tipo <?= $flecha ?>
                </a>
            </th>

            <th class="border p-3">Acciones</th>
        </tr>

        <?php foreach ($datos['usuarios'] as $u): ?>
            <tr>
                <td class="border p-3"><?= $u['id'] ?></td>
                <td class="border p-3"><?= htmlspecialchars($u['nombre']) ?></td>
                <td class="border p-3"><?= htmlspecialchars($u['email']) ?></td>
                <td class="border p-3"><?= htmlspecialchars($u['tipo']) ?></td>

                <td class="border p-3">
                    <a href="<?= RUTA_URL ?>/adminUsuarios/eliminar/<?= $u['id'] ?>"
                       class="text-red-600 font-semibold hover:underline"
                       onclick="return confirm('¿Eliminar usuario?')">
                        Eliminar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
