<?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<form method="post" action={guardar} enctype="multipart/form-data">
	<label>Nome:</label>
	<input type="text" placeholder="Nome..." name="nome" value="{nome}">
	<label>Numero Utente:</label>
	<input type="text" placeholder="Nº Utente..." name="nUtente" value="{nUtente}">
	<label>Morada:</label>
	<input type="text" placeholder="Morada..." name="idMorada" value="{idMorada}">
	<input type="hidden" name={idItem} value={id}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
