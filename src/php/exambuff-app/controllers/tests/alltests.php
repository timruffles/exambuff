<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once ('simpletest/unit_tester.php');
require_once ('simpletest/reporter.php');
class AllTests extends Controller {
	function AllTests() {
		parent::Controller();
		$this->load->database('testing');
	}
	function index() {
		$this->runAllTests();
	}
	function runAllTests() {
		$test = new TestSuite();
		/*//$test->addTestFile(dirname(__FILE__).'/testcrud.php');
		$test->addTestFile(dirname(__FILE__).'/testdatabase.php');
		$test->addTestFile(dirname(__FILE__).'/testcrudasmodel.php');
		//$test->addTestFile(dirname(__FILE__).'/testusersignup.php'); obselete - users store themselves
		$test->addTestFile(dirname(__FILE__).'/testupload.php');
		$test->addTestFile(dirname(__FILE__).'/testscript.php');
		$test->addTestFile(dirname(__FILE__).'/testmarkjson.php');
		$test->addTestFile(dirname(__FILE__).'/testpayment.php');
		$test->addTestFile(dirname(__FILE__).'/testpagegroup.php');*/
		$test->addTestFile(dirname(__FILE__).'/testscript.php');
		$test->run(new HtmlReporter);
	}
}

?>