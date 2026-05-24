<?php

class Db
{
    private $host = DB_HOST;
    private $usuario = DB_USUARIO;
    private $password = DB_PASSWORD;
    private $nombreBase = DB_NOMBRE;

    private $dbh;     
    private $stmt;    
    private $error;    

    public function __construct()
    {
        if ($this->host === "localhost" || $this->host === "127.0.0.1" || $this->host === "db") {
            $this->host = "db";
        }

        // CONFIGURACIÓN DE CONEXIÓN
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->nombreBase . ";charset=utf8";
        $opciones = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->usuario, $this->password, $opciones);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo "Error de conexión: " . $this->error;
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($parametro, $valor, $tipo = null)
    {
        if (is_null($tipo)) {
            switch (true) {
                case is_int($valor):
                    $tipo = PDO::PARAM_INT;
                    break;
                case is_bool($valor):
                    $tipo = PDO::PARAM_BOOL;
                    break;
                case is_null($valor):
                    $tipo = PDO::PARAM_NULL;
                    break;
                default:
                    $tipo = PDO::PARAM_STR;
            }
        }

        $this->stmt->bindValue($parametro, $valor, $tipo);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function registros()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registro()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

}
