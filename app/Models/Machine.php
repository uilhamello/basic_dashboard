<?php

class Machine extends Model{

	protected $table = 'machines';
	protected $id = 'id';

	public function __construct()
	{
		parent::__construct();
	}
}