<?php
class Usuario
{
	private $conn;
	private $table = 'usuarios';
	public $nombre;
	public $correo;
	public $contrasena;
	public $rol;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function login()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE correo = :correo LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':correo', $this->correo);
		$stmt->execute();

		$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($usuario && password_verify($this->contrasena, $usuario['contrasena'])) {
			return $usuario;
		}

		return false;
	}

	// Método para registrar un nuevo usuario
	public function registrar()
	{
		$showError = false;
		try {
			// Validar si el usuario ya existe
			$query = 'SELECT * FROM ' . $this->table . ' WHERE correo = :correo LIMIT 1';
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':correo', $this->correo);
			$stmt->execute();

			$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($usuario) {
				$showError = true;
				echo "El usuario ya existe.";
				return false;
			}

			$query = "INSERT INTO usuarios (correo, contrasena, nombre, rol) VALUES (:correo, :contrasena, :nombre, :rol)";
			$stmt = $this->conn->prepare($query);

			// Bindear los parámetros
			$stmt->bindParam(':correo', $this->correo);
			$hashed_password = password_hash($this->contrasena, PASSWORD_DEFAULT);
			$stmt->bindParam(':contrasena', $hashed_password);
			$stmt->bindParam(':nombre', $this->nombre);
			$stmt->bindParam(':rol', $this->rol);

			// Ejecutar la consulta
			if ($stmt->execute()) {
				return true;
			}

			return false;
		} catch (PDOException $e) {
			// Puedes capturar errores aquí también
			throw new Exception($showError ? $e->getMessage() : "Error al registrar al usuario.");
			return false;
		}
	}

	

}
