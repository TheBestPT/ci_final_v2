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
		$this->parser->parse('comuns/header', $data);
		$this->load->view('comuns/menu');
		$this->parser->parse('home', $data);
		$this->load->view('comuns/footer');
	}
}
