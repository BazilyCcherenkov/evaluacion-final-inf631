<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alto - Productos con Stock &gt; 5</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .subtitle {
            font-size: 1.2em;
            opacity: 0.9;
        }
        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 600;
        }
        .btn-primary {
            background: #4CAF50;
            color: white;
        }
        .btn-info {
            background: #2196F3;
            color: white;
        }
        .btn-warning {
            background: #FF9800;
            color: white;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        .content {
            padding: 30px;
        }
        .filter-info {
            background: #e8f5e9;
            border-left: 4px solid #4CAF50;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
        .filter-info h3 {
            color: #2e7d32;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        thead {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
        }
        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
            letter-spacing: 1px;
        }
        td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        tr:hover {
            background: #f8f9fa;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .stock-alto {
            color: #28a745;
            font-weight: 700;
            font-size: 1.3em;
        }
        .precio {
            font-weight: 600;
            color: #28a745;
            font-size: 1.1em;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📈 Stock Alto</h1>
            <p class="subtitle">Productos con Stock Mayor a 5 Unidades</p>
            <div class="nav-buttons">
                <a href="/?action=index" class="btn btn-primary">📋 Todos los Productos</a>
                <a href="/?action=stock-alto" class="btn btn-info">📈 Stock Alto (&gt;5)</a>
                <a href="/?action=vista-boom" class="btn btn-warning">⚡ Vista Boom (Stock &gt;0)</a>
            </div>
        </header>

        <div class="content">
            <div class="filter-info">
                <h3>🔍 Filtro Activo</h3>
                <p><strong>Condición:</strong> Mostrando únicamente productos con stock &gt; 5 unidades</p>
                <p><strong>Resultados encontrados:</strong> <?php echo count($productos); ?> productos</p>
            </div>

            <?php if (empty($productos)): ?>
                <div class="empty-state">
                    <h2>No hay productos con stock alto</h2>
                    <p>No existen productos con más de 5 unidades en stock</p>
                    <a href="/?action=index" class="btn btn-primary">Ver todos los productos</a>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($producto['id']); ?></td>
                            <td><strong><?php echo htmlspecialchars($producto['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                            <td class="precio">$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td class="stock-alto">
                                <?php echo $producto['stock']; ?> unidades
                            </td>
                            <td>
                                <span class="badge-success">✓ Stock Alto</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
