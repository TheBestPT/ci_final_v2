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
				$ver = $this->{$this->loadModel()}->getSome($item['idConsulta'], 'idConsulta', 'receita');
				$red = $this->nomeController().'/'.$item['idConsulta'];
				if ($this->upload->do_upload('receita'))
					$data = array('upload_data' => $this->upload->data());
				$item['receita'] = $data['upload_data']['file_name'];
				if(isset($ver)) {
					redirect($this->nomeController().'/'.$item['idConsulta'], 'refresh');
					$this->session->set_flashdata('error', 'Não pode ter mais que uma receita');
				}
				return $item;
			case 'del':
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
		print_r($items);
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

	public function guardarAction()
	{
		return null;
	}

	public function remAction()
	{
		return null;
	}
}
