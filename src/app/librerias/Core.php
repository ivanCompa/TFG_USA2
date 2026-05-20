<?php

class Core
{

    protected $controladorActual = "Paginas";
    protected $metodoActual = "index";
    protected $parametros = [];

    public function __construct()
    {

        $url = $this->getUrl();

        // CONTROLADOR
        if (!empty($url[0])) {

            // CONVERTIR A PASCALCASE (UCFIRST) POR SI HAY CONTROLADORES CON NOMBRES COMPUESTOS
            $controlador = ucfirst(strtolower($url[0]));

            if (file_exists(__DIR__ . "/../controladores/" . $controlador . ".php")) {
                $this->controladorActual = $controlador;
                unset($url[0]);
            }
        }

        require_once __DIR__ . "/../controladores/" . $this->controladorActual . ".php";
        $this->controladorActual = new $this->controladorActual;

        // MÉTODO
        if (!empty($url[1])) {
            if (method_exists($this->controladorActual, $url[1])) {
                $this->metodoActual = $url[1];
                unset($url[1]);
            }
        }

        // PARÁMETROS
        $this->parametros = $url ? array_values($url) : [];

        // EJECUTAR CONTROLADOR/MÉTODO
        call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
    }

    // PROCESAR URL
    private function getUrl()
    {

        if (isset($_GET['url'])) {

            $url = rtrim($_GET['url'], "/");
            $url = filter_var($url, FILTER_SANITIZE_URL);

            return explode("/", $url);
        }

        return [];
    }
}
