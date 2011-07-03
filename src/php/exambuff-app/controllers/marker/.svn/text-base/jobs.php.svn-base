<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('../exambuff/controllers/I_FlexMarksIn.php');
require_once('../exambuff/controllers/I_FlexJobs.php');
/**
 * Controls the accepting and sending of job data from and to 
 * Flex.
 */
class Jobs extends EB_Controller implements I_FlexMarksIn, I_FlexJobs {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	
	protected $_flexOnly = true;
	
	/**
	 * Loads jobs available to be marked for Flex, or the marker's current job if present.
	 * 
	 * @return $jobs JSON encoded array of jobs if marker hasn't already got a job
	 * @return $script ID of script if marker has a job already
	 * @return $lastPage of script if marker has a job already
	 */
	function joblist() {
		$this->load->database();
		$this->load->model('script');
		$this->load->model('mark');
		
		$query = $this->mark->getScriptsBeingMarkedBy($this->_getUser());
		if($query->num_rows() > 0) {
			$scripts = $query->result_array();
			$script = $scripts[0]['ID'];
			$lastPage = count(unserialize($scripts[0]['pageKeys']));
			$this->load->view('flex/json_result',array('result'=>'{"result":"'.I_FlexJobs::MARKER_HAS_JOB.'","script":'.$script.',"lastPage":'.$lastPage.'}'));
			return;
		}
		
		$script = new Script();
		// load 10 oldest jobs still active
		$results = $script->getScriptsForMarking(10);
		if($results->num_rows() !== 0 ) {
			foreach($results->result_array() as $script) {
				$explodeAroundPipe = explode('|',$script['pageKeys']);
				$script['pages'] =  count($explodeAroundPipe);
				unset($script['pageKeys']);
				$jobs[] = $script;
			}
		} else {
		$jobs = 'jobs=false';
		}
		$this->load->library('json');
		$jobs = $this->json->encode($jobs);
		$this->load->view('marker/job_list',array('jobs'=>$jobs));
	}
	/**
	 * Called by Flex as of 15-01-09 to ensure that DB reflects when a job
	 * is being marked by someone, to stop double marking.
	 * 
	 * @param $script int POST'ed
	 */
	function takeJob() {
		$this->load->model('script');
		$this->load->model('mark');
		
		if(!is_numeric($this->input->post('script'))) {
			$this->load->view('flex/json_result',array('result'=>'{"result":"'.I_FlexJobs::ERROR.'"}'));
			return;
		}
		
		$this->script->setKey($this->input->post('script'));
		$this->script->retrieve();
				
		// check if script is still available
		if($this->script->get('status') === Script::MARKING ||
		   $this->script->get('status') === Script::MARKED) {
		   	$this->load->view('flex/json_result',array('result'=>'{"result":"'.I_FlexJobs::NOT_AVAILABLE.'"}'));
			return;
		}
			
		
		$query = $this->mark->getScriptsBeingMarkedBy($this->_getUser());
		
		// check the marker isn't already assigned a job
		if($query->num_rows() > 0) {
			$this->load->view('flex/json_result',array('result'=>'{"result":"'.I_FlexJobs::MARKER_HAS_JOB.'"}'));
			return;
		}
		
		// set script to marking
		$this->script->marking();
		$scriptUpt = $this->script->update();
		
		if($scriptUpt) {
			// create a new mark
			$this->mark->setKey($this->script->getKey());
			$this->mark->set('marker',$this->session->userdata($this->_sessionAuthVar));
			$this->mark->marking();
			$markCrt = $this->mark->create();
		} else {
			// @todo add a standard method for CRUD exception handling
		}
		
		($scriptUpt && $markCrt) ? $result = I_FlexJobs::MARKER_ACCEPTED : $result = I_FlexJobs::ERROR;
		$this->_flexResult($result);
	}
	/**
	 * Method for saving Flex models.Mark.
	 * @param POST jsonData - holds the markData information in JSON format
	 */
	public function addMark() {
	 	if(!$jsonData = $this->input->post('jsonData')) { return; }
		$this->load->model('mark');
		$this->load->model('script');
		$this->load->library('json');
		
		$decoded = $this->json->decode($jsonData);
		$script = new Script();
		$script->setKey($decoded->script);
	
		$mark = new Mark();
		$mark->setKey($script->getKey());
		$mark->retrieve();
		// make sure the marker has right to mark this
		if($mark->get('marker') !== $this->_getUser()) {
			$this->_flexResult(I_FlexMarksIn::NOT_AUTH);
			return;
		}
		
		// store data
		$mark->set('markData',$jsonData);
		$mark->set('targets',serialize($decoded->targets));
		$mark->set('generalComment',$decoded->generalComment);
		
		// change status 
		$mark->submit();
		
		if(!$mark->update()) {
			// @todo add some Flex handeling for this if it occurs
			$this->_flexResult(I_FlexMarksIn::ERROR);
			return;
		}

		// set script's status to marked
		$script->marked();
		$script->update();
		
		// get the script data to use in the email
		$script->retrieve();
		
		$customerEmail = $script->get('email');
		$scriptID = $script->getKey();
		$lastPage = count($script->pages->getPageKeys());
		
		// save an email for the customers, to be send by cron task
		
		$subject = 'A tutor has read your exam essay and provided feedback';
		
		foreach($decoded->targets as $target) {
			$newTarget['type'] = $target->type;
			$newTarget['text'] = $target->text;
			$emailData['targets'][] = $newTarget; 
		}
		
		$emailData['generalComment'] = $decoded->generalComment;
		// link for user to launch flex viewer
		$emailData['viewURL'] = site_url("/user/scripts/viewfeedback/$scriptID/$lastPage");
		
		$msg = $this->load->view('email/marked',$emailData,true);
		
		$this->load->model('email');
		$this->email->set('sender','fyi@exambuff.co.uk');
		$this->email->set('receiver',$customerEmail);
		$this->email->set('subject',$subject);
		$this->email->set('message',$msg);
		//$this->email->set('messageHTML',$msgHTML);
		$this->email->create();
		
		$this->_flexResult(I_FlexMarksIn::SAVE_SUCCESSFUL);
	}
	/**
	 * Takes a request for a image in "scriptNum-pageNum.jpg" format - to allow caching.
	 * 
	 * @param "$scriptNum-$pageNum.jpg" in 4th url segment
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
	/**
	 * Internal function, loads page data and outputs.
	 *
	 * @param unknown_type $page
	 */
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