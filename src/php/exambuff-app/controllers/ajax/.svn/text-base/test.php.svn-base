<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test extends Controller {
	public function index() {
		echo 'hellllllo AJAX!';	
	}
	public function ergo() {
		$viewData['js'][] = 'ergofields.js';
		$viewData['js'][] = 'jquery.listen.js';		
		
		$this->load->view('header',$viewData);
		$this->load->view('user/user_management',$viewData);
	}
}