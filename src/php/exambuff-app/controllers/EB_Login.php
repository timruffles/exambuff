<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Base class for all login classes - allows all models that implement the user interface
 * to be used as auth_controller users
 * 
 * @param session_flashdata('loginReason') - string displayed to user to explain why they need to login
 * @param session_flashdata('referrer') - url where users who've successfully logged in will be redirected to
 */
class EB_Login extends EB_Controller {
	// the session variable which stores the user's account key
	protected $_sessionAuthVar;
	// the model which stores and checks user data on teh database
	protected $_userModel;
	// successfully logged in users will be redirected here
	protected $_successURL;
	// users attempting to log in when already logged in will be redirected here
	protected $_alreadyAuthURL;
	// location of this file, to allow redirections to functions, without trailing slashes
	protected $_selfURL;
	
	// don't change these
	const FORM_EMAIL_FIELD = 'email';
	const FORM_PASSWORD_FIELD = 'password';
	
	public function index() {
		
		// logged in already? Don't need to be here
		if($this->_getUser()) {
			redirect($this->_alreadyAuthURL);
		}
		
		$this->load->helper('url');
		$this->load->library('validation');

		/*
		 *set up CI form
		 */
		$rules['email'] = 'required|valid_email';
		$rules['password'] = 'required';

		$fields['email'] = 'email';

		$this->validation->set_rules($rules);
		$this->validation->set_fields($fields);

		/*
		 * Data for view
		 */
		$this->session->keep_flashdata('referrer');
		// pick up viewdata which contains the reason for login
		if($this->session->flashdata('loginReason')) {
			$viewData['messages']['loginReason'] = $this->session->flashdata('loginReason');
		}
		
		// aim form at this, the current page
		$viewData['formAction'] = site_url($this->_selfURL,true);
		
		$viewData['forgottenPassword'] = site_url($this->_selfURL.'/forgottenpassword');

		/*
		 * validate
		 */

		// validate data first - otherwise unsubmitted forms will show a token error
		if ($this->validation->run() == TRUE) {
			if($this->_checkToken()) {
				// store all flavours of user model in $this->user - so marker, control etc will all
				// go under $this->user, as they all implement the same interface
				$this->load->model($this->_userModel,'user');
				
				// does the account exsist
				
				$loginEmail = $this->input->post(EB_Login::FORM_EMAIL_FIELD);
				
				if($this->user->retrieve($loginEmail)) {
					
					// does the password match, and is everything good with the account
					if (($loginResult = $this->user->loginAttempt($this->input->post(EB_Login::FORM_PASSWORD_FIELD)))===Account::SUCCESS) {
						
						// either not a user, or a user and actually activated
						if (get_class($this)!=='User' ||
							$this->user->get('accountActive')==User::EARLY ||
							$this->user->get('accountActive')==User::ACTIVE) {
								
							// LOG USER IN
							$this->_setUser($loginEmail);
							
							// did we come to login via a referrer on the site - a secure page etc - which wants
							// successfully logged in users to be returned? If so, redirect them, otherwise send them to
							// the vanilla location
							if($url = $this->session->flashdata('referrer')) {
								redirect($url);
							}
							
							redirect($this->_successURL);
						
						} else {
							// account not active
							$viewData['errors'][] = 
							'Your account is not yet active. Check your email for instructions on how to activate your account.';
						}
					} 
				} else {
					// no user by that name
					$loginResult = Account::FAIL_WRONG_PASSWORD;
				}
				
				if($loginResult === Account::FAIL_TOO_MANY_ATTEMPTS) {
					$this->session->unset_userdata($this->_sessionAuthVar);
					$failMsg = 'You have entered the wrong password too many times and for your security your account has been locked. Please use the forgotten password feature to create a new password.';
				}
				if($loginResult === Account::FAIL_WRONG_PASSWORD) {
					$this->session->unset_userdata($this->_sessionAuthVar);
					$failMsg = 'Your username or password were incorrect.';
					if(get_class($this)==='User') $failMsg .=  'Are you a new user? You\'ll need to <a href="'.$this->config->item('app_base').'user/signup">sign up</a>';
				}
				$viewData['errors'][] = $failMsg;
				
			} else {
				// token invalid
				$viewData['errors'][] = 'Your form submission was invalid. Please retry';
			}
			// no need for validation error logic here - the error array will be accessed in the view
		}
		
		$this->session->keep_flashdata('referrer');
		$token = $this->_token();
		$viewData['token'] = $token;

		$this->load->view('html_head.php',array('ssl'=>true));
		$this->load->view('page_head.php',array('bodyId'=>'login','userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('forms/login',$viewData);
		$this->load->view('footer.php');
	}
	public function fbLogin() {
		$this->_fbAuth();
	}
	public function alreadyLoggedIn() {
		$this->lang->load('loginlogout');
		$viewData['messages'][] = 'You are already logged in! <a href="'.site_url($this->_selfURL.'/logout').'">Would you like to logout?</a>';
		$viewData['pageTitle'] = 'You are already logged in';
		$this->load->view('html_head.php',array('ssl'=>true));
		$this->load->view('page_head.php',array('bodyId'=>'login','userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('response/question',$viewData);
		$this->load->view('footer.php');
	}
	public function forgottenPassword() {
		$this->load->library('templatedata');
		
		$viewData['formAction'] = $this->_selfURL.'/forgottenpassword';
		
		if($this->input->post('resetPass')) {
			
			$rules['email'] = 'required|valid_email';
	
			$fields['email'] = 'email';
	
			$this->validation->set_rules($rules);
			$this->validation->set_fields($fields);
			
			if($this->validation->run()===true) {
				if($this->_checkToken()) {
					
					// store all flavours of user model in $this->user - so marker, control etc will all
					// go under $this->user, as they all implement the same interface
					$this->load->model($this->_userModel,'user');
					$this->user->setKey($this->input->post('email'));
					if($this->user->retrieve()) {
						
						$emailData['resetKey'] = $this->user->createPasswordResetKey();
						$emailData['resetURL'] = $this->_selfURL.'/reset/';
						
						$msg = $this->load->view('email/password_reset',$emailData,true);
						$subject = 'You requested a password reset';
						$pass = 'aCc0un+y';
						$sender = 'account_management@exambuff.co.uk';
						
						$this->load->library('swiftwrap');
						$this->swiftwrap->email($sender,$pass,$this->input->post('email'),$subject,$msg);					
					}
					$viewData['checkpoints'][] = 'Please check your email: you have been sent an email explaining how to generate a new password.';
				} else {
					$viewData['errors'][] = 'Your form submission was invalid. Please retry';
				}
			}
		}
		$viewData['token'] = $this->_token();
		
		$templateData = new TemplateData();
		$templateData->setHead('Reset your password');
		$templateData->setView($viewData);
		
		$this->_template('forms/password_reset',$templateData);
	}
	public function reset() {
		$resetKey = $this->uri->segment(4);
		
		$this->load->model($this->_userModel,'user');
		
		if($this->user->findByResetKey($resetKey)) {
			// make a random slice of salty random md5 for the key
			$tempPassword = substr(md5('sal+1l1ciouz'.rand(0,100)),rand(0,4),8);
			
			$this->user->set('password',$this->user->makePass($tempPassword));
			$this->user->set('passwordResetKey','null');
			$this->user->set('failedLogins','1');
			$this->user->update();
			
			$emailData['tempPass'] = $tempPassword;
			
			$msg = $this->load->view('email/temp_pass',$emailData,true);
			$subject = 'Your temporary password';
			$sender = 'account_management@exambuff.co.uk';
			$pass = 'aCc0un+y';
			
			$this->load->library('swiftwrap');
			$this->swiftwrap->email($sender,$pass,$this->user->getKey(),$subject,$msg);			
		}
		// don't tell user if no key was found - can't see why they'd have an invalid code
		$this->_template('response/temp_pass_sent','You\'ve been sent a temporary password');
	}
	public function logout() {
		$this->session->sess_destroy();
		$this->session->unset_userdata($this->_sessionAuthVar);
		$this->session->set_flashdata('loginReason','You have successfully logged out. See you soon.');
		redirect($this->_selfURL);
	}
	private function _keepLoggedIn() {
		// need to work out a way to do this - maybe set expire way ahead
	}
	function _setUser($email) {
		$this->session->set_userdata($this->_sessionAuthVar,$email);
	}
}