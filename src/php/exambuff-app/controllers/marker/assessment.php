<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The user panel, routed from /user
 */
class Assessment extends EB_Controller {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	
	
	function demo() {
		
	}
	function index() {
		
	}
	function takeassessment() {
		$this->load->view('marker/assess_flex');
	}
	function confirmphd() {
		$this->load->model('marker');
		$this->marker->retrieve($this->session->userdata($this->_sessionAuthVar));
		
		$viewData['marker'] = $this->marker;
		
		$this->load->library('validation');

		// set rules
		$rules['studentNum'] = 'required|numeric|max_length[64]|min_length[1]';
		$rules['uniPermission'] = 'required|max_length[128]';
		$rules['accept'] = 'required';

		$fields['studentNum'] = 'Student number';
		$fields['uniPermission'] = 'Signature giving us permission to contact your university';
		$fields['accept'] = 'Acceptance of the terms';
		
		$this->validation->set_rules($rules);
		$this->validation->set_fields($fields);	
		if ($this->input->post('accept') && $this->validation->run() == TRUE) {
			$this->marker->authenticatePhDStatus();
			$this->marker->set('studentNum',$this->input->post('studentNum'));
			$this->marker->update();
			$this->session->set_flashdata('action','Thank you - you have successfully confirmed your PhD status.');
			redirect('/marker');
		}
		if($this->input->post('submit') && $this->validation->run() == FALSE) {
			
		}
		$this->load->view('html_head.php');
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('marker/confirmphd',$viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
}