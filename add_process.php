<?php
/**
 * add_process.php
 * ----------------
 * Controlador encargado de procesar el formulario de creación de productos.
 * Este archivo NO genera salida HTML; solo valida datos, gestiona errores,
 * actualiza la "base de datos" simulada en sesión y redirige al usuario.
 */

require_once __DIR__ . '/dataBase.php';    // Fuente de datos iniciales y clase Producto

session_start(); // Se inicia sesión para poder almacenar errores, datos antiguos y mensajes de éxito

// Carga de dependencias usando __DIR__ para asegurar rutas absolutas y evitar fallos por ubicaciones relativas
require_once __DIR__ . '/funciones.php';   // Funciones auxiliares: validación, sanitización, etc.


// Este script solo debe ejecutarse mediante POST; si no, se redirige de vuelta al formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: add.php');
    exit;
}

// Recuperación y sanitización mínima de los datos del formulario
// Se usa trim() para eliminar espacios al inicio y final
$input = [
    'nombre'      => trim($_POST['nombre'] ?? ''),
    'descripcion' => trim($_POST['descripcion'] ?? ''),
    'precio'      => trim($_POST['precio'] ?? ''),
    'stock'       => trim($_POST['stock'] ?? ''),
    'categoria'   => trim($_POST['categoria'] ?? ''),
];

// Validación de los datos mediante función externa.
// La función debe devolver un array de errores si encuentra inconsistencias.
$errors = validateProductData($input);

// Si hay errores, se guardan en sesión y se vuelve al formulario
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;        // Para mostrar mensajes de error
    $_SESSION['old_input'] = $input;      // Para rellenar el formulario con los datos previos
    header('Location: add.php');
    exit;
}

// Inicializar la colección de productos en sesión si aún no existe.
// Esto simula una base de datos en memoria.
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = $initialProducts ?? []; 
}

// Se obtiene la referencia al array de productos para modificarlo directamente
$productos = &$_SESSION['productos'];

// Generación del nuevo ID único recorriendo los productos existentes
$maxId = 0;
foreach ($productos as $producto) {
    if ($producto->id > $maxId) {
        $maxId = $producto->id;
    }
}
$newId = $maxId + 1; // Incremento del ID máximo actual para evitar duplicados

// Creación del nuevo objeto Producto.
// Se hace casting explícito para asegurar tipos correctos.
$newProduct = new Producto(
    $newId,
    $input['nombre'],
    $input['descripcion'],
    (float) $input['precio'],
    (int) $input['stock'],
    $input['categoria']
);

// El producto se añade a la "base de datos" en sesión (simulación).
$productos[] = $newProduct;

// Se guarda un mensaje de éxito para mostrar en el listado y se redirige al usuario.
$_SESSION['success'] = 'Producto añadido correctamente.';
header('Location: index.php');
exit;

?>
