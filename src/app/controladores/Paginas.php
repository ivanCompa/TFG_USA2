<?php

class Paginas extends Controlador
{
    private $categoriaModelo;
    private $productoModelo;

    public function __construct()
    {
        $this->categoriaModelo = $this->modelo("CategoriaModelo");
        $this->productoModelo = $this->modelo("ProductoModelo");
    }

    public function index()
    {
        // VALORES POR DEFECTO
        $contadorFavoritos = 0;
        $contadorNotificaciones = 0;
        $imagenUsuario = "pfp_Anonymous.jpg";

        if (isset($_SESSION['usuario_id'])) {

            $favoritos = $this->modelo("FavoritosModelo");
            $contadorFavoritos = $favoritos->contarProductos($_SESSION['usuario_id']);

            $notif = $this->modelo("NotificacionModelo");
            $contadorNotificaciones = $notif->contarNoLeidas($_SESSION['usuario_id']);

            $usuario = $this->modelo("UsuarioModelo");
            $imagenUsuario = $usuario->obtenerImagen($_SESSION['usuario_id']);
        }

        // CARGAR CATEGORÍAS DESDE LA BD
        $categorias = $this->categoriaModelo->obtenerCategorias();

        $slug = $_GET['cat'] ?? null;

        // BUSCAR CATEGORÍA SELECCIONADA
        $categoriaSeleccionada = null;

        if ($slug) {
            foreach ($categorias as $cat) {
                if ($cat['slug'] === $slug) {
                    $categoriaSeleccionada = $cat['nombre'];
                    break;
                }
            }
        }

        // RECOGER ORDEN DEL COMBOBOX
        $orden = $_GET['orden'] ?? "";

        // PRODUCTOS
        if ($categoriaSeleccionada) {

            // DESTACADOS
            $destacados = $this->productoModelo->obtenerDestacadosPorCategoria($categoriaSeleccionada);

            // IDS PARA EXCLUIR
            $idsDestacados = array_column($destacados, 'producto_id');

            // RESTO DE PRODUCTOS
            $restoProductos = $this->productoModelo->obtenerRestoPorCategoria(
                $categoriaSeleccionada,
                $idsDestacados,
                $orden
            );

        } else {

            // PÁGINA PRINCIPAL
            $destacados = $this->productoModelo->obtenerDestacadosInicio();
            $restoProductos = [];
        }

        // ENVIAR DATOS A LA VISTA
        $datos = [
            "titulo" => "Inicio USA2",
            "contadorFavoritos" => $contadorFavoritos,
            "contadorNotificaciones" => $contadorNotificaciones,
            "imagenUsuario" => $imagenUsuario,
            "categorias" => $categorias,
            "categoriaSeleccionada" => $categoriaSeleccionada,
            "destacados" => $destacados,
            "restoProductos" => $restoProductos,
            "orden" => $orden
        ];

        $this->vista("paginas/inicio", $datos);
    }
}
