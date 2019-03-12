<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strikeview extends CI_Controller {

	// Constructor para cargar el modelo principal
	public function __construct()
	{
		parent::__construct();
		$this->load->model('strikeview_m', 'svm');
	}

	// Mostrar página inicial/home con menú para después seleccionar ubicación del sistema de alerta
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

	// Cargar por primera vez la vista de alerta
	private function loadAlerta()
	{
		$data = $this->getAlerta();
		$this->load->view('alert/alert', $data);
	}

	// Actualizar cada minuto mediante petición AJAX desde flipclock.js
	public function updateAlerta()
	{
		// Bloquear acceso directo a la función o mediante URL en el navegador
		if($this->input->server('REQUEST_METHOD') != 'POST') {
			redirect('Strikeview', 'refresh');
		}
		$data = $this->getAlerta();
		echo json_encode($data);
	}

	// FIXME: ¿?
	// Llamar webservice ¿? mediante PDO con determinado $serverName, $uid, $pwd según la ubicación de la base de datos del Strike View
	private function getAlerta(/*$from*/)
	{
		$result = $this->svm->getAlerta();

		if(empty($result)) {
			$status = 0;
			$alert_exists = false;
			$start = '';
			$mode_id = -1;
			// Default datetime to start stopwatch (Time starts at 00:00:00. Today's date is preferred but it could be any date since my-footer div will be hidden)
			$stopwatch = [date('Y'), date('n'), date('j'), 0, 0, 0];
		}
		else {
			$status = $result['mode'];
			$alert_exists = true;
			$start = 'Inicio: ' . $result['format_start_time'];
			$mode_id = $result['mode_id'];
			// Default datetime to start stopwatch (Time starts at ??:??:00 depending on the time difference between start time and time when the query was executed)
			$hours = intdiv($result['current_minute_diff'], 60);
			$minutes = $result['current_minute_diff'] % 60;
			$stopwatch = [date('Y'), date('n'), date('j'), $hours, $minutes, 0];
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
				$alert_exists = false;	// Restore empty($result) value if the query was not indeed empty
				$start = '';			// Restore empty($result) value if the query was not indeed empty
				$mode_id = -1;			// Restore empty($result) value if the query was not indeed empty
				$alert = 'No se pudo consultar la base de datos';
				$description = 'Intente de nuevo más tarde. Si el error persiste, contacte a TI';
				$imagepath = 'images/alarm-no.png';
				$color = '#929395';		// Gris pantone (Peña Colorada)
		}
		$data['alert_exists'] = $alert_exists;
		$data['start'] = $start;
		$data['mode_id'] = $mode_id;
		$data['alert'] = $alert;
		$data['description'] = $description;
		$data['imagepath'] = $imagepath;
		$data['color'] = $color;
		$data['stopwatch'] = $stopwatch;

		return $data;
	}
}
?>