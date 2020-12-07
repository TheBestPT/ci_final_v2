<form method="post" action={guardar} enctype="multipart/form-data">
	<label>Nome:</label>
	<input type="text" placeholder="Nome..." name="nome" value="{nome}">
	<label>Nif:</label>
	<input type="text" placeholder="Nif..." name="nif" value="{nif}">
	<label>Nib:</label>
	<input type="text" placeholder="Nib..." name="nib" value="{nib}">
	<label>Especialidade:</label>
	<input type="text" placeholder="Especialidade..." name="especialidade" value="{especialidade}">
	<label>Especialidade:</label>
	<input type="text" placeholder="Especialidade..." name="especialidade" value="{especialidade}">
	<label>Morada:</label>
	<input type="text" placeholder="Morada..." name="idMorada" value="{idMorada}">
	<label>Username:</label>
	<input type="text" placeholder="Username..." name="username" value="{username}">
	<label>Fullname:</label>
	<input type="text" placeholder="Fullname..." name="fullname" value="{fullname}">
	<label>Email:</label>
	<input type="text" placeholder="Email..." name="email" value="{email}">
	<label>Password:</label>
	<input type="password" placeholder="Password..." name="password">
	<input type="hidden" name={idItem} value={id}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
