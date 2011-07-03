<?php
class EB_Controller extends Controller {
	
	protected $_authRequired;
	protected $_sessionAuthVar;
	
	protected $_loginReason = "You need to login to access this page. Please login below.";
	
	protected $_loginURL = '/user/login';
	
	protected $_flexOnly = false;
	protected $_flexFailURL = '';
	
	// use this in session to indicate that the user is logged in via fb
	CONST FB_SESSION_FLAG = 'fbAuthSession';
	
	function EB_Controller() {
		parent::Controller();
		if($this->_authRequired) $this->authCheck();
	}
	protected function logout() {
		$this->session->sess_destroy();
		$this->session->set_flashdata('loginReason',$this->_loginReason);
		if(!$this->_flexOnly) {
			$this->session->set_flashdata('referrer',$this->uri->uri_string());
			redirect($this->_flexFailURL);
		}
		redirect($this->_loginURL);
	}
	protected function authCheck() {
		if($this->session->userdata(EB_Controller::FB_SESSION_FLAG) == true) {
			$this->fbAuth();
		} else {
			if($this->session->userdata($this->_sessionAuthVar) == true) return;
			$this->logout();
		}
	}
	/**
	 * Loads standard Exambuff template, either using title, and bodyid or a complete TemplateData object passed as the second arg.
	 * @param $view Name of view required
	 * @param $title String || $templateData TemplateData - either title string or complete TemplateData object
	 * @param $bodyID String
	 * @param $viewData array
	 */
	function _template($view,$title=null,$bodyID=null,$viewData=null) {
		if(get_class(func_get_arg(1)) === 'TemplateData') {
			$templateData = $title;
		} else {
			$this->load->library('templatedata');
			$templateData = new TemplateData();
			$templateData->setHead($title);
			$templateData->setPage($bodyID);
			$templateData->setView($viewData);
		}
		
		if($templateData->page) {
			$templateData->setPage(array_merge($templateData->page,array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'))));
		} else {
			$templateData->setPage(array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		}
		
		$templateData->setFooter($templateData->footer+$this->_fbToken());
		
		$this->load->view('html_head.php',$templateData->head);
		$this->load->view('page_head.php',$templateData->page);
		$this->load->view($view,$templateData->view);
		$this->load->view('footer',$templateData->footer);	
	}
	/**
	 * Returns a token to be passed to view, and stores it in session for comparision on next request.
	 * 
	 * @return $token String
	 */
	function _token() {
		$token = md5(uniqid(rand(), true));
		$this->session->set_userdata('token',$token);
		return $token;
	}
	/**
	 * Compares token in post against session token, returning a boolean.
	 * @return $result boolean
	 */
	function _checkToken() {
		if ($this->session->userdata('token') === $this->input->post('token')) {
			return true;
		}
		return false;
	}
	function _getUser() {
		if($e = $this->session->userdata($this->_sessionAuthVar)) return $e;
		return false;
	}
	/**
	 * Displays a single flex result only.
	 *
	 * @param string $result
	 */
	function _flexResult($result) {
		$this->load->view('flex/json_result',array('result'=>'{"result":"'.$result.'"}'));
	}
	protected function _fbAuth() {
		$this->load->library('facebook');
		// this will redirect user if not logged in
		$UID = $this->facebook->require_login();
		/*
		$this->load->model('user');
		if(!$this->user->retrieve($UID)) {
			$this->user->setKey($UID);
			$this->user->setType(User::FB_CONNECT);
			$this->user->set('accountActive',User::ACTIVE);
			if(!$this->user->create()) throw new Exception('Failed to create account');
		}
		$this->_fbAuthorised = true;
		*/
	}
}