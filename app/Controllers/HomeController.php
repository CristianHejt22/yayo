<?php
// app/Controllers/HomeController.php

require_once 'core/Controller.php';

class HomeController extends Controller {
    
    private $productoModel;
    private $varianteModel;

    public function __construct() {
        $this->productoModel = $this->model('ProductoModel');
        $this->varianteModel = $this->model('VarianteModel');
    }

    public function index() {
        // En el home mostramos solo productos activos
        // Para esto necesitamos un método especial o filtrar el array,
        // Vamos a hacer un fix temporal usando PHP para filtrar:
        $todos_productos = $this->productoModel->getProductos();
        $productos_activos = array_filter($todos_productos, function($p) {
            return $p['estado_publicacion'] === 'activo';
        });

        $this->view('home/index', ['productos' => $productos_activos]);
    }

    public function producto() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?c=Home&a=index');
            exit;
        }

        $producto = $this->productoModel->getProductoById($id);
        
        if (!$producto || $producto['estado_publicacion'] !== 'activo') {
            echo "Producto no encontrado o no disponible.";
            exit;
        }

        $variantes = $this->varianteModel->getVariantesByProducto($id);
        
        $this->view('home/producto', [
            'producto' => $producto,
            'variantes' => $variantes
        ]);
    }
}
?>
