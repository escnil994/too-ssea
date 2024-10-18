<?php
class AuthController
{
	private $db;

	public function __construct()
	{
		$this->db = (new Database())->connect();
	}

	public function mostrarLogin()
	{
		session_start();
		if (isset($_SESSION['usuario_id'])) {
			header('Location: /dashboard');
		} else {
			require_once __DIR__ . '/../views/login.php';
		}
	}

	public function login()
	{
		$correo = $_POST['correo'];
		$contrasena = $_POST['contrasena'];

		require_once __DIR__ . '/../models/Usuario.php';
		$usuario = new Usuario($this->db);
		$usuario->correo = $correo;
		$usuario->contrasena = $contrasena;
		$usuarioLogueado = $usuario->login();
		if ($usuarioLogueado) {
			session_start();
			if ($usuarioLogueado['rol'] === 'operador') {
				require_once __DIR__ . '/../models/Operador.php';
				$operador = new Operador($this->db);
				$operador->id_usuario = $usuarioLogueado['id'];
				$operadorLogueado = $operador->getByUserId();
				if ($operadorLogueado) {
					$_SESSION['operador_id'] = $operadorLogueado['id'];
					header('Location: /dashboard');
				} else {
					$error = 'Operador no encontrado';
					session_unset();
					session_destroy();
					header('Location: /');
				}
			}
			$_SESSION['usuario_id'] = $usuarioLogueado['id'];
			$_SESSION['usuario_correo'] = $usuarioLogueado['correo'];
			$_SESSION['usuario_nombre'] = $usuarioLogueado['nombre'];
			$_SESSION['usuario_rol'] = $usuarioLogueado['rol'];
			header('Location: /');
		} else {
			$error = 'Credenciales de acceso inválidas';
			require_once __DIR__ . '/../views/login.php';
		}
	}

	public function registrar()
	{
		$nombre = $_POST['nombre'];
		$correo = $_POST['correo'];
		$contrasena = $_POST['contrasena'];
		$rol = 'cliente';

		require_once __DIR__ . '/../models/Usuario.php';
		$usuario = new Usuario($this->db);
		$usuario->nombre = $nombre;
		$usuario->correo = $correo;
		$usuario->contrasena = $contrasena;
		$usuario->rol = $rol;

		if ($usuario->registrar()) {
			header('Location: /login');
		} else {
			$error = 'Error al registrar al usuario';
			require_once __DIR__ . '/../views/register.php';
		}
	}

	public function logout()
	{
		session_start();
		session_unset();
		session_destroy();
		header('Location: /');
	}
}
