<?php

class UserFile extends Model{

	protected $table = 'user_files';
	protected $id = 'id';

	public function __construct()
	{
		parent::__construct();
	}
}