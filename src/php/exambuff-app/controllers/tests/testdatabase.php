<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * test for database access
 */
class TestDataBase extends UnitTestCase {
	var $CI;
	function TestDataBase() {
		parent::UnitTestCase();
		$this->CI =& get_instance();
		$this->DBI = $this->CI->load->database('testing',TRUE);
	}
	// if we don't have a crud, get one, else load it up
	function resetModel($model) {
		if(isset($this->CI->$model)) {
			$this->CI->$model = new $model;
			return true;
		}
		$this->CI->load->model($model);
	}
function testInsertAndRetrieveValue() {
		$this->resetTestTable();
		$sql = "INSERT INTO test (name) VALUES ('testName')";
		$query = $this->DBI->query($sql);
		$sql = "SELECT * FROM test WHERE name='testName'";
		$query = $this->DBI->query($sql);
		$this->assertEqual($query->num_rows(),1);
		$this->assertFalse($this->DBI->_error_message());
	}
	function resetTestTable() {
		$this->DBI->query('truncate test');
	}
}
?>