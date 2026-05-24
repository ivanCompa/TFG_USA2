<?php

class AdminCategorias extends Controlador
{
    private $categoriaModelo;

    public function __construct()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== "Administrador") {
            redireccionar("/paginas/index");
        }

        $this->categoriaModelo = $this->modelo("CategoriaModelo");
    }

    public function index()
    {
        $orden = $_GET['orden'] ?? null;

        $categorias = $this->categoriaModelo->obtenerCategoriasOrdenadas($orden);

        $datos = [
            "categorias" => $categorias,
            "orden" => $orden
        ];

        $this->vista("admin/categorias", $datos);
    }

    public function crear()
    {
        if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] !== "Administrador") {
            redireccionar('/paginas/index');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redireccionar('/admincategorias/index');
            return;
        }

        $nombre = trim($_POST['nombre'] ?? '');

        if ($nombre === '') {
            redireccionar('/admincategorias/index?error=campos');
            return;
        }

        if ($this->categoriaModelo->crearCategoria($nombre)) {
            redireccionar('/admincategorias/index?ok=1');
        } else {
            redireccionar('/admincategorias/index?error=bd');
        }
    }

    public function eliminar($id)
    {
        $this->categoriaModelo->eliminarCategoria($id);
        redireccionar("/admincategorias/index");
    }

}
