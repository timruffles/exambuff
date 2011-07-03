<?php
class LoginForm extends WebTestCase {
	private $base = 'http://localhost:8080/CI/index.php/';	
	private $CI;
	private $DBI;
	function LoginForm() {
		parent::WebTestCase();
		$this->CI =& get_instance();
		$this->DBI = $this->CI->load->database('testing',TRUE);		
	}
	function _resetSession() {
		$cleanOutSessions = "TRUNCATE ci_sessions";
		$this->DBI->query($cleanOutSessions);
	}
	function setUp() {		
		
		$cleanOutUsers = "TRUNCATE users";
		$cleanOutPages = "TRUNCATE pages";
		$cleanOutScripts = "TRUNCATE scripts";
		
		$this->DBI->query($cleanOutUsers);
		$this->DBI->query($cleanOutPages);
		$this->DBI->query($cleanOutScripts);
		
		
		$rowOneSQL = "INSERT INTO scripts (email,pageKeys) VALUES ('jonny@woo.com','script1_page1|script1_page2')";
		$rowTwoSQL = "INSERT INTO scripts (email,pageKeys) VALUES ('nenny@woo.com','script2_page1|script2_page2')";
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
	function testLogin() {		
		$this->get($this->base.'user/login');
		$this->setField('email','jonny@woo.com');
		$this->setField('password','pass');
		$this->submitFormById('login');
		$this->assertText('Success!','Test login with correct details');
		//$this->assertEqual($this->CI->session->userdata('email'),'jonny@woo.com','Test login status in session');	
	}
	function testFailLoginPass() {	
		$this->get($this->base.'user/login');
		$this->setField('email','jonny@woo.com');
		$this->setField('password','wrongpass');
		$this->submitFormById('login');
		$this->assertText('incorrect','Test login with incorrect password');
		
		$this->get($this->base.'user/login');
		$this->setField('email','wrong@woo.com');
		$this->setField('password','pass');
		$this->submitFormById('login');
		$this->assertText('incorrect','Test login with incorrect username');
	}
	function testLogout() {
		$this->get($this->base.'/logout');
		$this->assertText('Email','Test logout redirects to login');		
	}
}
?>