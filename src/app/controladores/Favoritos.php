<?php

class Favoritos extends Controlador
{
    private $favoritosModelo;

    public function __construct()
    {
        $this->favoritosModelo = $this->modelo("FavoritosModelo");
    }

    public function agregar($producto_id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $this->favoritosModelo->agregarProducto($_SESSION['usuario_id'], $producto_id);

        redireccionar("/favoritos/ver");
    }

    public function ver()
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $productos = $this->favoritosModelo->obtenerFavoritos($_SESSION['usuario_id']);

        $this->vista("favoritos/ver", ["productos" => $productos]);
    }

    public function eliminar($producto_id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar("/usuarios/login");
        }

        $this->favoritosModelo->eliminarProducto($_SESSION['usuario_id'], $producto_id);

        redireccionar("/favoritos/ver");
    }

    public function obtenerUsuariosQueTienenEnFavoritos($producto_id)
    {
        $this->db->query("SELECT usuario_id FROM Favoritos WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        return $this->db->registros();
    }

    public function eliminarDeTodosLosFavoritos($producto_id)
    {
        $this->db->query("DELETE FROM Favoritos WHERE producto_id = :p");
        $this->db->bind(":p", $producto_id);
        return $this->db->execute();
    }


}
