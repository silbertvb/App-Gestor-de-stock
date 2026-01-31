<?php
// dataBase.php

/* ===============================================================
    1. Definición de la clase "Producto" usando POO en PHP 8
=================================================================== */

    // el PHP 8 nos permite hacer la definición de los atributos directamente en el constructor
    class Producto {
        public function __construct(
              // 1.1 Definimos las propiedades (atributos) de los productos
            public int $id,
            public string $nombre,
            public string $descripcion,
            public float $precio,
            public int $stock,
            public string $categoria,
        ) {} // cierre del constructor (método especial de PHP 8, que se ejecuta al crear un objeto )
    }

    // 1.2. Simulación de base de datos: array con 5 productos 
    $initialProducts = [
        new Producto(1, "Notebook HP", "Portátil 16 pulgadas 8GB RAM, 256GB SSD", 750.00, 10, "Ordenadores"),
        new Producto(2, "Smartphone Samsung", "Pantalla 6.5 pulgadas, 128GB almacenamiento", 500.00, 8, "Móviles"),
        new Producto(3, "Tablet Apple", "10.2 pulgadas, 64GB almacenamiento", 300.00, 7, "Tablets"),
        new Producto(4, "Auriculares Sony", "Inalámbricos, cancelación de ruido", 150.00, 15,"Accesorios"),
        new Producto(5, "Impresora HP", "Con Inyección de tinta, disponible hasta 5 colores", 89.50, 5,"Impresoras"),
        ];

    ?>
