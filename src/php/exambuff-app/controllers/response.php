<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Response handles passing viewData stored in a session to a response view
 * @param viewData:Array - holds view data in standard format, e.g 'title'=>'Title' etc
 * @method success - loads view with viewdata etc
 *
 */
class Response extends Controller {
	private $viewData;
	function Response() {
		parent::Controller();
		 // to get messages passed to view
		if(is_array($this->session->flashdata('responseData'))) {
			$this->viewData = $this->session->flashdata('responseData');
		}
		$this->session->keep_flashdata('responseData');
	}
	function success() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'login'));
		$this->load->view('response/success',$this->viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
		
	}
	function fail() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'login'));
		$this->load->view('response/fail',$this->viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
		
	}
	function message() {
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'login'));
		$this->load->view('response/message',$this->viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
}