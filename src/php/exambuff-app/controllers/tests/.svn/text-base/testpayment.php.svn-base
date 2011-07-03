<?php
class TestPayment extends UnitTestCase {
	var $CI;
	function TestPayment() {
		parent::UnitTestCase();
		$this->CI =& get_instance();
		$this->DBI = $this->CI->load->database('testing',TRUE);
	}
	// if we don't have a crud, get one, else load it up
	function testSetGet() {
		$this->CI->load->model('payment');
		$payment = new Payment($this->DBI);

		$payment->set('method',Payment::DIRECT);
		$this->assertEqual($payment->get('method'),Payment::DIRECT,"Test set and get");
		$passed= false;
		try {
			$payment->set('method','kooky');
		} catch (Exception $error) {
			$this->pass('Method set typing secure');
			$passed = true;
		}
		if(!$passed)	$this->fail("Failed to catch invalid set");
		$passed= false;
		try {
			$payment->set('amount','not numeric');
		} catch (Exception $error) {
			$this->pass('Amount set typing secure');
			$passed = true;
		}
		if(!$passed)	$this->fail("Failed to catch invalid amount set");
	}
	function testPaid() {
		$this->CI->load->model('payment');
		$payment = new Payment($this->DBI);
		$this->assertTrue($payment->paid('goog@goo.com',array('1_222','2_3333'),Payment::PAYPAL,6.50,'dfsdfsdfsdf'),'Payment returned true with valid details');
		$paymentID = $payment->getInsertID();
		$this->assertTrue($paymentID,'Successfully inserted payment with array of keys');
		$payment = new Payment($this->DBI);
		$this->assertTrue($payment->paid('goog@goo.com','1_222',Payment::PAYPAL,6.50,'dfsdfsdfsdf'),'Payment returned true with valid details');
		$paymentID = $payment->getInsertID();
		$this->assertTrue($paymentID,'Successfully inserted payment with single key');
	}
}