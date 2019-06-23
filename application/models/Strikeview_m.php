<?php
class Strikeview_m extends CI_Model {

	public function getAlerta($origin)
	{
		$select =
			"SELECT TOP(1) mode_id, mode, _start AS 'start_time', CONVERT(VARCHAR(8), _start, 3) + ' a las ' + CONVERT(VARCHAR(5), _start, 8) AS 'format_start_time', DATEDIFF(second, _start, GETDATE()) AS 'current_second_diff'
			FROM zstrikeview.t_mode t
			JOIN zstrikeview.ct_origin c ON t.id_origin=c.id_origin
			WHERE t._stop IS NULL AND c.origin = '$origin' ORDER BY mode_id DESC";

		$query = $this->db->query($select);
		return $query->row_array();
	}

	public function getLastAlert($origin)
	{
		$select =
			"SELECT TOP(1) CONVERT(VARCHAR(8), _start, 3) + ' a las ' + CONVERT(VARCHAR(5), _start, 8) AS 'last_alert'
			FROM zstrikeview.t_mode t
			JOIN zstrikeview.ct_origin c ON t.id_origin=c.id_origin
			WHERE t._stop IS NOT NULL AND c.origin = '$origin' ORDER BY mode_id DESC";

		$query = $this->db->query($select);
		return $query->row_array()['last_alert'];
	}
}
?>