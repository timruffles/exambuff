<?php
require_once 'crud.php';
class Ticket extends Crud {
	public function Ticket($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('ID'=>'',
						    'email'=>'',
							'subject'=>'',
							'message'=>'');
		$this->table = 'tickets';
		$this->key = 'ID';
	}
	public function keyForEmail() {
		return 'EBST'.str_pad($this->getKey(),6,'0',STR_PAD_LEFT);	
	}
	public function keyFromEmail($email) {
		return preg_replace('/^0*/','',str_replace('EBST','',$email));
	}
}