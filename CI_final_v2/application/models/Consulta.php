<?php
class Consulta extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function verificaSeEnf($idConsulta){
		$this->db->where('idConsul', $idConsulta);
		$query = $this->db->get('consultaenfermeiro');
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return null;
	}


	public function setTable()
	{
		return 'consulta';
	}


	public function setId()
	{
		return 'idConsulta';
	}
}
