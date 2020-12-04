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
<table>
	<thead>
	<tr>
		<th>Medico</th>
		<th>Utente</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{idMedico}</td>
		<td>{idUtente}</td>
	</tr>
	{/items}
	</tbody>
</table>
<center>{links}</center>
<?
$this->load->view('comuns/footer');
?>
