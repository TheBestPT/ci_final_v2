<?php
class Medico extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function setTable()
	{
		return 'medico';
	}

	public function setId()
	{
		return 'idMed';
	}
}
