<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';
require_once __DIR__ . '/../../app/models/Cliente.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario y cliente
$usuario = new Usuario($db);
$cliente = new Cliente($db);

// Array de usuarios y clientes para el seeder
$usuariosClientes = [
	[
		'correo' => 'cliente1@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Emily',
		'apellido' => 'Johnson',
		'rol' => 'cliente',
		'telefono' => '22334455',
		'dui' => '12345678-1',
		'email' => 'cliente1@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente2@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Michael',
		'apellido' => 'Brown',
		'rol' => 'cliente',
		'telefono' => '33445566',
		'dui' => '23456789-2',
		'email' => 'cliente2@too.ues',
		'status' => 'activo'
	],
	[
		'correo' => 'cliente3@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Super',
		'apellido' => 'Admin',
		'rol' => 'cliente',
		'telefono' => '44556677',
		'dui' => '34567890-3',
		'email' => 'cliente3@too.ues',
		'status' => 'activo'
	],
];

// Registrar los usuarios y clientes
foreach ($usuariosClientes as $data) {
	$usuario->correo = $data['correo'];
	$usuario->contrasena = $data['contrasena'];
	$usuario->nombre = $data['nombre'];
	$usuario->rol = $data['rol'];

	// Registrar el usuario
	try {
		if ($usuario->registrar()) {
			echo "Usuario {$usuario->correo} registrado con éxito.\n";

			// Obtener el ID del usuario recién creado
			$usuarioId = $db->lastInsertId();

			// Registrar el cliente asociado
			$cliente->id_usuario = $usuarioId;
			$cliente->nombre = $data['nombre'];
			$cliente->apellido = $data['apellido'];
			$cliente->telefono = $data['telefono'];
			$cliente->dui = $data['dui'];
			$cliente->email = $data['email'];
			$cliente->status = $data['status'];

			if ($cliente->create()) {
				echo "Cliente asociado al usuario {$usuario->correo} registrado con éxito.\n";
			} else {
				echo "Error al registrar al cliente asociado al usuario {$usuario->correo}.\n";
			}
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
