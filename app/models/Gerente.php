<?php
class Gerente
{
	private $conn;
	private $table = 'gerentes';

	public $id;
	public $nombre;
	public $apellido;
	public $codigo_empleado;
	public $extension_tel;
	public $status;
	public $id_usuario;
	public $creado_en;
	public $actualizado_en;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para obtener todos los operadores
	public function getAll()
	{
		$query = 'SELECT * FROM ' . $this->table . ' ORDER BY creado_en DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para obtener un operador por su ID
	public function getById()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function getByUserId()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id_usuario = :id_usuario LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id_usuario', $this->id_usuario);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// Método para crear un nuevo operador
	public function create()
	{
		$query = 'INSERT INTO ' . $this->table . ' (nombre, apellido, codigo_empleado, extension_tel, status, id_usuario) VALUES (:nombre, :apellido, :codigo_empleado, :extension_tel, :status, :id_usuario)';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':nombre', $this->nombre);
		$stmt->bindParam(':apellido', $this->apellido);
		$stmt->bindParam(':codigo_empleado', $this->codigo_empleado);
		$stmt->bindParam(':extension_tel', $this->extension_tel);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id_usuario', $this->id_usuario);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para actualizar un operador
	public function update()
	{
		$query = 'UPDATE ' . $this->table . ' SET nombre = :nombre, apellido = :apellido, codigo_empleado = :codigo_empleado, extension_tel = :extension_tel, status = :status, id_usuario = :id_usuario WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':nombre', $this->nombre);
		$stmt->bindParam(':apellido', $this->apellido);
		$stmt->bindParam(':codigo_empleado', $this->codigo_empleado);
		$stmt->bindParam(':extension_tel', $this->extension_tel);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id_usuario', $this->id_usuario);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para eliminar un operador
	public function delete()
	{
		$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
