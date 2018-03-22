<?php

class Database {
	private $db_server = 'localhost';
	private $db_user = 'eastmanf_web';
	private $db_password = 'webuser123!';
	private $db_name = 'eastmanf_home';
	public $mysqli = null;

	public function __construct() {
		$this->mysqli = new mysqli($this->db_server, $this->db_user, $this->db_password, $this->db_name);
	
		if ($this->mysqli->connect_error) {
			die('Connect Error (' . $this->mysqli->connect_errno . ') '
					 . $this->mysqli->connect_error);
		}
	}
	
}