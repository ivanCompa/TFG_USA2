<?php

class AdminUsuarios extends Controlador
{
    private $usuarioModelo;

    public function __construct()
    {
        // COMPROBAR SI ES ADMINISTRADOR
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== "Administrador") {
            redireccionar("/paginas/index");
        }

        $this->usuarioModelo = $this->modelo("UsuarioModelo");
    }

    public function index()
    {
        $orden = $_GET['orden'] ?? null;

        $usuarios = $this->usuarioModelo->obtenerUsuariosOrdenados($orden);

        $datos = [
            "usuarios" => $usuarios,
            "orden" => $orden
        ];

        $this->vista("admin/usuarios", $datos);
    }

    public function eliminar($id)
    {
        $this->usuarioModelo->eliminarUsuario($id);
        redireccionar("/adminUsuarios/index");
    }
}
