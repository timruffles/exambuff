<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Faq extends Controller {
	protected $_directory;
	protected $_faqFolder = 'faq/';
	protected $_viewDir = 'application/views/';
	protected $_faqTitle = 'Exambuff FAQ';
	function Faq() {
		parent::Controller();
		$this->_directory = $this->_viewDir.$this->_faqFolder;
	}
	function index() {	
		if(!$faqRequest = $this->uri->segment(2)) {
			$this->load->helper('directory');
			// only map the top level directory
			$faqDir = directory_map($this->_directory,TRUE);
			
			$faqArticles;
			foreach($faqDir as $index => $file) {
				// preg_match's third param takes the matches: first, the whole matched string, 
				// then each additional matched string
				if(!preg_match('#^(.+).html$#',$file,$matches)) break;
				$faqTitle = $this->titleFormat($matches[1]);
				$faqArticles[$faqTitle] = $this->_faqFolder.$matches[1];
			}
			$viewData['faqArticles'] = $faqArticles;
			$viewData['title'] = $this->_faqTitle;		
			$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
			$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
			$this->load->view('common/faq_list',$viewData);
			$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
			return;
		}
		$this->load->helper('file');
		$fileName = $this->_faqFolder.$faqRequest.".html";
		$faqTitle = $this->titleFormat($faqRequest);
		$this->load->view('html_head.php',array('site_base'=>$this->config->item('base_url')));
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('common/faq_header',array('title'=>$this->_faqTitle,'article'=>$faqTitle));
		$this->load->view($fileName);
		$this->load->view('footer.php',array('site_base'=>$this->config->item('base_url')));
	}
	private function titleFormat($title) {
		return ucfirst(preg_replace('#-#',' ',$title)).'?';
	}
}