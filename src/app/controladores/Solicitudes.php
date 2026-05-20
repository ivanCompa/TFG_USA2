<?php

class Solicitudes extends Controlador
{
    private $notificacionModelo;
    private $productoModelo;
    private $favoritosModelo;

    public function __construct()
    {
        $this->notificacionModelo = $this->modelo("NotificacionModelo");
        $this->productoModelo = $this->modelo("ProductoModelo");
        $this->favoritosModelo = $this->modelo("FavoritosModelo");
    }

    public function crear($producto_id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $this->notificacionModelo->crearSolicitud($_SESSION['usuario_id'], $producto_id);

        redireccionar("/solicitudes/confirmacion");
    }

    public function confirmacion()
    {
        $this->vista("solicitudes/confirmacion");
    }

    public function aceptar($producto_id)
    {
        // MARCAR SOLICITUD COMO ACEPTADA
        $this->notificacionModelo->marcarProcesado($producto_id, "aceptada");

        // LIMPIAR FAVORITOS Y NOTIFICAR A LOS USUARIOS AFECTADOS
        $this->limpiarFavoritosNotificar($producto_id);

        // REDIRIGIR
        redireccionar("/notificaciones?estado=aceptada");
    }

    public function rechazar($producto_id)
    {
        $this->notificacionModelo->marcarProcesado($producto_id, "rechazada");
        redireccionar("/notificaciones?estado=rechazada");
    }

    // FUNCIÓN CENTRAL: LIMPIAR FAVORITOS + NOTIFICAR USUARIOS
    private function limpiarFavoritosNotificar($producto_id)
    {
        // OBTENER USUARIOS QUE TENÍAN EL PRODUCTO EN FAVORITOS
        $usuarios = $this->favoritosModelo->obtenerUsuariosQueTienenEnFavoritos($producto_id);

        // OBTENER DATOS DEL PRODUCTO
        $producto = $this->productoModelo->obtenerProductoPorId($producto_id);
        $titulo = $producto ? $producto['titulo'] : "Producto eliminado";

        // ELIMINAR DE FAVORITOS
        $this->favoritosModelo->eliminarDeTodosLosFavoritos($producto_id);

        // NOTIFICAR A CADA USUARIO
        foreach ($usuarios as $u) {
            $this->notificacionModelo->notificarFavoritoEliminado($u['usuario_id'], $titulo);
        }
    }
}
