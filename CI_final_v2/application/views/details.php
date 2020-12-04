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
	<p>Nome: {nome}</p>
	<p>Nif: {nif}</p>
	<p>Nib: {nib}</p>
	<p>Especialidade: {especialidade}</p>
	<p>Morada: {morada}</p>
	<p>Username: {username}</p>
	<p>Email: {email}</p>
<a href="{back}">Voltar:</a>
<?
$this->load->view('comuns/footer');
?>
