<?php

class DashboardController
{
	private $db;

	public function __construct()
	{
		$this->db = (new Database())->connect();
	}

	public function showDashboard()
	{
		if (!isset($_SESSION['user_id'])) {
			header('Location: /login');
		}
		require_once __DIR__ . '/../models/Product.php';
		require_once __DIR__ . '/../models/Category.php';
		$product = new Product($this->db);
		$category = new Category($this->db);

		$categories = $category->getAll();
		$products = $product->getAll();

		require_once __DIR__ . '/../views/dashboard.php';
	}
}
