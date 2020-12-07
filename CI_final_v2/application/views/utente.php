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
<h1>Utente</h1>
<table>
	<thead>
	<tr>
		<th>Id</th>
		<th>Nome</th>
		<th>Numero Utente</th>
		<th>Morada</th>
		<th>Consultas</th>
		<th>Edicao</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{idUtente}</td>
		<td>{nome}</td>
		<td>{nUtente}</td>
		<td>{idMorada}</td>
		<td>{cons}</td>
		<td><a href="{del}">Del</a>
			&nbsp;&nbsp;<a href="{update}">Update</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
