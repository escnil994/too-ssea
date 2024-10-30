<?php
class LlamadaEmergencia
{
	private $conn;
	private $table = 'llamadas_emergencia';

	public $id;
	public $operador_id;
	public $cliente_id;
	public $tipo_emergencia;
	public $telefono;
	public $resolucion;
	public $estado;
	public $razon_cancelacion;
	public $fecha_llamada;
	public $hora_llamada;
	public $duracion;
	public $calidad_servicio;
	public $fecha_confirmacion;
	public $observaciones;
	public $creado_en;
	public $actualizado_en;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para obtener todas las llamadas de emergencia
	public function getAll()
	{
		$query = 'SELECT * FROM ' . $this->table . ' ORDER BY creado_en DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para obtener una llamada de emergencia por su ID
	public function getById()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':id', $this->id);
		$stmt->execute();

		return $stmt->fetch(PDO::FETCH_ASSOC);
	}

	// Método para obtener todas las llamadas atención de un operador
	public function getByOperator()
	{
		$query = 'SELECT * FROM ' . $this->table . ' WHERE operador_id = :operador_id ORDER BY fecha_llamada DESC, hora_llamada DESC';
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(':operador_id', $this->operador_id);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// Método para crear una nueva llamada de emergencia
	public function create()
	{
		$query = 'INSERT INTO ' . $this->table . ' (operador_id, cliente_id, tipo_emergencia, telefono, resolucion, estado, razon_cancelacion, fecha_llamada, hora_llamada, duracion, calidad_servicio, fecha_confirmacion, observaciones) VALUES (:operador_id, :cliente_id, :tipo_emergencia, :telefono, :resolucion, :estado, :razon_cancelacion, :fecha_llamada, :hora_llamada, :duracion, :calidad_servicio, :fecha_confirmacion, :observaciones)';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':operador_id', $this->operador_id);
		$stmt->bindParam(':cliente_id', $this->cliente_id);
		$stmt->bindParam(':tipo_emergencia', $this->tipo_emergencia);
		$stmt->bindParam(':telefono', $this->telefono);
		$stmt->bindParam(':resolucion', $this->resolucion);
		$stmt->bindParam(':estado', $this->estado);
		$stmt->bindParam(':razon_cancelacion', $this->razon_cancelacion);
		$stmt->bindParam(':fecha_llamada', $this->fecha_llamada);
		$stmt->bindParam(':hora_llamada', $this->hora_llamada);
		$stmt->bindParam(':duracion', $this->duracion);
		$stmt->bindParam(':calidad_servicio', $this->calidad_servicio);
		$stmt->bindParam(':fecha_confirmacion', $this->fecha_confirmacion);
		$stmt->bindParam(':observaciones', $this->observaciones);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para actualizar una llamada de emergencia
	public function update()
	{
		$query = 'UPDATE ' . $this->table . ' SET operador_id = :operador_id, cliente_id = :cliente_id, tipo_emergencia = :tipo_emergencia, telefono = :telefono, resolucion = :resolucion, estado = :estado, razon_cancelacion = :razon_cancelacion, fecha_llamada = :fecha_llamada, hora_llamada = :hora_llamada, duracion = :duracion, calidad_servicio = :calidad_servicio, fecha_confirmacion = :fecha_confirmacion, observaciones = :observaciones WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':operador_id', $this->operador_id);
		$stmt->bindParam(':cliente_id', $this->cliente_id);
		$stmt->bindParam(':tipo_emergencia', $this->tipo_emergencia);
		$stmt->bindParam(':telefono', $this->telefono);
		$stmt->bindParam(':resolucion', $this->resolucion);
		$stmt->bindParam(':estado', $this->estado);
		$stmt->bindParam(':razon_cancelacion', $this->razon_cancelacion);
		$stmt->bindParam(':fecha_llamada', $this->fecha_llamada);
		$stmt->bindParam(':hora_llamada', $this->hora_llamada);
		$stmt->bindParam(':duracion', $this->duracion);
		$stmt->bindParam(':calidad_servicio', $this->calidad_servicio);
		$stmt->bindParam(':fecha_confirmacion', $this->fecha_confirmacion);
		$stmt->bindParam(':observaciones', $this->observaciones);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para eliminar una llamada de emergencia
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

	// Método para finalizar el seguimiento de una llamada de emergencia
	public function seguimiento()
	{
		$query = 'UPDATE ' . $this->table . ' SET estado = :estado, observaciones = :observaciones, calidad_servicio = :calidad_servicio WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		$stmt->bindParam(':id', $this->id);
		$stmt->bindParam(':estado', $this->estado);
		$stmt->bindParam(':observaciones', $this->observaciones);
		$stmt->bindParam(':calidad_servicio', $this->calidad_servicio);


		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	// Método para cancelar una llamada de emergencia
	public function cancel()
	{
		$query = 'UPDATE ' . $this->table . ' SET estado = :estado, razon_cancelacion = :razon_cancelacion WHERE id = :id';
		$stmt = $this->conn->prepare($query);

		// Bind de los parámetros
		$stmt->bindParam(':estado', $this->estado);
		$stmt->bindParam(':razon_cancelacion', $this->razon_cancelacion);
		$stmt->bindParam(':id', $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}





	public function getAllByStatus($estado)
	{
		$query = 'SELECT t1.*, CONCAT(t2.nombre, \' \', t2.apellido)  AS operador_nombre, t2.codigo_empleado AS codigo_empleado 
              FROM ' . $this->table . ' t1 
              JOIN operadores t2 ON t1.operador_id = t2.id 
              WHERE t1.estado = :estado 
              ORDER BY t1.creado_en DESC';

		$stmt = $this->conn->prepare($query);
		$stmt->bindValue(':estado', $estado);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	public function ObtenerDatosUnicosDeLlamada($column): mixed
	{
		$query = "SELECT DISTINCT " . $column . " FROM " . $this->table;

		$stmt = $this->conn->prepare($query);
		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


	public function obtenerLlamadasFiltradas($filters = [])
	{
		$query = 'SELECT t1.*, CONCAT(t2.nombre, \' \', t2.apellido) AS operador_nombre, t2.codigo_empleado AS codigo_empleado,
						 t3.nombre AS cliente_nombre, t3.apellido AS cliente_apellido
				  FROM ' . $this->table . ' t1
				  JOIN operadores t2 ON t1.operador_id = t2.id
				  JOIN clientes t3 ON t1.cliente_id = t3.id
				  WHERE 1=1';

		if (!empty($filters['fecha_inicio']) && !empty($filters['fecha_fin'])) {
			$query .= ' AND t1.fecha_llamada BETWEEN :fecha_inicio AND :fecha_fin';
			$fechaInicio = $filters['fecha_inicio'];
			$fechaFin = $filters['fecha_fin'];
			unset($filters['fecha_inicio'], $filters['fecha_fin']);
		}

		foreach ($filters as $key => $value) {
			$query .= " AND t1.$key = :$key";
		}

		$query .= ' ORDER BY t1.creado_en DESC';

		$stmt = $this->conn->prepare($query);

		if (isset($fechaInicio) && isset($fechaFin)) {
			$stmt->bindValue(':fecha_inicio', $fechaInicio);
			$stmt->bindValue(':fecha_fin', $fechaFin);
		}

		foreach ($filters as $key => $value) {
			$stmt->bindValue(":$key", $value);
		}

		$stmt->execute();

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}



}
