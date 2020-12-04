<ul class="nav menu-nav">
	<li>
	<a class="active" href="<?=base_url()?>" >Home</a>
	</li>
	<li>
		<a href="<?=base_url('EnfermeiroController')?>" >Enfermeiro</a>
	</li>
	<li>
		<a href="<?=base_url('MedicoController')?>" >Medico</a>
	</li>
	<li>
		<a href="<?=base_url('UtenteController')?>" >Utentes</a>
	</li>
	<li>
		<a href="<?=base_url('ContatosController')?>" >Contatos</a>
	</li>
	<li>
		<a href="<?=base_url('ConsultaController')?>" >Consulta</a>
	</li>
	<?if($this->users->isLoggedIn()):?>
		<li>
			<a href="<?=base_url('ProdutoController')?>">Produtos</a>
		</li>
		<li>
			<a href="<?=base_url('UsersController')?>" >Users</a>
		</li>
	<?endif;?>
	<li>
		<?if(!$this->users->isLoggedIn()):?>
			<li style="float:right"><a class="active" href="<?= base_url('Login')?>">Login</a></li>
		<?else:?>
				<?$name  = $this->session->userdata('user');?>
			<li style="float:right"><a class="active" href="<?= base_url('Logout')?>">Logout: <?echo $name['username']?></a></li>
		<?endif;?>
	</li>
</ul>
