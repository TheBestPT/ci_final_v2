<?php
class ReceitaController extends MY_Controller{

	public function loadModel()
	{
		return 'receita';
	}

	public function titleName()
	{
		return 'Receita';
	}

	public function verification()
	{
		$rules['cuidado'] = array('trim', 'required', 'min_length[1]');
		$this->form_validation->set_rules('cuidado', 'Cuidado', $rules['cuidado']);
		return $this->form_validation->run();
	}

	public function nomeController()
	{
		return $this->titleName().'Controller';
	}

	public function idTable()
	{
		return 'idReceita';
	}

	public function form()
	{
		return ['receita' => ['display' => 'Receita', 'element' => 'file', 'name' => 'receita'], 'cuidado' => ['display' => 'Cuidado', 'element' => 'text', 'name' => 'cuidado']];
	}

	public function permissions()
	{
		return 'consulta';
	}

	public function irregularItems($item, $what, $id)
	{
		switch ($what){
			case 'guardar':
				$this->red = $this->nomeController().'/'.$item['idConsulta'];
				$ver = $this->{$this->loadModel()}->getSome($item['idConsulta'], 'idConsulta', 'receita');
				if ($this->upload->do_upload('receita'))
					$data = array('upload_data' => $this->upload->data());
				$item['receita'] = $data['upload_data']['file_name'];
				if(isset($ver)) {
					$this->session->set_flashdata('error', 'Não pode ter mais que uma receita');
					redirect($this->nomeController().'/'.$item['idConsulta'], 'refresh');
				}
				return $item;
			case 'del':
				$this->red = $this->nomeController().'/'.$item['idConsulta'];
				$this->{$this->loadModel()}->delItem('idReceita', $item['idReceita'], 'carrinho');
				return $item;
			default:
				return $item;
		}
	}

	public function indexConf($id)
	{
		$items = $this->{$this->loadModel()}->getSome($id, 'idConsulta', 'receita');
		$dados = $this->{$this->loadModel()}->getSome($id, 'idConsulta', 'consulta');
		$this->red .= '/'.$id;
		if(isset($items['idReceita'])){
			$enf = $this->{$this->loadModel()}->verificaSeProd($items['idReceita']);
			$enfermeiroStr = '';
			if(isset($enf))
				foreach ($enf as $e)
					if($items['idReceita'] == $e['idReceita']) {
						$enfermeiroStr .= $this->{$this->loadModel()}->getSome($e['idProduto'], 'idProduto', 'produto')['descricao'].' ';
						$items['produto'] = $enfermeiroStr;
					}else
						$items['produto'] = '';
			else
				$items['produto'] = 'Sem produtos';
		}
		$form_error = $this->session->flashdata('error') == TRUE ? $this->session->flashdata('error') : null;
		$form_sucess = $this->session->flashdata('success') == TRUE ? $this->session->flashdata('success') : null;
		$data = [
			'title' => $this->titleName(),
			'idReceita' => $items['idReceita'],
			'receita' => $items['receita'],
			'cuidado' => $items['cuidado'],
			'idMedico' => $dados['idMedico'],
			'idUtente' => $dados['idUtente'],
			'produto' => $items['produto'],
			'download' => base_url('uploads/').$items['receita'],
			'idConsulta' => $id,
			'voltar' => base_url('ConsultaController'),
			'form' => $this->form(),
			'guardar' => base_url($this->nomeController()).'/guardar',
			'del' => base_url($this->nomeController()).'/del/'.$items['idReceita'],
			'addprod' => base_url($this->nomeController()).'/addAction/'.$items['idReceita'],
			'form_error' => $form_error,
			'form_sucess' => $form_sucess
		];
		return $data;
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
		$id = $this->uri->segment(3);
		$items = $this->{$this->loadModel()}->getAllByTable('produto', true);
		$back = $this->{$this->loadModel()}->getSome($id, 'idReceita', 'receita');
		$produtoStr = $this->verificaEnfProf($id, 'idProduto', 'idReceita', 'produto', 'descricao');
		foreach ($items as $it){
				$it->add = base_url('ProdutoController/guardarAction/').$id.'/'.$it->idProduto;
			$it->del = base_url('ProdutoController/remAction/').$id.'/'.$it->idProduto;
		}
		$data = [
			'title' => $this->titleName(),
			'items' => $items,
			'nome' => $produtoStr,
			'voltar' => base_url('ReceitaController').'/'.$back['idConsulta'],
			'idCon' => base_url($this->nomeController().'/guardarEnf/').$id,
			'guardar' => base_url($this->nomeController().'/guardarEnf')
		];
		$this->parser->parse('comuns/header', $i = ['title' => 'Adicionar Enfermeiros']);
		$this->loadMenu(true);
		$this->parser->parse('addProd', $data);
		$this->load->view('comuns/footer');

	}

	public function guardarAction()
	{
		return null;
	}

	public function remAction()
	{
		return null;
	}

	public function editarData()
	{
		return null;
	}
}
