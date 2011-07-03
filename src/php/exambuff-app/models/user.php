<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('account.php');
/**
 * 
 * @author tim
 *
 */
class User extends Account {
	
	const ACTIVE = 'active';
	const INACTIVE = 'inactive'; 
	const EARLY = 'early';
	
	const FB_CONNECT = 'fbConnect';
	const EMAIL = 'email';
	
	protected $_salt = '$^090f49ua984/*fe';
	private $fbDataLoaded = false;
	
	public function User($codeIgniterDb = null) {
		$data = array('UID'=>'',
					  'name'=>'',							
				      'subject'=>'',
					  'institution'=>'',
					  'password'=>'',
				      'accountActive'=>'',
					  'type'=>'',
					  'fbEmail'=>'',
					  'fbProfilePic'=>'');
		parent::Account($codeIgniterDb,$data);
		$this->table = 'users';
		$this->key = 'UID';
	}
	function get($key) {
		if($key == 'institution' && $this->data['type']===User::FB_CONNECT) return $this->fbInstitution();
	}
	function activate() {
		$this->data['accountActive'] = User::ACTIVE;
		$this->update();
	}
	function getType() {
		return $this->data['type'];
	}
	function setType($type) {
		if($type !== User::FB_CONNECT && $type !== User::EMAIL) throw new Exception ('Not a valid type');
		$this->data['type'] = $type;		
	}
	function fbEmail($onOff) {
		if($onOff != 1 && $onOff != 0) throw new Exception('fbEmail is boolean');
		$this->data['fbEmail'] = $onOff;
	}
	/**
	 * Gets the institution from the FB server, if not already set
	 * @return unknown_type
	 */
	function institution() {
		if(($d = $this->data['institution']) != '') return $d;
		$this->load->library('facebook');
		if($resArray = $this->facebook->api_client->users_getInfo($this->getKey(), array('affiliations'))) {
			$affil = $resArray[0]['affiliations'];
			for($i=0; $i<count($affil);$i++) {
				if($affil[$i]['type'] === 'college' || $affil[$i]['type'] === 'high school') {
					$network = $affil[$i]['name'];
					break;
				}
				if($i==count($affil)-1) $network = $affil[0]['name'];
			}
			$this->data['institution'] = $network;
			$this->fbDataLoaded = true;
			return $network;
		}
		return false;
	}
	function name(){
		if(($d = $this->data['name']) != '') return $d;
		$this->load->library('facebook');
		if($resArray = $this->facebook->api_client->users_getInfo($this->getKey(), array('name'))) {
			$this->data['name'] = $resArray[0]['name'];
			$this->fbDataLoaded = true;
			return $this->data['name'];
		}
		return false;
	}
	function subject() {
		if(($d = $this->data['subject']) != '') return $d;
		$this->load->library('facebook');
		if($resArray = $this->facebook->api_client->users_getInfo($this->getKey(), array('education_history'))) {
			if(!@$subject = @$resArray[0]['education_history']['degree']) return false;
			$this->data['subject'] = $subject;
			$this->fbDataLoaded = true;
			return $subject;
		}
		return false;
	}
	/**
	 * Just to speed things up, if data has been loaded from FB store it.
	 * @return unknown_type
	 */
	function __destruct() {
		if($this->fbDataLoaded) $this->update();
	}
}