<p>{form_error}</p>
<p>{form_sucess}</p>
<h3>Aqui pode deixar uma menasagem para nos ajudar a melhorar!!!!!!!!</h3>
<form method="post" action="{guardar}" enctype="multipart/form-data">
	{form}
		<label>{display}:</label>
		<input type="{element}" placeholder="{display}" name="{name}">
	{/form}
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
