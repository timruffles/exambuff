<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The marker panel, routed from /marker
 */
class MarkerPanel extends EB_Controller {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	function panel() {
		$this->load->model('marker');
		$this->load->model('assessment');
		$this->load->library('validation');
		$this->load->model('mark');
		$this->load->model('markerPref');
		
		
		
		// form submit names
		$updatePref = 'updatePref';
		$markerEmail = $this->session->userdata($this->_sessionAuthVar);
		$marker = new Marker();
		$marker->retrieve($markerEmail);
		$markerPref = new MarkerPref();
		$markerPref->retrieve($markerEmail);
		
		// do this first due to the hacky implementation - it will result in doubled validation
		// messages for every other form
		if($this->_updatePref($marker,$markerPref)) {
			$viewData['checkpoints'][] = 'You have successfully updated your job update preferences';
		}
		
		
		// assessment fix required?
		$requireFix = array("timruffles@googlemail.com","aaxcr@nottingham.ac.uk","C.Rienzo@rhul.ac.uk","D.Zhang@rhul.ac.uk","dhara.anjaria@gmail.com","eaxlx@nottingham.ac.uk","gondal3@gmail.com","info@ldandt.co.uk","lexmza@nottingham.ac.uk","liuqian842@gmail.com","mesell25@hotmail.com","qian.zhao@ucl.ac.uk","S.Ford@rhul.ac.uk","sbxjra@nottingham.ac.uk","stefano@cs.rhul.ac.uk","V.Amin@rhul.ac.uk","Yen.Liu@rhul.ac.uk");
		$viewData['assessmentFix'] = false;
		if(in_array($this->_getUser(),$requireFix)) $viewData['assessmentFix'] = true;
		
		
		$this->load->model('assessmentFix');
		
		
		
		if($viewData['assessmentFix']) {
			$assessmentFix = new AssessmentFix();
			$assessmentFix->setKey($this->_getUser());
			if($assessmentFix->retrieve()) {
				$viewData['assessmentFix'] = false;
			}
		}
		
		if($this->input->post('assessmentFix')) {
			if($this->_checkToken()) {
				$this->load->library('validation');
					
				$rules['requireFix'] = 'required';
				
				$fields['requireFix'] = 'yes or no';
				
				$this->validation->set_rules($rules);
				$this->validation->set_fields($fields);
				
				if($this->validation->run()===true) {
					$assessmentFix = new AssessmentFix();
					$assessmentFix->requireFix($this->input->post('requireFix'));
					$assessmentFix->setKey($this->_getUser());
					$assessmentFix->create();
					$viewData['checkpoints'][] = 'You have registered for the assessment fix. You will paid a re-assessment bounty when you submit your assessment.';
					$viewData['assessmentFix'] = false;
				}
			}
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
					$marker = new Marker();
					$marker->setKey($this->_getUser());
					$marker->retrieve();
					if($marker->get('password')===$marker->makePass($this->input->post('currentPassword'))) {
						$marker->set('password',$marker->makePass($this->input->post('newPassword')));
						$viewData['checkpoints'][] = 'You have successfully changed your password.';
						$marker->update();
					} else {
						$viewData['errors'][] = 'You did not enter your current password correctly.';
					}
				}
			}
		}
		
		$viewData['token'] = $this->_token();
		
		$viewData['markerPref'] = $markerPref;
		
		if($this->session->flashdata('action')) $viewData['checkpoints'][] = $this->session->flashdata('action');
		
		$viewData['marker'] = $marker;
		$headData['js'][] = 'eb_ui';
		$viewData['assessment'] = false;
		$viewData[$updatePref] = $updatePref;
		
		if($this->assessment->retrieve($marker->getKey())) $viewData['assessment'] = true;
		
		$this->load->view('html_head.php',$headData);
		$this->load->view('page_head.php',array('bodyId'=>'my account','userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('marker/panel',$viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
	private function _updatePref(Marker $marker,$markerPref) {
		
		$rules['alertThreshold'] = 'numeric';
		$rules['alertSubjects'] = '';
		$rules['alertMax'] = 'numeric';
		$rules['jobMin'] = 'numeric';
		$rules['alertSubjects'] = '';
		$rules['alertTimeHH'] = 'numeric|min_length[1]|max_length[2]|callback_validHour';
		$rules['alertTimeMM'] = 'numeric|min_length[1]|max_length[2]|callback_validMinute';
		
		if($this->input->post('alertTimeHH') == 24 && $this->input->post('alertTimeMM') != 0) {
			$rules['alertTimeMM'] = 'callback_invalid24';
		}
		
		$fields['alertThreshold'] = 'job email threshold';
		$fields['alertMax'] = 'job email max';
		$fields['jobMin'] = 'job email min';
		$fields['alertSubjects'] = 'job subjects your are interested in';
		$fields['alertTimeMM'] = 'minute field of email time (MM)';
		$fields['alertTimeHH'] = 'hour field of email time (HH)';
		
		$this->validation->set_message('validHour','The %s field needs to be part of a valid 24H time');
		$this->validation->set_message('validMinute','The %s field needs to be part of a valid 24H time');
		$this->validation->set_message('invalid24','The %s field needs to be part of a valid 24H time');
		
		$this->validation->set_fields($fields);
		$this->validation->set_rules($rules);
		if($this->validation->run()) {
			$markerPref->set('alertThreshold',$this->input->post('alertThreshold'));
			$markerPref->set('alertSubjects',$this->input->post('alertSubjects'));
			$markerPref->set('alertMax',$this->input->post('alertMax'));
			$markerPref->set('jobMin',$this->input->post('jobMin'));
			$markerPref->set('alertTime',$this->input->post('alertTimeHH').$this->input->post('alertTimeMM'));
			$markerPref->update();
			return true;
		}
		return false;
	}
	public function validHour($hour) {
		if($hour > 24) return false;
		return true;
	}
	public function invalid24($minute) {
		return false;
	}
	public function validMinute($minute) {
		if($minute>59) return false;
		return true;
	}
}