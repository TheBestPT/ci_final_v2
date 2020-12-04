<?php
class Receita extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function verificaSeProd($idReceita){
		$this->db->where('idReceita', $idReceita);
		$query = $this->db->get('carrinho');
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return null;
	}


	public function setTable()
	{
		return 'receita';
	}

	public function setId()
	{
		return 'idReceita';
	}
}
