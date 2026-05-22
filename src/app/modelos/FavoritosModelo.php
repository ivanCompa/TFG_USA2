<?php

class FavoritosModelo
{

    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    /* CONTAR PRODUCTOS EN FAVORITOS */
    public function contarProductos($usuario_id)
    {
        $this->db->query("SELECT COUNT(*) AS total FROM favoritos WHERE usuario_id = :id");
        $this->db->bind(":id", $usuario_id);
        $resultado = $this->db->registro();
        return $resultado['total'] ?? 0;
    }

    /* AÑADIR PRODUCTO A FAVORITOS */
    public function agregarProducto($usuario_id, $producto_id)
    {
        $this->db->query("
            SELECT producto_id FROM favoritos 
            WHERE usuario_id = :u AND producto_id = :p
        ");
        $this->db->bind(":u", $usuario_id);
        $this->db->bind(":p", $producto_id);
        $existe = $this->db->registro();

        if ($existe) {
            return false;
        }

        // INSERTAR NUEVO PRODUCTO 
        $this->db->query("
            INSERT INTO favoritos (usuario_id, producto_id)
            VALUES (:u, :p)
        ");
        $this->db->bind(":u", $usuario_id);
        $this->db->bind(":p", $producto_id);
        return $this->db->execute();
    }

    /* OBTENER FAVORITOS COMPLETOS */
    public function obtenerFavoritos($usuario_id)
    {
        $this->db->query("
            SELECT c.*, p.titulo, p.precio, p.imagen
            FROM favoritos c
            INNER JOIN producto p ON p.producto_id = c.producto_id
            WHERE c.usuario_id = :u
        ");
        $this->db->bind(":u", $usuario_id);
        return $this->db->registros();
    }

    public function eliminarProducto($usuario_id, $producto_id)
    {
        $this->db->query("DELETE FROM favoritos WHERE usuario_id = :uid AND producto_id = :pid");
        $this->db->bind(":uid", $usuario_id);
        $this->db->bind(":pid", $producto_id);
        return $this->db->execute();
    }

    public function existeEnFavoritos($usuario_id, $producto_id)
    {
        $this->db->query("
            SELECT producto_id FROM favoritos 
            WHERE usuario_id = :u AND producto_id = :p
        ");
        $this->db->bind(":u", $usuario_id);
        $this->db->bind(":p", $producto_id);
        return $this->db->registro() ? true : false;
    }

    public function obtenerUsuariosQueTienenEnFavoritos($producto_id)
    {
        $this->db->query("SELECT usuario_id FROM favoritos WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        return $this->db->registros();
    }

    public function eliminarDeTodosLosFavoritos($producto_id)
    {
        $this->db->query("DELETE FROM favoritos WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        return $this->db->execute();
    }
}
