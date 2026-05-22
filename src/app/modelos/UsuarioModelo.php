<?php

class UsuarioModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }

    /* OBTENER USUARIO POR ID */
    public function obtenerUsuarioPorId($id)
    {
        $this->db->query("SELECT * FROM usuario WHERE usuario_id = :id");
        $this->db->bind(":id", $id);
        return $this->db->registro();
    }

    /* LOGIN POR NOMBRE */
    public function obtenerUsuarioPorNombre($nombre)
    {
        $this->db->query("SELECT * FROM usuario WHERE nombre = :nombre");
        $this->db->bind(':nombre', $nombre);
        return $this->db->registro();
    }

    public function obtenerUsuarioPorEmail($email)
    {
        $this->db->query("SELECT * FROM usuario WHERE email = :email");
        $this->db->bind(":email", $email);
        return $this->db->registro();
    }


    public function obtenerUsuariosOrdenados($orden)
    {
        $sql = "SELECT * FROM usuario";

        switch ($orden) {
            case "id_asc":
                $sql .= " ORDER BY usuario_id ASC";
                break;
            case "id_desc":
                $sql .= " ORDER BY usuario_id DESC";
                break;

            case "nombre_asc":
                $sql .= " ORDER BY nombre ASC";
                break;
            case "nombre_desc":
                $sql .= " ORDER BY nombre DESC";
                break;

            case "email_asc":
                $sql .= " ORDER BY email ASC";
                break;
            case "email_desc":
                $sql .= " ORDER BY email DESC";
                break;

            case "tipo_asc":
                $sql .= " ORDER BY tipo_usuario ASC";
                break;
            case "tipo_desc":
                $sql .= " ORDER BY tipo_usuario DESC";
                break;

            default:
                $sql .= " ORDER BY usuario_id ASC";
                break;
        }

        $this->db->query($sql);
        $resultado = $this->db->registros();

        $usuarios = [];
        foreach ($resultado as $fila) {
            $usuarios[] = [
                "id" => $fila['usuario_id'],
                "nombre" => $fila['nombre'],
                "email" => $fila['email'],
                "tipo" => $fila['tipo_usuario']
            ];
        }

        return $usuarios;
    }

    /* REGISTRO */
    public function registrarUsuario($usuario, $email, $password, $codigo_postal)
    {
        $this->db->query("INSERT INTO usuario (nombre, email, contraseña, codigo_postal, tipo_usuario, imagen) 
                      VALUES (:nombre, :email, :password, :codigo_postal, 'Estandar', 'pfp_Anonymous.jpg')");

        $this->db->bind(':nombre', $usuario);
        $this->db->bind(':email', $email);
        $this->db->bind(':password', $password);
        $this->db->bind(':codigo_postal', $codigo_postal);

        return $this->db->execute();
    }


    /* OBTENER IMAGEN */
    public function obtenerImagen($usuario_id)
    {
        $this->db->query("SELECT imagen FROM usuario WHERE usuario_id = :id");
        $this->db->bind(":id", $usuario_id);

        $resultado = $this->db->registro();
        return $resultado['imagen'] ?? "pfp_Anonymous.jpg";
    }



    /* ACTUALIZAR PERFIL */
    public function actualizarPerfil($id, $nombre, $email, $imagen, $codigo_postal)
    {
        $this->db->query("UPDATE usuario 
                      SET nombre = :nombre, 
                          email = :email, 
                          imagen = :imagen,
                          codigo_postal = :codigo_postal
                      WHERE usuario_id = :id");

        $this->db->bind(":nombre", $nombre);
        $this->db->bind(":email", $email);
        $this->db->bind(":imagen", $imagen);
        $this->db->bind(":codigo_postal", $codigo_postal);
        $this->db->bind(":id", $id);

        return $this->db->execute();
    }

    public function contarUsuarios()
    {
        $this->db->query("SELECT COUNT(*) AS total FROM usuario");
        return $this->db->registro()['total'];
    }



}
