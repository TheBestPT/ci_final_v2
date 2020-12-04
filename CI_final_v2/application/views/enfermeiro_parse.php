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
<form method="post" action={guardar} enctype="multipart/form-data">
	{form}
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
<h1>Enfermeiro</h1>
<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Nome</th>
			<th>Nif</th>
			<th>Nib</th>
			<th>Epecialidade</th>
			<th>Morada</th>
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
				<td><a href="<?= base_url('EnfermeiroController/del')?>/{idInferm}">Del</a>
					&nbsp;&nbsp;<a href="<?= base_url('EnfermeiroController/editar/')?>{idInferm}">Update</a></td>
			</tr>
		{/items}
	</tbody>
</table>
<center>{links}</center>
<?
$this->load->view('comuns/footer');
?>
