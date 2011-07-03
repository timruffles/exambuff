<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Scripts extends EB_Controller {
	
	protected $_sessionAuthVar = 'user';
	protected $_authRequired = true;
	
	public function Scripts() {
		parent::EB_Controller();
		$this->DBI = $this->load->database('local',TRUE);
	}
	private function _viewDataFromScript($scriptResult) {
		$returnArray['id'] = $scriptResult->ID;
		$returnArray['question'] = $scriptResult->question;
		$returnArray['created'] = $scriptResult->created;
		return $returnArray;
	}
	function feedback() {
		$this->load->model('script');
		
		$script = new Script();
		
		
		$numberOfScriptsToDisplay = 10;	
		$startFrom = 0;
		
		if(is_numeric($this->uri->segment(3))) $startFrom = $this->uri->segment(3);
		 	
		$resultAssoc = $script->getScriptsFor($this->_getUser(),$numberOfScriptsToDisplay+1,$startFrom);
		
		$pageate = false;
		
		if(count($resultAssoc)>$numberOfScriptsToDisplay) $pageate = true;
		// remove the extra result returned to see whether pagation was required
		if(count($resultAssoc)>$numberOfScriptsToDisplay) array_pop($resultAssoc);
		
		// highlight new order
		if($this->session->flashdata('newOrder')) $viewData['messages'][] = $this->session->flashdata('newOrder');
			
		$viewData['scripts'] = $resultAssoc;
		$viewData['pageate'] = $pageate;
		$viewData['resultsPer'] = $numberOfScriptsToDisplay;
		$viewData['startFrom'] = $startFrom;
		
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('bodyId'=>'view feedback','userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('user/script_management',$viewData);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
	public function viewtargets() {
		$scriptNum = $viewData['script'] = $this->uri->segment(4);
		
		$this->load->model('script');
		
		if(!$this->_scriptAuthCheck($scriptNum,$this->script)) return;
		
		$this->script->setKey($scriptNum);
		$feedbackData = $this->script->getTargets();
		$viewData['question'] = $feedbackData['question'];
		$viewData['targets'] = unserialize($feedbackData['targets']);
		$viewData['generalComment'] = $feedbackData['generalComment'];
		$viewData['scriptID'] = $scriptNum;
		$viewData['pages'] = $feedbackData['pages'];
		$this->_template('user/show_feedback','View feedback',null,$viewData);
	}
	/**
	 * Flex requests this function to get the list of marked scripts possible to display in viewer.swf.
	 * @return JSON object, empty if none found
	 */
	public function marked() {
		$this->load->database();
		$this->load->model('script');
		$script = new Script();
		// load all marked scripts
		$query = $script->getMarkedScriptsFor($this->session->userdata($this->_sessionAuthVar));
		
		if(!$query instanceof CI_DB_mysql_result) throw new Exception('Did not return a result object(?!)');
		
		if($query->num_rows()>0) {
			$results = $query->result_array();
			foreach($results as $script) {
				$explodeAroundPipe = explode('|',$script['pageKeys']);
				$script['pages'] =  count($explodeAroundPipe);
				unset($script['pageKeys']);
				$scripts[] = $script;
			}
			$this->load->library('json');
			$scripts = $this->json->encode($scripts);
		} else {		
			$scripts = '{}';
		}
		$this->load->view('user/marked_scripts',array('scripts'=>$scripts));
	}
	public function page() {
		$this->load->model('script');
		
		$imageFileRequested = $this->uri->segment(4);
		$splitAroundHyphen = explode('-',$imageFileRequested);
		$scriptNum = $splitAroundHyphen[0];
		
		// is the user auth'd to see this?
		if(!$this->_scriptAuthCheck($scriptNum,$this->script)) return;
		
		$splitOnFullstop = explode('.',$splitAroundHyphen[1]);
		$pageNum = $splitOnFullstop[0];
		$pageFile = $this->script->pages->getPageKeyAt((int)$pageNum);
		$this->_outputPage($pageFile);
	}
	private function _scriptAuthCheck($scriptNum,Script $script=null) {
		if(!$script) {
			$this->load->model('script');
			$script = new Script();
		}
		$script->retrieve($scriptNum);
		// is the script this user's?
		if($script->get('email')===$this->_getUser()) return true;
		return false;
	}
	public function viewfeedback() {
		$scriptNum = $viewData['script'] = $this->uri->segment(4);
		$viewData['numPages'] =  $this->uri->segment(5);
		
		$this->load->model('script');
		// is the user auth'd to see this?
		if(!$this->_scriptAuthCheck($scriptNum,$this->script)) return;
		
		$this->load->view('user/viewer_flex',$viewData);
	}
	private function _outputPage($page) {
		$this->load->helper('file');
		$location = $this->config->item('page_directory').$page;
		$data = file_get_contents($location);
	    header('Content-Length:'.strlen($data));
	    header('Content-type: image/jpeg');
	    echo $data;
	    //log_message('error','attempting to output '.strlen($data).' from '.$location);
	}
	/**
	 * Returns mark data for a script.
	 */
	public function mark() {
		$this->load->model('mark');
		$this->load->library('json');
		
		$mark = new Mark();
		$query = $mark->getJSONMark($this->input->post('script'));
		$results = $query->result_array();
		foreach($results as $row) {
			$jsonResponse = $row['markData'];
		}

		$this->load->view('marker/mark',array('mark'=>$jsonResponse));
	}
}