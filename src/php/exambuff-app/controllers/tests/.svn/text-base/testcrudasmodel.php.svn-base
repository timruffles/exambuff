<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * test for base Crud class, mainly through its subclasses (as it's pretty well an abstract)
 * currently tests create and retrieve
 */
class TestCRUD extends UnitTestCase {
	var $CI;
	function TestCRUD() {
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
	function resetTestTable() {
		$this->DBI->query('truncate test');
	}
	// just checking whether we can load it up in the first place. This was a milestone; play nice CI!
	function testGetCRUDObject() {
		$this->resetModel('crud');
	}
	/* test obselete - decided to use Crud as an abstract, and therefore no params need to be set
	// check the error detection
	function testCRUDRequiresCorrectParams () {
		try {
		$this->resetCrud(array(FALSE,array()));
		$this->expectException(); // we have passed the data as a TRUE not an Array - we need a fail here
		} catch (Exception $e) {

		}
	}*/
	// can we add a datum?
	function testAddData() {
		$this->resetModel('user');
		$this->CI->user->set('name','harry');
		$this->assertEqual($this->CI->user->get('name'),'harry');
		try {
			$this->CI->user->set('firstName',array()); // set it to the wrong data type
			$this->expectException();
		} catch (Exception $e) {

		}
	}

	function testCreate() {
		$this->DBI->query('truncate users');
		$user = new User($this->DBI);
		$user->set('email','testEmail');
		//$this->CI->user->{get_parent_class($this->CI->user)}(); <- Big realisation - i didn't call parent::Crud(); in user's constructor!

		$user->create();

		//test
		$sql = "SELECT * FROM users WHERE email='testEmail' LIMIT 1";
		$query = $this->DBI->query($sql);
		$this->assertEqual($query->num_rows(),1,'Successfully created and retrieved user model');
		$this->assertFalse($this->DBI->_error_message(),'No database error unexpectedly present');
	}
	function testRetrieve() {
		$user = new User($this->DBI);
		$this->resetTestTable();
		$testEmail = 'testerEmail';
		$testName = 'testerName';

		//set up
		$user->table = 'test'; // this isn't going to be allowed...
		$user->set('name',$testName);
		$user->set('email',$testEmail);
		//$user->{get_parent_class($user)}(); <- Big realisation - i didn't call parent::Crud(); in user's constructor!
		$user->create();
		$this->resetModel('user');

		$user->table = 'test';
		$user->retrieve($testEmail);
		$this->assertEqual($user->get('email'),$testEmail,'Test email correctly retrieved');
		$this->assertEqual($user->get('name'),$testName,'Test name correctly retrieved');
	}
	function testPassdatabase() {
		$this->CI->load->model('script');
		$testCrudInstance = new Script($this->DBI);
		$testCrudInstance->createNewScriptFor('testPassdatabase@test.com');
		$this->assertNoErrors('Test pass database with no errors');
	}

}
?>