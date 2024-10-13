<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/User.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario
$user = new User($db);

// Array de usuarios para el seeder
$users = [
	['email' => 'admin@example.com', 'password' => '1234', 'name' => 'Administrador', 'role' => 'admin'],
	['email' => 'john.doe@example.com', 'password' => '1234', 'name' => 'John Doe', 'role' => 'user'],
	['email' => 'jane.smith@example.com', 'password' => '1234', 'name' => 'Jane Smith', 'role' => 'user'],
	['email' => 'emily.johnson@example.com', 'password' => '1234', 'name' => 'Emily Johnson', 'role' => 'user'],
	['email' => 'michael.brown@example.com', 'password' => '1234', 'name' => 'Michael Brown', 'role' => 'user'],
	['email' => 'admin2@example.com', 'password' => '1234', 'name' => 'Super Admin', 'role' => 'admin']
];

// Registrar los usuarios
foreach ($users as $userData) {
	$user->email = $userData['email'];
	$user->password = $userData['password'];
	$user->name = $userData['name'];
	$user->role = $userData['role'];

	// Registrar el usuario
	if ($user->register()) {
		echo "Usuario {$user->email} registrado con éxito.\n";
	} else {
		echo "Error al registrar al usuario {$user->email}.\n";
	}
}
