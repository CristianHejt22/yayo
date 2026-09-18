<?php
// app/Controllers/AdminController.php

require_once 'core/Controller.php';

class AdminController extends Controller {
    
    private $productoModel;
    private $varianteModel;
    private $pedidoModel;

    public function __construct() {
        // En una app real, aquí se verificaría si el usuario está logueado como admin
        $this->productoModel = $this->model('ProductoModel');
        $this->varianteModel = $this->model('VarianteModel');
        $this->pedidoModel = $this->model('PedidoModel');
    }

    public function index() {
        // Dashboard principal de admin
        $this->view('admin/dashboard');
    }

    // --- CRUD PRODUCTOS ---

    public function productos() {
        $productos = $this->productoModel->getProductos();
        $this->view('admin/productos/index', ['productos' => $productos]);
    }

    public function producto_create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'marca' => $_POST['marca'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio' => $_POST['precio'] ?? 0,
                'estado_publicacion' => $_POST['estado_publicacion'] ?? 'activo',
                'imagen_principal' => ''
            ];

            // Manejo básico de imagen (En un entorno real, mover el archivo subido)
            if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != '') {
                $data['imagen_principal'] = $_FILES['imagen']['name'];
                // Mover archivo subido a public/assets/img/
                move_uploaded_file($_FILES['imagen']['tmp_name'], 'public/assets/img/' . $data['imagen_principal']);
            }

            if ($this->productoModel->createProducto($data)) {
                header('Location: ?c=Admin&a=productos');
                exit;
            } else {
                echo "Error al crear producto";
            }
        } else {
            $this->view('admin/productos/create');
        }
    }

    public function producto_edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?c=Admin&a=productos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nombre' => $_POST['nombre'] ?? '',
                'marca' => $_POST['marca'] ?? '',
                'descripcion' => $_POST['descripcion'] ?? '',
                'precio' => $_POST['precio'] ?? 0,
                'estado_publicacion' => $_POST['estado_publicacion'] ?? 'activo',
                'imagen_principal' => ''
            ];

            if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != '') {
                $data['imagen_principal'] = $_FILES['imagen']['name'];
                move_uploaded_file($_FILES['imagen']['tmp_name'], 'public/assets/img/' . $data['imagen_principal']);
            }

            if ($this->productoModel->updateProducto($id, $data)) {
                header('Location: ?c=Admin&a=productos');
                exit;
            } else {
                echo "Error al actualizar producto";
            }
        } else {
            $producto = $this->productoModel->getProductoById($id);
            $this->view('admin/productos/edit', ['producto' => $producto]);
        }
    }

    public function producto_delete() {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $this->productoModel->deleteProducto($id);
        }
        header('Location: ?c=Admin&a=productos');
        exit;
    }

    // --- CRUD VARIANTES ---

    public function variantes() {
        $producto_id = $_GET['producto_id'] ?? null;
        if (!$producto_id) {
            header('Location: ?c=Admin&a=productos');
            exit;
        }
        $producto = $this->productoModel->getProductoById($producto_id);
        $variantes = $this->varianteModel->getVariantesByProducto($producto_id);
        $this->view('admin/variantes/index', ['producto' => $producto, 'variantes' => $variantes]);
    }

    public function variante_create() {
        $producto_id = $_GET['producto_id'] ?? null;
        if (!$producto_id) {
            header('Location: ?c=Admin&a=productos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'producto_id' => $producto_id,
                'talle' => $_POST['talle'] ?? '',
                'color' => $_POST['color'] ?? '',
                'stock' => $_POST['stock'] ?? 0,
                'sku' => $_POST['sku'] ?? ''
            ];

            if ($this->varianteModel->createVariante($data)) {
                header('Location: ?c=Admin&a=variantes&producto_id=' . $producto_id);
                exit;
            } else {
                echo "Error al crear variante";
            }
        } else {
            $producto = $this->productoModel->getProductoById($producto_id);
            $this->view('admin/variantes/create', ['producto' => $producto]);
        }
    }

    public function variante_edit() {
        $id = $_GET['id'] ?? null;
        $producto_id = $_GET['producto_id'] ?? null;
        
        if (!$id || !$producto_id) {
            header('Location: ?c=Admin&a=productos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'talle' => $_POST['talle'] ?? '',
                'color' => $_POST['color'] ?? '',
                'stock' => $_POST['stock'] ?? 0,
                'sku' => $_POST['sku'] ?? ''
            ];

            if ($this->varianteModel->updateVariante($id, $data)) {
                header('Location: ?c=Admin&a=variantes&producto_id=' . $producto_id);
                exit;
            } else {
                echo "Error al actualizar variante";
            }
        } else {
            $variante = $this->varianteModel->getVarianteById($id);
            $producto = $this->productoModel->getProductoById($producto_id);
            $this->view('admin/variantes/edit', ['variante' => $variante, 'producto' => $producto]);
        }
    }

    public function variante_delete() {
        $id = $_GET['id'] ?? null;
        $producto_id = $_GET['producto_id'] ?? null;
        
        if ($id) {
            $this->varianteModel->deleteVariante($id);
        }
        
        if ($producto_id) {
            header('Location: ?c=Admin&a=variantes&producto_id=' . $producto_id);
        } else {
            header('Location: ?c=Admin&a=productos');
        }
        exit;
    }

    // --- GESTIÓN DE PEDIDOS ---

    public function pedidos() {
        $pedidos = $this->pedidoModel->getPedidos();
        $this->view('admin/pedidos/index', ['pedidos' => $pedidos]);
    }

    public function pedido_detalle() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?c=Admin&a=pedidos');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['estado_pago'])) {
                $this->pedidoModel->updateEstadoPago($id, $_POST['estado_pago']);
            }
            if (isset($_POST['estado_envio'])) {
                $this->pedidoModel->updateEstadoEnvio($id, $_POST['estado_envio']);
            }
            header('Location: ?c=Admin&a=pedido_detalle&id=' . $id);
            exit;
        }

        $pedido = $this->pedidoModel->getPedidoById($id);
        $items = $this->pedidoModel->getPedidoItems($id);
        
        $this->view('admin/pedidos/detalle', ['pedido' => $pedido, 'items' => $items]);
    }
}
?>
