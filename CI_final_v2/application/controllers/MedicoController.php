<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MedicoController extends MY_Controller {

	public function loadModel()
	{
		return 'medico';
	}

	public function titleName()
	{
		return 'Medico';
	}

	public function verification(){
		$rules['nome'] = array('trim', 'required', 'min_length[3]');
		$rules['nib'] = array('trim', 'required', 'min_length[3]');
		$rules['nif'] = array('trim', 'required', 'min_length[3]');
		$rules['especialidade'] = array('trim', 'required', 'min_length[3]');
		$rules['idMorada'] = array('trim', 'required', 'min_length[1]');
		$rules['username'] = array('trim', 'required', 'min_length[3]');
		$rules['password'] = array('trim', 'required', 'min_length[5]');
		$rules['email'] = array('trim', 'required', 'min_length[10]');
		$rules['fullname'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('username', 'Username', $rules['username']);
		$this->form_validation->set_rules('password', 'Password', $rules['password']);
		$this->form_validation->set_rules('email', 'Email', $rules['email']);
		$this->form_validation->set_rules('fullname', 'Fullname', $rules['fullname']);
		$this->form_validation->set_rules('nome', 'Nome', $rules['nome']);
		$this->form_validation->set_rules('nib', 'Nib', $rules['nib']);
		$this->form_validation->set_rules('nif', 'Nif', $rules['nif']);
		$this->form_validation->set_rules('especialidade', 'Especialidade', $rules['especialidade']);
		$this->form_validation->set_rules('idMorada', 'IdMorada', $rules['idMorada']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'MedicoController';
	}

	public function idTable()
	{
		return 'idMed';
	}

	public function form()
	{
		return ['nome' => ['display' => 'Nome', 'element' => 'text', 'name' => 'nome'], 'nif' => ['display' => 'Nif', 'element' => 'text', 'name' => 'nif'], 'nib' => ['display' => 'Nib', 'element' => 'text', 'name' => 'nib'], 'especialidade' => ['display' => 'Especialidade', 'element' => 'text', 'name' => 'especialidade'], 'idMorada' => ['display' => 'Morada', 'element' => 'text', 'name' => 'idMorada'], 'username' => ['display' => 'Username', 'element' => 'text', 'name' => 'username'], 'fullname' => ['display' => 'Fullname', 'element' => 'text', 'name' => 'fullname'], 'email' => ['display' => 'Email', 'element' => 'text', 'name' => 'email'], 'password' => ['display' => 'Password', 'element' => 'password', 'name' => 'password']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}

	public function irregularItems($item, $what, $id)
	{
		switch ($what){
			case 'guardar':
				$item = $this->userCreate($item, true, 0);
				return $item;
			case 'editar':
				$item = $this->userCreate($item, false, $id);
				return $item;
			case 'del':
				$this->{$this->loadModel()}->delItem('idMorada', $item['idMorada'], 'morada');
				$this->{$this->loadModel()}->delItem('idUser', $item['idUser'], 'users');
				return $item;
			default:
				return $item;
		}
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
			$it->idMorada = $this->{$this->loadModel()}->getMoradaById($it->idMorada)['morada'];
			$it->details = base_url($this->nomeController()).'/details/'.$it->{$this->idTable()};
			$consultas = $this->{$this->loadModel()}->get_count_from_table_where($it->idMed, 'idMedico', 'consulta');
			if(isset($consultas))
				$it->cons = $consultas.' consultas por fazer';
			else
				$it->cons = 'Sem consultas';
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
