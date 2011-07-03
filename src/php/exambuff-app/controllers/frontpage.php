<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FrontPage extends EB_Controller {
	function index()
	{
		$viewData['token'] = $this->_token();
		$viewData['userAuth'] = @$this->session->userdata('email');
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages'),'bodyId'=>'home'));
		$this->load->view('splash');
		$this->load->view('statics/front_page',$viewData);
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	function write() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	function read() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	function succeed() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	function pricing() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'),'site_pages'=>$this->config->item('site_pages')));
		$this->load->vieW('statics/pricing');
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
}