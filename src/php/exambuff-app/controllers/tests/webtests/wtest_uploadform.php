<?php
class UploadForm extends WebTestCase {
	private $base = 'http://localhost:8080/CI/index.php/';	
	private $CI;
	private $DBI;
	function UploadForm() {
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
	function testUpload() {
		$uploadDir = '../../uploadedFiles/';
		$fileDirectory = '../../uploadedFiles/tests/';
		$goodFile = $fileDirectory.'testImage.jpg';
		$badFile = $fileDirectory.'wrong.exe';
		
		
		$this->_login();
		$this->get($this->base.'user/scriptupload');	
		$this->setFieldById('page11',$goodFile);
		$this->submitFormById('noscriptUploader');
		$this->showSource();
	
		
		$this->assertText("1",'Upload successful');
				
	}
	function _login() {		
		$this->get($this->base.'user/login');
		$this->setField('email','jonny@woo.com');
		$this->setField('password','pass');
		$this->clickSubmit();
		$this->assertText('1','Login attempt with correct details');
	}
}
?>