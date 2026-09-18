<?php
// index.php - Punto de entrada principal (Front Controller)

session_start();

// Autoloading básico o requerimiento de archivos core
require_once 'config/database.php';

// Router básico
$controller = isset($_GET['c']) ? $_GET['c'] : 'Home';
$action = isset($_GET['a']) ? $_GET['a'] : 'index';

// Formatear nombres
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'app/Controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerInstance = new $controllerName();
    
    if (method_exists($controllerInstance, $action)) {
        $controllerInstance->{$action}();
    } else {
        echo "404 - Acción no encontrada";
    }
} else {
    echo "404 - Controlador no encontrado";
}
?>
