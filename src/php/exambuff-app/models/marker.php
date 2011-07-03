<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('account.php');
class Marker extends Account {
	
	const TUTOR = 'tutor';
	const AUTHENTICATED = 'authenticated';
	
	protected $_salt =  '^5oo4£42';
	
	function Marker($ciDB=null) {
		$data = array('name'=>'',
							'username'=>'',
							'email'=>'',
							'subject'=>'',
							'institution'=>'',
							'password'=>'',
							'status'=>'',
							'phdStatus'=>'',
							'studentNum'=>'');
		parent::Account($ciDB,$data);
		$this->table = 'markers';
		$this->key = 'email';
	}
	/**
	 * Checks whether a marker's PhD student status has been confirmed
	 * @return 
	 */
	function isPHD() {
		if($this->get('phdStatus') == Marker::AUTHENTICATED) return true;
		return false;
	}
	/**
	 * Check whether a marker has passed the tutor test, and has been accepted
	 * as a tutor
	 * @return bool
	 */
	function isTutor() {
		if($this->get('status') == Marker::TUTOR) return true;
		return false;
	}
	/**
	 * Mark this marker account as one which has had their PhD status authenticated 
	 */
	function authenticatePhDStatus() {
		$this->set('phdStatus',Marker::AUTHENTICATED);
	}
	/**
	 * Make this marker's account into a full tutor account
	 */
	function makeTutor() {
		$this->set('status',Marker::TUTOR);
	}
}