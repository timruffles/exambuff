<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class GetPaid extends EB_Controller {
	
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	/**
	 * Just to stop the refresh problem. If the redirect is old, send back to the getpaid function.
	 * @return 
	 */
	function complete() {
		if(!$this->session->flashdata('redirectReason')) redirect('/marker/getpaid');
		$this->index();
	}
	function index() {
		$this->load->model('mark');
		$this->load->model('assessment');
		$this->load->model('assessmentfix');
		$mark = new Mark();
		$marker = $this->_getUser();
		$marks = $mark->getMarksForWage($marker);
		
		$assessmentFixReq = false;
		if($assessment = $this->assessment->getAssessmentForWage($marker)) {
			$assessmentFixReq = $this->assessmentfix->isUnpaid($marker);
		}
		
		
		$viewData['assessmentFixReq'] = $assessmentFixReq;
		$viewData['marks'] = $marks;
		$viewData['assessment'] = $assessment;
		
		
		$pageData['bodyId'] = 'getpaid';
		if($this->input->post('getPaid')) {
			if($amount = $this->_sendPayment($marker,$marks,$assessment,$assessmentFixReq)) {
				$formattedAmount = number_format($amount,2);
				$successMsg = "You will be sent an email informing you of how to transfer your payment of £$formattedAmount to your bank account within the next working day.";
				$this->session->set_flashdata('redirectReason',$successMsg);
				redirect('/marker/getpaid/complete');
			}
		}
		if($r = $this->session->flashdata('redirectReason')) $viewData['messages'][] = $r;
		
		
		$this->load->view('html_head.php');
		$this->load->view('page_head.php',array('bodyId'=>'get paid','userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('marker/payment',$viewData);
		$this->load->view('footer.php');
	}
	private function _sendPayment($marker,$marks,$assessmentAssoc,$assessmentFix= 0) {
		if(count($marks) === 0 && empty($assessmentAssoc)) return false;
		
		foreach($marks as $markAssoc) {
			$mark = new Mark();
			$mark->setKey($markAssoc[$mark->getKeyField()]);
			$mark->paid();
			$mark->update();
			$markKeys[] = $markAssoc[$mark->getKeyField()];
		}
		$assessmentAmount = 0;
		if(!empty($assessmentAssoc)) {
			$assessment = new Assessment();
			$assessment->setKey($assessmentAssoc[$assessment->getKeyField()]);
			$assessment->paid();
			$assessment->update();
			$markKeys[] = 'Assessment script';
			$assessmentAmount = 1;
		}
		if($assessmentFix) {
			$assessmentFix = new AssessmentFix();
			$assessmentFix->setKey($this->_getUser());
			$assessmentFix->paid();
			$assessmentFix->update();
			$markKeys[] = 'Assessment bounty';
		}
		
		$this->load->model('wage');
		$amount = ($assessmentFix + count($marks) + $assessmentAmount) * 1.5;
		$wage = new Wage();
		$wage->paid($marker,$amount,$markKeys);
		$wage->create();
		
		return $amount;
	}
}
