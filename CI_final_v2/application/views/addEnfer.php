<?php
$this->load->view('comuns/header');
$this->load->view('comuns/menu')
?>
<h1>Adcionar enfermeiros a consulta</h1>
<table>
	<thead>
	<tr>
		<th>Nome</th>
		<th>Edição</th>
	</tr>
	</thead>
	<tbody>
	{items}
	<tr>
		<td>{nome}</td>
		<td><a href="<?= base_url('ConsultaController/guardarAction/').$this->uri->segment(3);?>/{idInferm}">Adcionar</a>
			&nbsp;&nbsp;<a href="<?= base_url('ConsultaController/remAction/').$this->uri->segment(3);?>/{idInferm}">Del</a></td>
	</tr>
	{/items}
	</tbody>
</table>
<h1>Enfermeiros já adicionados</h1>
<p><b>{nome}</b></p>
<p><a href="{voltar}">Voltar</a></p>
<?
$this->load->view('comuns/footer');
?>
