<h1>{title}</h1>
<table>
	<thead>
	<tr>
		<th>Id</th>
		<th>Nome</th>
		<th>Email</th>
		<th>Mensagem</th>
		<th>Edicao</th>
	</tr>
	</thead>
	<tbody>
	{items}
			<tr>
				<td>{id}</td>
				<td>{nome}</td>
				<td>{email}</td>
				<td>{mensagem}</td>
				<td><a href="{del}">Del</a></td>
			</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
