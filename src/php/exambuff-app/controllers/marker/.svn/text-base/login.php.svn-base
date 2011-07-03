<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('../exambuff/controllers/EB_Login.php');
/**
 * Handles logins
 * @todo sort out the logout link in language file - needs a nice way of working
 */
class Login extends EB_Login {
	// the session variable which stores the user's account key
	protected $_sessionAuthVar = 'markerEmail';
	// the model which stores and checks user data on teh database
	protected $_userModel = 'marker';
	// successfully logged in users will be redirected here
	protected $_successURL = '/marker';
	// users attempting to log in when already logged in will be redirected here
	protected $_alreadyAuthURL = '/marker/login/alreadyLoggedIn';
	// location of this file, to allow redirections to functions
	protected $_selfURL = '/marker/login';
	
	const FLEX_LOGIN = 'flex login';
	const FLEX_FAIL = 'flex fail';
	
	const NOT_LOGGED_IN = 'NOT LOGGED IN';
	
	public function flexLogin() {
		// store all flavours of user model in $this->user - so marker, control etc will all
		// go under $this->user, as they all implement the same interface
		$this->load->model($this->_userModel,'user');
		
		// does the account exsist
		
		$loginEmail = $this->input->post(EB_Login::FORM_EMAIL_FIELD);
		
		if(!$this->user->retrieve($loginEmail)) {
			$this->_flexFail();
			return;
		}
		// does the password match, and is everything good with the account
		if (($loginResult = $this->user->loginAttempt($this->input->post(EB_Login::FORM_PASSWORD_FIELD)))===Account::SUCCESS) {
			// login user
			$this->_setUser($loginEmail);
			$this->_flexLogin();
			return;
		}
		$this->_flexFail();
	}
	// redirect target for markerAuth _flexFailURL()
	public function flexFail() {
		$this->_flexResult(Login::NOT_LOGGED_IN);
	}
	private function _flexFail() {
		$this->_flexResult(Login::FLEX_FAIL);
	}
	private function _flexLogin() {
		$this->_flexResult(Login::FLEX_LOGIN);
	}
}