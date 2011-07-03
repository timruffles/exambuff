<?php
class TestUpload extends UnitTestCase {
	var $CI;
	function TestUpload() {
		parent::UnitTestCase();
		$this->CI =& get_instance();
		$this->DBI = $this->CI->load->database('testing',TRUE);		
		$this->setUpDB();
	}
	function setUpDB() {
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
	// if we don't have a crud, get one, else load it up
	function resetModel($model) {
		if(isset($this->CI->$model)) {					
			$this->CI->$model = new $model;			
			return true;
		}
		$this->CI->load->model($model);
	}
	function testSecureUploadClass() {
		$this->CI->load->library('secureupload','../../uploadedfiles/');
		$this->assertNoErrors('No error in loading secure upload');		
	}

}
?>