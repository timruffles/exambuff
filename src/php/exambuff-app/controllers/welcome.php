<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('site_pages'=> array()) );
		$this->load->view('footer',array('site_pages'=>array()));
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
