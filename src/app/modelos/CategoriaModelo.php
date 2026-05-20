<?php

class CategoriaModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    public function obtenerCategorias()
    {
        $this->db->query("SELECT * FROM categoria ORDER BY nombre ASC");
        $resultado = $this->db->registros();


        $categorias = [];
        foreach ($resultado as $fila) {
            $categorias[] = [
                "id" => $fila['id'],
                "nombre" => $fila['nombre'],
                "slug" => $fila['slug']
            ];
        }

        return $categorias;
    }

    public function crearCategoria($nombre, $slug)
    {
        $this->db->query("INSERT INTO categoria (nombre, slug) VALUES (:nombre, :slug)");
        $this->db->bind(':nombre', $nombre);
        $this->db->bind(':slug', $slug);
        return $this->db->execute();
    }

    public function eliminarCategoria($id)
    {
        $this->db->query("DELETE FROM categoria WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function obtenerCategoriasOrdenadas($orden)
    {
        $sql = "SELECT * FROM categoria";

        switch ($orden) {
            case "id_asc":
                $sql .= " ORDER BY id ASC";
                break;

            case "id_desc":
                $sql .= " ORDER BY id DESC";
                break;

            case "nombre_asc":
                $sql .= " ORDER BY nombre ASC";
                break;

            case "nombre_desc":
                $sql .= " ORDER BY nombre DESC";
                break;

            default:
                $sql .= " ORDER BY id ASC";
                break;
        }

        $this->db->query($sql);
        $resultado = $this->db->registros();

        $categorias = [];
        foreach ($resultado as $fila) {
            $categorias[] = [
                "id" => $fila['id'],
                "nombre" => $fila['nombre'],
                "slug" => $fila['slug']
            ];
        }

        return $categorias;
    }

}
