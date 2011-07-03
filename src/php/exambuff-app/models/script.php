<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'crud.php';
require_once 'pagegroup.php';
/**
 * Exam script - stores the reference to pages stored in another table, and is reponsible for their ordering
 *
 */
class Script extends Crud {
	const ACTIVE = 'active';
	const PAID = 'paid';
	const MARKING = 'marking';
	const MARKED = 'marked';
	private $_pages; // stores the pageGroup that controls the keys and page objects representing this script

	public function Script($codeIgniterDb = null) {
		parent::Crud($codeIgniterDb);
		$this->data = array('email'=>'',
                                    'subject'=>'',
                                    'question'=>'',
                                    'ID'=>'',
                                    'pageKeys'=>'',
                                    'status'=>''); // pagekeys in a string of pageKey[|key...]
		$this->_pages = new PageGroup($this,$this->DBI);
		$this->table = 'scripts';
		$this->key = 'ID';
	}
	/**
	 * Returns a new page name in the correct format
	 *
	 * @param Int $number - the page of the page
	 * @return string - a new name in the page$number format
	 */
	public function newPageName() {
		$newName = $this->getKey().'_'.time(); // create the file name in 'id_time' format
		return $newName;
	}
	/**
	 * Used to create a new script for a user, and then prepare it to be updated by getting the created key.
	 *
	 * @param string $key - $key for user - at 1.08.08 the email
	 */
	public function createNewScriptFor($email) {
		$this->set('email',$email);
		$this->set('status',Script::ACTIVE);
		$this->create();
		// get the new ID in this instance
		$this->setKey($this->getInsertID());
	}
	/**
	 * Used to find the key of an active script for a user, if present, returns false if none found
	 *
	 * @param $email
	 * @return String $key - script key
	 */
	public function getUnpaidScript($email) {
		$sql = "SELECT * FROM $this->table WHERE email=? AND status='".Script::ACTIVE."' LIMIT 1";
		$keyResult = $this->DBI->query($sql,array($email));

		if($keyResult->num_rows() == 1) {
			$resultRow = $keyResult->row();
			$key = $resultRow->ID;
		} else {
			$key = false;
		}
		return $key;
	}
	/**
	 * Used to find the key of an active script for a user, if present, returns false if none found
	 *
	 * @param $email
	 * @return String $key - script key
	 */
	public function getActiveScriptKey($email) {
		$sql = "SELECT * FROM $this->table WHERE email=? AND status='".Script::ACTIVE."' LIMIT 1";
		$keyResult = $this->DBI->query($sql,array($email));

		if($keyResult->num_rows() == 1) {
			$resultRow = $keyResult->row();
			$key = $resultRow->ID;
		} else {
			$key = false;
		}
		return $key;
	}
	/*
	 * Returns a CI result object for the specified number of submitted scripts, as old as possible.
	 */
	public function getScriptsForMarking($numberOfScripts = 10) {
		// don't select 32, that's the assessment script as of 18-01-09
		$sql = "SELECT ID, question, subject, created, pageKeys FROM scripts WHERE status='".Script::PAID."' AND ID <> 32 ORDER BY created LIMIT $numberOfScripts";
		return $this->DBI->query($sql);
	}
	public function getAssessmentScript() {
		$assessID = 32;
		$sql = "SELECT ID, question, subject, created, pageKeys FROM scripts WHERE ID='".$assessID."' LIMIT 1";
		return  $this->DBI->query($sql);
	}
	
