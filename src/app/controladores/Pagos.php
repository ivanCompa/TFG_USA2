<?php

class Pagos extends Controlador
{
    private $productoModelo;

    public function __construct()
    {
        $this->productoModelo = $this->modelo("ProductoModelo");
    }

    public function checkout($producto_id)
    {
        if (!isset($_SESSION['usuario_id'])) {
            redireccionar('/usuarios/login');
        }

        // CARGAR STRIPE
        require_once __DIR__ . '/../../vendor/autoload.php';

        \Stripe\Stripe::setApiKey('');

        // OBTENER EL PRODUCTO
        $producto = $this->productoModelo->obtenerProductoPorId($producto_id);

        if (!$producto) {
            redireccionar('/paginas/error');
        }

        // CREAR SESIÓN DE PAGO
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [
                [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $producto['titulo'],
                        ],
                        'unit_amount' => $producto['precio'] * 100,
                    ],
                    'quantity' => 1,
                ]
            ],
            'mode' => 'payment',
            'success_url' => RUTA_URL . '/pagos/exito',
            'cancel_url' => RUTA_URL . '/pagos/cancelado',
        ]);

        header("Location: " . $session->url);
        exit;
    }

    public function exito()
    {
        $this->vista("paginas/pago_exito");
    }

    public function cancelado()
    {
        $this->vista("paginas/pago_cancelado");
    }
}
