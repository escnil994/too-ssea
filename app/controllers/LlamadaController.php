<?
require_once 'app/models/LlamadaEmergencia.php';

class LlamadaController
{
	private $db;
	private $llamada;

	public function __construct()
	{
		$this->db = (new Database())->connect();
		$this->llamada = new LlamadaEmergencia($this->db);
	}
}
