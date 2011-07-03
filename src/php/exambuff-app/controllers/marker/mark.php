<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * The user panel, routed from /user
 */
class Mark extends EB_Controller {
	protected $_authRequired = true;
	protected $_sessionAuthVar = 'marker';

	function index() {
		$this->load->model('marker');
		$this->marker->retrieve($this->_getUser());
		if($this->marker->isTutor()) { 
			$this->load->view('marker/marker_flex');
			return;
		}
		$this->_template('chunks/messages','',array('errors'=>array('You need to have passed your tutor assessment to view this page')));
	}
}