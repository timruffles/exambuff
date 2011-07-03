<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('crud.php');
class MarkerPref extends Crud {
	function MarkerPref() {
		parent::Crud();
		$this->table = 'markers';
		$this->data = array('email'=>'',
							'alertThreshold'=>'',
							'alertSubjects'=>'',
							'alertMax'=>'',
							'jobMin'=>'',
							'alertTime'=>'');
		$this->key = 'email';
	}
	function set($key,$value) {
		if($key === 'alertSubjects') $value = serialize($value);
		return Crud::set($key,$value);
	}
	function get($key) {
		if($key === 'alertSubjects'){ return unserialize($this->data['alertSubjects']); }
		return Crud::get($key);
	}
}