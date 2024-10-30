<?php
class Administrador
{
	private $conn;
	private $table = 'administradores';

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


	public function obtenerUsuarios($table, $email)
	{
		// Lista de tablas permitidas para evitar inyecciones SQL
		$allowed_tables = ['gerentes', 'clientes', 'operadores']; // Agrega las tablas que necesites

		if (!in_array($table, $allowed_tables)) {
			throw new Exception("Nombre de tabla inválido");
		}

		// Si la tabla es 'clientes', manejamos el caso especial
		if ($table == 'clientes') {
			// Construcción de la consulta SQL para 'clientes'
			$sql = "SELECT t.*, u.*
					FROM usuarios AS u
					LEFT JOIN clientes AS t ON t.id_usuario = u.id
					WHERE u.rol = 'cliente'";

			// Si se proporciona un email, añadimos la cláusula AND
			if (!empty($email)) {
				$sql .= " AND u.correo LIKE :email";
			}
		} else if ($table == 'operadores') {
			// Construcción de la consulta SQL básica para otras tablas
			$sql = "SELECT t.*, u.*
					FROM {$table} AS t
					INNER JOIN usuarios AS u ON t.id_usuario = u.id
					where u.rol = 'operador'";

			// Si se proporciona un email, añadimos la cláusula WHERE con LIKE
			if (!empty($email)) {
				$sql .= " WHERE u.correo LIKE :email";
			}
		} else {
			// Construcción de la consulta SQL básica para otras tablas
			$sql = "SELECT t.*, u.*
					FROM {$table} AS t
					INNER JOIN usuarios AS u ON t.id_usuario = u.id
					where u.rol = 'gerente'";

			// Si se proporciona un email, añadimos la cláusula WHERE con LIKE
			if (!empty($email)) {
				$sql .= " WHERE u.correo LIKE :email";
			}
		}

		// Preparar la consulta
		$stmt = $this->conn->prepare($sql);

		// Vincular el parámetro si el email no está vacío
		if (!empty($email)) {
			$emailParam = '%' . $email . '%';
			$stmt->bindParam(':email', $emailParam, PDO::PARAM_STR);
		}

		// Ejecutar la consulta
		$stmt->execute();

		// Obtener los resultados
		$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}





	public function updateUsuario($id, $nombre, $estado, $rol, $correo)
	{
		$sql = "UPDATE usuarios SET nombre = :nombre, estado = :estado, rol = :rol, correo = :correo WHERE id = :id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':estado', $estado);
		$stmt->bindParam(':rol', $rol);
		$stmt->bindParam(':correo', $correo);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		return $stmt->execute();
	}

	// Method to update or insert into the 'clientes' table
	public function saveCliente($id, $nombre, $apellido, $estado, $dui, $telefono)
	{
		// Check if the client exists
		$sql = "SELECT COUNT(*) FROM clientes WHERE id_usuario = :id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$exists = $stmt->fetchColumn();

		if ($exists) {
			// Update existing client
			$sql = "UPDATE clientes SET nombre = :nombre, apellido = :apellido, status = :estado, dui = :dui, telefono = :telefono WHERE id_usuario = :id";
		} else {
			// Insert new client
			$sql = "INSERT INTO clientes (id_usuario, nombre, apellido, status) VALUES (:id, :nombre, :apellido, :estado)";
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellido', $apellido);
		$stmt->bindParam(':estado', $estado);
		$stmt->bindParam(':dui', $dui);
		$stmt->bindParam(':telefono', $telefono);

		return $stmt->execute();
	}

	// Method to update or insert into 'gerentes' or 'operadores' table
	public function saveGerenteOOperador($table, $id, $nombre, $apellido, $codigo_empleado, $extension_tel, $estado)
	{
		// Validate table name to prevent SQL injection
		if (!in_array($table, ['gerentes', 'operadores'])) {
			throw new Exception('Invalid table name');
		}

		// Check if the record exists
		$sql = "SELECT COUNT(*) FROM {$table} WHERE id_usuario = :id";
		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$exists = $stmt->fetchColumn();

		if ($exists) {
			// Update existing record
			$sql = "UPDATE {$table} SET 
							nombre = :nombre, 
							apellido = :apellido, 
							codigo_empleado = :codigo_empleado, 
							extension_tel = :extension_tel, 
							status = :estado 
						WHERE id_usuario = :id";
		} else {
			// Insert new record
			$sql = "INSERT INTO {$table} (id_usuario, nombre, apellido, codigo_empleado, extension_tel, status) 
						VALUES (:id, :nombre, :apellido, :codigo_empleado, :extension_tel, :estado)";
		}

		$stmt = $this->conn->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->bindParam(':nombre', $nombre);
		$stmt->bindParam(':apellido', $apellido);
		$stmt->bindParam(':codigo_empleado', $codigo_empleado);
		$stmt->bindParam(':extension_tel', $extension_tel);
		$stmt->bindParam(':estado', $estado);

		return $stmt->execute();
	}
}







