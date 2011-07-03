<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('../exambuff/controllers/I_FlexMarksIn.php');
require_once('../exambuff/controllers/I_FlexJobs.php');
/**
 * Controls the accepting and sending of job data from and to 
 * Flex.
 */
class Assess extends EB_Controller implements I_FlexMarksIn, I_FlexJobs {
	
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';
	
	protected $_flexOnly = true;
	
	function joblist() {
		$this->load->database();
		$this->load->model('script');
		$script = new Script();
		// load 10 oldest jobs still active
		$results = $script->getAssessmentScript();
		
		foreach($results->result_array() as $script) {
			$script['pages'] =  4;
			unset($script['pageKeys']);
			$jobs[] = $script;
		}
		
		$this->load->library('json');
		$jobs = $this->json->encode($jobs);
		$this->load->view('marker/job_list',array('jobs'=>$jobs));
	}
	/**
	 * FakeIt as we don't need to reserve anything for the marker - the assessment script is used
	 * by all.
	 *
	 */
	function takeJob() {
		$this->_flexResult(I_FlexJobs::MARKER_ACCEPTED);
	}
	public function addMark() {
	 	if(!$jsonData = $this->input->post('jsonData')) { die('null'); }
		$this->load->model('assessment');
		$this->load->model('script');

		$this->load->library('json');

		$decoded = $this->json->decode($jsonData);

		$assessment = new Assessment();
		$assessment->setKey($decoded->script);
		
		$assessment->set('marker',$this->session->userdata($this->_sessionAuthVar));
		$assessment->set('markData',$jsonData);
		$assessment->set('targets',serialize($decoded->targets));
		$assessment->set('generalComment',$decoded->generalComment);
		$assessment->set('status',Assessment::UNPAID);
		
		if($assessment->create()) {
			$this->_flexResult(I_FlexMarksIn::SAVE_SUCCESSFUL);
		} else {
			$this->_flexResult(I_FlexIO::ERROR);
		}
	}
	
	/*
	 * Takes a request for a image in scriptNum-pageNum.jpg format - to allow caching
	 */
	public function page() {
		$this->load->model('script');
		$script = new Script();
		$imageFileRequested = $this->uri->segment(4);
		$splitAroundPipe = explode('-',$imageFileRequested);
		$scripNum = $splitAroundPipe[0];
		$splitOnFullstop = explode('.',$splitAroundPipe[1]);
		$pageNum = $splitOnFullstop[0];
		$script->retrieve($scripNum);
		$pageFile = $script->pages->getPageKeyAt((int)$pageNum);
		$this->_outputPage($pageFile);
	}
	private function _outputPage($page) {
		$this->load->helper('file');
		$location = $this->config->item('page_directory').$page;
		$data = file_get_contents($location);
	    header('Content-Length:'.strlen($data));
	    header('Content-type: image/jpeg');
	    echo $data;
	    log_message('error','attempting to output '.strlen($data).' from '.$location);
	}
}