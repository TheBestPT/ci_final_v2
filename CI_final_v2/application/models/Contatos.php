<?php
class Contatos extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function setTable()
	{
		return 'contatos';
	}

	public function setId()
	{
		return 'id';
	}
}
