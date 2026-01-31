<?php
// funciones.php
// validadores, utilidades y factory closueres para validaciones.
// No hace session_start aquí. Lo hará el script que incluya este fichero.

function escape(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
} // escape para evitar XSS (vulnerabilidades)

/* =======================================
    Validadores simples del formulario 
============================================*/
function isValidString(mixed $value): bool {
    return is_string($value) && trim($value) !== '';
} // Valida que sea una cadena no vacía

function isValidPrice(mixed $value): bool {
    if (!is_numeric($value)) return false;
    $price = (float) $value;
    return $price > 0;
} // Valida que sea un número positivo (>0)

function isValidStock(mixed $value): bool {
    if (!is_numeric($value)) return false;
    $stock = (int)$value;
    return ((string) $stock === (string)$value || $value === '0') && $stock >= 0;
} // valida que sea un entero positivo (>=0) y no un float ni string no numérico



/* =======================================
    Factory closures para validadores
============================================*/
// Validador de longitud mínima de cadena 
// Ejemplo de uso: $isValidMin3 = createMinLengthValidator(3); 
// por ejemplo para nombre de producto para validar que tenga al menos 3 caracteres
function createMinLengthValidator(int $minLength): Closure {
    return function(mixed $value) use ($minLength): bool {
        return is_string($value) && mb_strlen(trim($value)) >= $minLength;
    };
} 

function validateProductData(array $data) : array {
    $errors = [];

    // Uso de closere factory: validador de nombre (mínimo 3 caracteres)
    $minLength3 = createMinLengthValidator(3);

    // Validar nombre
    if (!isValidString($data['nombre'] ) || !$minLength3($data['nombre'])) {
        $errors['nombre'] = 'El nombre debe contener al menos 3 caracteres.';
    }

    // Validar descripción
    if (!isValidString($data['descripcion'] ) || !isset($data['descripcion'])) {
        $errors['descripcion'] = 'La descripción es obligatoria.';
    }

    // Validar precio
    if (!isValidPrice($data['precio'] ) || !isset($data['precio'])) {
        $errors['precio'] = 'El precio debe ser un número positivo.';
    }

    // Validar stock
    if (!isValidStock($data['stock'] ?? null)) {
        $errors['stock'] = 'El stock debe ser un entero positivo.';
    }

    // Validar categoría
    if (!isValidString($data['categoria'])|| !isset($data['categoria'])) {
        $errors['categoria'] = 'La categoría es obligatoria.';
    }

    return $errors;
}


