<?php

class ProductoModelo
{

    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    /* OBTENER PRODUCTO POR ID */
    public function obtenerProductoPorId($id)
    {
        $this->db->query("SELECT * FROM producto WHERE producto_id = :id");
        $this->db->bind(':id', $id);
        return $this->db->registro();
    }

    /* OBTENER IMÁGENES DEL PRODUCTO */
    public function obtenerImagenesProducto($producto_id)
    {
        $this->db->query("SELECT * FROM productoimagen WHERE producto_id = :pid");
        $this->db->bind(":pid", $producto_id);
        return $this->db->registros();
    }

    /* DESTACADOS GENERALES */
    public function obtenerDestacados()
    {
        $this->db->query("SELECT * FROM producto ORDER BY RAND() LIMIT 4");
        return $this->db->registros();
    }

    /* PRODUCTOS POR CATEGORÍA */
    public function obtenerPorCategoria($categoria_id)
    {
        $this->db->query("SELECT * FROM producto WHERE categoria_id = :cat ORDER BY producto_id DESC");
        $this->db->bind(':cat', $categoria_id);
        return $this->db->registros();
    }

    /* DESTACADOS POR CATEGORÍA */
    public function obtenerDestacadosPorCategoria($categoria_id)
    {
        $this->db->query("
            SELECT * FROM producto 
            WHERE categoria_id = :cat 
            ORDER BY RAND() 
            LIMIT 4
        ");
        $this->db->bind(':cat', $categoria_id);
        return $this->db->registros();
    }

    /* RESTO DE PRODUCTOS */
    public function obtenerRestoPorCategoria($categoria_id, $excluirIds)
    {
        if (empty($excluirIds)) {
            $excluirIds = [0];
        }

        $placeholders = implode(',', array_fill(0, count($excluirIds), '?'));

        $sql = "
            SELECT * FROM producto 
            WHERE categoria_id = ? 
            AND producto_id NOT IN ($placeholders)
            ORDER BY producto_id DESC
        ";

        $this->db->query($sql);

        $this->db->bind(1, $categoria_id);

        $i = 2;
        foreach ($excluirIds as $id) {
            $this->db->bind($i, $id);
            $i++;
        }

        return $this->db->registros();
    }

    public function obtenerDestacadosInicio()
    {
        $this->db->query("SELECT * FROM producto ORDER BY RAND() LIMIT 4");
        return $this->db->registros();
    }

    /* BÚSQUEDA DE PRODUCTOS */
    public function buscarProductos($texto, $orden = "")
    {
        $sql = "
        SELECT * FROM producto 
        WHERE titulo LIKE :txt 
        OR descripcion LIKE :txt
    ";

        switch ($orden) {
            case "az":
                $sql .= " ORDER BY titulo ASC";
                break;

            case "za":
                $sql .= " ORDER BY titulo DESC";
                break;

            case "precio_asc":
                $sql .= " ORDER BY precio ASC";
                break;

            case "precio_desc":
                $sql .= " ORDER BY precio DESC";
                break;

            default:
                $sql .= " ORDER BY producto_id DESC";
                break;
        }

        $this->db->query($sql);
        $this->db->bind(':txt', '%' . $texto . '%');

        return $this->db->registros();
    }

    public function obtenerProductosDeUsuario($usuario_id)
    {
        $this->db->query("SELECT * FROM producto WHERE usuario_id = :id ORDER BY producto_id DESC");
        $this->db->bind(':id', $usuario_id);
        return $this->db->registros();
    }

    /* ACTUALIZAR CAMPOS DEL PRODUCTO */
    public function actualizarProducto($datos)
    {
        $this->db->query("
        UPDATE producto 
        SET titulo = :titulo,
            descripcion = :descripcion,
            precio = :precio,
            estado = :estado,
            categoria_id = :categoria_id
        WHERE producto_id = :id
    ");

        $this->db->bind(":titulo", $datos["titulo"]);
        $this->db->bind(":descripcion", $datos["descripcion"]);
        $this->db->bind(":precio", $datos["precio"]);
        $this->db->bind(":estado", $datos["estado"]);
        $this->db->bind(":categoria_id", $datos["categoria_id"]);
        $this->db->bind(":id", $datos["id"]);

        return $this->db->execute();
    }

    /* ACTUALIZAR IMAGEN PRINCIPAL */
    public function actualizarImagenPrincipal($id, $ruta)
    {
        $this->db->query("
        UPDATE producto 
        SET imagen = :img 
        WHERE producto_id = :id
    ");

        $this->db->bind(":img", $ruta);
        $this->db->bind(":id", $id);

        return $this->db->execute();
    }

    /* REEMPLAZAR IMAGEN EXISTENTE */
    public function reemplazarImagen($imagenId, $ruta)
    {
        $this->db->query("
        UPDATE productoimagen 
        SET ruta = :ruta 
        WHERE imagen_id = :id
    ");

        $this->db->bind(":ruta", $ruta);
        $this->db->bind(":id", $imagenId);

        return $this->db->execute();
    }

    /* AÑADIR NUEVA IMAGEN */
    public function agregarImagen($producto_id, $ruta)
    {
        $this->db->query("INSERT INTO productoimagen (producto_id, ruta)
                      VALUES (:pid, :ruta)");

        $this->db->bind(":pid", $producto_id);
        $this->db->bind(":ruta", $ruta);

        return $this->db->execute();
    }

    /* CREAR PRODUCTO */
    public function crearProducto($datos)
    {
        $this->db->query("INSERT INTO producto 
        (usuario_id, titulo, descripcion, categoria_id, precio, estado, imagen) 
        VALUES (:usuario_id, :titulo, :descripcion, :categoria_id, :precio, :estado, :imagen)");

        $this->db->bind(":usuario_id", $datos["usuario_id"]);
        $this->db->bind(":titulo", $datos["titulo"]);
        $this->db->bind(":descripcion", $datos["descripcion"]);
        $this->db->bind(":categoria_id", $datos["categoria_id"]);
        $this->db->bind(":precio", $datos["precio"]);
        $this->db->bind(":estado", $datos["estado"]);
        $this->db->bind(":imagen", $datos["imagen"]);

        $this->db->execute();

        return $this->db->lastInsertId();
    }

    public function eliminarProducto($producto_id)
    {
        $this->db->query("DELETE FROM producto WHERE producto_id = :id");
        $this->db->bind(":id", $producto_id);
        return $this->db->execute();
    }

    public function esPropietario($usuario_id, $producto_id)
    {
        $this->db->query("SELECT producto_id FROM producto 
                      WHERE producto_id = :pid AND usuario_id = :uid");

        $this->db->bind(":pid", $producto_id);
        $this->db->bind(":uid", $usuario_id);

        return $this->db->registro();
    }

    public function agregarImagenExtra($producto_id, $ruta)
    {
        $this->db->query("INSERT INTO productoimagen (producto_id, ruta)
                      VALUES (:pid, :ruta)");

        $this->db->bind(":pid", $producto_id);
        $this->db->bind(":ruta", $ruta);

        return $this->db->execute();
    }

    public function eliminarImagen($imagen_id)
    {
        $this->db->query("DELETE FROM productoimagen WHERE imagen_id = :id");
        $this->db->bind(":id", $imagen_id);
        return $this->db->execute();
    }

    public function eliminarImagenesDeProducto($producto_id)
    {
        $this->db->query("DELETE FROM productoimagen WHERE producto_id = :pid");
        $this->db->bind(":pid", $producto_id);
        return $this->db->execute();
    }

    public function contarProductos()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM producto");
        return $this->db->registro()['total'];
    }

    public function marcarComoVendido($producto_id)
    {
        $this->db->query("
        UPDATE producto 
        SET vendido = 1 
        WHERE producto_id = :id
    ");

        $this->db->bind(":id", $producto_id);
        return $this->db->execute();
    }

    /* OBTENER TODAS LAS CATEGORÍAS */
    public function obtenerCategorias()
    {
        $this->db->query("SELECT * FROM categoria ORDER BY nombre ASC");
        return $this->db->registros();
    }

    /* OBTENER UNA CATEGORÍA POR ID */
    public function obtenerCategoriaPorId($id)
    {
        $this->db->query("SELECT * FROM categoria WHERE id = :id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }
}
