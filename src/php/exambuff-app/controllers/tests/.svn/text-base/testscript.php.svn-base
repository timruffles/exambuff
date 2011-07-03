<?php
class TestScript extends UnitTestCase {
	private $CI;
	function TestScript() {
		parent::UnitTestCase();
		$this->CI =& get_instance();		
		$this->DBI = $this->CI->load->database('testing',TRUE);
	}
	function setUp() {
		$this->CI =& get_instance();
		$this->CI->load->model('script');
		$this->TestScript();
		$cleanOutUsers = "TRUNCATE users";
		$cleanOutPages = "TRUNCATE pages";
		$cleanOutScripts = "TRUNCATE scripts";

		$this->DBI->query($cleanOutUsers);
		$this->DBI->query($cleanOutPages);
		$this->DBI->query($cleanOutScripts);
		
		$pages1 = 'a:2:{i:0;s:13:"script1_page1";i:1;s:13:"script1_page2";}';
		$pages2 = 'a:2:{i:0;s:13:"script2_page1";i:1;s:13:"script2_page2";}';
		
		$rowOneSQL = "INSERT INTO scripts (email,pageKeys,status) VALUES ('jonny@woo.com',?,'".Script::ACTIVE."')";
		$rowTwoSQL = "INSERT INTO scripts (email,pageKeys,status) VALUES ('nenny@woo.com',?,'".Script::ACTIVE."')";
		$page1 = "INSERT INTO pages (fileName) VALUES ('script1_page1')";
		$page2 = "INSERT INTO pages (fileName) VALUES ('script1_page2')";
		$page3 = "INSERT INTO pages (fileName) VALUES ('script2_page1')";
		$page4 = "INSERT INTO pages (fileName) VALUES ('script2_page2')";
		$pass = sha1('pass');

		$user1 = "INSERT INTO users (email,password) VALUES ('jonny@woo.com','$pass')";
		$user2 = "INSERT INTO users (email,password) VALUES ('nenny@woo.com','$pass')";

		$this->DBI->query($rowOneSQL,array($pages1));
		$this->DBI->query($rowTwoSQL,array($pages2));
		$this->DBI->query($page1);
		$this->DBI->query($page2);
		$this->DBI->query($page3);
		$this->DBI->query($page4);
		$this->DBI->query($user1);
		$this->DBI->query($user2);
	}
	// if we don't have a crud, get one, else load it up
	function resetModel($model) {
		if(isset($this->CI->$model)) {
			$this->CI->$model = new $model;
			return true;
		}
		$this->CI->load->model($model);
	}
	function testScriptClass() {
		$this->resetModel('script');
		$this->assertNoErrors('Assert script model can be opened');
	}
	function testPageKeys() {
		$script = new Script();
		$script->pages->setPageKeys(array('one','two','three'));
		$pageArray = $script->pages->getPageKeys();
		$this->assertTrue(is_array($pageArray),'Expect successful explosion of pipe delinated page keys');

	}
	function testReorderScript() {
		$script = new Script($this->DBI);
		$script->pages->setPageKeys(array('one','two','three'));
		$this->assertTrue(is_array($script->pages->getPageKeys()) && count($script->pages->getPageKeys())===3,'Test successfully set array');
		$script->pages->swapPages(0,1);
		$script->pages->swapPages(1,2);
		$this->assertTrue($script->pages->getPageKeyAt(1)==='three','Test successfully swapped pages');

		$this->assertTrue($script->pages->getPageKeyAt(2)==='one','Test successfully swapped pages');
		$script->pages->addPage(3,'four','fifty');
		$this->assertTrue($script->pages->getPageKeyAt(3)==='four','Test successfully swapped pages');
	}
	function testCrudFunctions() {
		$script = new Script($this->DBI);
		$script->setKey(2);
		$script->retrieve();

		$this->assertTrue(count($script->pages->getPageKeys())===2,'Ensure script has retrieved successfully');
		$this->assertTrue($script->pages->getPageKeyAt(0)==='script2_page1','Test read page');

		$script->pages->swapPages(0,1);

		$this->assertTrue($script->pages->getPageKeyAt(0)==='script2_page2','Test swap page');

		$script->pages->removePage(1);
		$this->assertTrue(count($script->pages->getPageKeys())===1,'Test page delete');
		
		$script->update();
		
		$script = new Script($this->DBI);
		$script->setKey(2);
		$script->retrieve();
		$this->assertTrue(count($script->pages->getPageKeys())===1,'Test page updated after deleting');
		//echo "\n\n **** REMOVING PAGE 0 *** \n";
		$script->pages->removePage(0);
		$this->assertTrue(count($script->pages->getPageKeys())===0,'Test page delete after update');
		//echo "\n\n **** UPDATE WITH 0 *** \n";
		$script->update();
		//echo "\n\n **** RETRIEVE WITH 0 *** \n";
		$script = new Script($this->DBI);
		$script->setKey(2);
		$script->retrieve();
		$this->assertTrue(count($script->pages->getPageKeys())===0,'Test page updated and retrieved with 0 script keys');
		
		$script = new Script($this->DBI);
		$script->createNewScriptFor('joe@fish.com');
		$key = $script->getKey();
		$script->pages->addPage(1,'fourxx','old');
		$script->update();

		$script = new Script($this->DBI);
		$script->setKey($key);
		$script->retrieve();

		$this->assertTrue($script->get('email')==='joe@fish.com','Test createNewScriptFor');
		$this->assertTrue($script->pages->getPageKeyAt(0) === 'fourxx','Test create, update, and retrieve');


	}
	function testActiveScriptFunctions() {
		$script = new Script($this->DBI);
		// get active script for jonny - this will be ID 1
		$activeKey = $script->getActiveScriptKey('jonny@woo.com');
		$this->assertEqual($activeKey,1,'Test select active script by user email');
	}
	function testSetPageAndAddPage() {
		$script = new Script($this->DBI);
		$script->pages->setPageKeys(array('one','two','three'));

		$this->assertTrue($script->pages->countPages() === 3,'Count pages gets right number');

		$script->pages->addPage(1,'fourx','old');
		$script->create();
		$key = $script->getInsertID();

		$newScript = new Script($this->DBI);
		$newScript->setKey($key);
		$newScript->retrieve();

		$this->assertTrue($newScript->pages->getPageKeyAt(3) === 'fourx','Add at index and retrieve');

		$newScript->pages->removePage($key);
		$newScript->update();

		$deletedScript = new Script($this->DBI);
		$deletedScript->setKey($key);
		$deletedScript->retrieve();
		$pageKeys = $newScript->pages->getPageKeys();
		//$this->assertTrue(empty($pageKeys),'Can handle empty page group');
	}
	function testSplicingRight() {
		$arr = array('one','two','three','four');
		array_splice($arr,1,1);
		$this->assertTrue($arr[1]==='three','Test splice method is as assumed');
		array_splice($arr,0,1);
		$this->assertTrue($arr[0]==='three','Test splice method is as assumed');
		array_splice($arr,0,1);
		array_splice($arr,0,1);
		$this->assertTrue(count($arr)===0,'Test splice method is as assumed');
	}
	function testEmptyStoring() {
		$this->CI->load->model('mark');
		$this->CI->load->model('script');

		
		// set script's status to marked
		$script = new Script();
		$script->setKey(1);
		$script->retrieve();
		$pageKeyOriginal = $script->pages->getPageKeys();
		
		$script = new Script();
		$script->setKey(1);
		$script->marked();
		$script->update();
		
		$script = new Script();
		$script->setKey(1);
		$script->retrieve();
		$this->assertTrue($pageKeyOriginal === $script->pages->getPageKeys(),'Ensure updating other values doesn\'t over-write pageKeys');
		
		$script->pages->addPage(1,'fourx','old');
		$script->update();
		
		$script = new Script();
		$script->setKey(1);
		$script->retrieve();
		$this->assertTrue(count($script->pages->getPageKeys()),'Ensure can add pageKeys');
	}
}
?>