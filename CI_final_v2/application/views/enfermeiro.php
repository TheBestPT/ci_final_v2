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
		<th>Nome</th>
		<th>Nif</th>
		<th>Nib</th>
		<th>Epecialidade</th>
		<th>Morada</th>
		<th>Consultas</th>
		<th>Edicao</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{idInferm}</td>
		<td>{nome}</td>
		<td>{nif}</td>
		<td>{nib}</td>
		<td>{especialidade}</td>
		<td>{idMorada}</td>
		<td>{consultas}</td>
		<td><a href="{del}">Del</a>
			&nbsp;&nbsp;<a href="{update}">Update</a>&nbsp;&nbsp;
			<a href="{details}">Details</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