	/*
	 * Returns scripts in an assoc array
	 */
	public function getScriptsFor($user,$numberOfScripts = 10,$startFrom = false) {
		if($startFrom !== false && !is_numeric($startFrom)) throw new Exception ('Start from must be numeric');
		$startFrom ? $startFrom = "$startFrom" : $startFrom = 0;
		$sql = "SELECT ID, question, status, updated, pageKeys FROM scripts WHERE email=? ORDER BY updated DESC LIMIT $startFrom, $numberOfScripts";
		$query = $this->DBI->query($sql,array($user));
		return $query->result_array(); 	
	}
	/**
	 * Gets the latest N scripts marked by a specified marker that are marked but not paid.
	 * 
	 * @return assoc array
	 */
	function getMarksForWages($marker,$numberOfScripts = 10) {
		if(!is_numeric($numberOfScripts)) throw new Exception('Mark getMarkedScripts requires a number as its second param');
		$sql = "SELECT ID, created, status FROM $this->table WHERE marker=? AND status=".Mark::UNPAID." LIMIT $numberOfScripts";
		$query = $this->DBI->query($sql,array($marker));
		return $query->result_array(); 
	}
	/**
	 * Returns scripts requiring payment, or the current script, in an array
	 *
	 * @return array 
	 */
	public function getScriptsToPay($user) {
		$this->load->model('script');
		$sql = "SELECT ID, question, updated FROM scripts WHERE email=? AND status='".Script::SUBMITTED."'";
		$query = $this->DBI->query($sql,array($user));
		return $query->result_array(); 	
	}
	/**
	 *  Returns scripts in CI Query obj format
	 *
	 * @param $user
	 * @return CI_Query
	 */
	public function getMarkedScriptsFor($user) {
		if($user == null) throw new Exception("Can't fetch scripts without being authorised");
		$sql = "SELECT scripts.ID, scripts.question, scripts.subject, markers.username, scripts.pageKeys FROM scripts, marks, markers WHERE scripts.email=? AND marks.script = scripts.ID and markers.email = marks.marker";
		$query = $this->DBI->query($sql,array($user));
		return $query;
	}	
	/**
	 * Gets all target data for a script, in array format below
	 *
	 * @param unknown_type $scriptID
	 * @return array['targets','generalComments']
	 */
	public function getTargets($scriptID = null) {
		if($scriptID == null) {
			if(!$scriptID = $this->getKey()) throw new Exception ('Get targets either needs to be passed an ID or have one set');
		}
		// page keys to allow linking to view inline comments
		
		$sql = "SELECT scripts.question, scripts.pageKeys, marks.targets, marks.generalComment FROM scripts, marks WHERE scripts.ID = marks.script AND scripts.ID = '$scriptID' LIMIT 1";
		$query = $this->DBI->query($sql,array($scriptID));
		
		if($query->num_rows()===0) return false;
		
		$results = $query->result_array();
		
		$targetRow = $results[0];
		
		
		$returnArray['targets'] = $targetRow['targets'];
		$returnArray['generalComment'] = $targetRow['generalComment'];
		$returnArray['question'] = $targetRow['question'];
		$returnArray['pages'] = count(unserialize($targetRow['pageKeys']));
		
		return $returnArray;
	}
	/**
	 * CRUD overrides and magic methods
	 */
		public function __get($key) {
			if($key=='pages') return $this->_pages;
		}
		/**
		 * Over-rides Crud create
		 *
		 */
		public function create() {
			$this->data['pageKeys'] = $this->_pages->getStorableKeys();
			return Crud::create();
		}
		/**
		 * Over-rides Crud update
		 *
		 */
		public function update() {
			$updateOnEmpty = true;
			$retrievedKeys = $this->data['pageKeys'];
			if(empty($retrievedKeys)) {
				$updateOnEmpty = false; 
			} else {
				if ($unS = serialize($retrievedKeys)) {
					if(empty($unS)) {
						$updateOnEmpty = false; 
					}
				}
			}
			$current = $this->_pages->getPageKeys();
			if(empty($current)) {
				if($updateOnEmpty) $this->data['pageKeys'] = $this->_pages->getStorableKeys();
			} else {
				$this->data['pageKeys'] = $this->_pages->getStorableKeys();
			}
			return Crud::update();
		}
		/**
		 * Over-rides Crud retrieve
		 *
		 */
		public function retrieve($key = null) {
			$result = Crud::retrieve($key);
			if($result) {
				$this->_pages->restoreStoredKeys($this->data['pageKeys']);
			}
			return $result;
		}
		public function delete() {
			foreach($this->_pages->getPageKeys() as $page) {
				$this->_pages->removePage($page);
			}
			return Crud::delete();
		}
		/*
		 * Sets status to paid
		 */
		public function paid() {
			$this->data['status'] = Script::PAID;
		}
		/*
		 * Sets status to marked
		 */
		public function marked() {
			$this->data['status'] = Script::MARKED;
		}
		/*
		 * Sets status to currently being marked
		 */
		public function marking() {
			$this->data['status'] = Script::MARKING;
		}
}