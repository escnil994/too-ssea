<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Product.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de producto
$product = new Product($db);

// Array de productos para el seeder
$products = [
	['category_id' => 1, 'name' => 'Laptop HP Pavilion', 'price' => 799.99, 'description' => 'Laptop HP con pantalla de 15 pulgadas, 8 GB de RAM y disco duro de 512 GB SSD. Ideal para tareas cotidianas y profesionales.'],
	['category_id' => 2, 'name' => 'Smartphone Samsung Galaxy S21', 'price' => 999.99, 'description' => 'El último modelo de Samsung con 128 GB de almacenamiento, 5G y pantalla de 6.2 pulgadas. Cámara de alta resolución.'],
	['category_id' => 3, 'name' => 'Audífonos Bluetooth Sony WH-1000XM4', 'price' => 349.99, 'description' => 'Audífonos con cancelación de ruido líder en el mercado. Batería de larga duración y sonido de alta calidad.'],
	['category_id' => 4, 'name' => 'Mouse Inalámbrico Logitech MX Master 3', 'price' => 99.99, 'description' => 'Ratón ergonómico con precisión avanzada. Conectividad Bluetooth y múltiples botones programables.'],
	['category_id' => 1, 'name' => 'Monitor Dell UltraSharp 27"', 'price' => 449.99, 'description' => 'Monitor de alta resolución 4K con colores precisos y diseño sin bordes. Ideal para edición gráfica y multitarea.'],
	['category_id' => 3, 'name' => 'Cámara Canon EOS R5', 'price' => 3899.99, 'description' => 'Cámara profesional mirrorless con sensor de 45 MP, capacidad de grabación en 8K y un sistema de enfoque avanzado.'],
	['category_id' => 2, 'name' => 'Tablet Apple iPad Air 10.9"', 'price' => 599.99, 'description' => 'Pantalla Liquid Retina, procesador A14 Bionic, compatible con el Apple Pencil de segunda generación.'],
	['category_id' => 1, 'name' => 'Teclado Mecánico Razer BlackWidow', 'price' => 159.99, 'description' => 'Teclado mecánico con switches Razer Green, retroiluminación RGB personalizable y diseño duradero.'],
	['category_id' => 2, 'name' => 'Smartwatch Apple Watch Series 7', 'price' => 399.99, 'description' => 'Reloj inteligente con pantalla más grande, resistencia mejorada, y monitoreo de salud avanzado.'],
	['category_id' => 3, 'name' => 'Parlante Portátil JBL Charge 5', 'price' => 179.99, 'description' => 'Parlante Bluetooth portátil con sonido potente, resistente al agua y con una duración de batería de hasta 20 horas.']
];

// Insertar los productos
foreach ($products as $productData) {
	$product->category_id = $productData['category_id'];
	$product->name = $productData['name'];
	$product->price = $productData['price'];
	$product->description = $productData['description'];

	if ($product->create()) {
		echo "Producto '{$product->name}' insertado con éxito.\n";
	} else {
		echo "Error al insertar el producto '{$product->name}'.\n";
	}
}
