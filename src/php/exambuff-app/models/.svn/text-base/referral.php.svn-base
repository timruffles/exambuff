<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('crud.php');
class Referral extends Crud {
	function Referral($codeIgniterDB=null) {
		parent::Crud($codeIgniterDB);
		$this->data = array('user'=>'',
							'referee'=>'',
							'ipRequested'=>'',
							'paypalRef'=>'');
		$this->table = 'referrals';
		$this->key = 'referee';
	}
	function paid($paymentID,$ip) {
		$this->set('paypalRef',$paymentID);
		$this->set('ipRequested',$ip);
		$this->update();
	}
}