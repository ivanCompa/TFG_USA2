<?php

class Productos extends Controlador
{
    private $productoModelo;
    private $favoritosModelo;
    private $notificacionModelo;

    public function __construct()
    {
        $this->productoModelo = $this->modelo("ProductoModelo");
        $this->favoritosModelo = $this->modelo("FavoritosModelo");
        $this->notificacionModelo = $this->modelo("NotificacionModelo");
    }

    /* POR DEFECTO */
    public function index()
    {
        redireccionar("/paginas/index");
    }

    /* DETALLE DEL PRODUCTO */
    public function detalle($id)
    {
        $producto = $this->productoModelo->obtenerProductoPorId($id);

        if (!$producto) {
            die("Producto no encontrado");
        }

        $imagenes = $this->productoModelo->obtenerImagenesProducto($id);

        $imagenesFinales = [];

        if (!empty($producto['imagen'])) {
            $imagenesFinales[] = ['ruta' => $producto['imagen']];
        }

        foreach ($imagenes as $img) {
            $imagenesFinales[] = $img;
        }

        // CARGAR DATOS DEL USUARIO QUE SUBIÓ EL PRODUCTO
        $usuarioModelo = $this->modelo("UsuarioModelo");
        $usuario = $usuarioModelo->obtenerUsuarioPorId($producto['usuario_id']);

        if (empty($usuario['imagen'])) {
            $usuario['imagen'] = "pfp_Anonymous.jpg";
        }

        $datos = [
            'producto' => $producto,
            'imagenes' => $imagenesFinales,
            'usuario' => $usuario
        ];

        $this->vista("productos/detalle", $datos);
    }

    /* EDITAR PRODUCTO (VISTA) */
    public function editar($id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $producto = $this->productoModelo->obtenerProductoPorId($id);

        if (!$producto || $producto['usuario_id'] != $_SESSION['usuario_id']) {
            die("No tienes permiso para editar este producto.");
        }

        $imagenes = $this->productoModelo->obtenerImagenesProducto($id);

        $datos = [
            "producto" => $producto,
            "imagenes" => $imagenes
        ];

        $this->vista("productos/editar", $datos);
    }

    /* PROCESAR EDICIÓN */
    public function procesarEditar()
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            redireccionar("/paginas/index");
        }

        $id = $_POST["producto_id"];

        $producto = $this->productoModelo->obtenerProductoPorId($id);

        if (!$producto || $producto["usuario_id"] != $_SESSION["usuario_id"]) {
            die("No tienes permiso para editar este producto.");
        }

        // ACTUALIZAR CAMPOS BÁSICOS
        $datosActualizados = [
            "id" => $id,
            "titulo" => trim($_POST["titulo"]),
            "descripcion" => trim($_POST["descripcion"]),
            "precio" => $_POST["precio"],
            "estado" => $_POST["estado"]
        ];

        $this->productoModelo->actualizarProducto($datosActualizados);

        // CAMBIAR IMAGEN PRINCIPAL
        if (!empty($_FILES["imagen_principal"]["name"])) {
            $nombre = uniqid() . "_" . $_FILES["imagen_principal"]["name"];
            $rutaDestino = RUTA_PUBLIC . "/img/productos/" . $nombre;

            move_uploaded_file($_FILES["imagen_principal"]["tmp_name"], $rutaDestino);

            $this->productoModelo->actualizarImagenPrincipal($id, $nombre);
        }

        // REEMPLAZAR IMÁGENES EXISTENTES
        foreach ($_FILES as $key => $file) {
            if (strpos($key, "reemplazar_") === 0 && !empty($file["name"])) {
                $imagenId = str_replace("reemplazar_", "", $key);
                $nuevoNombre = uniqid() . "_" . $file["name"];
                $rutaDestino = RUTA_PUBLIC . "/img/productos/" . $nuevoNombre;

                move_uploaded_file($file["tmp_name"], $rutaDestino);

                $this->productoModelo->reemplazarImagen($imagenId, $nuevoNombre);
            }
        }

        // SUBIR NUEVAS IMÁGENES
        if (!empty($_FILES["nuevas_imagenes"]["name"][0])) {
            foreach ($_FILES["nuevas_imagenes"]["name"] as $i => $nombreOriginal) {
                $nuevoNombre = uniqid() . "_" . $nombreOriginal;
                $rutaDestino = RUTA_PUBLIC . "/img/productos/" . $nuevoNombre;

                move_uploaded_file($_FILES["nuevas_imagenes"]["tmp_name"][$i], $rutaDestino);

                $this->productoModelo->agregarImagen($id, $nuevoNombre);
            }
        }

        redireccionar("/productos/editar/$id?estado=ok");
    }

    /* ELIMINAR IMAGEN */
    public function eliminarImagen($imagenId, $productoId)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $producto = $this->productoModelo->obtenerProductoPorId($productoId);

        if (!$producto || $producto["usuario_id"] != $_SESSION["usuario_id"]) {
            die("No tienes permiso para eliminar esta imagen.");
        }

        $this->productoModelo->eliminarImagen($imagenId);

        redireccionar("/productos/editar/$productoId?estado=imagen_eliminada");
    }

    /* BÚSQUEDA DE PRODUCTOS */
    public function buscar()
    {
        if (!isset($_GET['buscar']) || empty($_GET['buscar'])) {
            redireccionar("/paginas/index");
        }

        $texto = trim($_GET['buscar']);
        $orden = $_GET['orden'] ?? "";

        $resultados = $this->productoModelo->buscarProductos($texto, $orden);

        $datos = [
            "titulo" => "Resultados de búsqueda",
            "texto" => $texto,
            "resultados" => $resultados,
            "orden" => $orden
        ];

        $this->vista("productos/buscar", $datos);
    }

    /* ELIMINAR PRODUCTO */
    public function eliminar($id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        // VERIFICAR PROPIETARIO
        if (!$this->productoModelo->esPropietario($_SESSION['usuario_id'], $id)) {
            die("No tienes permiso para eliminar este producto.");
        }

        // LIMPIAR FAVORITOS Y NOTIFICAR USUARIOS AFECTADOS
        $this->limpiarFavoritosNotificar($id);

        // ELIMINAR IMÁGENES ADICIONALES
        $this->productoModelo->eliminarImagenesDeProducto($id);

        // ELIMINAR EL PRODUCTO
        $this->productoModelo->eliminarProducto($id);

        redireccionar("/usuarios/misproductos");
    }

    /* LIMPIAR FAVORITOS Y NOTIFICAR */
    private function limpiarFavoritosNotificar($producto_id)
    {
        // OBTENER TÍTULO DEL PRODUCTO
        $producto = $this->productoModelo->obtenerProductoPorId($producto_id);
        $titulo = $producto ? $producto['titulo'] : "Producto eliminado";

        // USUARIOS QUE LO TENÍAN EN FAVORITOS
        $usuarios = $this->favoritosModelo->obtenerUsuariosQueTienenEnFavoritos($producto_id);

        // ELIMINAR DE FAVORITOS
        $this->favoritosModelo->eliminarDeTodosLosFavoritos($producto_id);

        // NOTIFICAR A CADA USUARIO
        foreach ($usuarios as $u) {
            $this->notificacionModelo->notificarFavoritoEliminado($u['usuario_id'], $titulo);
        }
    }
}
