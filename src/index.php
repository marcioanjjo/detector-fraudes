<?php
    
require_once __DIR__ . '/Controllers/AnaliseController.php';


$action = $_GET['action'] ?? 'index';

$controller = new AnaliseController();

switch ($action) {
    case 'analisar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->analisar();
        } else {
            $controller->index();
        }
        break;

    case 'privacidade':
        $controller->privacidade();
        break;

    case 'termos':
        $controller->termos();
        break;

    case 'index':
    default:
        $controller->index();
        break;
}
   
    