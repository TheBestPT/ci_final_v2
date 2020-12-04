<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UtenteController extends MY_Controller {

	public function loadModel()
	{
		return 'utente';
	}

	public function titleName()
	{
		return 'Utente';
	}

	public function verification(){
		$rules['nome'] = array('trim', 'required', 'min_length[3]');
		$rules['nUtente'] = array('trim', 'required', 'min_length[3]');
		$rules['idMorada'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('nome', 'Nome', $rules['nome']);
		$this->form_validation->set_rules('nUtente', 'NumeroUtente', $rules['nUtente']);
		$this->form_validation->set_rules('idMorada', 'IdMorada', $rules['idMorada']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'UtenteController';
	}

	public function idTable()
	{
		return 'idUtente';
	}

	public function form()
	{
		return ['nome' => ['display' => 'Nome', 'element' => 'text', 'name' => 'nome'], 'nUtente' => ['display' => 'Numero Utente', 'element' => 'text', 'name' => 'nUtente'], 'idMorada' => ['display' => 'Morada', 'element' => 'text', 'name' => 'idMorada']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}

	public function irregularItems($item, $what, $id)
	{
		switch ($what){
			case 'guardar':
				$item['idMorada'] = $item['idMorada'] = $this->setMorada($item);
				return $item;
			case 'editar':
				$item['idMorada'] = $this->updateMorada($item);
				return $item;
			case 'del':
				$this->{$this->loadModel()}->delItem('idMorada', $item['idMorada'], 'morada');
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
			$utentes = $this->{$this->loadModel()}->get_count_from_table_where($it->idUtente, 'idUtente', 'consulta');
			if (isset($utentes))
				$it->cons = $utentes . ' consultas por fazer';
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
