<?php
class ContatosController extends MY_Controller{

	public function loadModel()
	{
		return 'contatos';
	}

	public function titleName()
	{
		return 'Contatos';
	}

	public function verification()
	{
		$rules['nome'] = array('trim', 'required', 'min_length[3]');
		$rules['email'] = array('trim', 'required', 'min_length[3]');
		$rules['mensagem'] = array('trim', 'required', 'min_length[20]');
		$this->form_validation->set_rules('nome', 'Nome', $rules['nome']);
		$this->form_validation->set_rules('email', 'Email', $rules['email']);
		$this->form_validation->set_rules('mensagem', 'Mensagem', $rules['mensagem']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'ContatosController';
	}

	public function idTable()
	{
		return 'id';
	}

	public function form()
	{
		return ['nome' => ['display' => 'Nome', 'element' => 'text', 'name' => 'nome'], 'email' => ['display' => 'Email', 'element' => 'text', 'name' => 'email'], 'mensagem' => ['display' => 'Mensagem', 'element' => 'text', 'name' => 'mensagem']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}

	public function irregularItems($item, $what, $id)
	{
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
		}
		return $items;
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
		return null;
	}
}
