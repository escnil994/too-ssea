<?php
class Product
{
	private $conn;
	private $table = 'products';

	public $id;
	public $category_id;
	public $name;
	public $price;
	public $description;
	public $created_at;
	public $updated_at;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para obtener todos los productos
	public function getAll()
	{
		$query = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para obtener un producto por su ID
	public function getById()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// Método para obtener productos por categoría
	public function getByCategory()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE category_id = :category_id';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->execute();

		return $stmt;
	}

	// Método para crear un nuevo producto
	public function create()
	{
		$query = 'INSERT INTO ' . $this->table . ' (category_id, name, price, description) VALUES (:category_id, :name, :price, :description)';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para actualizar un producto
	public function update()
	{
		$query = 'UPDATE ' . $this->table . ' SET category_id = :category_id, name = :name, price = :price, description = :description WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para eliminar un producto
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
