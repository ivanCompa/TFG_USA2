<?php

class NotificacionModelo
{

    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function contarNoLeidas($usuario_id)
    {
        $this->db->query("SELECT COUNT(*) AS total 
                          FROM notificaciones 
                          WHERE usuario_id = :id AND leida = 0");

        $this->db->bind(":id", $usuario_id);
        $resultado = $this->db->registro();
        return $resultado['total'] ?? 0;
    }

    public function obtenerUltimas($usuario_id)
    {
        $this->db->query("SELECT mensaje, fecha 
                          FROM notificaciones 
                          WHERE usuario_id = :id 
                          ORDER BY fecha DESC 
                          LIMIT 5");

        $this->db->bind(":id", $usuario_id);
        return $this->db->registros();
    }

    public function obtenerTodas($usuario_id)
    {
        $this->db->query("SELECT * 
                          FROM notificaciones 
                          WHERE usuario_id = :id 
                          ORDER BY fecha DESC");

        $this->db->bind(":id", $usuario_id);
        return $this->db->registros();
    }

    public function marcarLeidas($usuario_id)
    {
        $this->db->query("UPDATE notificaciones 
                          SET leida = 1 
                          WHERE usuario_id = :id");

        $this->db->bind(":id", $usuario_id);
        return $this->db->execute();
    }

    // MARCAR SOLICITUD COMO ACEPTADA / RECHAZADA
    public function marcarProcesado($producto_id, $estado)
    {
        // OBTENER DATOS DEL PRODUCTO
        $this->db->query("SELECT usuario_id, titulo FROM producto WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        $producto = $this->db->registro();

        if (!$producto)
            return false;

        $dueno_id = $producto['usuario_id'];
        $titulo = $producto['titulo'];

        // OBTENER COMPRADOR REAL DESDE LA NOTIFICACIÓN ORIGINAL
        $this->db->query("
            SELECT comprador_id 
            FROM notificaciones 
            WHERE extra_id = :p AND tipo = 'solicitud'
            ORDER BY fecha DESC LIMIT 1
        ");
        $this->db->bind(":p", $producto_id);
        $solicitud = $this->db->registro();

        if (!$solicitud)
            return false;

        $comprador_id = $solicitud['comprador_id'];

        // MARCAR SOLICITUD ORIGINAL COMO PROCESADA
        $this->db->query("
            UPDATE notificaciones
            SET procesada = 1,
                estado = :estado
            WHERE extra_id = :p AND tipo = 'solicitud'
        ");

        $this->db->bind(":p", $producto_id);
        $this->db->bind(":estado", $estado);
        $this->db->execute();

        // NOTIFICACIÓN AL COMPRADOR SEGÚN ACEPTADA / RECHAZADA
        if ($estado === "aceptada") {

            $mensaje = "Tu solicitud para comprar '$titulo' ha sido aceptada. Pulsa para proceder al pago.";

            $this->db->query("
                INSERT INTO notificaciones (usuario_id, comprador_id, mensaje, fecha, leida, tipo, extra_id, procesada, estado)
                VALUES (:u, :c, :m, NOW(), 0, 'pago', :p, 0, 'pendiente')
            ");

            $this->db->bind(":u", $comprador_id);
            $this->db->bind(":c", $comprador_id);
            $this->db->bind(":m", $mensaje);
            $this->db->bind(":p", $producto_id);
            return $this->db->execute();

        } else if ($estado === "rechazada") {

            $mensaje = "Tu solicitud para comprar '$titulo' ha sido rechazada.";

            $this->db->query("
                INSERT INTO notificaciones (usuario_id, comprador_id, mensaje, fecha, leida, tipo, extra_id, procesada, estado)
                VALUES (:u, :c, :m, NOW(), 0, 'info', :p, 1, 'rechazada')
            ");

            $this->db->bind(":u", $comprador_id);
            $this->db->bind(":c", $comprador_id);
            $this->db->bind(":m", $mensaje);
            $this->db->bind(":p", $producto_id);
            return $this->db->execute();
        }

        return true;
    }

    // CREAR SOLICITUD DE COMPRA
    public function crearSolicitud($comprador_id, $producto_id)
    {
        // OBTENER DUEÑO DEL PRODUCTO
        $this->db->query("SELECT usuario_id, titulo FROM producto WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        $producto = $this->db->registro();

        if (!$producto)
            return false;

        $dueno_id = $producto['usuario_id'];
        $titulo = $producto['titulo'];

        // OBTENER NOMBRE DEL COMPRADOR
        $this->db->query("SELECT nombre FROM usuario WHERE usuario_id = :id");
        $this->db->bind(":id", $comprador_id);
        $comprador = $this->db->registro();

        $nombreComprador = $comprador ? $comprador['nombre'] : "Un usuario";

        // NOTIFICACIÓN AL VENDEDOR
        $mensajeVendedor = "$nombreComprador está solicitando la compra de tu producto: $titulo";

        $this->db->query("
            INSERT INTO notificaciones (usuario_id, comprador_id, mensaje, fecha, leida, tipo, extra_id, procesada, estado)
            VALUES (:u, :c, :m, NOW(), 0, 'solicitud', :p, 0, 'pendiente')
        ");

        $this->db->bind(":u", $dueno_id);
        $this->db->bind(":c", $comprador_id);
        $this->db->bind(":m", $mensajeVendedor);
        $this->db->bind(":p", $producto_id);
        $this->db->execute();

        // NOTIFICACIÓN AL COMPRADOR
        $mensajeComprador = "Has solicitado la compra del producto: $titulo";

        $this->db->query("
            INSERT INTO notificaciones (usuario_id, comprador_id, mensaje, fecha, leida, tipo, extra_id, procesada, estado)
            VALUES (:u, :c, :m, NOW(), 0, 'info', :p, 1, 'aceptada')
        ");

        $this->db->bind(":u", $comprador_id);
        $this->db->bind(":c", $comprador_id);
        $this->db->bind(":m", $mensajeComprador);
        $this->db->bind(":p", $producto_id);

        return $this->db->execute();
    }

    public function notificarFavoritoEliminado($usuario_id, $producto_titulo)
    {
        $mensaje = "El producto '$producto_titulo' ha sido eliminado de tus favoritos porque ya no está disponible.";

        $this->db->query("
            INSERT INTO notificaciones (usuario_id, mensaje, fecha, leida, tipo, procesada, estado)
            VALUES (:u, :m, NOW(), 0, 'info', 1, 'aceptada')
        ");

        $this->db->bind(":u", $usuario_id);
        $this->db->bind(":m", $mensaje);

        return $this->db->execute();
    }

}
