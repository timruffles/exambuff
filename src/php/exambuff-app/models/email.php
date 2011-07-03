<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Email extends Crud {
	const SENT = 'sent';
	const FAILED = 'failed';
	/*
	 * Marks relate to scripts on a one-to-one basis, and therefore they share
	 * a primary key: the ID field of script, thus script.ID = mark.script
	 *
	 * @param unknown_type $codeIgniterDb
	 * @return Mark
	 */
	public function Email($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('ID'=>'',
						    'sender'=>'',
							'receiver'=>'',
							'subject'=>'',
							'message'=>'',
							'error'=>'',
							'status'=>'');
		$this->table = 'emails';
		$this->key = 'ID';
	}
}