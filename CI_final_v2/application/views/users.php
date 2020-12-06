<?php if ($this->session->flashdata('error') == TRUE): ?>
	<p><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php if ($this->session->flashdata('success') == TRUE): ?>
	<p><?php echo $this->session->flashdata('success'); ?></p>
<?php endif; ?>
<form method="post" action={guardar} enctype="multipart/form-data">
	{form}
		<label>{display}:</label>
		<input type="{element}" placeholder="{display}" name="{name}">
	{/form}
	<div>
		<label><em>Todos os campos são obrigatórios.</em></label>
		<input type="submit" value="Save"/>
	</div>

</form>
<h1>Users</h1>
<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Email</th>
			<th>Full Name</th>
			<th>Papel</th>
			<th>Permissions</th>
			<th>Edicao</th>
		</tr>
	</thead>
	<tbody>
		{items}
			<tr>
				<td>{idUser}</td>
				<td>{username}</td>
				<td>{email}</td>
				<td>{fullname}</td>
				<td>{papel}</td>
				<td>{permissions}</td>
				<td><a href="{del}">Del</a>
					&nbsp;&nbsp;<a href="{update}">Update</a></td>
			</tr>
		{/items}
	</tbody>
</table>
<center>{links}</center>
