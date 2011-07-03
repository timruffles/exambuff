<?php
class TestMarkJson extends UnitTestCase {
	var $CI;
	private $_jsonTest = '{"generalComment":"Test general com","pages":[[{"commentType":"Boo","x":422,"y":124,"commentText":"This sentance is excellent. Score!","width":555,"height":430}],[{"commentType":"Style","x":100,"y":125,"commentText":"This sentance is shoddy.","width":300,"height":400}]],"classification":"FirstTest"}';
	function TestMarkJson() {
		parent::UnitTestCase();
		$this->CI =& get_instance();
	}
	function testBuildFromJSON() {
		$this->CI->load->library('json');
		$this->CI->load->model('mark');

		$mark = new Mark();
		$mark->buildFromJSON($this->_jsonTest);

		$this->assertEqual('FirstTest',$mark->get('classification'),'Classification extracted from JSON');

		$data = $mark->get('markData');
		$this->assertEqual('Test general com',$data->generalComment,'Ensure json process transparent');

		try {
			$mark = new Mark();
			$mark->buildFromJSON('{}xxx');
		} catch (Exception $e) {
			$this->pass("Detected invalid JSON");
			$passed = true;
		}
		if(!$passed)	$this->fail("Failed to detect invalid JSON");

	}
	function testOutputAsFlexJSON() {
		$this->CI->load->model('mark');
		$mark = new Mark();
		//$mark->objForJSONEncode();
	}
}