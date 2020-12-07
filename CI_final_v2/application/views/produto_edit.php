<form method="post" action={guardar} enctype="multipart/form-data">
	<label>Descricao:</label>
	<input type="text" placeholder="Descricao..." name="descricao" value="{descricao}">
	<label>Preco:</label>
	<input type="text" placeholder="Preco..." name="preco" value="{preco}">
	<input type="hidden" name={idItem} value={id}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
