<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CRUD gives create, retrieve, update and delete capabilities to a class
 * The CRUD methods all use mysql binding with CI's ? markers. ? markers are automatically
 * escaped, and will have ''s put round them if required
 *
 *  Remeber - sub-classes calling CRUD functions need to return true/false if they are going to be used for further logic.
 *  The true/false from the crud functions will not magically be returned by them!
 *
 * @todo think about the security of the meta field, which currently accepts all new fields from db
 * @todo createFromPost() is not secure
 */
class Crud extends Model {
	var $table;	// the table we'll be storing things in
	protected $data = array(); // the data
	protected $_metaData = array(); // data created and controlled only by the database - not updated
	var $DBI; // database instance - being passed this increases encapsulation
	var $key; // the array field used as the primary key
	var $autoKey = false;
	// allow DB object passing if required - much easier testing and much better OO practise
	function Crud($codeIgniterDb = null) {
		parent::Model();
		if($codeIgniterDb != null) {
			$this->DBI = $codeIgniterDb;
			return;
		}
		$this->DBI = $this->load->database($this->config->item('default_database'),TRUE);
	}
	/**
	 * Creates the row for the Crud object in the database, checking whether the key is not already stored
	 *
	 * @return unknown
	 */
	public function create() {
		if ($this->getKey() && !$this->checkKeyNotPresent($this->getKey()))  {
			return false;
		}
		foreach($this->data as $key => $value) {
			$keys[] = $key;
			$values[] = $value;
			$placeholders[] = '?';
		}
		// add useful extra columns
		// set created to null to log creation date - add another ? placeholder to be bound in query string
		$keys[] = 'created';
		$values[] = NULL;
		$placeholders[] = '?';

		$keys = implode(',',$keys);
		$placeholders = implode(',',$placeholders);
		$sql = "INSERT INTO $this->table ($keys) VALUES ($placeholders)"; // returns a string for binding
		if($this->DBI->query($sql,$values)) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * Retrieves the object from the database, from a key if supplied, but otherwise using the key set in the Crud instance
	 *
	 * @param unknown_type $findBy
	 * @return unknown
	 */
	public function retrieve( $findBy = null ) {
		if($findBy === null) {
			if(($findBy = $this->get($this->key)) === '') {
				throw new Exception("Request to retrieve made without key, though key is not already set");
			} 
		}
		$sql = "SELECT * FROM $this->table WHERE $this->key=? LIMIT 1";
		$query = $this->DBI->query($sql,array($findBy));
		if($query->num_rows()>0) {

			foreach($query->result_array() as $rowOfColumns) {
				foreach($rowOfColumns as $column => $value) {
					if(array_key_exists($column,$this->data)) {
						$this->data[$column] = $value;
					} else {
						$this->_metaData[$column] = $value;
					}
				}
			}
			return true;
		}
		log_message('error','Failed to return any results from '.$this->table.' with key '.$findBy);
		return false;
	}
	/**
	 * Updates the object's key row in the database
	 *
	 * @return unknown
	 */
	public function update() {
		foreach($this->data as $key => $value) {
			// make sure we don't overwrite anything that hasn't been changed with blanks
			if(!empty($value)) {
				// set each key up with a key='?' for sql binding with CI's ? binding character and mysql syntax
				$keys[] = $key." = ?";
				$values[] = $value;
			}
		}
		$keys = implode(', ',$keys);
		$sql = "UPDATE $this->table SET $keys WHERE $this->key ='".$this->getKey()."' LIMIT 1"; // returns a string for binding
		
		if($this->DBI->query($sql,$values)) {
			return true;
		} else {
			throw new Exception("Update failed due to ".mysql_error());
			return false;
		}

	}
	/**
	 * Removes the object's row from the database.
	 *
	 * @return unknown
	 */
	public function delete() {
		
		$key = $this->getKey();
		$keyColumn = $this->key;
		$sql = "DELETE FROM $this->table WHERE $keyColumn = ? LIMIT 1";
		$query = $this->DBI->query($sql,array($key));
		return true;
		if($query->affected_rows() == 1) {
			log_message('error','aff rows = 1');
			return TRUE;
		}
		log_message('error','aff rows < 1');
		return FALSE;
	}
	/**
	 * Data functions
	 **/
	/*
	 * Returns the value from the data array - all info set from outside the database
	 */
	function get($field) {
		if(array_key_exists($field,$this->data)) {
			return $this->data[$field];
		}
		throw new Exception("Request to get field $field when $field does not exsist in this object");
	}
	/*
	 * Returns a value in the data array - all info set from outside the database
	 */
	function set($field, $value) {
		if(is_array($value)) throw new Exception('Set value passed as array when string is required');
		if(array_key_exists($field,$this->data)) {
			$this->data[$field] = $value;
			return true;
		} else {
			throw new Exception("Request to set field $field to $value when $field does not exist in this object");
		}
	}
	/*
	 * Returns a value in the meta array - all info set by the database
	 */
	function meta($field) {
		if(array_key_exists($field,$this->_metaData)) {
			return $this->_metaData[$field];
		}
		return false;
 	}

	function getInsertID() {
		return $this->DBI->insert_id();
	}
	/**
	 * Get the column name used as key
	 *
	 * @return unknown
	 */
	public function getKeyField() {
		return $this->key;
	}
	/**
	 * Gets the value of the column used as key, or the value that will go into this column
	 *
	 * @return unknown
	 */
	public function getKey() {
		empty($this->data[$this->key]) ? $r = false : $r =$this->data[$this->key];
		return $r;
	}
	/*
	 *  Sets the value of the column used as key, or the value that will go into this column
	 */
	public function setKey($to) {
		$this->data[$this->key] = $to;
	}
	// secure? only takes post values we have set
	public function buildFromPost() {
		$keysPresent = 0;
		foreach($this->data as $key => $value) {
			if($this->input->post($key)) {
				$this->data[$key] = $this->input->post($key);
				$keysPresent++;
			}
		}
		if($keysPresent === 0) {
			log_message('error','buildFromPost called when no fields matched');
			return false;
		}
		return true;
	}
	public function asAssoc() {
		return $this->data;
	}
	public function fromAssoc($assoc) {
		foreach($this->data as $key => $value) {
			$this->set($key,$assoc[$key]);
		}
	}
	/**
	 * Check that the data to be inserted is not over-writing a field. Returns false if it is
	 *
	 * @param unknown_type $key
	 * @return boolean: true is present; false otherwise
	 */
	public function checkKeyNotPresent($key) {
		$sql = "SELECT * FROM $this->table WHERE $this->key='$key'"; // returns a string for binding
		$query = $this->DBI->query($sql);
		if($query->num_rows()!==0) {
			return false;
		}
		return true;
	}
}