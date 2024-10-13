<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Category.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

$category = new Category($db);

// Array de categorías para el seeder
$categories = [
	['id' => 1, 'name' => 'Electrónica'],
	['id' => 2, 'name' => 'Dispositivos Móviles'],
	['id' => 3, 'name' => 'Accesorios'],
	['id' => 4, 'name' => 'Fotografía'],
	['id' => 5, 'name' => 'Gaming'],
	['id' => 6, 'name' => 'Hogar y Oficina']
];

// Insertar las categorías
foreach ($categories as $categoryData) {
	$category->id = $categoryData['id']; // Si la base de datos permite insertar manualmente IDs
	$category->name = $categoryData['name'];

	if ($category->create()) {
		echo "Categoría '{$category->name}' insertada con éxito.\n";
	} else {
		echo "Error al insertar la categoría '{$category->name}'.\n";
	}
}
