<form method="post" action={guardar} enctype="multipart/form-data">
	<label>Username:</label>
	<input type="text" placeholder="Username..." name="username" value="{username}">
	<label>Fullname:</label>
	<input type="text" placeholder="Fullname..." name="fullname" value="{fullname}">
	<label>Email:</label>
	<input type="text" placeholder="Email..." name="email" value="{email}">
	<label>Password:</label>
	<input type="password" placeholder="Password..." name="password">
	<label>Permissions:</label>
	<input type="text" placeholder="Permissions..." name="permissions" value="{permissions}">
	<input type="hidden" name={idItem} value={id}>
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>
</form>
