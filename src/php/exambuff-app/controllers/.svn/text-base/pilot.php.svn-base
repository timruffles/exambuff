<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pilot extends Controller {
	function index() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'pilot'));
		$this->load->view('statics/pilot');
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
	function universities() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'pilot'));
		$this->load->view('statics/universities');
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
}