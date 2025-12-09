<?php

// app/Controllers/ProductoController.php

require_once __DIR__ . '/../Models/Producto.php';

class ProductoController
{
    private $db;
    private $producto;

    public function __construct($db)
    {
        $this->db = $db;
        $this->producto = new Producto($db);
    }

    public function index()
    {
        $productos = $this->producto->obtenerTodos();
        require_once __DIR__ . '/../Views/productos/index.php';
    }

    public function stockAlto()
    {
        $productos = $this->producto->stockAlto();
        require_once __DIR__ . '/../Views/productos/stock_alto.php';
    }

    public function vistaBoom()
    {
        $productos = $this->producto->vistaBoom();
        require_once __DIR__ . '/../Views/productos/vista_boom.php';
    }

    public function inicializar()
    {
        // Crear tabla si no existe
        $this->producto->crearTabla();

        // Insertar datos de prueba
        $this->producto->insertarDatosPrueba();

        header('Location: /');
        exit();
    }

    public function crear()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->producto->nombre = $_POST['nombre'] ?? '';
            $this->producto->descripcion = $_POST['descripcion'] ?? '';
            $this->producto->precio = $_POST['precio'] ?? 0;
            $this->producto->stock = $_POST['stock'] ?? 0;
            $this->producto->categoria = $_POST['categoria'] ?? '';

            if ($this->producto->crear()) {
                header('Location: /?mensaje=Producto creado exitosamente');
                exit();
            }
        }

        require_once __DIR__ . '/../Views/productos/crear.php';
    }
}
