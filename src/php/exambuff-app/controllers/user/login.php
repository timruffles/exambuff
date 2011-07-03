<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('../exambuff/controllers/EB_Login.php');
/**
 * Handles logins
 * @todo sort out the logout link in language file - needs a nice way of working
 */
class Login extends EB_Login {
	// the session variable which stores the user's account key
	protected $_sessionAuthVar = 'email';
	// the model which stores and checks user data on teh database
	protected $_userModel = 'user';
	// successfully logged in users will be redirected here
	protected $_successURL = '/user';
	// users attempting to log in when already logged in will be redirected here
	protected $_alreadyAuthURL = '/user/login/alreadyLoggedIn';
	// location of this file, to allow redirections to functions
	protected $_selfURL = '/user/login';
}