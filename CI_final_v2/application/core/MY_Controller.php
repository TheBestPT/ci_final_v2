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
		$this->red = $this->nomeController();
	}

	public function index()
	{
		$id = 0;
		if($this->loadModel() == 'receita') $id = $this->uri->segment(2);
		$data = $this->indexConf($id);
		if($this->form_validation->run() == FALSE && $this->verifyLogin())
			if($this->verifyPermissions())
				$this->parser->parse($this->loadModel(), $data);
			else
				$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);
		else
			$this->parser->parse($this->loadModel().'_view', $data);
	}

	public function guardar(){
		$validacao = $this->verification();
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

	public function editar(){
		if($this->verifyLogin()) if(!$this->verifyPermissions()){$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);return;}
		$data['title'] = 'Edit '.$this->titleName();
		$data['id'] = $this->uri->segment(3);
		$data['model'] = $this->loadModel();
		$id =$this->uri->segment(3);
		$list = $this->{$this->loadModel()}->GetById($id);
		$form = null;
		foreach ($this->form() as $key => $item){
			$item[]['value'] = $list[$key];
		}
		print_r($form);
		$data = [
			'title' => 'Edit '.$this->titleName(),
			'guardar' => base_url($this->nomeController()).'/guardar',
			'form' => $form,
			'idItem' => $this->idTable(),
			'id' => $id
		];
		$this->parser->parse($this->loadModel().'_edit', $data);
	}

	private function editApply($id){
		if(!$this->verifyLogin()) if(!$this->verifyPermissions()){$this->parser->parse('perm', $title = ['title' => $this->titleName(), 'voltar' => base_url('home')]);return;}
		$validacao = $this->verification();
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

	public function guardarEnf(){
		if($this->loadModel() == 'consulta') {
			$item['idConsulta'] = $this->uri->segment(3);
			$item['idInfermeiro'] = $this->uri->segment(4);
			$red = 'ConsultaController/addEnf/'.$item['idConsulta'];
			$status = $this->guardarConEnf($item);
		}else{
			$item['idReceita'] = $this->uri->segment(3);
			$item['idProduto'] = $this->uri->segment(4);
			$red = 'ReceitaController/addEnf/'.$item['idReceita'];
			$status = $this->guardarConEnf($item);
		}
		if(!$status){
			$this->session->set_flashdata('error', ERROR_MSG);
		}else{
			$this->session->set_flashdata('success', SUCESS_MSG);
			redirect($red, 'refresh');
		}
	}

	public function remEnf(){
		if($this->loadModel() == 'consulta'){
			$item['idConsulta'] = $this->uri->segment(3);
			$item['idInfermeiro'] = $this->uri->segment(4);
			$status = $this->{$this->loadModel()}->delItemWithTwoWheres('idConsul', $item['idConsulta'], 'idInferm', $item['idInfermeiro'], 'consultaenfermeiro');
			$red = 'ConsultaController/addEnf/'.$item['idConsulta'];
		}else{
			$item['idReceita'] = $this->uri->segment(3);
			$item['idProduto'] = $this->uri->segment(4);
			$status = $this->{$this->loadModel()}->delItemWithTwoWheres('idReceita', $item['idReceita'], 'idProduto', $item['idProduto'], 'carrinho');
			$red = 'ReceitaController/addEnf/'.$item['idReceita'];
		}
		if(!$status){
			$this->session->set_flashdata('error', ERROR_MSG);
		}else{
			$this->session->set_flashdata('success', SUCESS_MSG);
			redirect($red, 'refresh');
		}
	}

	public function addEnf(){
		$id = $this->uri->segment(3);
		if($this->loadModel() == 'consulta') {
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
		}else{
			$items = $this->{$this->loadModel()}->getAllByTable('produto');
			$back = $this->{$this->loadModel()}->getSome($id, 'idReceita', 'receita');
			$produtoStr = $this->verificaEnfProf($id, 'idProduto', 'idReceita', 'produto', 'descricao');
			$data = [
				'title' => $this->titleName(),
				'items' => $items,
				'nome' => $produtoStr,
				'voltar' => base_url('ReceitaController').'/'.$back['idConsulta'],
				'idCon' => base_url($this->nomeController().'/guardarEnf/').$id,
				'guardar' => base_url($this->nomeController().'/guardarEnf')
			];
			$this->parser->parse('addProd', $data);
		}
	}

	private function guardarConEnf($item){
		if($this->loadModel() == 'consulta'){
			$data['idConsul'] = $item['idConsulta'];
			$data['idInferm'] = $item['idInfermeiro'];
			return $this->{$this->loadModel()}->insertSomeItem($data, 'consultaenfermeiro');
		}else{
			return $this->{$this->loadModel()}->insertSomeItem($item, 'carrinho');
		}
	}

	private function modelarForm(){
		$form = '';
		$item = $this->form();
		foreach ($item as $key => $f){
			if($key != $this->idTable()) {
				if ($key == 'idMedico') {
					$form .= '<label>' . $f['display'] . ':</label><select name="' . $key . '">';
					$form .= $this->selectModelar($this->{$this->loadModel()}->getAllByTable('medico'), 'idMed');
				}elseif($key == 'idUtente'){
					$form .= '<label>' . $f['display'] . ':</label><select name="' . $key . '">';
					$form .= $this->selectModelar($this->{$this->loadModel()}->getAllByTable('utente'), $key);
				}else
					$form .= '<label>'.$f['display'].':</label><input type="'.$f['element'].'" name="'.$key.'" placeholder="'.$f['display'].'">';
			}
		}
		return $form;
	}

	/*protected function verificacoes($items){
		foreach ($items as $it){
			$it->del = base_url($this->nomeController()).'/del/'.$it->{$this->idTable()};
			$it->update = base_url($this->nomeController().'/editar/').$it->{$this->idTable()};
			if(isset($it->idUser))
				$it->papel = $this->users->captureWhatUser($it->idUser);
			if(isset($it->permissions)){
				if($it->permissions != '')
					$it->permissions = implode(',' , unserialize($it->permissions));
				else
					$it->permissions = 'Sem permissoes';
			}
			if(isset($it->idMorada))
				$it->idMorada = $this->{$this->loadModel()}->getMoradaById($it->idMorada)['morada'];
			if(isset($it->idMedico))
				$it->idMedico = $this->{$this->loadModel()}->getSome($it->idMedico, 'idMed', 'medico')['nome'];
			if(isset($it->idUtente) && $this->loadModel() == 'consulta')
				$it->idUtente = $this->{$this->loadModel()}->getSome($it->idUtente, 'idUtente', 'utente')['nome'];
			if(isset($it->estado))
				$it->estado = $it->estado == 1 ? 'Concluida' : 'Marcada';
			if(isset($it->idInferm)){
				$it->details = base_url($this->nomeController()).'/details/'.$it->{$this->idTable()};
				$enf = $this->{$this->loadModel()}->get_count_from_table_where($it->idInferm, 'idInferm', 'consultaenfermeiro');
				if(isset($enf))
					$it->consultas = $enf.' consultas por fazer';
				else
					$it->consultas = 'Sem consultas';
			}
			if(isset($it->idUtente) && isset($it->idMedico) && $this->loadModel() != 'receita'){
				$enf = $this->{$this->loadModel()}->verificaSeEnf($it->idConsulta);
				$enfermeiroStr = '';
				if(isset($enf))
					foreach ($enf as $e)
						if($it->idConsulta == $e['idConsul']) {
							$enfermeiroStr .= $this->{$this->loadModel()}->getSome($e['idInferm'], 'idInferm', 'enfermeiro')['nome'].' ';
							$it->enfermeiro = $enfermeiroStr;
						}else
							$it->enfermeiro = '';
				else
					$it->enfermeiro = 'Sem enfermeiros';
				$verReceita = $this->{$this->loadModel()}->getSome($it->idConsulta, 'idConsulta', 'receita');
				if(isset($verReceita))
					$it->rec = 'Tem receita';
				else
					$it->rec = 'Não tem receita';
			}elseif (isset($it->idMed)){
				$it->details = base_url($this->nomeController()).'/details/'.$it->{$this->idTable()};
				$consultas = $this->{$this->loadModel()}->get_count_from_table_where($it->idMed, 'idMedico', 'consulta');
				if(isset($consultas))
					$it->cons = $consultas.' consultas por fazer';
				else
					$it->cons = 'Sem consultas';
			}elseif (isset($it->idUtente) && $this->loadModel() == 'utente'){
				$utentes = $this->{$this->loadModel()}->get_count_from_table_where($it->idUtente, 'idUtente', 'consulta');
				if(isset($utentes))
					$it->cons = $utentes.' consultas por fazer';
				else
					$it->cons = 'Sem consultas';
			}
		}
		return $items;
	}*/

	protected function setPassword($password, $item){
		$passwordHashed = $this->{$this->loadModel()}->mdPassword($item['password']);
		return $passwordHashed;
	}

	protected function setMorada($item){
		$morada = $this->{$this->loadModel()}->setSomeItem($item['idMorada'], 'morada', 'idMorada');
		return $morada['idMorada'];
	}


	private function verifyLogin(){
		return $this->users->isLoggedIn();
	}

	private function verifyPermissions(){
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
			$user['permissions'] = $this->serializePerm('consulta');
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
}
