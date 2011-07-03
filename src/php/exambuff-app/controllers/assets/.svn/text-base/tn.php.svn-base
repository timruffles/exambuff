<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tn extends Controller {
	public function index() {
		$this->_outputPage('owls.jpg');		
	}
	private function _outputPage($page) {
		$this->load->helper('file');
		$location = $this->config->item('page_directory').$page;
		$data = file_get_contents($location);
					
	    // outputing HTTP headers
	    header('Content-Length: '.strlen($data));
	    header('Content-type: image/jpeg');
		
		echo ($data);
		
	}
}
?>
