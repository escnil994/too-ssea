<?php
require_once __DIR__ . '/../models/Gerente.php';
require_once __DIR__ . '/../models/LlamadaEmergencia.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Operador.php';

class GerenteController
{
	private $db;
	private $gerente;
	private $llamada;
	private $cliente;
	private $operador;

	public function __construct()
	{
		$this->db = (new Database())->connect();
		$this->gerente = new Gerente($this->db);
		$this->llamada = new LlamadaEmergencia($this->db);
		$this->cliente = new Cliente(db: $this->db);
		$this->operador = new Operador(db: $this->db);
		$this->gerente->id = $_SESSION['gerente_id'] ?? null;
		$this->llamada->operador_id = $_SESSION['gerente_id'] ?? null;
	}

	public function obtenerLlamadasPorEstado($status)
	{
		$error = null;
		$llamadas = []; 

		if ($this->gerente->id) {
			$llamadas = $this->llamada->getAllByStatus($status);
			foreach ($llamadas as $index => $llamada) {
				$this->cliente->id = $llamada['cliente_id'];
				$cliente = $this->cliente->getById();
				$llamadas[$index]['cliente'] = $cliente;
			}

		} else {
			$error = 'Gerente no encontrado';
		}
		require_once __DIR__ . '/../views/llamadas-atendidas.php';
	}



	private function inicializarDatosParaReporte()
	{
		$llamadaestado = $this->llamada->ObtenerDatosUnicosDeLlamada("estado");
		$llamadatipo = $this->llamada->ObtenerDatosUnicosDeLlamada("tipo_emergencia");
	
		$listadoclientes = $this->llamada->ObtenerDatosUnicosDeLlamada("cliente_id");
		$detallesClientes = [];
		if ($listadoclientes != null) {
			foreach ($listadoclientes as $cliente) {
				$this->cliente->id = $cliente['cliente_id'];
				$detallesClientes[] = $this->cliente->getById();
			}
		}
	
		$listado_operadores = $this->llamada->ObtenerDatosUnicosDeLlamada("operador_id");
		$detallesoperadores = [];
		if ($listado_operadores != null) {
			foreach ($listado_operadores as $operador) {
				$this->operador->id = $operador['operador_id'];
				$detallesoperadores[] = $this->operador->getById();
			}
		}
	
		return compact('llamadaestado', 'llamadatipo', 'detallesClientes', 'detallesoperadores');
	}
	
	public function crearReportes(): void
	{
		if ($this->gerente->id) {
			extract($this->inicializarDatosParaReporte());
		} else {
			$llamadaestado = [];
			$llamadatipo = [];
			$detallesClientes = [];
			$detallesoperadores = [];

		}
	
		require_once __DIR__ . '/../views/generar-reportes.php';
	}
	
	public function obtenerLlamadas()
	{
		extract($this->inicializarDatosParaReporte());

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$filters = [];
			if (!empty($_POST['fecha_inicio'])) {
				$filters['fecha_inicio'] = $_POST['fecha_inicio'];
			}
			if (!empty($_POST['fecha_fin'])) {
				$filters['fecha_fin'] = $_POST['fecha_fin'];
			}
			if (!empty($_POST['operador_id'])) {
				$filters['operador_id'] = $_POST['operador_id'];
			}
			if (!empty($_POST['cliente_id'])) {
				$filters['cliente_id'] = $_POST['cliente_id'];
			}
			if (!empty($_POST['estado']) && $_POST['estado'] !== 'Todos') {
				$filters['estado'] = $_POST['estado'];
			}
			if (!empty($_POST['tipo']) && $_POST['tipo'] !== 'Todos') {
				$filters['tipo_emergencia'] = $_POST['tipo'];
			}
			$llamadas = $this->llamada->obtenerLlamadasFiltradas($filters);
		}
	
		require_once __DIR__ .'/../views/generar-reportes.php';
	}
	


	public function getInfo(): void
	{
		$error = null;

		if ($this->gerente->id) {
			$llamadatipo = $this->llamada->ObtenerDatosUnicosDeLlamada("tipo_emergencia");
			$llamadaestado = $this->llamada->ObtenerDatosUnicosDeLlamada("estado");
			$listadoclientes = $this->llamada->ObtenerDatosUnicosDeLlamada("cliente_id");
			$listado_operadores = $this->llamada->ObtenerDatosUnicosDeLlamada("operador_id");
			$detallesClientes = [];
			if ($listadoclientes != null) {
				foreach ($listadoclientes as $cliente) {
					$this->cliente->id = $cliente['cliente_id']; 
					$detallesClientes[] = $this->cliente->getById();
				}
			}
			$detallesoperadores = [];
			if ($listado_operadores != null) {
				foreach ($listado_operadores as $operador) {
					$this->operador->id = $operador['operador_id']; 
					$detallesoperadores[] = $this->operador->getById();
				}
			}
		} else {
			$llamadaestado = [];
			$llamadatipo = [];
			$detallesClientes = [];
			$detallesoperadores = [];
		}
	}

	

}

