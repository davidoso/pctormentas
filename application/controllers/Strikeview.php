<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strikeview extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct()
	{
		parent::__construct();
		$this->load->model('strikeview_m', 'svm');
	}

	// Mostrar página inicial/home con menú para seleccionar ubicación del sistema de alerta
	public function index()
	{
		$this->load->view('home/home');
	}

	// Funciones que cargan la vista de alerta según la imagen de la ubicación seleccionada
	public function mina()
	{
		$this->loadAlerta();			// Mina se considera como 1
	}

	public function peletizadora()
	{
		$this->loadAlerta();			// Peletizadora se considera como 2
	}

	public function presas()
	{
		$this->loadAlerta();			// Presas se considera como 3
	}

	private function loadAlerta()
	{
		$data = $this->getAlerta();
		$this->load->view('alert/alert', $data);
	}

	public function updateAlerta()
	{
		$data = $this->getAlerta();
		echo json_encode($data);
	}

	// Llamar webservice ¿? mediante PDO con determinado $serverName, $uid, $pwd según la ubicación de la base de datos del Strike View
	private function getAlerta(/*$from*/)
	{
		$result = $this->svm->getAlerta();

		if(empty($result)) {
			$status = 0;
			$alert_exists = false;
			$start = '';
		}
		else {
			$status = $result['mode'];
			$alert_exists = true;
			$start = 'Inicio: ' . $result['format_start_time'];
		}

		switch($status) {
			case 0:
				$alert = 'No hay alerta';
				$description = 'Última alerta detectada: ¿?';
				$imagepath = 'images/alarm-no.png';
				$color = '#929395';		// Gris pantone (Peña Colorada)
				break;
			case 1:
				$alert = 'Alarma roja';
				$description = 'Peligro: actividad eléctrica dentro del rango de los 0 a 8 km';
				$imagepath = 'images/alarm-1-red.png';
				$color = '#d32f2f';		// Red-darken-2
				break;
			case 2:
				$alert = 'Alerta naranja';
				$description = 'Advertencia: actividad eléctrica dentro del rango de los 8 a 16 km';
				$imagepath = 'images/alarm-2-orange.png';
				$color = '#fb8c00';		// Naranja pantone (Peña Colorada)
				break;
			case 3:
				$alert = 'Alerta amarilla';
				$description = 'Precaución: actividad eléctrica dentro del rango de los 16 a 32 km';
				$imagepath = 'images/alarm-3-yellow.png';
				$color = '#fdc52f';		// Amarillo pantone (Peña Colorada)
				break;
			default:					// Validar en caso el modo no esté en el rango [1-3]
				$alert = 'No se pudo consultar la base de datos';
				$description = 'Intente de nuevo más tarde. Si el error persiste, contacte a TI';
		}
		$data['alert'] = $alert;
		$data['alert_exists'] = $alert_exists;
		$data['description'] = $description;
		$data['start'] = $start;
		$data['imagepath'] = $imagepath;
		$data['color'] = $color;

		return $data;
	}
}
?>