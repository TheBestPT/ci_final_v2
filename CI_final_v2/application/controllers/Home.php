<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [
			'title' => 'Home'
		];
		$menu = $this->users->isLoggedIn() ? menuArray() : menuWithoutPerm();
		$this->parser->parse('comuns/header', $data);
		$this->parser->parse('comuns/menu', $menuLi = [
			'menu' => $menu,
			'home' => base_url(),
			'urlLogin' => $this->users->isLoggedIn() ? base_url('Logout') : base_url('Login'),
			'urlBtn' => $this->users->isLoggedIn() ? 'Logout: '.$this->session->userdata('user')['username'] : 'Login'
		]);
		$this->parser->parse('home', $data);
		$this->load->view('comuns/footer');
	}
}
