<?php
require_once('account.php');
class ControlAccount extends Account {
	
	protected $_salt = '3000ilik""30f00888x8fe££!"£/*fe';
	
	public function ControlAccount($codeIgniterDb = null) {
		$data = array('name'=>'',							
					  'email'=>'',
					  'password'=>'');
		parent::Account($codeIgniterDb,$data);
		$this->table = 'admins';
		$this->key = 'email';
	}
}