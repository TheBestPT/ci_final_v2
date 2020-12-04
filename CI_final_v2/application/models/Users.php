<?php
class Users extends MY_Model {
	public function __construct(){
		parent::__construct();
	}

	public function getByUsername($username){
		$user = array('username' => $username);
		$query = $this->db->get_where($this->table, $user,1);
		if($query->num_rows()>0)
			return $query->row_array();
		return false;
	}

	public function isLoggedIn(){
		// $logged_in = $_SESSION['logged_in'];
		//ou
		// $logged_in = $this->session->logged_in;
		$logged_in = $this->session->userdata('logged_in');
		$user = $this->session->userdata('user');
		if($logged_in== TRUE){
			$this->createSession($user);
			return true;
		}
		return false;
	}

	public function createSession($user_data){
		$this->session->set_userdata(array('logged_in' =>TRUE, 'user'=>$user_data));
	}

	public function emailExists($email){
		$user = array('email' => $username);
		$query = $this->db->get_where($this->table, $user,1);
		if($query->num_rows()>0)
			return true;
		return false;
	}

	public function usernameExists(){
		$user = array('username' => $username);
		$query = $this->db->get_where($this->table, $user,1);
		if($query->num_rows()>0)
			return true;
		return false;
	}


	public function checkPassword($password,$hashed_password) {
		return (md5($password)==$hashed_password);
	}//alterar aqui para o projeto

	public function mdPassword($pwd){
		return md5($pwd);
	}

	public function get_count(){
		return $this->db->count_all($this->table);
	}

	public function get_pag($limit, $start){
		$this->db->limit($limit, $start);
		$query = $this->db->get($this->table);
		return $query->result();
	}

	public function captureWhatUser($idUser){
		$this->table = 'enfermeiro';
		$enf = $this->GetById($idUser);
		if($enf == null){
			$this->table = 'medico';
			$med = $this->GetById($idUser);
			if($med == null) {
				$this->table = 'users';
				return 'admin';
			}
			else {
				$this->table = 'users';
				return 'medico';
			}
		}else{
			$this->table = 'users';
			return 'enfermeiro';
		}
	}

	public function permissionsToAdm(){
		$user = $this->GetById(1);
		$p = 'enfermeiro,medico,utente,users,contatos';
		$permissions = $user;
		//print_r($permissions);
		if(preg_match('/[^0-9A-Za-z\,\.\-\_\S]/is',$p)){
			return;
		}
		$permissions['permissions'] = array_map('trim',explode(',', $p));
		$permissions['permissions'] = array_unique($permissions['permissions']);

		$permissions['permissions'] = array_filter($permissions['permissions']);

		$permissions['permissions'] = serialize($permissions['permissions']);
		print_r($permissions);
		$this->db->where('idUser', $user['idUser']);
		$this->db->update($this->table, $permissions);
	}

	public function setTable()
	{
		return 'users';
	}

	public function setId()
	{
		return 'idUser';
	}
}
