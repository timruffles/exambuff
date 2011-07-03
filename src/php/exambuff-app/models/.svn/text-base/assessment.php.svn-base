<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Assessment extends Crud {
	
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
	public function Assessment($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('script'=>'',
						    'marker'=>'',
							'markData'=>'',
							'status'=>'',
							'targets'=>'',
							'generalComment'=>'');
		$this->table = 'assessments';
		$this->key = 'marker';
	}
		/**
	 * Gets the latest N scripts marked by a specified marker. Returns an assoc array
	 */
	function getAssessmentForWage($marker,$numberOfScripts = 10) {
		if(!is_numeric($numberOfScripts)) throw new Exception('Mark getMarkForWage requires a number as its second param');
		$sql = "SELECT assessments.$this->key, assessments.updated FROM $this->table WHERE assessments.$this->key=? AND assessments.status ='".Assessment::UNPAID."' LIMIT $numberOfScripts";
		$query = $this->DBI->query($sql,array($marker));
		if($query->num_rows() === 0) {
			return false;
		}
		$r = $query->result_array(); 
		return @$r[0];
	}
	/**
	 * Gets assessments that have been submitted but not paid.
	 *
	 * @return CI_Query obj
	 */
	public function getSubmittedAssessments() {
		$sql = "SELECT script, marker, classification FROM assessments WHERE status <> '".Assessment::UNPAID."'";
		return  $this->DBI->query($sql);
	}
	public function paid() {
		$this->data['status'] = Assessment::PAID;
	}
}