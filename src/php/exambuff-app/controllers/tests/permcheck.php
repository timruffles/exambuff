<?php
class permcheck extends Controller {
	function index() {
		$this->load->helper('file');
		$tmpdir = '../../tmp';
		echo 'upload dir:'.$this->config->item('upload_directory').'<br />';
		echo octal_permissions(fileperms($this->config->item('upload_directory'))).'<br />';
		echo 'tmp dir:'.$tmpdir.'<br />';
		echo octal_permissions(fileperms($tmpdir)).'<br />';
		if(opendir($this->config->item('upload_directory'))){
			echo 'sucessfully opened upload dir<br />';
		} else {
			echo 'failed to open upload dir<br />';
		}
		if(write_file($this->config->item('upload_directory').'/test.txt','success')) {
			echo 'successfully wrote to upload dir';
		}
		if(opendir($tmpdir)){
			echo 'sucessfully opened tmp dir<br />';
		} else {
			echo 'failed to open upload dir<br />';
		}
		if(write_file($this->config->item('../../tmp').'/test.txt','success')) {
			echo 'successfully wrote to tmp dir';
		}
		phpinfo();
	}
}