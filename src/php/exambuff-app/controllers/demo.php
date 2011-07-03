<?php
class Demo extends EB_Controller implements I_FlexMarksIn, I_FlexJobs {
	public function index() {
		$this->load->view('flex/demo_flex');
	}
	/**
	 * Returns mark data for a script for Flex models Mark; Modified method for demo.
	 * 
	 * Modification -  - enforced white list for demo
	 * 
	 */
/*
	 * Returns mark data for a script.
	 */
	public function mark() {
		$this->load->model('mark');
		$this->load->library('json');
		
		$mark = new Mark();
		$query = $mark->getJSONMark(32);
		$results = $query->result_array();
		foreach($results as $row) {
			$jsonResponse = $row['markData'];
		}

		$this->load->view('marker/mark',array('mark'=>$jsonResponse));
	}
	/**
	 * 
 	 * Takes a request for a image in "scriptNum-pageNum.jpg" format - to allow caching; Modified method for demo..
	 * Modified - enforced white list for demo
	 * @param "$scriptNum-$pageNum.jpg" in 4th url segment
	 */
	public function page() {
		$this->load->model('script');
		$script = new Script();
		// CHECK THIS IS CORRECT FOR THE CURRENT CONTROLLER LOCATION
		$imageFileRequested = $this->uri->segment(3);
		$splitAroundPipe = explode('-',$imageFileRequested);
		$scripNum = $splitAroundPipe[0];
		$scripNum = 32;
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
	}
}