<?php

class AdminModelo
{
    private $db;

    public function __construct()
    {
        $this->db = new Db;
    }



    public function actividadReciente()
    {
        $this->db->query("
            SELECT titulo, fecha 
            FROM actividad_admin 
            ORDER BY fecha DESC 
            LIMIT 10
        ");
        return $this->db->registros();
    }
}
