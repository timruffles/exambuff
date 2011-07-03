<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('crud.php');
/**
 * Abstract class which provides the basic password checking and brute force protection.
 * 
 */
abstract class Account extends Crud {
	const FAIL_WRONG_PASSWORD = 'bad pass';
	const FAIL_TOO_MANY_ATTEMPTS = 'too many';
	const SUCCESS = 'login';
	/**
	 * Creates a new account, requiring a normal CRUD data array to ensure that the base db columns
	 * are added.
	 * 
	 * @param $codeIgniterDb
	 * @param $data pass a normal CRUD data array here instead of defining it in the constructor
	 * @return unknown_type
	 */
	public function Account($codeIgniterDb = null,$data) {
		parent::Crud($codeIgniterDb);
		$this->data = array_merge(array('failedLogins'=>'',
										'lastLoggedIn'=>'',
										'passwordResetKey'=>''),$data);
	}
	public function buildFromPost() {
		parent::buildFromPost();
		$this->data['password'] = $this->makePass($this->input->post('password'));
	}
	public function makePass($plainText) {
		return sha1($plainText.$this->_salt);
	}
	/**
	 * Makes a login attempt on a user with a supplied password. Returns true on success, or one of the
	 * Account fail constants on failure.
	 * 
	 * @param $pass
	 * @return true or one of Account fail constants
	 */
	public function loginAttempt($pass) {
		if(!$this->accountSecure()) return Account::FAIL_TOO_MANY_ATTEMPTS;
		if(sha1($pass.$this->_salt)===$this->get('password')) {
			$this->set('lastLoggedIn',time());
			$this->set('failedLogins',1);
			$this->update();
			return Account::SUCCESS;
		}
		// legacy support for users pre-salt		
		if(get_class($this) === 'User' 
		   && in_array($this->getKey(),array('kukydan_83@yahoo.com','versha.prakash@gmail.com','qing.wang@rhul.ac.uk','a.chhatwal@rhul.ac.uk'))
		   && sha1($pass)===$this->get('password')) {
			return Account::SUCCESS;
		}
		$this->failed();
		return Account::FAIL_WRONG_PASSWORD;
	}
	/**
	 * Creates a random reset key and updates the model
	 * @return $key String
	 */
	public function createPasswordResetKey() {
		$key = substr(md5('4909WErsalty'.rand(0,100)),rand(0,4),16);
		$this->set('passwordResetKey',$key);
		$this->update();
		return $key;
	}
	/**
	 * Searches account table for a given reset key; if found, loads the primary key into the model
	 * and returns true.
	 * @return boolean - if found or not
	 */
	public function findByResetKey($key) {
		$sql = "SELECT * from $this->table WHERE passwordResetKey=? LIMIT 1";
		$query = $this->db->query($sql,array($key));
		if($query->num_rows()===1) {
			$resultAssoc = $query->result_array();
			$key = $resultAssoc[0][$this->key];
			$this->setKey($key);
			return true;
		}
		return false;
	}
	/**
	 * Confirms whether the account is currently secure - if it looks as if a brute force attack
	 * is being carried out, this will return false
	 * 
	 * @return boolean 
	 */
	private function accountSecure() {
		if($this->get('failedLogins')>5) return false;
		return true;
	}
	private function failed() {
		if(!$this->data['failedLogins']) $this->data['failedLogins'] = 1;
		$this->data['failedLogins']++;
		$this->update();
	}
}