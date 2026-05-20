<?php

function redireccionar($ruta) {
    header("Location: " . RUTA_URL . $ruta);
    exit;
}
