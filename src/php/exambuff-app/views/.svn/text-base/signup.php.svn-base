<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Handles the sets of usersignup
 * @method index - loads the startup form, validates, and calls email activation
 * @method emailActivation - private function to email an activation code to the user's email
 * @method activate - accepts the links generated in the email, takes the activation code from
 * URL and checks with activation model, which itself activates the user if successful.
 * @todo add language for signuped and signupfailed
 * @todo make sure to add salted hashes for passwords
 */
class SignUp extends Controller {
	/**
	 * Sets up the usersign up form and validation rules. On submission creates a user and an
	 * activation object stores them, and calls emailActivation.
	 *
	 */
	function index() {
		
		$this->load->helper('url');
		if($this->session->userdata('email')) {
			redirect('/user/login');
		}
		$this->load->helper('url');
		$this->load->library('validation');

		// set rules
		$rules['name'] = 'required|callback_alphaAndWhiteSpace|max_length[64]|min_length[1]';
		$rules['email'] = 'required|valid_email|max_length[60]';
		$rules['password'] = 'required|max_length[30]|min_length[6]';
		$rules['repeatPassword'] = 'required|matches[password]';
		$rules['subject'] = 'alpha|max_length[40]';
		$rules['institution'] = 'alpha|max_length[50]';

		$fields['name'] = 'Name';
		$fields['email'] = 'Email';
		$fields['password'] = 'Password';
		$fields['repeatPassword'] = 'Repeated password';
		$fields['subject'] = 'Subject';
		$fields['institution'] = 'Institution';
		
		$this->validation->set_message('alphaAndWhiteSpace','%s contains invalid characters. Please enter only letters and spaces.');

		$this->validation->set_rules($rules);
		$this->validation->set_fields($fields);

		// validate
		if ($this->validation->run() == TRUE) {
			$this->lang->load('usersignup');
			if($this->_checkToken()) {
				$activationKey ='';
				$this->load->model('user');
				$user = new User();
				$user->buildFromPost();
				if ($user->create()) {
					$this->emailActivation($user->getKey(),$user->get('name'));
					redirect('/user/usersignup/signedup');
				} else {
					// something has gone wrong with creating a new user - very likely they already exsist
					$viewData['errors'][] = $this->lang->line('emailUsed');
				}
			}
		}

		$token = $this->_token();
		$viewData['token'] = $token;

		$viewData['formAction'] = 'user/signup';
		$this->load->view('html_head.php');
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'sign-up/login'));
		$this->load->view('forms/user_sign_up',$viewData);
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	public function signedup() {
		$this->load->view('html_head.php',array('site_base'=>base_url()));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('/response/success');
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	/**
	 * Private function that emails the user with their activation key
	 *
	 * @param String $email
	 * @param String $firstName
	 * @todo add language lines for emails
	 */
	private function emailActivation($email,$firstName) {
		require_once($this->config->item('swift'));
		require_once($this->config->item('swift_smtp'));
		require_once($this->config->item('swift_auth'));
		
		$this->load->model('activator');

		$this->activator->generateKey();
		$this->activator->set('email',$email);
		$this->activator->create();
		try {
			$smtp = new Swift_Connection_SMTP("smtp.gmail.com",465, Swift_Connection_SMTP::ENC_SSL);
			$smtp->setTimeout(10);
			$smtp->setUsername("activations@exambuff.co.uk");
			$smtp->setPassword("44naughty555");
			$smtp->attachAuthenticator(new Swift_Authenticator_LOGIN());
			$swift = new Swift($smtp,'exambuff.co.uk');			
		} catch (Exception $e) {
			$msg = $e->getMessage();
			log_message('error',$msg);
		}
	
		$message = new Swift_Message("test","Dear $firstName,\n Please go to ".app_base().'signup/activate/'.$this->activator->get('activationKey').' to finish your activation');
		
		$swift->send($message,$email,'no-reply@exambuff.co.uk');
	}
	/**
	 * Private function to email an activation code to the user's email
	 *
	 */
	public function activate() {

		$this->load->model('activator'); // this takes the url activation and activates the user's account
		$this->lang->load('usersignup');
		$this->load->helper('url');
		 // we need this to login the user

		$activationKeyFromURL = $this->uri->segment(4); // this is where the key is stored user/usersignup/key

		// the actual activation; true if succeeds, false if it fails
		if ($this->activator->activate($activationKeyFromURL)) {
			
			$this->activator->delete();
			
			// log the user in explicitly
			$userEmail = $this->activator->get('email');
			$this->session->set_userdata('email',$userEmail);

			// set up messages to pass to response controller
			$title = $this->lang->line('activationTitle');
			$messages[] = $this->lang->line('activationSuccessful');
			
			// store messages in session
			$this->session->set_flashdata('signedUp',TRUE);

			// redirect us to the reponse
			redirect('/user');

		} else {

			// set up messages to pass to response controller
			$title = $this->lang->line('activationTitle');
			$errors[] = $this->lang->line('activationFailed');
			$forView = array('errors'=>$errors,'title'=>$title);

			// store messages in session
			$this->session->set_userdata('forView',$forView);

			// redirect us to the reponse
			redirect('response/fail');
		}
	}
	function alphaAndWhiteSpace($str) {
		if(!preg_match("/^([-a-z\._-\s])+$/i", $str)) {
			return false;
		}
		return true;
	}
}