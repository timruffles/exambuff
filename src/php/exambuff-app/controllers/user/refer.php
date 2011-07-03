<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Refer extends EB_Controller {
	
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'user';
	
	function index() {
		if($this->input->post('emails')) {
			$this->load->library('validation');
			
			$rules['emails'] = 'valid_emails|required';
			
			$fields['emails'] = 'referree emails';
			
			$this->validation->set_fields($fields);
			$this->validation->set_rules($rules);
			
			$this->validation->set_message('valid_emails', 'All email addresses entered into %s must be valid, seperated by commas');
			
			if($this->validation->run() === TRUE) {
				$emails = explode(',',$this->input->post('emails'));
				$this->load->model('referral');
				foreach($emails as $email) {
					$referral = new Referral();
					$referral->set('user',$this->_getUser());
					$referral->set('referee',trim($email));
					$referral->set('ipRequested',@$_SERVER['REMOTE_ADDR']);
					if($referral->create()) {
						$viewData['checkpoints'][] = "You have successfully sent a referral email to $email.";
					} else {
						$viewData['errors'][] = "A referral email has already been sent to $email.";
					}
				}
			}
		} 
		
		if($this->validation->error_string) $viewData['errors'][] = $this->validation->error_string;
		$viewData['token'] = $this->_token();
		
		$this->load->library('templatedata');
		$templateData = new TemplateData();
		$templateData->setHead('Refer a friend and get cash back');
		$templateData->setView($viewData);
		
		$this->_template('user/referral',$templateData);
	}
	function validmultiple($string) {
		return preg_match('/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*([,;]\s*\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*)*/',$string);
	}
}