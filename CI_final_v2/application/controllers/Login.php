<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    private $data;
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('text','string','url'));
        $this->load->library(array('form_validation','session'));
        $this->load->model('users');
    }
    
	public function login()	{
	    if($this->users->isLoggedIn()) { redirect(base_url('home')); }
	    $this->form_validation->set_rules('username','user','required');
	    $this->form_validation->set_rules('password','senha','required');
	    
	    if($this->form_validation->run()){
	        $username = $this->input->post('username');
	        $password = $this->input->post('password');
	        if($user = $this->users->getByUsername($username)){
	            if($this->users->checkPassword($password,$user['password'])){
	                $this->users->createSession($user);
	                redirect(base_url('home'));
					//$this->load->view()
	            }else
	                $this->data['login_error'] = 'Palavra-passe incorreta';
	        }else 
	            $this->data['login_error'] = 'User n�o exite';
	    }
	    $this->data['title'] = 'Login';
		$this->parser->parse('comuns/header', $i = ['title' => 'Login']);
		$this->parser->parse('comuns/menu', $menuLi = [
			'menu' => menuWithoutPerm(),
			'home' => base_url(),
			'urlLogin' => $this->users->isLoggedIn() ? base_url('Logout') : base_url('Login'),
			'urlBtn' => $this->users->isLoggedIn() ? 'Logout: '.$this->session->userdata('user')['username'] : 'Login'
		]);
	    $this->load->view('login',$this->data);
		$this->load->view('comuns/footer');
	}	
	
	public function logout(){
	    session_destroy();
	    $this->data['login_success'] = 'logout com sucesso!!!';
		$this->data['title'] = 'Login';
		$this->parser->parse('comuns/header', $i = ['title' => 'Login']);
		$this->parser->parse('comuns/menu', $menuLi = [
			'menu' => menuWithoutPerm(),
			'home' => base_url(),
			'urlLogin' => $this->users->isLoggedIn() ? base_url('Logout') : base_url('Login'),
			'urlBtn' => $this->users->isLoggedIn() ? 'Logout: '.$this->session->userdata('user')['username'] : 'Login'
		]);
	    $this->load->view('login',$this->data);
		$this->load->view('comuns/footer');
	}
	
}// controller Login

