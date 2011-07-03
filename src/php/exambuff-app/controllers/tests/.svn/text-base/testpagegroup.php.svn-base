<?php
class TestPageGroup extends UnitTestCase {
	private $CI;
	function TestPageGroup() {
		parent::UnitTestCase();
		$this->CI =& get_instance();		
		$this->DBI = $this->CI->load->database('testing',TRUE);
	}
	function setUp() {
		$this->CI->load->model('script');
		$cleanOutUsers = "TRUNCATE users";
		$cleanOutPages = "TRUNCATE pages";
		$cleanOutScripts = "TRUNCATE scripts";

		$this->DBI->query($cleanOutUsers);
		$this->DBI->query($cleanOutPages);
		$this->DBI->query($cleanOutScripts);

		$rowOneSQL = "INSERT INTO scripts (email,pageKeys,status) VALUES ('jonny@woo.com','script1_page1|script1_page2','".Script::ACTIVE."')";
		$rowTwoSQL = "INSERT INTO scripts (email,pageKeys,status) VALUES ('nenny@woo.com','script2_page1|script2_page2','".Script::ACTIVE."')";
		$page1 = "INSERT INTO pages (fileName) VALUES ('script1_page1')";
		$page2 = "INSERT INTO pages (fileName) VALUES ('script1_page2')";
		$page3 = "INSERT INTO pages (fileName) VALUES ('script2_page1')";
		$page4 = "INSERT INTO pages (fileName) VALUES ('script2_page2')";
		$pass = sha1('pass');

		$user1 = "INSERT INTO users (email,password) VALUES ('jonny@woo.com','$pass')";
		$user2 = "INSERT INTO users (email,password) VALUES ('nenny@woo.com','$pass')";

		$this->DBI->query($rowOneSQL);
		$this->DBI->query($rowTwoSQL);
		$this->DBI->query($page1);
		$this->DBI->query($page2);
		$this->DBI->query($page3);
		$this->DBI->query($page4);
		$this->DBI->query($user1);
		$this->DBI->query($user2);
	}
	function testRemovePage() {
		$this->CI->load->model('script');
		$script = new Script($this->DBI);
		$script->setKey(1);
		$script->retrieve();
		$this->assertTrue(count($script->pages->getPageKeys())===2,'Test page group retrieves as expected');
		
		
	}
}