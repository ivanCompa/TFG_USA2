<?php

class Usuarios extends Controlador
{
    private $usuarioModelo;

    public function __construct()
    {
        $this->usuarioModelo = $this->modelo("UsuarioModelo");
    }

    /* LOGIN */
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nombre = trim($_POST['usuario']);
            $password = trim($_POST['password']);

            $usuario = $this->usuarioModelo->obtenerUsuarioPorNombre($nombre);

            if ($usuario && password_verify($password, $usuario['contraseña'])) {

                // GUARDAR DATOS EN SESIÓN
                $_SESSION['usuario_id'] = $usuario['usuario_id'];
                $_SESSION['usuario_nombre'] = $usuario['nombre'];
                $_SESSION['usuario_email'] = $usuario['email'];
                $_SESSION['usuario_imagen'] = $usuario['imagen'];

                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

                header("Location: " . RUTA_URL . "/paginas/index");
                exit;

            } else {
                $datos = ['error' => "Usuario o contraseña incorrectos"];
                $this->vista("usuarios/login", $datos);
            }

        } else {
            $datos = ['error' => ""];
            $this->vista("usuarios/login", $datos);
        }
    }

    /* REGISTRO */
    public function registro()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $usuario = trim($_POST['usuario']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $codigo_postal = trim($_POST['codigo_postal']);

            if ($this->usuarioModelo->obtenerUsuarioPorNombre($usuario)) {
                $datos = ['error' => "El usuario ya existe"];
                $this->vista("usuarios/registro", $datos);
                return;
            }



            if ($this->usuarioModelo->obtenerUsuarioPorEmail($email)) {
                $datos = ['error' => "Este e-mail ya está en uso."];
                $this->vista("usuarios/registro", $datos);
                return;
            }



            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $this->usuarioModelo->registrarUsuario($usuario, $email, $passwordHash, $codigo_postal);

            header("Location: " . RUTA_URL . "/usuarios/login");
            exit;

        } else {
            $datos = ['error' => ""];
            $this->vista("usuarios/registro", $datos);
        }
    }




    /* LOGOUT */
    public function logout()
    {
        session_destroy();
        header("Location: " . RUTA_URL . "/paginas/index");
        exit;
    }

    /* PERFIL */
    public function perfil()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . RUTA_URL . "/usuarios/login");
            exit;
        }

        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($_SESSION['usuario_id']);

        if (!$usuario) {
            die("Error: usuario no encontrado.");
        }

        $datos = [
            'usuario' => $usuario,
            'ok' => isset($_GET['ok'])
        ];

        $this->vista("usuarios/perfil", $datos);
    }

    /* ACTUALIZAR PERFIL */
    public function actualizarPerfil()
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: " . RUTA_URL . "/usuarios/login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = $_SESSION['usuario_id'];
            $nombre = trim($_POST['nombre']);
            $email = trim($_POST['email']);
            $codigo_postal = trim($_POST['codigo_postal']);

            // OBTENER DATOS ACTUALES
            $usuarioActual = $this->usuarioModelo->obtenerUsuarioPorId($id);
            $imagenActual = $usuarioActual['imagen'];

            /* PROCESAR IMAGEN */
            $imagenFinal = $imagenActual;

            if (!empty($_FILES['imagen']['name'])) {

                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                $nuevoNombre = uniqid("user_") . "." . $extension;

                $rutaDestino = RUTA_APP . "/../public/img/usuarios/" . $nuevoNombre;

                move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);

                $imagenFinal = $nuevoNombre;
            }

            /* ACTUALIZAR EN BASE DE DATOS */
            $this->usuarioModelo->actualizarPerfil($id, $nombre, $email, $imagenFinal, $codigo_postal);

            /* ACTUALIZAR SESION */
            $_SESSION['usuario_nombre'] = $nombre;
            $_SESSION['usuario_email'] = $email;
            $_SESSION['usuario_imagen'] = $imagenFinal;

            header("Location: " . RUTA_URL . "/usuarios/perfil?ok=1");
            exit;
        }
    }

    /* MIS PRODUCTOS */
    public function misproductos()
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar('/usuarios/login');
        }

        $productoModelo = $this->modelo('ProductoModelo');
        $productos = $productoModelo->obtenerProductosDeUsuario($_SESSION['usuario_id']);

        $datos = [
            'productos' => $productos
        ];

        $this->vista('usuarios/misproductos', $datos);
    }

    /* PERFIL PUBLICO DE UN USUARIO */
    public function ver($id)
    {
        $usuario = $this->usuarioModelo->obtenerUsuarioPorId($id);

        if (!$usuario) {
            die("Usuario no encontrado.");
        }

        // CARGAR PRODUCTOS DEL USUARIO
        $productoModelo = $this->modelo("ProductoModelo");
        $productos = $productoModelo->obtenerProductosDeUsuario($id);

        $datos = [
            "usuario" => $usuario,
            "productos" => $productos
        ];

        $this->vista("usuarios/ver", $datos);
    }
}
