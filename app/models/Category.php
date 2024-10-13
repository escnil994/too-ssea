<?php
class Category
{
	private $conn;
	private $table = 'categories';

	public $id;
	public $name;
	public $created_at;
	public $updated_at;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para obtener todas las categorías
	public function getAll()
	{
		$query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para obtener una categoría por su ID
	public function getById()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// Método para crear una nueva categoría
	public function create()
	{
		$query = 'INSERT INTO ' . $this->table . ' (name) VALUES (:name)';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':name', $this->name);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para actualizar una categoría
	public function update()
	{
		$query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para eliminar una categoría
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
