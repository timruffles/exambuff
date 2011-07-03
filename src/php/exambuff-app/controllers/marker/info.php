<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Info extends Controller {
	function assessment() {
		$this->showInfo('assessment');
	}
	function confirmphd() {
		$this->showInfo('confirm_phd');
	}
	function markingtutorial() {
		$this->showInfo('marking_tutorial');
	}
	private function showInfo($view) {
		if(!$this->input->post('inline')) {
			$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
			$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		}
		$this->load->view('marker/info/'.$view);
		if(!$this->input->post('inline')) $this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
}