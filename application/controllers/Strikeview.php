<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strikeview extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct()
	{
		parent::__construct();
		$this->load->model('strikeview_m', 'svm');
	}

	// Mostrar página inicial/home con menú para seleccionar ubiación del sistema de alerta
	public function index()
	{
		$this->load->view('home/home');
	}

	// Funciones que cargan la vista de alerta según la imagen de la ubicación seleccionada
	public function mina()
	{
		$this->getAlerta(1); // Mina se considera como 1
	}

	public function peletizadora()
	{
		$this->getAlerta(2); // Peletizadora se considera como 2
	}

	public function presas()
	{
		$this->getAlerta(3); // Presas se considera como 3
	}

	// Llamar webservice ¿? mediante PDO con determinado $serverName, $uid, $pwd según la ubicación de la base de datos del Strike View
	private function getAlerta($from)
	{
		$this->load->view('alert/alert', $data);
	}

	// ELIMINAR ESTO
	// Llamar webservice BUSCAMW con USUARIOID y BUSCAR para crear DataTable con el JSON retornado
	public function getMasterweb()
	{
		// Bloquear acceso directo a la función o mediante URL en el navegador
		if($this->input->server('REQUEST_METHOD') != 'POST') {
			$this->session->sess_destroy();
			redirect('Login#SesionNoIniciada', 'refresh');
		}
		$docsMasterweb = $this->svm->getMasterweb();
		echo json_encode($docsMasterweb);
	}
}
?>