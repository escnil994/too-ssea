<?php
require_once __DIR__ . '/../models/Product.php';

class ProductController
{
	private $db;
	private $product;

	public function __construct()
	{
		$this->db = (new Database())->connect();
		$this->product = new Product($this->db);
	}

	// Método para mostrar todos los productos
	public function index()
	{
		$products = $this->product->getAll();
		require_once __DIR__ . '/../views/productos.php'; // Vista para mostrar todos los productos
	}

	// Método para mostrar un producto específico por ID
	public function show($id)
	{
		$this->product->id = $id;
		$product = $this->product->getById();
		require_once 'app/views/products/show.php'; // Vista para mostrar un solo producto
	}

	// Método para crear un nuevo producto (manejo de formulario)
	public function create()
	{
		$this->product->category_id = $_POST['category_id'];
		$this->product->name = $_POST['name'];
		$this->product->price = $_POST['price'];
		$this->product->description = $_POST['description'];

		if ($this->product->create()) {
			header('Location: /dashboard');
		} else {
			echo "Error al crear el producto";
		}
	}

	// Método para actualizar un producto
	public function update($id)
	{
		$this->product->id = $id;

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->product->category_id = $_POST['category_id'];
			$this->product->name = $_POST['name'];
			$this->product->price = $_POST['price'];
			$this->product->description = $_POST['description'];

			if ($this->product->update()) {
				header('Location: /dashboard'); // Redirigir al producto actualizado
			} else {
				echo "Error al actualizar el producto";
			}
		} else {
			$product = $this->product->getById();
			require_once 'app/views/products/edit.php'; // Vista para el formulario de edición
		}
	}

	// Método para eliminar un producto
	public function delete($id)
	{
		$this->product->id = $id;

		if ($this->product->delete()) {
			header('Location: /dashboard');
		} else {
			echo "Error al eliminar el producto";
		}
	}
}
