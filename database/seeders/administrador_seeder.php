<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Administrador.php';
require_once __DIR__ . '/../../app/models/Usuario.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario y administrador
$usuario = new Usuario($db);
$administrador = new Administrador($db);

// Array de usuarios y administradores para el seeder
$usuariosAdministradores = [
	[
		'correo' => 'administrador1@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Cesar',
		'apellido' => 'Mendez',
		'rol' => 'administrador ',
		'codigo_empleado' => 1015,
		'extension_tel' => 115,
		'status' => 'activo'
	],
	
];

// Registrar los usuarios y administradores
foreach ($usuariosAdministradores as $data) {
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

			// Registrar el administrador asociado
			$administrador->id_usuario = $usuarioId;
			$administrador->nombre = $data['nombre'];
			$administrador->apellido = $data['apellido'];
			$administrador->codigo_empleado = $data['codigo_empleado'];
			$administrador->extension_tel = $data['extension_tel'];
			$administrador->status = $data['status'];

			if ($administrador->create()) {
				echo "Administrador asociado al usuario {$usuario->correo} registrado con éxito.\n";
			} else {
				echo "Error al registrar al Administrador asociado al usuario {$usuario->correo}.\n";
			}
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
