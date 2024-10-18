<?php
require_once __DIR__ . '/../models/Operador.php';
require_once __DIR__ . '/../models/LlamadaEmergencia.php';
require_once __DIR__ . '/../models/Cliente.php';

class OperadorController
{
	private $db;
	private $operador;
	private $llamada;
	private $cliente;

	public function __construct()
	{
		$this->db = (new Database())->connect();
		$this->operador = new Operador($this->db);
		$this->llamada = new LlamadaEmergencia($this->db);
		$this->cliente = new Cliente($this->db);
		$this->operador->id = $_SESSION['operador_id'] ?? null;
		$this->llamada->operador_id = $_SESSION['operador_id'] ?? null;
	}

	// Método para mostrar todas las llamadas de emergencia de un operador
	public function obtenerLlamadasAtendidas()
	{
		$error = null;
		if ($this->operador->id) {
			$llamadas = $this->llamada->getByOperator();
			foreach ($llamadas as $llamada) {
				$cliente = $this->cliente->getById($llamada['cliente_id']);
				$llamada['cliente'] = $cliente['nombre'];
			}
		} else {
			$error = 'Operador no encontrado';
		}
		header('Location: /');
		require_once __DIR__ . '/../views/llamadas-atendidas.php';
	}

	public function atenderLlamada()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->llamada->fecha_llamada = $_POST['fecha_llamada'];
			$this->llamada->hora_llamada = $_POST['hora_llamada'];
			$this->llamada->duracion = $_POST['duracion'];
			$this->llamada->cliente_id = $_POST['cliente_id'];
			$this->llamada->telefono = $_POST['telefono'];
			$this->llamada->tipo_emergencia = $_POST['tipo_emergencia'];
			$this->llamada->resolucion = $_POST['resolucion'];
			$this->llamada->observaciones = $_POST['observaciones'];

			if ($this->llamada->create()) {
				header('Location: /atender-llamada');
			} else {
				echo "Error al atender la llamada";
			}
		} else {
			$error = null;
			$clientes = $this->cliente->getAll();

			//error si no hay operador
			if (!$this->operador->id) {
				$error = 'Operador no encontrado';
			}
			require_once __DIR__ . '/../views/atender-llamada.php';
		}
	}
}
