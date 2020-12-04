<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ConsultaController extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('receita');
	}

	public function loadModel()
	{
		return 'consulta';
	}

	public function titleName()
	{
		return 'Consulta';
	}

	public function verification(){
		$rules['data'] = array('trim', 'required', 'min_length[1]');
		$rules['idMedico'] = array('trim', 'required', 'min_length[1]');
		$rules['idUtente'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('data', 'Data', $rules['data']);
		$this->form_validation->set_rules('idMedico', 'IdMedico', $rules['idMedico']);
		$this->form_validation->set_rules('idUtente', 'IdUtente', $rules['idUtente']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return 'ConsultaController';
	}

	public function idTable()
	{
		return 'idConsulta';
	}

	public function form()
	{
		return ['data' => ['display' => 'Data', 'element' => 'text', 'name' => 'data']];
	}

	public function permissions()
	{
		return $this->loadModel();
	}


	public function muda(){
		$id = $this->uri->segment(3);
		$consulta = $this->{$this->loadModel()}->GetById($id);
		$consulta['estado'] = $consulta['estado'] == 1 ? 0 : 1;
		$this->{$this->loadModel()}->Update($id, $consulta);
		redirect($this->nomeController(), 'refresh');
	}






	/*private function guardarConEnf($item){
		//$data['idConsulta'] = $item[''];
		$data['idConsul'] = $item['idConsulta'];
		$data['idInferm'] = $item['idInfermeiro'];
		print_r($data);
		return $this->{$this->loadModel()}->insertSomeItem($data, 'consultaenfermeiro');
	}*/


	public function irregularItems($item, $what, $id)
	{
		switch ($what){
			case 'guardar':
				$item['estado'] = 0;
				return $item;
			case 'del':
				$this->{$this->loadModel()}->delItem('idConsulta', $item['idConsulta'], 'receita');
				return $item;
			default:
				return $item;
		}
	}

	public function indexConf($id)
	{
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
		$utentes = null;
		$u = $this->{$this->loadModel()}->getAllByTable('utente');
		foreach ($u as $it)
			$utentes[] = ['display' => $it['nome'], 'value' => $it['idUtente']];

		$medicos = null;
		$m = $this->{$this->loadModel()}->getAllByTable('medico');
		foreach ($m as $it)
			$medicos[] = ['display' => $it['nome'], 'value' => $it['idMed']];

		$data = [
			'title' => $this->titleName(),
			'guardar' => $this->nomeController().'/guardar',
			'form' => $this->form(),
			'utentes' => $utentes,
			'medicos' => $medicos,
			'items' => $items,
			'links' => $links
		];
		return $data;
	}

	public function verificacoes($items)
	{
		foreach ($items as $it) {
			$it->del = base_url($this->nomeController()).'/del/'.$it->{$this->idTable()};
			$it->update = base_url($this->nomeController().'/editar/').$it->{$this->idTable()};
			if (isset($it->idUtente) && isset($it->idMedico)) {
				$enf = $this->{$this->loadModel()}->verificaSeEnf($it->idConsulta);
				$enfermeiroStr = '';
				if (isset($enf))
					foreach ($enf as $e)
						if ($it->idConsulta == $e['idConsul']) {
							$enfermeiroStr .= $this->{$this->loadModel()}->getSome($e['idInferm'], 'idInferm', 'enfermeiro')['nome'] . ' ';
							$it->enfermeiro = $enfermeiroStr;
						} else
							$it->enfermeiro = '';
				else
					$it->enfermeiro = 'Sem enfermeiros';
				$verReceita = $this->{$this->loadModel()}->getSome($it->idConsulta, 'idConsulta', 'receita');
				if (isset($verReceita))
					$it->rec = 'Tem receita';
				else
					$it->rec = 'Não tem receita';
			}
			if(isset($it->idMedico))
				$it->idMedico = $this->{$this->loadModel()}->getSome($it->idMedico, 'idMed', 'medico')['nome'];
			if(isset($it->idUtente) && $this->loadModel() == 'consulta')
				$it->idUtente = $this->{$this->loadModel()}->getSome($it->idUtente, 'idUtente', 'utente')['nome'];
			if(isset($it->estado))
				$it->estado = $it->estado == 1 ? 'Concluida' : 'Marcada';
		}
	}

	public function addAction()
	{
		$id = $this->uri->segment(3);
		$items = $this->{$this->loadModel()}->getAllByTable('enfermeiro');
		$enfermeiroStr = $this->verificaEnfProf($id, 'idInferm', 'idConsul','enfermeiro', 'nome');
		$data = [
			'title' => $this->titleName(),
			'items' => $items,
			'nome' => $enfermeiroStr,
			'voltar' => base_url('ConsultaController'),
			'idCon' => base_url($this->nomeController().'/guardarEnf/').$id,
			'guardar' => base_url($this->nomeController().'/guardarEnf')
		];
		$this->parser->parse('addEnfer', $data);

	}

	public function guardarAction()
	{
		$item['idConsulta'] = $this->uri->segment(3);
		$item['idInfermeiro'] = $this->uri->segment(4);
		$red = 'ConsultaController/addEnf/'.$item['idConsulta'];
		$status = $this->guardarConEnf($item);
		if(!$status){
			$this->session->set_flashdata('error', ERROR_MSG);
		}else {
			$this->session->set_flashdata('success', SUCESS_MSG);
			redirect($red, 'refresh');
		}
	}

	public function remAction()
	{
		$item['idConsulta'] = $this->uri->segment(3);
		$item['idInfermeiro'] = $this->uri->segment(4);
		$status = $this->{$this->loadModel()}->delItemWithTwoWheres('idConsul', $item['idConsulta'], 'idInferm', $item['idInfermeiro'], 'consultaenfermeiro');
		$red = 'ConsultaController/addEnf/'.$item['idConsulta'];
		if(!$status){
			$this->session->set_flashdata('error', ERROR_MSG);
		}else {
			$this->session->set_flashdata('success', SUCESS_MSG);
			redirect($red, 'refresh');
		}
	}
}
