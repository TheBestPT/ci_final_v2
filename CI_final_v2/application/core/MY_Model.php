<?php
abstract class MY_Model extends CI_Model{
	public $table;
	public $id;
	public function __construct() {
		parent::__construct();
		$this->table = $this->setTable();
		$this->id = $this->setId();
	}

	function Insert($data) {
		if(!isset($data))
			return false;
		return $this->db->insert($this->table,$data);
	}

	function GetAll($sort = 'id', $order = 'asc') {
		$this->db->order_by($sort, $order);
		$query = $this->db->get($this->table);
		if ($query->num_rows()>0)
			return $query->result();
		else
			return null;
	}
	function GetById($id) {
		if(is_null($id))
			return false;
		$this->db->where($this->id, $id);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return null;
	}



	public function getItem($item, $itemToCompare){
		if(is_null($item))
			return false;
		$this->db->where($itemToCompare, $item);
		$query = $this->db->get($this->table);
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return null;
	}

	public function getSome($item, $itemToCompare, $table){
		if(is_null($item))
			return false;
		$this->db->where($itemToCompare, $item);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
			return $query->row_array();
		else
			return null;
	}

	function Update($id, $data) {
		if(is_null($id) || !isset($data))
			return false;
		$this->db->where($this->id, $id);
		return $this->db->update($this->table, $data);
	}

	function Delete($id) {
		if(is_null($id))
			return false;
		$this->db->where($this->id, $id);
		return $this->db->delete($this->table);
	}

	function getMoradaById($id){
		if(is_null($id))
			return false;
		$this->db->select('morada');
		$this->db->where('idMorada', $id);
		$query = $this->db->get('morada');
		return $query->row_array();
	}

	function getAllByTable($table){
		if(is_null($table))
			return;
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
			return $query->result_array();
		else
			return null;
	}

	function setSomeItem($item, $table, $idTable){
		if(is_null($item))
			return false;
		$data['morada'] = $item;
		$query = $this->db->insert($table, $data);
		//print_r($query->result());
		$this->db->select($idTable);
		$this->db->where('morada', $data['morada']);
		$query2 = $this->db->get($table);
		$return = $query2->row_array();
		return $return;
	}

	public function editMorada($item, $table, $idTable){
		if(is_null($item))
			return false;
		$data['morada'] = $item;
		$query = $this->db->insert($table, $data);
		//print_r($query->result());
		$id = $this->db->query('SELECT * FROM '.$table.' ORDER BY '.$idTable.' DESC LIMIT 1')->row_array();
		return $id;
	}

	function delItem($idCompare, $id, $table) {
		if(is_null($id))
			return false;
		$this->db->where($idCompare, $id);
		return $this->db->delete($table);
	}

	function delItemWithTwoWheres($idCompare, $id, $idCompare2, $id2, $table){
		if(is_null($id))
			return false;
		$this->db->where($idCompare, $id);
		$this->db->where($idCompare2, $id2);
		return $this->db->delete($table);
	}

	public function get_count(){
		return $this->db->count_all($this->table);
	}

	public function get_pag($limit, $start){
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	function setSomeItemIWant($item, $table, $idTable){
		if(is_null($item))
			return false;
		//$data['morada'] = $item;
		print_r($item);
		$query = $this->db->insert($table, $item);
		$id = $this->db->query('SELECT * FROM '.$table.' ORDER BY '.$idTable.' DESC LIMIT 1')->row_array();
		print_r($id);
		$this->db->select($idTable);
		echo $id['idUser'];
		$this->db->where($idTable, $id[$idTable]);
		$query2 = $this->db->get($table);
		$return = $query2->row_array();
		return $return;
	}

	function updateSomeItemIWant($item, $table, $idTable, $idOptional){
		if(is_null($item))
			return false;
		//if(!$this->db->where($idTable, $item[$idTable]))
		$this->db->where($idTable, $idOptional);
		return $this->db->update($table, $item);
	}

	function updateMorada($item, $table, $idTable){
		if(is_null($item))
			return false;
		$ut = $this->GetById($item[$this->id]);
		$this->db->where($idTable, $ut[$idTable]);
		$id = $this->db->get($table)->row_array();
		$this->db->where($idTable, $id[$idTable]);
		$up['morada'] = $item[$idTable];
		$this->db->update($table, $up);
		return $id[$idTable];
	}

	public function mdPassword($pwd){
		return md5($pwd);
	}

	public function get_count_table($table){
		return $this->db->count_all($table);
	}

	public function insertSomeItem($item, $table){
		if(!isset($item))
			return false;
		return $this->db->insert($table,$item);
	}

	public function getNextId($table, $id){
		$idReturn = $this->db->query('SELECT * FROM '.$table.' ORDER BY '.$id.' DESC LIMIT 1')->row_array();
		return $idReturn[$id];
	}


	public function get_count_from_table_where($id, $idCompare, $table){
		if(is_null($id))
			return false;
		//if(!$this->db->where($idTable, $item[$idTable]))
		$this->db->where($idCompare, $id);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0)
			return $query->num_rows();
		else
			return null;
	}

	public abstract function setTable();
	public abstract function setId();
}
