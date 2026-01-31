<?php

// Incluir helpers y datos iniciales
require_once __DIR__ . '/dataBase.php'; // debe definir $initialProducts y la clase Producto

session_start();

require_once __DIR__ . '/funciones.php';

// Si ya hay productos en sesión, usar esos; si no, usar los iniciales definidos en dataBase.php
$productos = $_SESSION['productos'] ?? $initialProducts;

// Mensaje de éxito desde sesión (si existe) y eliminación para que no se repita
$success = $_SESSION['success'] ?? null;
unset($_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Productos</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .agotado { color: red; font-weight: bold; }
        .disponible { color: green; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Listado de Productos</h1>

    <?php if ($success): ?>
        <p style="color: green; font-weight: bold;"><?php echo escape($success); ?></p>
    <?php endif; ?>

    <p><a href="add.php">Añadir producto</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio (€)</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo escape($producto->id); ?></td>
                    <td><?php echo escape($producto->nombre); ?></td>
                    <td><?php echo escape($producto->descripcion); ?></td>
                    <td><?php echo number_format($producto->precio, 2); ?></td>
                    <td class="<?php echo $producto->stock > 0 ? 'disponible' : 'agotado'; ?>">
                        <?php echo $producto->stock > 0 ? escape($producto->stock) : 'Agotado'; ?>
                    </td>
                    <td><?php echo escape($producto->categoria); ?></td>
                    <td><a href="edit.php?id=<?php echo $producto->id; ?>">Editar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
