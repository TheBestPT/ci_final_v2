<?php
class Utente extends MY_Model {
	public function __construct()
	{
		parent::__construct();
	}


	public function setTable()
	{
		return 'utente';
	}

	public function setId()
	{
		return 'idUtente';
	}
}
