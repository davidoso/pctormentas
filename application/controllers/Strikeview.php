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
		$this->loadAlerta('Mina');
	}

	public function pelet()
	{
		$this->loadAlerta('Peletizadora');
	}

	public function presas()
	{
		$this->loadAlerta('Presas');
	}

	// Cargar por primera vez la vista de alerta
	private function loadAlerta($origin)
	{
		$data = $this->getAlerta($origin);
		$data['origin'] = $origin;
		$this->load->view('alert/alert', $data);
	}

	// Actualizar cada minuto mediante petición AJAX desde flipclock.js
	public function updateAlerta()
	{
		// Bloquear acceso directo a la función o mediante URL en el navegador
		if($this->input->server('REQUEST_METHOD') != 'POST') {
			redirect('Strikeview', 'refresh');
		}
        $origin = $this->input->post('origin');
		$data = $this->getAlerta($origin);
		echo json_encode($data);
	}

	// NOTE: DELETE THIS COMMENT
	// FIXME: ¿?
	// Llamar webservice ¿? mediante PDO con determinado $serverName, $uid, $pwd según la ubicación de la base de datos del Strike View
	private function getAlerta($origin)
	{
		$result = $this->svm->getAlerta($origin);

		if(empty($result)) {
			$status = 0;
			$alert_exists = false;
			$start = '';
			$mode_id = -2;				// El valor -2 valida el caso cuando no hay alerta
			// Default datetime to start stopwatch (Time starts at 00:00:00. Today's date is preferred but it could be any date since my-footer div will be hidden)
			$stopwatch = [date('Y'), date('n'), date('j'), 0, 0, 0];
			$last_alert = $this->svm->getLastAlert($origin);
		}
		else {
			$status = $result['mode'];
			$alert_exists = true;
			$start = 'Inicio: ' . $result['format_start_time'];
			$mode_id = $result['mode_id'];
			// Beta version
			// Default datetime to start stopwatch (Time starts at ??:??:00 depending on the time difference between start time and time when the query was executed)
			// $hours = intdiv($result['current_minute_diff'], 60);
			// $minutes = $result['current_minute_diff'] % 60;
			$time = gmdate("H:i:s", $result['current_second_diff']);	// gmdate() displays a formatted GMT/UTC datetime, e.g. 06:06:06
			$h = substr($time, 0, 2);
			$m = substr($time, 3, 2);
			$s = substr($time, 6, 2);
			$stopwatch = [date('Y'), date('n'), date('j'), $h, $m, $s];
		}

		switch($status) {
			case 0:
				$alert = 'No hay alerta';
				$description = 'Última alerta detectada: ' . $last_alert;
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
			/* El valor -1 valida el caso de que el modo no esté en el rango de alertas [1-3]. Estos valores aparecen también en la función de error de la llamada AJAX
			desde flipclock.js en caso el servidor de BD se caiga mientras un navegador tenga abierta la página */
			default:
				$alert_exists = false;
				$start = '';
				$mode_id = -1;
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