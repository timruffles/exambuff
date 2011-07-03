<?php
class EB_FlexOutputPage extends Controller {
	/**
	 * Takes a request for a image in scriptNum-pageNum.jpg format - to allow caching
	 */
	protected function page() {
		$this->load->model('script');
		$script = new Script();
		$imageFileRequested = $this->uri->segment(4);
		$splitAroundPipe = explode('-',$imageFileRequested);
		$scripNum = $splitAroundPipe[0];
		$splitOnFullstop = explode('.',$splitAroundPipe[1]);
		$pageNum = $splitOnFullstop[0];
		$script->retrieve($scripNum);
		$pageFile = $script->pages->getPageKeyAt((int)$pageNum);
		$this->_outputPage($pageFile);
	}
	/**
	 * Outputs a page from its real filename.
	 *
	 * @param unknown_type $page
	 */
	protected function _outputPage($page) {
		$this->load->helper('file');
		$location = $this->config->item('page_directory').$page;
		$data = file_get_contents($location);
	    header('Content-Length:'.strlen($data));
	    header('Content-type: image/jpeg');
	    echo $data;
	    log_message('error','attempting to output '.strlen($data).' from '.$location);
	}
}