<?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<form action="{guardar}" method="post" enctype="multipart/form-data">
	<label>Data:</label>
	<input type="text" placeholder="Data..." name="data" value="{data}">
	<select name="idUtente">
		{utentes}
			<option value="{value}">{display}</option>
		{/utentes}
	</select>
	<select name="idMedico">
		{medicos}
		<option value="{value}">{display}</option>
		{/medicos}
	</select>
	<input type="hidden" name={idItem} value={id}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>

</form>
