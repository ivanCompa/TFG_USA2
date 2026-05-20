<?php

class Controlador {

    public function modelo($modelo) {
        require_once __DIR__ . "/../modelos/" . $modelo . ".php";
        return new $modelo();
    }

    public function vista($vista, $datos = []) {
        require __DIR__ . "/../vistas/" . $vista . ".php";
    }
}
