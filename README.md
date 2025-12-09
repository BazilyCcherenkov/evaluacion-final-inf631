# Evaluación Final INF-631 - Sistema de Stock de Productos

1. CRUD Productos
Crear modulo completo Producto (id,nombre,precio,stock, categoria), Usar eloquent, migraciones controlador resource y vistas Blade.

Requisitos:

- Tabla: nombre(string),precio (decimal), stock(integer)
- Vista: index Tabla HTML listnado todos productos(@foreach)
- Rutas resource completas.
- Controlador con index() (listar), store() (crear datos fijos).
Probar: Crear 4 productos -> Ver lista funcional en /productos
Features Implementadas

### Rama: feature-filtro-stock

Esta rama contiene las siguientes mejoras:

1. **Stock Alto**: Filtro para productos con stock > 5
   - URL: `/?action=stock-alto`
   - Muestra solo productos con inventario abundante

2. **Vista Boom**: Productos disponibles
   - URL: `/?action=vista-boom`
   - Filtra productos con stock > 0
   - Destacado visual para items con stock alto

3. **Vista Principal**: Todos los productos
   - URL: `/?action=index`
   - Muestra el inventario completo
   - Estadísticas en tiempo real

## Estructura del Proyecto

```
evaluacion-final-inf631/
├── app/
│   ├── Controllers/
│   │   └── ProductoController.php
│   ├── Models/
│   │   └── Producto.php
│   └── Views/
│       └── productos/
│           ├── index.php
│           ├── stock_alto.php
│           └── vista_boom.php
├── config/
│   └── database.php
├── public/
│   └── index.php
├── .gitignore
└── README.md
```

## Instalación

1. Clonar el repositorio
2. Configurar MySQL (usuario: root, sin password)
3. Acceder a `public/index.php?action=inicializar` para crear BD y datos
4. Navegar por las diferentes vistas

```
# Accede a esta URL:
http://localhost:8000/setup.php
```

## Rutas Disponibles

- `/` o `/?action=index` - Vista principal
- `/?action=stock-alto` - Productos con stock > 5
- `/?action=vista-boom` - Productos disponibles (stock > 0)
- `/?action=inicializar` - Inicializar base de datos
