<?php
define('ERROR_MSG', 'Não foi possível inserir o item.');
define('SUCESS_MSG', 'Item inserido com sucesso.');
define('REMOVE_MSG', 'Item eliminado');
function menuArray(){
	return ['enfermeiro' => ['url' => base_url('EnfermeiroController'), 'display' => 'Enfermeiro'], 'medico' => ['url' => base_url('MedicoController'), 'display' => 'Medico'], 'utente' => ['url' => base_url('UtenteController'), 'display' => 'Utente'], 'contatos' => ['url' => base_url('ContatosController'), 'display' => 'Contatos'], 'consulta' => ['url' => base_url('ConsultaController'), 'display' => 'Consulta'], 'produto' => ['url' => base_url('ProdutoController'), 'display' => 'Produtos'], 'users' => ['url' => base_url('UsersController'), 'display' => 'Users']];
}

function menuWithoutPerm(){
	$menu = menuArray();
	unset($menu['users'], $menu['produto']);
	return $menu;
}
