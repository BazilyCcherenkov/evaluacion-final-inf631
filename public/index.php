<?php

// public/index.php - Router Principal

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Controllers/ProductoController.php';

Database::crearBaseDatos();

$database = new Database();
$db = $database->getConnection();

$controller = new ProductoController($db);

$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'index':
        $controller->index();
        break;

    case 'stock-alto':
        $controller->stockAlto();
        break;

    case 'vista-boom':
        $controller->vistaBoom();
        break;

    case 'inicializar':
        $controller->inicializar();
        break;

    case 'crear':
        $controller->crear();
        break;

    default:
        $controller->index();
        break;
}
