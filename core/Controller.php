<?php
// core/Controller.php

class Controller {
    // Cargar un modelo
    public function model($model) {
        require_once 'app/Models/' . $model . '.php';
        return new $model();
    }

    // Cargar una vista (con soporte para layout admin)
    public function view($view, $data = []) {
        if (file_exists('app/Views/' . $view . '.php')) {
            // Extraer variables para que estén disponibles en la vista
            extract($data);
            
            // Iniciar buffer de salida
            ob_start();
            require_once 'app/Views/' . $view . '.php';
            $content = ob_get_clean();
            
            // Verificar si es una vista de admin para usar su layout
            if (strpos($view, 'admin/') === 0) {
                require_once 'app/Views/admin/layout.php';
            } else {
                // Usar layout del frontend
                if (file_exists('app/Views/layout.php')) {
                    require_once 'app/Views/layout.php';
                } else {
                    echo $content;
                }
            }
        } else {
            die("La vista no existe: " . $view);
        }
    }
}
?>
