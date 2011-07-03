<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Payment extends Crud {
	public function Payment($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('ID'=>'',
						    'user'=>'',
							'amount'=>'',
							'method'=>'',
							'scripts'=>'',
							'transactionID'=>'');
		$this->table = 'payments';
		$this->key = 'ID';

	}
	const PAYPAL = 'paypal';
	const DIRECT= 'direct';
	function set($key,$value) {
		if($key === 'method' && $value != Payment::PAYPAL && $value !=  Payment::DIRECT) throw new Exception('Payment method must be either Paypal or Direct');
		if($key === 'amount' && !is_numeric($value)) throw new Exception('Amount must be numeric');
		if($key === 'scripts' && !is_array($value)) $value = array($value);
		if($key === 'scripts') $value = serialize($value);
		return Crud::set($key,$value);
	}
	function get($key) {
		if($key === 'scripts'){ return unserialize($this->data['scripts']); }
		return Crud::get($key);
	}
	/**
	 * Creates payment on DB
	 * 
	 * @param $user
	 * @param $scripts
	 * @param $method
	 * @param $amount
	 * @return unknown_type
	 */
	public function paid($user,$scripts,$method,$amount,$transactionID) {
		$this->set('user',$user);
		$this->set('scripts',$scripts);
		$this->set('method',$method);
		$this->set('amount',$amount);
		$this->set('transactionID',$transactionID);
		if($this->create()) {
			return true;
		} else {
			return false;
		}
	}
}