<?php
class TemplateData {
	
	private $head;
	private $page;
	private $view;
	private $footer;
	
	public function __get($name) {
		if($name == 'head' ||
			$name == 'page' ||
			$name == 'view' ||
			$name == 'footer') return $this->$name;
		throw new Exception('No parameter '.$name.' on TemplateData');
	}
	/**
	 * Creates a assoc headData array; can be passed individuals variables, or a associative array
	 * with keys named below as a sole arg.
	 * 
	 * @param $title String || $assocArgs Array
	 * @param $js Array
	 * @param $ssl Boolean
	 */
	function setHead($title=null,$js=null,$ssl=false) {
		if(func_num_args()===1) {
			if(is_array(func_get_arg(0))) {
				$this->head = $title;
				return;
			}
		}
		if($ssl!=false&&$ssl!=true) throw new Exception('$ssl needs to be a boolean');
		$this->head = array('title'=>$title,'js'=>$js,'ssl'=>$ssl);
	}
	/**
	 * Creates a assoc headData array; can be passed individuals variables, or a associative array
	 * with keys named below as a sole arg.
	 * 
	 * @param $bodyID String || $assocArgs Array
	 */
	function setPage($bodyID=null) {
		if(func_num_args()===1) {
			if(is_array(func_get_arg(0))) {
				$this->page =  $bodyID;
				return;
			}
		}
		$this->page =  array('bodyId'=>$bodyID);
	}
	/**
	 * Stores assoc viewData array; can be passed individuals variables, or a associative array
	 * with keys named below as a sole arg.
	 * 
	 * @param $viewData Array
	 */
	function setView($viewData) {
		$this->view =  $viewData;
	}
	function setFooter($footerData) {
		$this->footer =  $footerData;
	}
}