<?php
// -----------------------------------------------------------
// add.php – Página para añadir un nuevo producto
// -----------------------------------------------------------

// Iniciar sesión para poder recuperar errores y datos previos
session_start();

// Incluimos el archivo que cumplirá con las funciones auxiliares (como escape())
require_once 'funciones.php';

// Recuperar errores y valores previos desde la sesión (si existen)
$errors = $_SESSION['errors'] ?? [];         // Array de errores de validación
$old    = $_SESSION['old_input'] ?? [];      // Valores previos del formulario

// Limpia los datos de sesión para evitar que se repitan
unset($_SESSION['errors'], $_SESSION['old_input']);
?>  


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>

    <!-- Estilos básicos -->
    <style>
        .error { color: red; }
        label { display: block; margin-top: 10px; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 15px; }
    </style>
</head>

<body>
    <!-- ==============================================
        FORMULARIO PARA AÑADIR UN NUEVO PRODUCTO
    =============================================== -->

    <h1>Añadir Nuevo Producto</h1>
    <p><a href="index.php">Volver al listado de productos</a></p>

    <!-- Mostrar errores si existen (ESCAPE DE SALIDA) -->
    <?php if (!empty($errors)): ?>
        <div style="color: red;">
            <p>Se han encontrado errores:</p>
            <ul>
                <?php foreach ($errors as $field => $msg): ?>
                    <li><?php echo escape($msg); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulario de creación de producto -->
    <form action="add_process.php" method="post" novalidate>

        <!-- Campo: Nombre -->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre"
               value="<?php echo escape($old['nombre'] ?? ''); ?>">
        <?php if (isset($errors['nombre'])): ?>
            <span class="error"><?php echo escape($errors['nombre']); ?></span>
        <?php endif; ?>

        <!-- Campo: Descripción -->
        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" rows="4" cols="50"><?php
            echo escape($old['descripcion'] ?? ''); ?></textarea>
        <?php if (isset($errors['descripcion'])): ?>
            <span class="error"><?php echo escape($errors['descripcion']); ?></span>
        <?php endif; ?>

        <!-- Campo: Precio -->
        <label for="precio">Precio (€):</label>
        <input type="text" id="precio" name="precio"
               value="<?php echo escape($old['precio'] ?? ''); ?>">
        <?php if (isset($errors['precio'])): ?>
            <span class="error"><?php echo escape($errors['precio']); ?></span>
        <?php endif; ?>

        <!-- Campo: Stock -->
        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock"
               value="<?php echo escape($old['stock'] ?? ''); ?>">
        <?php if (isset($errors['stock'])): ?>
            <span class="error"><?php echo escape($errors['stock']); ?></span>
        <?php endif; ?>

        <!-- Campo: Categoría -->
        <label for="categoria">Categoría:</label>
        <input type="text" id="categoria" name="categoria"
               value="<?php echo escape($old['categoria'] ?? ''); ?>">
        <?php if (isset($errors['categoria'])): ?>
            <span class="error"><?php echo escape($errors['categoria']); ?></span>
        <?php endif; ?>

        <!-- Botón de envío -->
        <button type="submit">Añadir Nuevo Producto</button>

    </form>

</body>
</html>
