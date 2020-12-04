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
		return [$this->idTable() => ['display' => '', 'element' => 'hidden'], 'username' => ['display' => 'Username', 'element' => 'text'], 'fullname' => ['display' => 'Fullname', 'element' => 'text'], 'email' => ['display' => 'Email', 'element' => 'text'], 'password' => ['display' => 'Password', 'element' => 'password'], 'permissions' => ['display' => 'Permissions', 'element' => 'text']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}

	public function irregularItems($item, $what, $id)
	{
		switch ($item){
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
}
