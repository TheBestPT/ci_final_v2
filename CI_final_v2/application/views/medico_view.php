<?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<h1>{title}</h1>
<table>
	<thead>
	<tr>
		<th>Nome</th>
		<th>Epecialidade</th>
	</tr>
	</thead>
	<tbody>
	{items}
		<tr>
			<td>{nome}</td>
			<td>{especialidade}</td>
		</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
