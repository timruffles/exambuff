<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Wage extends Crud {
	public function Wage($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('ID'=>'',
						    'marker'=>'',
							'amount'=>'',
							'scripts'=>'');
		$this->table = 'wages';
		$this->key = 'ID';
	}
	function set($key,$value) {
		if($key === 'scripts' && !is_array($value)) $value = array($value);
		if($key === 'scripts') $value = serialize($value);
		if($key === 'amount' && !is_numeric($value)) throw new Exception('Value of wage needs to be numeric');
		return Crud::set($key,$value);
	}
	function get($key) {
		if($key === 'scripts'){ return unserialize($this->data['scripts']); }
		return Crud::get($key);
	}
	function paid($marker,$amount,$scripts) {
		$this->set('marker',$marker);
		$this->set('amount',$amount);	
		$this->set('scripts',$scripts);			
	}
}
