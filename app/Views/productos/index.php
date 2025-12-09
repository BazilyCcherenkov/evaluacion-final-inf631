<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Productos - Stock</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
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
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .stat-card h3 {
            font-size: 2em;
            margin-bottom: 5px;
        }
        .stat-card p {
            font-size: 0.9em;
            opacity: 0.9;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: 600;
        }
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
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
        .empty-state svg {
            width: 100px;
            height: 100px;
            opacity: 0.5;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1> Sistema de Stock de Productos</h1>
            <p>Vista Completa - Todos los Productos</p>
            <div class="nav-buttons">
                <a href="/?action=index" class="btn btn-primary"> Todos los Productos</a>
                <a href="/?action=stock-alto" class="btn btn-info"> Stock Alto (&gt;5)</a>
                <a href="/?action=vista-boom" class="btn btn-warning"> Vista Boom (Stock &gt;0)</a>
            </div>
        </header>

        <div class="content">
            <?php
            $total = count($productos);
            $enStock = count(array_filter($productos, fn ($p) => $p['stock'] > 0));
            $stockAlto = count(array_filter($productos, fn ($p) => $p['stock'] > 5));
            $sinStock = $total - $enStock;
            ?>

            <div class="stats">
                <div class="stat-card">
                    <h3><?php echo $total; ?></h3>
                    <p>Total Productos</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $enStock; ?></h3>
                    <p>En Stock</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $stockAlto; ?></h3>
                    <p>Stock Alto (&gt;5)</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $sinStock; ?></h3>
                    <p>Sin Stock</p>
                </div>
            </div>

            <?php if (empty($productos)): ?>
                <div class="empty-state">
                    <h2>No hay productos registrados</h2>
                    <p>Usa el botón de inicializar para cargar datos de prueba</p>
                    <a href="/?action=inicializar" class="btn btn-primary">Inicializar Datos</a>
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
                            <td>
                                <strong style="font-size: 1.2em;">
                                    <?php echo $producto['stock']; ?>
                                </strong>
                            </td>
                            <td>
                                <?php if ($producto['stock'] > 5): ?>
                                    <span class="badge badge-success">Stock Alto</span>
                                <?php elseif ($producto['stock'] > 0): ?>
                                    <span class="badge badge-warning">Stock Bajo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Sin Stock</span>
                                <?php endif; ?>
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
