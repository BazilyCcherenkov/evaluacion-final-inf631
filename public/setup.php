<?php
// public/setup.php - Script de inicialización de base de datos

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔧 Configuración de Base de Datos</h1>";
echo "<hr>";

// Paso 1: Crear base de datos
echo "<h2>Paso 1: Creando base de datos...</h2>";
try {
    $conn = new PDO("mysql:host=localhost", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "CREATE DATABASE IF NOT EXISTS stock_productos CHARACTER SET utf8 COLLATE utf8_general_ci";
    $conn->exec($sql);
    
    echo "✅ Base de datos 'stock_productos' creada exitosamente<br>";
} catch(PDOException $e) {
    echo "❌ Error al crear base de datos: " . $e->getMessage() . "<br>";
    die();
}

// Paso 2: Conectar a la base de datos
echo "<h2>Paso 2: Conectando a la base de datos...</h2>";
try {
    $conn = new PDO("mysql:host=localhost;dbname=stock_productos", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Conexión exitosa<br>";
} catch(PDOException $e) {
    echo "❌ Error de conexión: " . $e->getMessage() . "<br>";
    die();
}

// Paso 3: Eliminar tabla si existe (para reiniciar limpio)
echo "<h2>Paso 3: Preparando tabla...</h2>";
try {
    $conn->exec("DROP TABLE IF EXISTS productos");
    echo "✅ Tabla anterior eliminada (si existía)<br>";
} catch(PDOException $e) {
    echo "⚠️ Advertencia: " . $e->getMessage() . "<br>";
}

// Paso 4: Crear tabla productos
echo "<h2>Paso 4: Creando tabla productos...</h2>";
try {
    $sql = "CREATE TABLE productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100) NOT NULL,
        descripcion TEXT,
        precio DECIMAL(10, 2) NOT NULL,
        stock INT NOT NULL DEFAULT 0,
        categoria VARCHAR(50),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    
    $conn->exec($sql);
    echo "✅ Tabla 'productos' creada exitosamente<br>";
} catch(PDOException $e) {
    echo "❌ Error al crear tabla: " . $e->getMessage() . "<br>";
    die();
}

// Paso 5: Insertar datos de prueba
echo "<h2>Paso 5: Insertando datos de prueba...</h2>";
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

try {
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria) 
                           VALUES (:nombre, :descripcion, :precio, :stock, :categoria)");
    
    foreach ($productos as $producto) {
        $stmt->execute([
            ':nombre' => $producto[0],
            ':descripcion' => $producto[1],
            ':precio' => $producto[2],
            ':stock' => $producto[3],
            ':categoria' => $producto[4]
        ]);
        echo "✅ Producto insertado: {$producto[0]}<br>";
    }
    
    echo "<br><strong>✅ Total: " . count($productos) . " productos insertados</strong><br>";
} catch(PDOException $e) {
    echo "❌ Error al insertar datos: " . $e->getMessage() . "<br>";
    die();
}

// Paso 6: Verificar datos
echo "<h2>Paso 6: Verificando datos...</h2>";
try {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM productos");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "✅ Total de productos en la base de datos: <strong>{$result['total']}</strong><br>";
    
    // Mostrar resumen por categoría
    $stmt = $conn->query("SELECT categoria, COUNT(*) as cantidad, SUM(stock) as stock_total 
                         FROM productos 
                         GROUP BY categoria");
    
    echo "<h3>Resumen por categoría:</h3>";
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Categoría</th><th>Cantidad</th><th>Stock Total</th></tr>";
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>{$row['categoria']}</td>";
        echo "<td>{$row['cantidad']}</td>";
        echo "<td>{$row['stock_total']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
} catch(PDOException $e) {
    echo "❌ Error al verificar: " . $e->getMessage() . "<br>";
}

echo "<hr>";
echo "<h2>🎉 ¡Configuración completada!</h2>";
echo "<p><a href='/' style='padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px;'>Ir a la aplicación →</a></p>";

// Estadísticas finales
echo "<h3>📊 Estadísticas:</h3>";
try {
    $stmt = $conn->query("SELECT 
        COUNT(*) as total,
        COUNT(CASE WHEN stock > 5 THEN 1 END) as stock_alto,
        COUNT(CASE WHEN stock > 0 THEN 1 END) as disponibles,
        COUNT(CASE WHEN stock = 0 THEN 1 END) as sin_stock
        FROM productos");
    
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<ul>";
    echo "<li><strong>Total productos:</strong> {$stats['total']}</li>";
    echo "<li><strong>Con stock alto (>5):</strong> {$stats['stock_alto']}</li>";
    echo "<li><strong>Disponibles (>0):</strong> {$stats['disponibles']}</li>";
    echo "<li><strong>Sin stock:</strong> {$stats['sin_stock']}</li>";
    echo "</ul>";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background: #f5f5f5;
    }
    h1 {
        color: #333;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
    }
    h2 {
        color: #667eea;
        margin-top: 30px;
    }
    table {
        background: white;
        margin: 20px 0;
        width: 100%;
    }
    th {
        background: #667eea;
        color: white;
    }
</style>
