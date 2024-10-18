<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Usuario.php';
require_once __DIR__ . '/../../app/models/Operador.php';

// Crear una conexión con la base de datos
$database = new Database();
$db = $database->connect();

// Crear el modelo de usuario y operador
$usuario = new Usuario($db);
$operador = new Operador($db);

// Array de usuarios y operadores para el seeder
$usuariosOperadores = [
	[
		'correo' => 'operador1@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Carlos',
		'apellido' => 'Martínez',
		'rol' => 'operador',
		'codigo_empleado' => 1001,
		'extension_tel' => 101,
		'status' => 'activo'
	],
	[
		'correo' => 'operador2@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Ana',
		'apellido' => 'López',
		'rol' => 'operador',
		'codigo_empleado' => 1002,
		'extension_tel' => 102,
		'status' => 'activo'
	],
	[
		'correo' => 'operador3@too.ues',
		'contrasena' => '1234',
		'nombre' => 'Miguel',
		'apellido' => 'González',
		'rol' => 'operador',
		'codigo_empleado' => 1003,
		'extension_tel' => 103,
		'status' => 'activo'
	],
];

// Registrar los usuarios y operadores
foreach ($usuariosOperadores as $data) {
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

			// Registrar el operador asociado
			$operador->id_usuario = $usuarioId;
			$operador->nombre = $data['nombre'];
			$operador->apellido = $data['apellido'];
			$operador->codigo_empleado = $data['codigo_empleado'];
			$operador->extension_tel = $data['extension_tel'];
			$operador->status = $data['status'];

			if ($operador->create()) {
				echo "Operador asociado al usuario {$usuario->correo} registrado con éxito.\n";
			} else {
				echo "Error al registrar al operador asociado al usuario {$usuario->correo}.\n";
			}
		} else {
			echo "Error al registrar al usuario {$usuario->correo}.\n";
		}
	} catch (Exception $e) {
		echo "Error al registrar al usuario {$usuario->correo}: {$e->getMessage()}\n";
	}
}
