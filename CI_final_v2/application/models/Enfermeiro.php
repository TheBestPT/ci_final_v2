<?php
class Enfermeiro extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function verificaSeCon($idInferm){
		$this->db->where('idInferm', $idInferm);
		$query = $this->db->get('consultaenfermeiro');
		if ($query->num_rows() > 0)
			return $query->num_rows();
		else
			return null;
	}

	public function setTable()
	{
		return 'enfermeiro';
	}

	public function setId()
	{
		return 'idInferm';
	}
}
