<?php
$this->load->view('comuns/header');
$this->load->view('comuns/menu')
?>
<h1>Adcionar podutos à receita</h1>
<table>
	<thead>
	<tr>
		<th>Nome</th>
		<th>Edição</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{descricao}</td>
		<td><a href="<?= base_url('ProdutoController/guardarEnf/').$this->uri->segment(3);?>/{idProduto}">Adcionar</a>
			&nbsp;&nbsp;<a href="<?= base_url('ProdutoController/remEnf/').$this->uri->segment(3);?>/{idProduto}">Del</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<h1>Produtos já adicionados</h1>
<p><b>{nome}</b></p>
<p><a href="{voltar}">Voltar</a></p>
<?
$this->load->view('comuns/footer');
?>
