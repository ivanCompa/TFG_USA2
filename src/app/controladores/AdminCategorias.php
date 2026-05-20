<?php

class AdminCategorias extends Controlador
{
    private $categoriaModelo;

    public function __construct()
    {
        // COMPROBAR SI ES ADMINISTRADOR
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = trim($_POST['nombre']);
            $slug = strtolower(str_replace(" ", "-", $nombre));

            $this->categoriaModelo->crearCategoria($nombre, $slug);

            redireccionar("/categorias/index");
        }
    }

    public function eliminar($id)
    {
        $this->categoriaModelo->eliminarCategoria($id);
        redireccionar("/categorias/index");
    }
}
