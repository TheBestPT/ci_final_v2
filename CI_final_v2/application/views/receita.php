<?php
$this->load->view('comuns/header');
$this->load->view('comuns/menu')
?>

<?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<h1>{title}</h1>
<form enctype="multipart/form-data" method="post" action="{guardar}">
	{form}
		<label>{display}:</label>
		<input type="{element}" placeholder="{display}" name="{name}">
	{/form}
	<input type="hidden" name="idMedico" value={idMedico}>
	<input type="hidden" name="idUtente" value={idUtente}>
	<input type="hidden" name="idConsulta" value={idConsulta}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
<table>
	<thead>
		<th>IdReceita</th>
		<th>Receita</th>
		<th>Cuidado</th>
		<th>Produto</th>
		<th>Edição</th>
	</thead>
	<tbody>
		<tr>
			<td>{idReceita}</td>
			<td><a href="{download}">View</a></td>
			<td>{cuidado}</td>
			<td>{produto}</td>
			<td><a href="{del}">Del</a>&nbsp;&nbsp;
				<a href="{addprod}">Adicionar produtos</a></td>
		</tr>
	</tbody>
</table>
<p><a href="{voltar}">Voltar</a></p>
<?
$this->load->view('comuns/footer');
?>
