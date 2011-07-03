<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require ('../exambuff/controllers/markerauth.php');
class Passwrds extends EB_Controller {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	function index() {
		return;
		$this->load->model('marker');
		$emails = array('maarit.lassander@yahoo.co.uk','U.Wolski@rhul.ac.uk','l.francis@rhul.ac.uk');
		$words = array('dance','el3phant','cam3ra');
		$i = 1;
		foreach($emails as $email) {
			$i++;
			if($i > 2) $i = 0;
			$marker = new Marker();
			$pass = substr(uniqid(),2,2).$words[$i];
			$marker->setKey($email);
			$newPass = $marker->makePass($pass);
			$marker->set('password',$newPass);
			$marker->create();
			echo '<br>Marker: '.$email.'<br>Pass: '.$pass;
		}
	}
}
