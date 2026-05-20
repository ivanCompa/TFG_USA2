<?php

class Admin extends Controlador
{
    private $usuarioModelo;
    private $productoModelo;
    private $adminModelo;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== "Administrador") {
            redireccionar("/paginas/index");
        }

        $this->usuarioModelo = $this->modelo("UsuarioModelo");
        $this->productoModelo = $this->modelo("ProductoModelo");
        $this->adminModelo = $this->modelo("AdminModelo");
    }

    public function panel()
    {
        $datos = [
            "totalUsuarios" => $this->usuarioModelo->contarUsuarios(),
            "totalProductos" => $this->productoModelo->contarProductos(),
            "actividad" => $this->adminModelo->actividadReciente()
        ];

        $this->vista("admin/panel", $datos);
    }

    public function usuarios()
    {
        redireccionar("/adminUsuarios/index");
    }

    public function categorias()
    {
        redireccionar("/adminCategorias/index");
    }



}
