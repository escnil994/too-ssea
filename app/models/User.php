<?php
class User
{
	private $conn;
	private $table = 'users';
	public $name;
	public $email;
	public $password;
	public $role;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function login()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':email', $this->email);
		$stmt->execute();

		$user = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($user && password_verify($this->password, $user['password'])) {
			return $user;
		}

		return false;
	}

	// Método para registrar un nuevo usuario
	public function register()
	{
		$showError = false;
		try {
			//Validar si el usuario ya existe
			$query = 'SELECT * FROM ' . $this->table . ' WHERE email = :email LIMIT 1';
			$stmt = $this->conn->prepare($query);
			$stmt->bindParam(':email', $this->email);
			$stmt->execute();

			$user = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($user) {
				$showError = true;
				echo "El usuario ya existe.";
				return false;
			}

			$query = "INSERT INTO users (email, password, name, role, created_at, updated_at) VALUES (:email, :password, :name, :role, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

			$stmt = $this->conn->prepare($query);

			// Bindear los parámetros
			$stmt->bindParam(':email', $this->email);
			$hashed_password = password_hash($this->password, PASSWORD_DEFAULT);
			$stmt->bindParam(':password',  $hashed_password);
			$stmt->bindParam(':name', $this->name);
			$stmt->bindParam(':role', $this->role);

			// Ejecutar la consulta
			if ($stmt->execute()) {
				return true;
			}

			return false;
		} catch (PDOException $e) {
			// Puedes capturar errores aquí también
			throw new Exception($showError ? "El usuario ya existe." : "Error al registrar al usuario.");
			return false;
		}
	}
}
