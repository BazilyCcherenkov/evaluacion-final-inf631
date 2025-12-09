<?php

// app/Models/Producto.php

class Producto
{
    private $conn;
    private $table = 'productos';

    // Propiedades del producto
    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $stock;
    public $categoria;

    // Constructor con conexión a BD
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function crearTabla()
    {
        $query = "CREATE TABLE IF NOT EXISTS " . $this->table . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nombre VARCHAR(100) NOT NULL,
            descripcion TEXT,
            precio DECIMAL(10, 2) NOT NULL,
            stock INT NOT NULL DEFAULT 0,
            categoria VARCHAR(50),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function obtenerTodos()
    {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function stockAlto()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE stock > 5 ORDER BY stock DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function vistaBoom()
    {
        $query = "SELECT * FROM " . $this->table . " WHERE stock > 0 ORDER BY nombre ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear()
    {
        $query = "INSERT INTO " . $this->table . " 
                  (nombre, descripcion, precio, stock, categoria) 
                  VALUES (:nombre, :descripcion, :precio, :stock, :categoria)";

        $stmt = $this->conn->prepare($query);

        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->descripcion = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio = htmlspecialchars(strip_tags($this->precio));
        $this->stock = htmlspecialchars(strip_tags($this->stock));
        $this->categoria = htmlspecialchars(strip_tags($this->categoria));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':descripcion', $this->descripcion);
        $stmt->bindParam(':precio', $this->precio);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':categoria', $this->categoria);

        return $stmt->execute();
    }

    public function insertarDatosPrueba()
    {
        $productos = [
            ['Laptop HP', 'Laptop HP Pavilion 15"', 850.00, 3, 'Electrónica'],
            ['Mouse Logitech', 'Mouse inalámbrico', 25.50, 15, 'Accesorios'],
            ['Teclado Mecánico', 'Teclado RGB', 75.00, 8, 'Accesorios'],
            ['Monitor Samsung', 'Monitor 24" Full HD', 180.00, 0, 'Electrónica'],
            ['Webcam HD', 'Webcam 1080p', 45.00, 12, 'Accesorios'],
            ['Auriculares Sony', 'Auriculares Bluetooth', 95.00, 6, 'Audio'],
            ['SSD Kingston', 'SSD 500GB', 65.00, 20, 'Almacenamiento'],
            ['RAM Corsair', 'RAM 16GB DDR4', 80.00, 2, 'Componentes'],
            ['Hub USB', 'Hub USB 3.0 4 puertos', 18.00, 25, 'Accesorios'],
            ['Cable HDMI', 'Cable HDMI 2.0 2m', 12.00, 0, 'Cables']
        ];

        foreach ($productos as $producto) {
            $this->nombre = $producto[0];
            $this->descripcion = $producto[1];
            $this->precio = $producto[2];
            $this->stock = $producto[3];
            $this->categoria = $producto[4];
            $this->crear();
        }

        return true;
    }
}
