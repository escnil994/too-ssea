<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario
$usuario = new Usuario($db);

// Array de usuarios para el seeder
$usuarios = [
	['correo' => 'administrador@too.ues', 'contrasena' => '1234', 'nombre' => 'Administrador', 'rol' => 'administrador'],
	['correo' => 'operador@too.ues', 'contrasena' => '1234', 'nombre' => 'John Doe', 'rol' => 'operador'],
	['correo' => 'gerente@too.ues', 'contrasena' => '1234', 'nombre' => 'Jane Smith', 'rol' => 'gerente'],
	['correo' => 'cliente1@too.ues', 'contrasena' => '1234', 'nombre' => 'Emily Johnson', 'rol' => 'cliente'],
	['correo' => 'cliente2@too.ues', 'contrasena' => '1234', 'nombre' => 'Michael Brown', 'rol' => 'cliente'],
	['correo' => 'cliente3@too.ues', 'contrasena' => '1234', 'nombre' => 'Super Admin', 'rol' => 'cliente']
];

// Registrar los usuarios
foreach ($usuarios as $usuarioData) {
	$usuario->correo = $usuarioData['correo'];
	$usuario->contrasena = $usuarioData['contrasena'];
	$usuario->nombre = $usuarioData['nombre'];
	$usuario->rol = $usuarioData['rol'];

	// Registrar el usuario
	try {
		if ($usuario->registrar()) {
			echo "Usuario {$usuario->correo} registrado con éxito.\n";
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
