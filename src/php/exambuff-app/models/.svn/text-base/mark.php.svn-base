<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Mark extends Crud {
	
	const MARKING = 'marking';
	const UNPAID = 'unpaid';
	const PAID = 'paid';
	/**
	 * Marks relate to scripts on a one-to-one basis, and therefore they share
	 * a primary key: the ID field of script, thus script.ID = mark.script
	 *
	 * @param unknown_type $codeIgniterDb
	 * @return Mark
	 */
	public function Mark($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('script'=>'',
						    'marker'=>'',
							'markData'=>'',
							'targets'=>'',
							'generalComment'=>'',
							'status'=>'');
		$this->table = 'marks';
		$this->key = 'script';
	}
	/**
	 * Builds the mark from a JSON encoded string sent from Flex
	 *
	 */
	public function buildFromJSON($jsonString) {
		if(gettype($jsonString) !== 'string') { throw new Exception('Mark buildFromJSON takes a JSON encoded string'); }
		// total hack for unit testing
		if(!($this->load->library('json'))) {$CI = get_instance(); $CI->load->library('json'); }
		if(!($decoded = $this->json->decode($jsonString))) { throw new Exception('Mark buildFromJSON passed invalid JSON string'); }

		$markData = $decoded;
		$classification = $decoded->classification;

		$this->set('markData',$markData);
		$this->set('classification',$classification);
	}
	/**
	 * Returns mark data for Flex marking/viewing views
	 *
	 */
	public function marks() {

		$id = $this->input->post('script');
		
		$results = $results->result();

		$jsonResponse;

		foreach($results as $row) {
			$jsonResponse = $row->markData;
		}


		$this->load->library('json');
		$jsonResponse = $this->json->encode($jsonResponse);

		$this->load->view('marker/mark',array('mark'=>$jsonResponse));
	}
	/**
	 * Mark submitted by marker. Mark is not updated automatically
	 * by this function.
	 */
	public function submit() {
		$this->data['status'] = Mark::UNPAID;
	}
	/**
 	 * Mark as taken for marking by marker. Mark is not updated automatically
	 * by this function.
	 */
	public function marking() {
		$this->data['status'] = Mark::MARKING;
	}
	/**
	 * This mark has now been paid for. Mark is not updated automatically
	 * by this function.
	 */
	public function paid() {
		$this->data['status'] = Mark::PAID;
	}
	/**
	 * Gets the latest N scripts marked by a specified marker. Returns an assoc array
	 */
	function getMarksForWage($marker,$numberOfScripts = 10) {
		if(!is_numeric($numberOfScripts)) throw new Exception('Mark getMarkForWage requires a number as its second param');
		$sql = "SELECT marks.$this->key, marks.updated, scripts.question FROM $this->table, scripts WHERE marker=? AND marks.status ='".Mark::UNPAID."' AND marks.script = scripts.ID LIMIT $numberOfScripts";
		$query = $this->DBI->query($sql,array($marker));
		return $query->result_array(); 
	}
	/*
	 * Get mark
	 * */
	function getJSONMark($script) {
		$query = 'SELECT markData FROM marks WHERE script=? LIMIT 1';
		$results = $this->DBI->query($query,array($script));
		return $results;
	}
	/**
	 * Get marks currently in progress by a marker
	 * 
	 * @param $marker String - key of marker, if not already set in data array
	 * @return $query CI_Query
	 * */
	function getScriptsBeingMarkedBy($marker = null) {
		if($marker == null ) {
			if(!$marker = $this->get('marker')) {
				throw new Exception ('Marker required as param or already set in data array');
			}
		}
		
		$sql = "SELECT scripts.ID, scripts.pageKeys, marks.$this->key FROM $this->table, scripts WHERE marker=? AND marks.status ='".Mark::MARKING."' AND marks.script = scripts.ID LIMIT 1";
		$query = $this->DBI->query($sql,array($marker));
		return $query; 
	}
	
}