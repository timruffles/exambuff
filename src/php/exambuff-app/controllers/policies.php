<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Policies extends Controller {
	function privacy() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('site_pages'=>$this->config->item('site_pages')));
		$this->load->view('statics/privacy');
		$this->load->view('footer',array('site_base'=>$this->config->item('base_url')));
	}
	function refunds() {
		$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head',array('site_pages'=>$this->config->item('site_pages')));
		$this->load->view('statics/refunds');
		$this->load->view('footer',array('site_base'=>$this->config->item('base_url')));
	}
}