<?php
// edit.php - Vista para mostrar los datos de un producto en modo solo lectura

require_once __DIR__ . '/dataBase.php'; // para cargar datos iniciales y definición de la clase Pro (si es necesario)

session_start(); // Se inicia sesión para acceder a los productos almacenados previamente
require_once __DIR__ . '/funciones.php'; // funciones auxiliares de sanitización y escape de datos


//  1. PARA OBTENER EL ID DEL PRODUCTO DESDE GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
 // Si no se envió id=X, mostramos mensaje de error
if ($id === null) {
    echo "Error: ID no proporcionado.";
    exit;
}



//    2.  OBTENER LA LISTA DE PRODUCTOS DESDE SISIÓN O INICIALIZAR  
if (!isset($_SESSION['productos'])) {
    $_SESSION['productos'] = $initialProducts;
}

$productos = $_SESSION['productos'];

// 3. BUSCAR EL PRODUCTO POR EL ID USANDO UN BUCLE FOR 
$found = null;

for ($i = 0; $i < count($productos); $i++) {
    if ($productos[$i]->id === $id) {
        $found = $productos[$i]; // producto encontrado
        break;
    }
}

// si el producto no existe, mostramos mensaje de error
if (!$found) {
    echo "Error: Producto no encontrado.";
    exit;
}
?>

<!-------------------------------------------------------
    NUEVA PÁGINA GENERADA PARA MOSTRAR LOS PRODUCTOS 
    ----------------------------------------------------->
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Editar Producto (Simulado)</title>
</head>
<body>
    <h1>Editar Producto (Simulación)</h1>
    <p><a href="index.php">Volver al listado</a></p>

    <!-- FORMULARIO SOLO DE LECTURA (NO MODIFICA DATOS) -->
    <form>
        <!-- Campos: nombre, descripción, precio, stock, categoria -->
        <label>Nombre:<br>
            <input type="text" name="nombre" value="<?php echo escape($found->nombre); ?>" disabled>
        </label><br><br>

        <label>Descripción:<br>
            <textarea rows="4" cols="50" disabled><?php echo escape($found->descripcion); ?></textarea>
        </label><br><br>

        <label>Precio:<br>
            <input type="text" value="<?php echo escape((string)number_format($found->precio, 2, '.', '')); ?>" disabled>
        </label><br><br>

        <label>Stock:<br>
            <input type="number" value="<?php echo escape((string)$found->stock); ?>" disabled>
        </label><br><br>

        <label>Categoría:<br>
            <input type="text" value="<?php echo escape($found->categoria); ?>" disabled>
        </label><br><br>

        <p>Nota: esta página solo muestra los datos para editar (simulación). No guarda los cambios.</p>
    </form>
</body>
</html>
