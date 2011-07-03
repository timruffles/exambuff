<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Jobs extends EB_Controller {
	function index() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'jobs'));
		$this->load->view('statics/jobs');
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
}