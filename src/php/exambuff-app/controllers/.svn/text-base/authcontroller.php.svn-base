<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EB_Controller should be used for any pages requiring authentication.
 *
 * Override logoutMessage to set custom logout reasons, redirections etc
 *
 */
class EB_Controller extends EB_Controller {
	const NO_TOKEN = 'no token';

	protected $_loginReason = "You need to login to access this page. Please login below.";
	protected $_sessionAuthVar = 'email';
	protected $_loginURL = '/user/login';
	protected $_flexOnly = false;
	protected $_flexFailURL = '';
	
	function EB_Controller() {
		parent::EB_Controller();
		if($this->authCheck() == false) { $this->logout(); }
	}
	protected function logout($viewData = null) {
		$this->session->sess_destroy();
		$this->session->set_flashdata('loginReason',$this->_loginReason);
		if(!$this->_flexOnly) $this->session->set_flashdata('referrer',$this->uri->uri_string());
		if(!$this->_flexOnly) redirect($this->_loginURL);
		redirect($this->_flexFailURL);
	}
	protected function authCheck() {
		if($this->_fbAuthorised == true) return true;
		if($this->session->userdata($this->_sessionAuthVar) == true) return true;
		return false;
	}
}