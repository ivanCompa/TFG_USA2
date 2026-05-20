<?php

class Notificaciones extends Controlador
{
    private $notificacionModelo;

    public function index()
    {
        redireccionar("/notificaciones/ver");
    }

    public function __construct()
    {
        $this->notificacionModelo = $this->modelo("NotificacionModelo");
    }

    // LISTAR TODAS LAS NOTIFICACIONES
    public function ver()
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar('/usuarios/login');
        }

        $usuario_id = $_SESSION['usuario_id'];

        // OBTENER TODAS LAS NOTIFICACIONES
        $notificaciones = $this->notificacionModelo->obtenerTodas($usuario_id);

        // MARCAR COMO LEÍDAS
        $this->notificacionModelo->marcarLeidas($usuario_id);

        $datos = [
            'notificaciones' => $notificaciones,
            'estado' => $_GET['estado'] ?? null
        ];

        $this->vista("paginas/notificaciones", $datos);
    }

    // VER UNA NOTIFICACIÓN INDIVIDUAL
    public function detalle($id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar('/usuarios/login');
        }

        // OBTENER LA NOTIFICACIÓN INDIVIDUAL
        $notificacion = $this->notificacionModelo->obtenerNotificacion($id);

        if (!$notificacion) {
            redireccionar('/notificaciones?estado=no_encontrada');
        }

        $datos = [
            'notificacion' => $notificacion
        ];

        $this->vista("notificaciones/ver", $datos);
    }

    public function marcarLeidas()
    {
        if (!isset($_SESSION['usuario_id'])) {
            return;
        }
        
        $this->notificacionModelo->marcarLeidas($_SESSION['usuario_id']);
    }
}
