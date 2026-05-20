<?php require RUTA_APP . "/vistas/inc/header.php"; ?>

<link rel="stylesheet" href="<?= RUTA_URL ?>/css/index.css">
<link rel="stylesheet" href="<?= RUTA_URL ?>/css/notificaciones.css">

<nav class="ruta">
    Notificaciones
</nav>

<?php if (!empty($datos['estado'])): ?>
    <div class="estado-msg <?= $datos['estado'] === 'ok' ? 'ok' : 'bad' ?>">
        <?= $datos['estado'] === 'ok'
            ? 'La solicitud se ha procesado correctamente.'
            : 'Ha ocurrido un problema al procesar la solicitud.' ?>
    </div>
<?php endif; ?>

<div class="notificaciones-wrapper">

    <a href="<?= RUTA_URL ?>/paginas/index" class="volver-btn">← Volver</a>

    <h2 class="titulo-notificaciones">Notificaciones</h2>

    <?php if (empty($datos['notificaciones'])): ?>

        <p class="sin-notificaciones">No tienes notificaciones.</p>

    <?php else: ?>

        <?php foreach ($datos['notificaciones'] as $n): ?>
            <div class="notif-box flex justify-between items-center">

                <!-- TEXTO -->
                <div>
                    <p><?= htmlspecialchars($n['mensaje']) ?></p>
                    <small><?= $n['fecha'] ?></small>
                </div>

                <!-- SOLICITUD (VENDEDOR) = -->
                <?php if ($n['tipo'] === 'solicitud'): ?>

                    <?php if (empty($n['procesada'])): ?>

                        <!-- BOTONES ACEPTAR / RECHAZAR -->
                        <div class="flex gap-3">

                            <a href="<?= RUTA_URL ?>/solicitudes/aceptar/<?= $n['extra_id'] ?>"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition shadow">
                                Aceptar
                            </a>

                            <a href="<?= RUTA_URL ?>/solicitudes/rechazar/<?= $n['extra_id'] ?>"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition shadow">
                                Rechazar
                            </a>

                        </div>

                    <?php else: ?>

                        <!-- ESTADO -->
                        <?php if ($n['estado'] === 'aceptada'): ?>
                            <span class="text-green-700 font-semibold">Aceptada</span>

                        <?php elseif ($n['estado'] === 'rechazada'): ?>
                            <span class="text-red-700 font-semibold">Rechazada</span>

                        <?php else: ?>
                            <span class="text-yellow-600 font-semibold">Pendiente</span>
                        <?php endif; ?>

                    <?php endif; ?>

                <?php endif; ?>


                <!-- NOTIFICACIÓN DE PAGO (COMPRADOR) -->
                <?php if ($n['tipo'] === 'pago' && $n['estado'] === 'pendiente'): ?>

                    <a href="<?= RUTA_URL ?>/pagos/checkout/<?= $n['extra_id'] ?>"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition shadow">
                        Proceder al pago
                    </a>

                <?php endif; ?>


                <!-- NOTIFICACIÓN INFORMATIVA (RECHAZO) -->
                <?php if ($n['tipo'] === 'info' && $n['estado'] === 'rechazada'): ?>
                    <span class="text-red-700 font-semibold">Solicitud rechazada</span>
                <?php endif; ?>

            </div>
        <?php endforeach; ?>

    <?php endif; ?>

</div>

<?php require RUTA_APP . "/vistas/inc/footer.php"; ?>
