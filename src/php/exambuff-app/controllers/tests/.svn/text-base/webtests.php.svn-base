<?php
require_once('simpletest/reporter.php');
require_once('simpletest/web_tester.php');
/**
 * Tests all non-javascript functionality
 *
 */
class WebTests extends Controller {
	var $webTestDir;
	function WebTests() {
		parent::Controller();
	}
	function index() {	
		$this->webTestDir = dirname(__FILE__).'/webtests/';
		$this->runAllTests();		
	}
	function runAllTests() {
		$test = new TestSuite();	
		$test->addTestFile($this->webTestDir.'wtest_uploadform.php');
		$test->addTestFile($this->webTestDir.'wtest_loginform.php');
		$test->run(new HtmlReporter);		
	}
	
}
?>