<?php 
  class Upload extends EB_Controller {
  	
  	protected $_sessionAuthVar = 'user';
	protected $_authRequired = true;
      // 3mb
      const MAX_SIZE = 10000000;
      // the maximun width or height of an uploaded image
      const MAX_IMAGE_DIMENSION = 800;
      
      private static $fileTypes = array('jpg','jpeg','doc','docx','txt','rtf','pdf','ods','sdw','odt');
      
      const ERROR = 'ERROR';
      
      public function ScriptUpload() {
          parent::EB_Controller();
          $this->load->library('secureupload');
      }
      public function index() {
          $this->load->model('script');
          
          $script = $this->_activeScriptOrNew();
          
          $pageKeys = $script->pages->getOldFileNames();
          
          if (count($pageKeys) > 0) {
              // get page keys, stored under the pageNumber as index
              
              $viewData['pageTitle'] = $this->lang->line('pageTitleExsistingPages') . $script->get('question');
              $viewData['pagesPresent'] = $pageKeys;
              
              // if the page is not null, pass pageNumber=>oldFileName, so the user can see what they've uploaded,
              // in what location. Also the view needs to decide which pageNumbers to place next to the upload fields
          } else {
              $viewData['pageTitle'] = 'Upload pages';
          }
          
		  // set redirectReError
		  $viewData['errors'] = $this->session->flashdata('redirectErrors');
		  
		  // set up token
          $viewData['token'] = $this->_token();
          
          $viewData['scriptDate'] = $script->meta('created');
          $viewData['js'][] = 'uploader';
          $viewData['stdFields'] = '5';
          $viewData['progressSteps'] = $this->_progressSteps($script);
          
          $this->load->view('html_head.php', array('site_base' => $this->config->item('base_url'), 'js' => array('uploader')));
          $this->load->view('page_head.php', array('userAuth' => @$this->session->userdata('email'), 'markerAuth' => @$this->session->userdata('markerEmail'), 'bodyId' => 'upload', 'site_pages' => $this->config->item('site_pages')));
          $this->load->view('forms/upload_index', $viewData);
          $this->load->view('footer.php', array('site_base' => $this->config->item('base_url')));
      }
      public function details() {
      	  
		  $script = $this->_activeScriptOrNew();
		  
		  if(!$script->pages->getPageKeys()) {
		  	$this->session->set_flashdata('redirectErrors',array('You haven\'t uploaded any images of your essay.'));
			redirect('/user/upload');
		  }
		  
		  // set redirectReError
		  $viewData['errors'] = $this->session->flashdata('redirectErrors');
		
          $token = $this->_token();
          $this->lang->load('scriptdetails');
          $this->load->helper('form');
          $this->load->helper('url');
          $this->load->library('validation');
          
          $this->load->helper('validation');
          
          // set rules
          $rules['question'] = 'trim|required|callback_alphaAndWhiteSpaceQuestion|max_length[255]';
          $rules['subject'] = 'trim|required|callback_alphaAndWhiteSpace|max_length[60]';
          
          $fields['question'] = 'Question';
          $fields['subject'] = 'Subject';
          
          $viewData['extantData']['question'] = $script->get('question');
          $viewData['extantData']['subject'] = $script->get('subject');
          
          $viewData['progressSteps'] = $this->_progressSteps($script);
          
          $this->validation->set_fields($fields);
          
          $this->validation->set_rules($rules);
          
          // validate
          if ($this->validation->run() == false) {
              $this->load->view('html_head.php', array('site_base' => $this->config->item('base_url')));
              $this->load->view('page_head.php', array('bodyId' => 'upload', 'userAuth' => @$this->session->userdata('email'), 'markerAuth' => @$this->session->userdata('markerEmail')));
              
              $viewData['formAction'] = site_url('/user/upload/details',true);
              $this->load->view('forms/script_details', $viewData);
              $this->load->view('footer', array('site_pages' => $this->config->item('site_pages')));
          } else {
              // validated, update the script with the details
              
              $script->set('question', $this->input->post('question'));
              $script->set('subject', $this->input->post('subject'));
              
              $script->update();
              
              header('location: '.site_url('/user/pay',true));
          }
      }
      public function delete() {
          
          $this->load->model('script');
          $token = $this->_token();
          
          $script = $this->_activeScriptOrNew();
          if (is_numeric($pageNum = $this->input->post('pageNum'))) {
              if ($script->pages->getPageKeyAt($pageNum - 1)) {
                  $result = $script->pages->removePage($pageNum - 1);
              }
          } else {
              $result = false;
          }
          // need to store the new, shorter, pages object
          $script->update();
          echo 'result=' . $result . '&token=' . $token;
      }
      public function pageDown() {
          
          $this->load->model('script');
          $token = $this->_token();
          
          $script = $this->_activeScriptOrNew();
          if (is_numeric($pageNum = $this->input->post('pageNum'))) {
              // page num isn't going to be swapped below page array - eg page 1 move down, 1-2 = -1, can't be swapped there
              if ($pageNum - 2 >= 0) {
                  if ($script->pages->swapPages($pageNum - 1, $pageNum - 2)) {
                      $result = true;
                  }
              } else {
                  $result = false;
              }
          } else {
              $result = false;
          }
          // need to store the new order
          $script->update();
          echo 'result=' . $result . '&token=' . $token;
      }
      public function pageUp() {
          
          $this->load->model('script');
          $token = $this->_token();
          // remember - pageNum will come in arrayFormat + 1
          $script = $this->_activeScriptOrNew();
          if (is_numeric($pageNum = $this->input->post('pageNum'))) {
              // page num isn't going to be swapped above page array - eg 3 pages, count(3), page 3, 3+1 = 4, above array
              if ($pageNum < count($script->pages->getPageKeys())) {
                  if ($script->pages->swapPages($pageNum - 1, $pageNum)) {
                      $result = true;
                  }
              } else {
                  $result = false;
              }
          } else {
              $result = false;
          }
          // need to store the new order
          $script->update();
          echo 'result=' . $result . '&token=' . $token;
      }
      /**
       * Async accepts Flex and jQuery iFrame based uploads. It returns a single variable, result=, which can be interpreted
       *
       * @return result
       *
       */
      public function async() {
          $token = $this->_token();
          $this->load->model('script');
          
          $script;
          
          // do we have a page key?
          $pageNum = $this->uri->rsegment(3);
          
          $script = $this->_activeScriptOrNew();
          
          $pageFileName = $this->_pageFileName();
          $result = $this->_upload($pageFileName, $script, $pageNum);
          // For jQuery: Flex cannot get returned data at present
          echo 'result=' . $result . '&token=' . $token;
          $this->session->set_userdata('result', $result);
      }
      /**
       * Async accepts Flex and jQuery iFrame based uploads. It returns a single variable, result=, which can be interpreted
       *
       * @return result
       *
       */
      public function documents() {
          $this->async();
      }
      /*
       * Allows Flex access to the results of uploads. This is accessed after the script has successfully uploaded, and
       * this process effectively replaces the need for Flex's broken ability to return data from DataEvent.UPLO...
       */
      public function result() {
          $token = $this->_token();
          
          if ($result = $this->session->userdata('result')) {
              echo 'result=' . $result . '&token=' . $token;
          } else {
              echo 'result=' . $result . '&token=' . $token;
          }
          $this->session->unset_userdata('result');
      }
      /*
       * @todo - wth does this do, with _interrogatePage?
       */
      public function ActiveScript() {
          $token = $this->_token();
          $script = $this->_activeScriptOrNew();
          foreach ($script->pages as $page) {
              $returnString += $this->_interrogatePage($page) . '&';
          }
          echo $returnString;
          //$this->load->view('upload/result',$returnString);
      }
      /**
       * Override EB_Controller's logout function, to allow us to delete the files uploaded
       *
       */
      protected function logout() {
          // if not logged in, delete all the files uploaded
          $loginStatus = $this->session->userdata('email');
          if ($loginStatus == '') {
              foreach ($_FILES as $file) {
                  unlink($file['tmp_name']);
              }
              $viewData = array('messages' => array('You need to be logged in to view this page'));
              parent::logout($viewData);
          }
      }
      /**
       * Deals with all script uploads, whether ajax or en masses
       * @pages all filenames in $_FILES to be uploaded
       * @return arrary of arrays with (bool:success,string:message)
       * @todo unlink temporary files
       */
      public function _upload($page, Script $script, $pageNum = null) {
          // allows us to take either one page or an array
          
          
          $this->load->helper('url');
          $this->lang->load('upload');
          $this->load->library('secureupload');
          $uploadResult;
          $publicResult;
          
          // we've actually got a page uploaded - error 4 if no file - for the multiple uploads w/o js that will have empty
          // file inputs and we don't want error messages for each of those
          
          // were $_FILES successfully POSTed?
          if (@$_FILES[$page]['error'] === 0) {
          	
              $oldPageName = $_FILES[$page]['name'];
              $newName = $script->newPageName();
              
              $uploadResult = $this->_uploadPage($page, $newName);
              
          } else {
              // find out why not
              if (!isset($_FILES[$page]) || $_FILES[$page]['error'] === 4) {
                  $publicResult = 'NO_FILE';
                  return $publicResult;
              }
              if ($_FILES[$page]['error'] === 1 || $_FILES[$page]['error'] === 2) {
                  SecureUpload::cleanTemporary($page);
                  $publicResult = SecureUpload::TOO_LARGE;
                  return $publicResult;
              }
              // return a generic error
              return SecureUpload::UNSUCCESSFUL;
          }
          
          switch ($uploadResult) {
              case SecureUpload::SUCCESSFUL:
                  $script->pages->addPage($pageNum, $newName, $oldPageName);
                  $script->update();
                  $publicResult = SecureUpload::SUCCESSFUL;
                  
                  break;
              case SecureUpload::MOVE_FAILED:
                  $publicResult = SecureUpload::MOVE_FAILED;
                  break;
                  case 'too large';
              case SecureUpload::TOO_LARGE:
                  $publicResult = SecureUpload::TOO_LARGE;
                  break;
              case SecureUpload::WRONG_TYPE:
                  $publicResult = SecureUpload::WRONG_TYPE;
                  break;
              default:
                  $publicResult = SecureUpload::UNSUCCESSFUL;
                  break;
          }
          
          return $publicResult;
      }
      /**
       * Selects the page from the $_FILES array - this is the field name of the uploader
       *
       * @return string $fileName in $_FILES array
       */
      private function _pageFileName() {
          return 'exambuff';
      }
      /**
       * Interroagates a page passed to it, returning the
       *
       * @param Page $page
       * @return unknown
       * @todo - wth does this do, with ActiveScript?
       */
      private function _interrogatePage(Page $page) {
          return array($page->index, $page->key);
      }
      /**
       * Gets the user's unpaid script if possible, and returns it, or returns a new script
       * @return $script - new or active script from db
       */
      private function _activeScriptOrNew() {
          $this->load->model('script');
          $script = new Script();
          // Does the user have an unpaid script?
          if ($activeScriptKey = $script->getUnpaidScript($this->session->userdata('email'))) {
              // if so, then load and retrieve it
              $script->setKey($activeScriptKey);
              $script->retrieve();
          } else {
              // No unpaid script; we need to create one
              $script->createNewScriptFor($this->session->userdata('email'));
              $script->retrieve();
          }
          return $script;
      }
      /**
       * Uploads the page, and returns the result of the upload
       *
       * @param string $file
       * @param string $newName
       * @todo pages aren't working properly! need to sort this out
       * @return an array of (result:Boolean,message:String)
       */
      private function _uploadPage($file, $newName) {
          $this->lang->load('upload');
          $this->load->library('secureupload');
          
          $fileLoc = $_FILES[$file]['tmp_name'];
          if($this->_isImage($file)) {
              if(!$this->_resizeToMax($fileLoc,$fileLoc)) return SecureUpload::MOVE_FAILED;
          }
          
          $result = $this->secureupload->store($file, $newName, Upload::$fileTypes, Upload::MAX_SIZE);
          
          return $result;
      }
      private function _isImage($file) {
          return preg_match('#.*(jpg|png|jpeg|tiff|bmp)^#',$file);
      }
      private function _resizeToMax($sourceFile,$destinationFile) {
      
	        $src=@imagecreatefromjpeg($sourceFile);
		
			if (!$src) return false;
			
			$srcw=imagesx($src);
			$srch=imagesy($src);
			
			if ($srcw<$srch) {
				$height=Upload::MAX_IMAGE_DIMENSION;
				$width=floor($srcw*$height/$srch);
			} else {
				$width=Upload::MAX_IMAGE_DIMENSION;
				$height=floor($srch*$width/$srcw);
			}
			
			if ($width>$srcw && $height>$srch) {
				$width=$srcw;
				$height=$srch;  
			}
			
			$thumb=imagecreatetruecolor($width, $height);
			
			if ($height<100) {
				imagecopyresized($thumb, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
			} else {
				imagecopyresampled($thumb, $src, 0, 0, 0, 0, $width, $height, imagesx($src), imagesy($src));
			}
			imagejpeg($thumb, $destinationFile);
			return true;
      }
      /**
       * Returns the progress steps for this controller
       *
       * @return Array $progress
       *
       */
      private function _progressSteps(Script $script) {
          $uploadStatus = '';
          $detailsStatus = 'disabled';
          $payStatus = 'disabled';
          $subject = $script->get('subject');
          $question = $script->get('question');
          if (!empty($subject) && !empty($question) && $script->pages->getPageKeys()) {
              $detailsStatus = 'complete';
			  $detailsComplete = true;
          }
          if ($script->pages->getPageKeys()) {
              $uploadStatus = 'complete';
              if($detailsStatus != 'complete') $detailsStatus = 'active';
			  $pagesAdded = true;
          }
          if (@$pagesAdded && @$detailsComplete) {
              $payStatus = '';
          }
          
          $upload = array('Upload page images', site_url('user/upload'), @$uploadStatus);
          $details = array('Enter essay details', site_url('user/upload/details'), @$detailsStatus);
          $pay = array('Pay', site_url('user/pay',true), @$payStatus);
          return array('upload'=>$upload,'details'=>$details,'pay'=>$pay);
      }
      private function _getPagesArray() {
          return array('page1', 'page2', 'page3', 'page4', 'page5');
      }
  }