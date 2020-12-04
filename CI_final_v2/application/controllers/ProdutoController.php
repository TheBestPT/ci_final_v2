<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProdutoController extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function loadModel()
	{
		return 'produto';
	}

	public function titleName()
	{
		return 'Produtos';
	}

	public function verification(){
		$rules['descricao'] = array('trim', 'required', 'min_length[1]');
		$rules['preco'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('descricao', 'Descricao', $rules['descricao']);
		$this->form_validation->set_rules('preco', 'Preco', $rules['preco']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'ProdutoController';
	}

	public function idTable()
	{
		return 'idProduto';
	}

	public function form()
	{
		return ['descricao' => ['display' => 'Descricao', 'element' => 'text', 'name' => 'descricao'], 'preco' => ['display' => 'Preco', 'element' => 'text', 'name' => 'preco']];
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
			$it->update = base_url($this->nomeController().'/editar/').$it->{$this->idTable()};
		}
		return $items;
	}
}
