<?php
class Control extends EB_Controller {
	protected $_authRequired = true;
	
	protected $_loginReason = "You need to login to access this page. Please login below.";
	protected $_sessionAuthVar = 'eb_control';
	protected $_loginURL = '/control/login';
	
	protected $_flexOnly = false;
	function index() {
		$this->load->view('control/control_panel');
	}
	/**
	 * Returns list of assessments for Flex.
	 *
	 */
	function assessments() {
		$this->load->model('assessment');
		$script = new Assessment();
		$query = $script->getSubmittedAssessments();
		
		if(!$query instanceof CI_DB_mysql_result) throw new Exception('Did not return a result object(?!)');
		
		if($query->num_rows()>0) {
			$results = $query->result_array();
			foreach($results as $assessment) {
				$explodeAroundPipe = explode('|',$assessment['pageKeys']);
				$assessment['pages'] =  count($explodeAroundPipe);
				unset($assessment['pageKeys']);
				$assessments[] = $assessment;
			}
			$this->load->library('json');
			$assessments = $this->json->encode($assessments);
		} else {		
			$assessments = '{}';
		}
		$this->load->view('user/marked_assessments',array('assessments'=>$assessments));
	}
	/**
	 * Creates new marker accounts from a list of emails and sends emails to new markers.
	 *
	 */
	function createmarkers() {
		if($this->input->post('emails')) {
			$this->load->library('validation');
			
			$rules['emails'] = 'valid_emails|required';
			
			$fields['emails'] = 'referree emails';
			
			$this->validation->set_fields($fields);
			$this->validation->set_rules($rules);
			
			$this->validation->set_message('valid_emails', 'All email addresses entered into %s must be valid, seperated by commas');
			
			if($this->validation->run() === TRUE) {
				$emails = explode(',',$this->input->post('emails'));
				$this->load->model('marker');
				$this->load->model('email');
				foreach($emails as $email) {
					$marker = new Marker();
					
					$marker->setKey($email);
					$password = $this->_createPassword();
					$marker->set('password',$marker->makePass($password));
					if($marker->create()) {
						$emailData['email'] = $email;
						$emailData['password'] = $password;
						
						$msg = $this->load->view('email/new_marker',$emailData,TRUE);
						$subject = 'Next step in your application';
						
						$emailToStore = new Email();
						$emailToStore->set('sender','recruitment@exambuff.co.uk');
						$emailToStore->set('receiver',$email);
						$emailToStore->set('subject',$subject);
						$emailToStore->set('message',$msg);
						$emailToStore->create();
						
						$viewData['messages'][] = "Successfully created marker account for $email with password $password";
					} else {
						
						
					}
				}
			}
		} 
		
		if($this->validation->error_string) $viewData['errors'][] = $this->validation->error_string;
		$viewData['token'] = $this->_token();
		
		$this->load->view('control/create_markers',$viewData);
	}
	private function _createPassword() {
		$randomWords = array('africa','animals','architecture','art','australia','autumn','baby','band','barcelona','beach','berlin','bird','birthday','black','blackandwhite','blue','boston','bw','california','cameraphone','camping','canada','canon','car','cat','chicago','china','christmas','church','city','clouds','color','concert','cute','dance','day','de','dog','england','europe','fall','family','festival','film','florida','flower','flowers','food','football','france','friends','fun','garden','germany','graffiti','green','halloween','hawaii','hiking','holiday','home','house','india','ireland','island','italia','italy','japan','july','kids','la','lake','landscape','light','live','london','macro','may','me','mexico','mountain','mountains','museum','music','nature','new','newyork','newyorkcity','night','nikon','nyc','ocean','old','paris','park','party','people','photo','photography','photos','portrait','red','river','rock','rome','san','sanfrancisco','scotland','sea','seattle','show','sky','snow','spain','spring','street','summer','sun','sunset','taiwan','texas','thailand','tokyo','toronto','tour','travel','tree','trees','trip','uk','urban','usa','vacation','vancouver','washington','water','wedding','white','winter','yellow','york','zoo');  
		$wordOne = $randomWords[rand(0,count($randomWords)-1)];
		$wordTwo = $randomWords[rand(0,count($randomWords)-1)];
		$hash = md5($wordTwo);
		return $wordOne.substr($hash,2,3).$wordTwo;
	}
	/**
	 * Sends all emails stored in email db, with a one second delay between each sending.
	 *
	 */
	public function sendEmails() {
		$sql = "SELECT * FROM emails WHERE status <> 'sent'";
		 $q = $this->db->query($sql);
		 $r = $q->result_array();
		 
		if(!$this->input->post('submit')) {
			
			 $viewData['emails'] = $r;
			 $this->load->view('control/send_emails',$viewData);
			 return;
		}
		$this->load->model('email');
		
		foreach($r as $emailAssoc) {
			sleep(1);
			
			$email = new Email();
			$email->fromAssoc($emailAssoc);
			
			$this->load->library('swiftwrap');
			
			if($result = $this->swiftwrap->email('recruitment@exambuff.co.uk','44naughty',
								  $email->get('receiver'),
								  $email->get('subject'),
								  $email->get('message'))) {
			
			
				$email->set('status',Email::SENT);
				$viewData['messages'][] = "Successfully emailed ".$email->get('receiver').", with email: ".$email->get('subject');
			} else {
				$email->set('error',$result);
				$email->set('status',Email::FAILED);
			}
			$email->update();
		}
	}
	function convert() {
		$sql = "SELECT ID, pageKeys FROM scripts";
		$q = $this->db->query($sql);
		$r = $q->result_array();
		$this->load->model('script');
		foreach($r as $script) {
			$this->script->setKey($script['ID']);
			if($script['pageKeys'] !== 'no pages') {
				// check in old format
				if(unserialize($script['pageKeys']) || $script['pageKeys'] == 'a:0:{}') continue;
				$asArray = explode("|",$script['pageKeys']);
			} else {
				$asArray = array();
			}
			$this->script->pages->setPageKeys($asArray);
			$key = $this->script->getKey();
			if($this->script->update()) echo "<p>Script $key was successfully converted</p>";
		}
	}
}