<p>{form_error}</p>
<p>{form_sucess}</p>
<form method="post" action={guardar} enctype="multipart/form-data">
	{form}
		<label>{display}:</label>
		<input type="{element}" placeholder="{display}" name="{name}">
	{/form}
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
<h1>{title}</h1>
<table>
	<thead>
	<tr>
		<th>Id</th>
		<th>Descricao</th>
		<th>Preco</th>
		<th>Edicao</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{idProduto}</td>
		<td>{descricao}</td>
		<td>{preco}</td>
		<td><a href="{del}">Del</a>
			&nbsp;&nbsp;<a href="{update}">Update</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
