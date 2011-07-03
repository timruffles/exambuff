<?php
require_once 'crud.php';
class AssessmentFix extends Crud {
	
	const PAID = 'paid';
	
	public function AssessmentFix($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('email'=>'',
							'hadProblem'=>'',
							'paid'=>'');
		$this->table = 'assessmentFix';
		$this->key = 'email';
	}
	public function requireFix($trueOrFalse) {
		if($trueOrFalse == 'yes') $trueOrFalse = 1;
		if($trueOrFalse == 'no') $trueOrFalse = 0;
		$this->set('hadProblem',$trueOrFalse);
	}
	public function paid() {
		$this->data['paid'] = AssessmentFix::PAID;
	}
	/**
	 * 
	 * @param $marker
	 * @return bool
	 */
	public function isUnpaid($marker) {
		$sql = "SELECT assessmentFix.email FROM $this->table WHERE assessmentFix.email=? AND assessmentFix.paid<>'".AssessmentFix::PAID."' LIMIT 1";
		$query = $this->DBI->query($sql,array($marker));
		return $query->num_rows(); 
	}
}