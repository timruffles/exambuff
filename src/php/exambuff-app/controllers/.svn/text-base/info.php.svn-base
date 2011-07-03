<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Info extends Controller {
	function upload() {
		$this->showInfo('upload');
	}
	function feedback() {
		$this->showInfo('feedback');
	}
	function images() {
		$this->showInfo('images');
	}
	function cardsecuritycode() {
		$this->showInfo('cardsecuritycode');
	}
	function switchsolo() {
		$this->showInfo('switchsolo');
	}
	function pilotsignup() {
		$this->showInfo('pilotsignup');
	}
	function guarantee() {
		$this->showInfo('money_back');
	}
	function faq() {
		$this->showInfo('faq','faq');
	}
	function testingprogress() {
		$this->showInfo('testingprogress');
	}
	function payment() {
		$this->showInfo('payment');
	}
	function tutors() {
		$this->showInfo('tutors','our-tutors');
	}
        function freebie() {
            $this->load->library('session');
            $this->load->model('offer');

            // freebie offer
            $this->offer->retrieve(1);
            $this->offer->set('count',$this->get('count')+1);
            $this->offer->update();

            // at the moment, just hack in the offer id and change it in code
            $this->session->userdata('offerId',2);

            $this->showInfo('freebie');
	}
	private function showInfo($view,$bodyId=null) {
		$pageData = array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail'));
		if($bodyId) $pageData['bodyId'] = $bodyId;
		
		// did this request come from a eb_ui a.inline? (it posts inline)
		if(!$this->input->post('inline')) {
			$this->load->view('html_head',array('site_base'=>$this->config->item('base_url')));
			$this->load->view('page_head',$pageData);
		}
		$this->load->view('info/'.$view);
		if(!$this->input->post('inline')) $this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
}