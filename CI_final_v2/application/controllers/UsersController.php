<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UsersController extends MY_Controller {


	public function loadModel()
	{
		return 'users';
	}

	public function titleName()
	{
		return 'Users';
	}

	public function verification(){
		$rules['username'] = array('trim', 'required', 'min_length[3]');
		$rules['password'] = array('trim', 'required', 'min_length[5]');
		$rules['email'] = array('trim', 'required', 'min_length[10]');
		$rules['fullname'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('username', 'Username', $rules['username']);
		$this->form_validation->set_rules('password', 'Password', $rules['password']);
		$this->form_validation->set_rules('email', 'Email', $rules['email']);
		$this->form_validation->set_rules('fullname', 'Fullname', $rules['fullname']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'UsersController';
	}

	public function idTable()
	{
		return 'idUser';
	}

	public function form()
	{
		return ['username' => ['display' => 'Username', 'element' => 'text', 'name' => 'username'], 'fullname' => ['display' => 'Fullname', 'element' => 'text', 'name' => 'fullname'], 'email' => ['display' => 'Email', 'element' => 'text', 'name' => 'email'], 'password' => ['display' => 'Password', 'element' => 'password', 'name' => 'password'], 'permissions' => ['display' => 'Permissions', 'element' => 'text', 'name' => 'permissions']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}

	public function irregularItems($item, $what, $id)
	{
		switch ($what){
			case 'guardar':
				return $this->userSettings($item);
			case 'editar':
				return $this->userSettings($item);
			default:
				return $item;
		}
	}

	private function userSettings($item){
		$item['password'] = $this->setPassword($item['password'], $item);
		$item['permissions'] = $this->serializePerm($item['permissions']);
		return $item;
	}

	public function indexConf($id)
	{
		return $this->normalIndex();
	}

	public function verificacoes($items)
	{
		foreach ($items as $it){
			$it->del = base_url($this->nomeController()).'/del/'.$it->{$this->idTable()};
			$it->update = base_url($this->nomeController().'/editar/').$it->{$this->idTable()};
			if($it->permissions != '')
				$it->permissions = implode(',' , unserialize($it->permissions));
			else
				$it->permissions = 'Sem permissoes';
			$it->papel = $this->users->captureWhatUser($it->idUser);
		}
	}

	public function addAction()
	{
		return null;
	}

	public function guardarAction()
	{
		return null;
	}

	public function remAction()
	{
		return null;
	}

	public function editar()
	{
		if($this->verifyLogin()) if(!$this->verifyPermissions()){$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);return;}
		$data['title'] = 'Edit '.$this->titleName();
		$data['id'] = $this->uri->segment(3);
		$data['model'] = $this->loadModel();
		$id =$this->uri->segment(3);
		$list = $this->{$this->loadModel()}->GetById($id);
		$perms = '';
		if($list['permissions'] != '') $perms = implode(',' , unserialize($list['permissions']));
		$data = [
			'title' => 'Edit '.$this->titleName(),
			'guardar' => base_url($this->nomeController()).'/guardar',
			'username' => $list['username'],
			'fullname' => $list['fullname'],
			'email' => $list['email'],
			'permissions' => $perms,
			'idItem' => $this->idTable(),
			'id' => $id
		];
		$this->parser->parse('comuns/header', $i = ['title' => $this->titleName()]);
		$this->load->view('comuns/menu');
		$this->parser->parse($this->loadModel().'_edit', $data);
		$this->load->view('comuns/footer');
	}
}
