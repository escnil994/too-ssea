<?php
class Cliente
{
	private $conn;
	private $table = 'clientes';

	public $id;
	public $id_usuario;
	public $nombre;
	public $apellido;
	public $telefono;
	public $dui;
	public $email;
	public $status;
	public $creado_en;
	public $actualizado_en;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para obtener todos los clientes
	public function getAll()
	{
		$query = 'SELECT * FROM ' . $this->table . ' ORDER BY creado_en DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para obtener un cliente por su ID
	public function getById()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// Método para crear un nuevo cliente
	public function create()
	{
		$query = 'INSERT INTO ' . $this->table . ' (id_usuario, nombre, apellido, telefono, dui, email, status) VALUES (:id_usuario, :nombre, :apellido, :telefono, :dui, :email, :status)';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':id_usuario', $this->id_usuario);
		$stmt->bindParam(':nombre', $this->nombre);
		$stmt->bindParam(':apellido', $this->apellido);
		$stmt->bindParam(':telefono', $this->telefono);
		$stmt->bindParam(':dui', $this->dui);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':status', $this->status);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para actualizar un cliente
	public function update()
	{
		$query = 'UPDATE ' . $this->table . ' SET id_usuario = :id_usuario, nombre = :nombre, apellido = :apellido, telefono = :telefono, dui = :dui, email = :email, status = :status WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':id_usuario', $this->id_usuario);
		$stmt->bindParam(':nombre', $this->nombre);
		$stmt->bindParam(':apellido', $this->apellido);
		$stmt->bindParam(':telefono', $this->telefono);
		$stmt->bindParam(':dui', $this->dui);
		$stmt->bindParam(':email', $this->email);
		$stmt->bindParam(':status', $this->status);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para eliminar un cliente
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
