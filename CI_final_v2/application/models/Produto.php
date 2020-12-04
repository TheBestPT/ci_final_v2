<?php
class Produto extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}

	public function setTable()
	{
		return 'produto';
	}

	public function setId()
	{
		return 'idProduto';
	}
}
