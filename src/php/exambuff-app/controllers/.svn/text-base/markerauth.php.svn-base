<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * EB_Controller should be used for any pages requiring authentication.
 *
 * Override logoutMessage to set custom logout reasons, redirections etc
 *
 */
class MarkerAuth extends EB_Controller {
	protected $_authRequired = true;

	protected $_sessionAuthVar = 'markerEmail';
	protected $_loginURL = '/marker/login';
	protected $_flexFailURL = '/marker/login/flexfail';
	
	const NOT_LOGGED_IN = 'NOT LOGGED IN';
	public function index() {
		parent::EB_Controller();
	}
}
