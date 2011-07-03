<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('script.php');
/**
 * Hides the page array nicely, making manipulation simpler and keeping the script class streamlined
 *
 */
class PageGroup extends Model {
	// stores the key of the script this PageGroup relates to

	private $_pageKeys = array();
	private $_script;
	private $_DBI;
	
	const NO_PAGES = 'no pages';

	public function PageGroup(Script $script,$DBI=null) {
		parent::Model();
		// require to pass to pages
		$this->_DBI = $DBI;
		$this->load->model('page');
		$this->_script = $script;
	}
	public function addPage($at=null,$fileKey,$oldName) {

		$this->_pageKeys[] = $fileKey;

		$page = new Page($this->_DBI);
		$page->setKey($fileKey);
		$page->set('oldFileName',$oldName);
		$page->set('scriptKey',$this->_script->getKey());

		$page->create();
	}
	/**
	 * Sets page keys via either a formatted string list of pageKeys with pipes
	 *
	 * @param mixed $pageKeys
	 */
	public function setPageKeys($pageKeys) {
		if(!empty($pageKeys) && !is_array($pageKeys)) throw new Exception('setPageKeys requires an array');
		$this->_pageKeys = $pageKeys;
	}
	public function removePage($pageNumber) {
		if(array_key_exists($pageNumber,$this->_pageKeys)) {
			$this->load->model('page');
			$page = new Page($this->_DBI);
			$pageKey = $this->_pageKeys[$pageNumber];
			$page->setKey($pageKey);
			if ($page->delete()) {
				array_splice($this->_pageKeys,$pageNumber,1);
				return true;
			}
		}
		return false;
	}
	public function countPages() {
		return count($this->_pageKeys);
	}
	public function setPageAt($at,$to) {
		if(!is_numeric($at)) throw new Exception('setPageAt requires $at to be a string');
		if(!is_string($to)) throw new Exception('setPageAt requires a string to set the page key');
		$this->_pageKeys[$at] = $to;
	}
	public function swapPages($one,$two) {
		if(!is_numeric($one)||!is_numeric($two)) throw new Exception('script swapPages requires numbers as arguments');

		$pageOneTemp = array_slice($this->_pageKeys,$one,1);

		array_splice($this->_pageKeys,$one,1,$this->_pageKeys[$two]);

		array_splice($this->_pageKeys,$two,1,$pageOneTemp);

	}
	public function getOldFileNames() {
		if(count($this->_pageKeys)===0) {
			$oldFileNames = false;
		} else {
			foreach($this->_pageKeys as $pageKey) {
				$page = new Page();
				$page->retrieve($pageKey);
				$oldFileNames[] = $page->get('oldFileName');
			}
		}
		return $oldFileNames;
	}
	/*
	 * Returns pageKeys in an array
	 */
	public function getPageKeys() {
		return $this->_pageKeys;
	}
	public function getPageKeyAt($at) {
		if(!is_numeric($at)) { throw new Exception('getPageKeyAt requires a single number as argument');}
		if(array_key_exists($at,$this->_pageKeys)) {
			return $this->_pageKeys[$at];
		}
		return false;
	}
	public function getStorableKeys() {
		$keys = serialize($this->_pageKeys);
		return $keys;
	}
	public function restoreStoredKeys($keys) {
		$this->_pageKeys = unserialize($keys);
	}
}