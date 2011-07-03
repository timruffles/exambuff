<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('crud.php');
require_once('user.php');

class Activator extends Crud {
	public function Activator($codeIgniterDB = null) {
		parent::Crud($codeIgniterDB);
		$this->table = 'activations';
		$this->data = array('email'=>'',
							'activationKey'=>'');
		$this->key = 'activationKey';
	}
	public function activate($key) {
		if ($this->retrieve($key)) {
			$user = new User();
			if ($user->retrieve($this->get('email'))) {
				$user->activate();
				$this->delete();
				return true;
			}
		}
		return false;
	}
	public function generateKey() {
		$this->load->helper('string');
		$this->set('activationKey',random_string('alnum',12));
	}
}