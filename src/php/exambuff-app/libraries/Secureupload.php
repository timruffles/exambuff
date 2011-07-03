<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class SecureUpload {

    const UNSUCCESSFUL = 'UNSUCCESSFUL';
	const MOVE_FAILED = 'MOVE_FAILED';
	const TOO_LARGE = 'TOO_LARGE';
	const WRONG_TYPE = 'WRONG_TYPE';
	const SUCCESSFUL = 'SUCCESSFUL';

	private $uploadDirectory;
	// null to allow loading to access constants
	public function SecureUpload($uploadDirectory = null) {
		if($uploadDirectory) {
			$this->uploadDirectory = $uploadDirectory;
			return;
		}
		$CI =& get_instance();
		$this->uploadDirectory =  $CI->config->item('upload_directory');
	}
	/**
	 * Takes either a single file to clean, or removes all temporary files in the $_FILES array if no paramater is passed
	 *
	 * @param string $file
	 */
	public static function cleanTemporary($file=null) {
		if($file) {
			@unlink($file['tmp_name']);
		} else {
			foreach($_FILES as $file) {
				unlink($file['tmp_name']);
			}
		}
	}
    /**
     * Stores a file from $_FILES specified by $file in $location, after checking whether it has an $allowExtensions
     * type, and it is below the $maxSize;
     *
     * @param $file - the file name in $_FILES
     * @param $location - new name for the file
     * @param $allowExtensions - extensions, array without .'s
     * @param $maxSize - max is in bytes
     * @return one of four SecureUpload class constants
     */
    public function store($file,$newName,$allowedExtensions,$maxSize) {
    		if(empty($allowedExtensions)) { throw new Exception('store requires allowed extensions to be set');}
    		if(!is_array($allowedExtensions)) { throw new Exception('store requires allowed extensions to be supplied in an array');}
    		if(!is_int($maxSize))  { throw new Exception('store requires max size to be passed as an interger in bytes'); }


	    	return $this->localUpload($file,$newName,$allowedExtensions,$maxSize);

    	// option to use a different technique via config file
    }
    private function localUpload($file,$fileName,$allowedExtensions,$maxSize) {

		$fileLocation = $this->uploadDirectory.$fileName;

    	if (!$this->allowedType($file,$allowedExtensions)) {
    		return SecureUpload::WRONG_TYPE;
    	} elseif (!$this->allowedSize($file,$maxSize)) {
    		return SecureUpload::TOO_LARGE;
    	} elseif (move_uploaded_file($_FILES[$file]['tmp_name'],$fileLocation)) {
			return SecureUpload::SUCCESSFUL;
		}
		return SecureUpload::UNSUCCESSFUL;
    }
    /**
     * Checks file type against list of allowed types
     * @param unknown_type $file
     */
    private function allowedType($file,$allowedExtensions) {

    	$tmp = explode('.',$_FILES[$file]['name']);
    	$fileExt = $tmp[count($tmp)-1];

    	if(in_array(strtolower($fileExt),$allowedExtensions)) {
    		return true;
    	}
    	return false;
    }
    /**
     * Checks file size vs the supplied maxsize
     *
     *
     */
    private function allowedSize($file,$maxSize) {

    	if($_FILES[$file]['size']>$maxSize) {
    		return false;
    	}
    	return true;
    }
}