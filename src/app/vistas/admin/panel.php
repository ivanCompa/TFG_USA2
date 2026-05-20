<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<div class="admin-panel">

    <h2 class="titulo-admin">Panel de administración</h2>

    <div class="admin-cards">

        <a href="<?= RUTA_URL ?>/admin/usuarios" class="admin-card">
            <h3>Usuarios</h3>
            <p><?= $totalUsuarios ?> registrados</p>
        </a>

        <a href="<?= RUTA_URL ?>/admin/productos" class="admin-card">
            <h3>Productos</h3>
            <p><?= $totalProductos ?> publicados</p>
        </a>

        <a href="<?= RUTA_URL ?>/admin/estadisticas" class="admin-card">
            <h3>Estadísticas</h3>
            <p>Ver actividad</p>
        </a>

    </div>

    <div class="admin-actividad">
        <h3>Actividad reciente</h3>

        <?php if (!empty($actividad)): ?>
            <ul>
                <?php foreach ($actividad as $item): ?>
                    <li>
                        <strong><?= $item['titulo'] ?></strong><br>
                        <small><?= $item['fecha'] ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No hay actividad reciente.</p>
        <?php endif; ?>
    </div>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>