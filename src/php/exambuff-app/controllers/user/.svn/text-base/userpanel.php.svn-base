<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The user panel, routed from /user
 */
class UserPanel extends EB_Controller {
	
	protected $_sessionAuthVar = 'user';
	protected $_authRequired = true;
	
	function panel() {
		$this->load->model('user');
		$this->load->model('script');
		$this->load->library('facebook');
		
		if($signedUp = $this->session->flashdata('signedUp')) {
			$this->session->keep_flashdata('signedUp');
			$viewData['signedUp'] = $signedUp;
		}
		
		if($this->input->post('changePassword')) {
			if($this->_checkToken()) {
				$this->load->library('validation');
				
				$rules['currentPassword'] = 'required';
				$rules['newPassword'] = 'required|min_length[6]';
				$rules['newPasswordRepeat'] = 'required|matches[newPassword]';
				
				$fields['currentPassword'] = 'current password';
				$fields['newPassword'] = 'new password';
				$fields['newPasswordRepeat'] = 'new password repeated';
				
				$this->validation->set_rules($rules);
				$this->validation->set_fields($fields);
				
				if($this->validation->run()===true) {
					$user = new User();
					$user->setKey($this->_getUser());
					$user->retrieve();
					if($user->get('password')===$user->makePass($this->input->post('currentPassword'))) {
						$user->set('password',$user->makePass($this->input->post('newPassword')));
						$viewData['checkpoints'][] = 'You have successfully changed your password.';
						$user->update();
					} else {
						$viewData['errors'][] = 'You did not enter your current password correctly.';
					}
				}
			}
		}
		
		$viewData['token'] = $this->_token();
		
		$user = new User();
		$script = new Script();
		$user->retrieve($this->session->userdata('email'));
		if($user->getType() === User::FB_CONNECT) {
			$viewData['email'] = false;
			$viewData['UID'] = $user->getKey();
			$viewData['name'] = $user->name();
			$viewData['institution'] = $user->institution();
			if(!($subject = $user->subject())){
				$subject = 'Not specified on Facebook';
			}
			$viewData['subject'] = $subject;
			$viewData['fbEmail'] = $user->get('fbEmail');
		} else {
			$viewData['email'] = $user->getKey();
			$viewData['name'] = $user->get('name');
			$user->get('subject') ? $viewData['subject'] = $user->get('subject') : $viewData['subject'] = 'Not specified' ;
			$viewData['institution'] = $user->get('institution');
		}
		
		//$viewData['messages'][] = 'We are on day '.ceil((time() - 1229536800)/86400).' of the Exambuff pilot. Thanks for taking part!';
		
		$this->_template('user/panel','Your account','my-account',$viewData);
	}
}