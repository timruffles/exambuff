<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
class Page extends Crud {
	/*
	 * @todo fileExists in delete - should this be worrying if there isn't a file? logging?
	 */
	public function Page($DBI = null) {
		parent::Crud($DBI);
		$this->table = 'pages';
		$this->data = array('fileName'=>'',
							'scriptKey'=>'',
							'oldFileName'=>'');
		$this->key = 'fileName';
	}
	public function delete() {
		// no need to retrieve - the key is the file name
		$fileName = $this->config->item('page_directory').$this->get('fileName');
		if(file_exists($fileName)) {
			unlink($fileName);
		}
		log_message('error','page deleting');
	   	return Crud::delete();
	}
}