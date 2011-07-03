<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html
 * @link		http://www.codeigniter.com
 * @since		Version 1.5
 * @filesource
 */

// ------------------------------------------------------------------------


if ( ! class_exists('Services_JSON') ){
	require_once('Services_JSON.php');
}

/**
 * CodeIgniter JSON Class
 *
 * Basically a wrapper for the original Services_JSON class
 * that allows to Encode and decode JSON.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Alex Golovanov
 * @link		http://pr0digy.com
 */

class Json {

	var $json;

	/**
	 * Constructor - Init Services_JSON class
	 *
	 */
	function Json(){
		$this->json = new Services_JSON();
	}

	/**
	 * encode
	 *
	 * Encode PHP to JSON.
	 *
	 * @access	public
	 * @param	mixed
	 * @return	string
	 */
	function encode($data = null){
		if($data == null) return false;
		return $this->json->encode($data);
	}

	/**
	 * decode
	 *
	 * Decode JSON to PHP.
	 *
	 * @access	public
	 * @param	string
	 * @return	mixed
	 */
	function decode($data = null){
		if($data == null) return false;
		return $this->json->decode($data);
	}
}

// ------------------------------------------------------------------------

?>