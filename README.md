# Evaluación Final INF-631 - Sistema de Stock de Productos

1. CRUD Productos
Crear modulo completo Producto (id,nombre,precio,stock, categoria), Usar eloquent, migraciones controlador resource y vistas Blade.

Requisitos:

- Tabla: nombre(string),precio (decimal), stock(integer)
- Vista: index Tabla HTML listnado todos productos(@foreach)
- Rutas resource completas.
- Controlador con index() (listar), store() (crear datos fijos).
Probar: Crear 4 productos -> Ver lista funcional en /productos
