<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ModelState extends Model {
	public function returnSessionModel($sessionModel) {
		

		// do we have a script in the current session?
		if($this->session->userdata($sessionModel)) {
			// YES session present
			$this->load->model($sessionModel);


			$sessionModelKey = $this->session->userdata($sessionModel);
			// retrieve the script
			$returnModel = new $sessionModel();
			$returnModel->setKey($sessionModelKey);
			$returnModel->retrieve();

			return $returnModel;
		}
		return false;
	}
}