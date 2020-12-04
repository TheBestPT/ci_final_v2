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
<form action="{guardar}" method="post" enctype="multipart/form-data">
	{form}
		<label>{display}:</label>
		<input type="{element}" placeholder="{display}" name="{name}">
	{/form}
	<select name="">
		{utentes}
			<option value="{value}">{display}</option>
		{/utentes}
	</select>
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
		<th>Data</th>
		<th>Estado</th>
		<th>Utente</th>
		<th>Medico</th>
		<th>Enfermeiros</th>
		<th>Receita</th>
		<th>Edicao</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{idConsulta}</td>
		<td>{data}</td>
		<td>{estado}</td>
		<td>{idUtente}</td>
		<td>{idMedico}</td>
		<td>{enfermeiro}</td>
		<td>{rec}</td>
		<td><a href="{del}">Del</a>
			&nbsp;&nbsp;<a href="{update}">Editar</a>
			&nbsp;&nbsp;<a href="<?= base_url('ConsultaController/muda/')?>{idConsulta}">Muda de estado (Concluido ou marcada)</a>
			&nbsp;&nbsp;<a href="<?= base_url('ConsultaController/addEnf/')?>{idConsulta}">Adicionar Enf</a>
			&nbsp;&nbsp;<a href="<?= base_url('ReceitaController/')?>{idConsulta}">Adicionar Receita</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<center><?echo $links;?></center>
<?
$this->load->view('comuns/footer');
?>
