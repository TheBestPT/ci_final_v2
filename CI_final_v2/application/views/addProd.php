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
		<td><a href="<?= base_url('ProdutoController/guardarAction/').$this->uri->segment(3);?>/{idProduto}">Adcionar</a>
			&nbsp;&nbsp;<a href="<?= base_url('ProdutoController/remAction/').$this->uri->segment(3);?>/{idProduto}">Del</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<h1>Produtos já adicionados</h1>
<p><b>{nome}</b></p>
<p><a href="{voltar}">Voltar</a></p>
