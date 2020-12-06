<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {
	public $red;
	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->loadModel());
		$this->load->model('users');
		define('ERROR_MSG', 'Não foi possível inserir o item.');
		define('SUCESS_MSG', 'Item inserido com sucesso.');
		define('REMOVE_MSG', 'Item eliminado');
	}

	public function index()
	{
		$id = 0;
		if($this->loadModel() == 'receita') $id = $this->uri->segment(2);
		$data = $this->indexConf($id);
		if($this->form_validation->run() == FALSE && $this->verifyLogin())
			if($this->verifyPermissions()) {
				$this->parser->parse('comuns/header', $i = ['title' => $this->titleName()]);
				$this->load->view('comuns/menu');
				$this->parser->parse($this->loadModel(), $data);
				$this->load->view('comuns/footer');
			}else {
				$this->parser->parse('comuns/header', $i = ['title' => $this->titleName()]);
				$this->load->view('comuns/menu');
				$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);
				$this->load->view('comuns/footer');
			}
		else {
			$this->parser->parse('comuns/header', $i = ['title' => $this->titleName()]);
			$this->load->view('comuns/menu');
			$this->parser->parse($this->loadModel() . '_view', $data);
			$this->load->view('comuns/footer');
		}
	}

	public function guardar(){
		$validacao = $this->verification();
		$this->red = $this->nomeController();
		if($validacao){
			$item =$this->input->post();
			if(!array_key_exists($this->idTable(), $item)){
				$item = $this->irregularItems($item, 'guardar', 0);
				$status = $this->{$this->loadModel()}->Insert($item);
			}else{
				$this->editApply($item[$this->idTable()]);
				return;
			}
			if(!$status){
				$this->session->set_flashdata('error', ERROR_MSG);
			}else{
				$this->session->set_flashdata('success', SUCESS_MSG);
				redirect($this->red, 'refresh');
			}
		}else{
			$this->session->set_flashdata('error', validation_errors('<p>','</p>'));
		}
		redirect($this->red, 'refresh');
	}

	public function del(){
		if(!$this->verifyLogin()) if(!$this->verifyPermissions()){$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);return;}
		$id = $this->uri->segment(3);
		$this->red = $this->nomeController();
		if(is_null($id))
			redirect($this->nomeController(), 'refresh');
		$item = $this->{$this->loadModel()}->GetById($id);
		$this->irregularItems($item, 'del', $id);
		$status = $this->{$this->loadModel()}->Delete($id);
		if(!$status){
			$this->session->set_flashdata('success', ERROR_MSG);
		}else{
			$this->session->set_flashdata('error', REMOVE_MSG);
		}
		redirect($this->red, 'refresh');
	}

	private function editApply($id){
		if(!$this->verifyLogin()) if(!$this->verifyPermissions()){$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);return;}
		$validacao = $this->verification();
		$this->red = $this->nomeController();
		if($validacao){
			$item = $this->input->post();
			$item = $this->irregularItems($item, 'editar', $id);
			$status = $this->{$this->loadModel()}->Update($id,$item);
			if(!$status){
				$this->session->set_flashdata('error', ERROR_MSG);
			}else{
				$this->session->set_flashdata('success', SUCESS_MSG);
				redirect($this->nomeController(), 'refresh');
			}
		}else {
			$this->session->set_flashdata('error', validation_errors());
		}
	}
	public function details(){
		if(!$this->verifyLogin() && $this->verifyPermissions()) redirect($this->nomeController());
		$id = $this->uri->segment(3);
		if(is_null($id))
			redirect($this->nomeController(), 'refresh');
		$item = $this->{$this->loadModel()}->GetById($id);
		$userDetails = $this->{$this->loadModel()}->getSome($item['idUser'], 'idUser', 'users');
		$data = [
			'title' => 'Perfil',
			'nome' => $item['nome'],
			'nif' => $item['nif'],
			'nib' => $item['nib'],
			'especialidade' => $item['especialidade'],
			'morada' => $this->{$this->loadModel()}->getMoradaById($item['idMorada'])['morada'],
			'username' => $userDetails['username'],
			'email' => $userDetails['email'],
			'back' => base_url($this->nomeController())
		];
		$this->parser->parse('details', $data);
	}

	protected function guardarConEnf($item){
		if($this->loadModel() == 'consulta'){
			$data['idConsul'] = $item['idConsulta'];
			$data['idInferm'] = $item['idInfermeiro'];
			return $this->{$this->loadModel()}->insertSomeItem($data, 'consultaenfermeiro');
		}else{
			return $this->{$this->loadModel()}->insertSomeItem($item, 'carrinho');
		}
	}

	protected function setPassword($password, $item){
		$passwordHashed = $this->{$this->loadModel()}->mdPassword($item['password']);
		return $passwordHashed;
	}

	protected function setMorada($item){
		$morada = $this->{$this->loadModel()}->setSomeItem($item['idMorada'], 'morada', 'idMorada');
		return $morada['idMorada'];
	}


	protected function verifyLogin(){
		return $this->users->isLoggedIn();
	}

	protected function verifyPermissions(){
		$userTable  = $this->session->userdata('user');
		$user = $this->users->GetById($userTable['idUser']);
		$permissions = unserialize($user['permissions']);
		for($i = 0; $i < count($permissions) ; $i++){
			if($permissions[$i] == $this->permissions())
				return true;
		}
	}

	protected function serializePerm($perm){
		if(preg_match('/[^0-9A-Za-z\,\.\-\_\S]/is',$perm)){
			return;
		}
		$permissions['permissions'] = array_map('trim',explode(',', $perm));
		$permissions['permissions'] = array_unique($permissions['permissions']);
		$permissions['permissions'] = array_filter($permissions['permissions']);
		$permissions['permissions'] = serialize($permissions['permissions']);
		return $permissions['permissions'];
	}

	protected function userCreate($item, $flag, $id){
		if($this->loadModel() == 'medico')//porque um medico tem de gerir as consultas
			$user['permissions'] = $this->serializePerm('consulta,receita');
		$item['password'] = $this->setPassword($item['password'], $item);
		$user['username'] = $item['username'];
		$user['fullname'] = $item['fullname'];
		$user['email'] = $item['email'];
		$user['password'] = $item['password'];
		if($flag) {
			$item['idMorada'] = $this->setMorada($item);
			$userid = $this->{$this->loadModel()}->setSomeItemIWant($user, 'users', 'idUser');
			$item['idUser'] = $userid['idUser'];
			if($this->loadModel() == 'medico')
				unset($item['username'], $item['fullname'], $item['email'], $item['password'], $item['permissions']);//, $item['permissions']
			else
				unset($item['username'], $item['fullname'], $item['email'], $item['password']);
		}else{
			$all = $this->{$this->loadModel()}->GetById($id);
			$item['idMorada'] = $this->updateMorada($item);
			$this->{$this->loadModel()}->updateSomeItemIWant($user, 'users', 'idUser', $all['idUser']);
			unset($item['username'], $item['fullname'], $item['email'], $item['password']);//, $item['permissions']
		}
		return $item;
	}

	public function verificaEnfProf($id, $idCompare, $idComprareDb, $table, $attr){
		if($table == 'enfermeiro')
			$it = $this->{$this->loadModel()}->verificaSeEnf($id);
		else
			$it = $this->{$this->loadModel()}->verificaSeProd($id);
		$returnStr = '';
		if(isset($it))
			foreach ($it as $e)
				if($id == $e[$idComprareDb])
					$returnStr .= $this->{$this->loadModel()}->getSome($e[$idCompare], $idCompare, $table)[$attr].' ';
				else
					$returnStr = '';
		else
			$returnStr = 'Sem '.$table.'s';
		return $returnStr;
	}

	private function selectModelar($list, $id){
		$form = '';
		for($i = 0; $i < count($list); $i++)
			$form .= '<option value="'.$list[$i][$id].'">'.$list[$i]['nome'].'</option>';
		$form .= '</select>';
		return $form;
	}

	public function updateMorada($morada){
		return $this->{$this->loadModel()}->updateMorada($morada, 'morada', 'idMorada');
	}

	protected function normalIndex(){
		$config = array();
		$config['base_url'] = base_url().$this->nomeController();
		$config['total_rows'] = $this->{$this->loadModel()}->get_count();
		$config['per_page'] = 3;
		$config['uri_segment'] = 2;
		$this->pagination->initialize($config);
		$page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$links = $this->pagination->create_links();
		$items = $this->{$this->loadModel()}->get_pag($config['per_page'], $page);
		$this->verificacoes($items);
		$data = [
			'title' => $this->titleName(),
			'guardar' => $this->nomeController().'/guardar',
			'form' => $this->form(),
			'items' => $items,
			'links' => $links
		];
		return $data;
	}
	public abstract function loadModel();

	public abstract function titleName();

	public abstract function verification();

	public abstract function nomeController();

	public abstract function idTable();

	public abstract function form();

	public abstract function permissions();

	public abstract function irregularItems($item, $what, $id);

	public abstract function indexConf($id);

	public abstract function verificacoes($items);

	public abstract function addAction();

	public abstract function guardarAction();

	public abstract function remAction();

	public abstract function editar();
}
