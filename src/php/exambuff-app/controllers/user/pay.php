<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pay extends EB_Controller {
	
	protected $_sessionAuthVar = 'user';
	protected $_authRequired = true;
	
	const CURR = 'GBP';
	const CONFIRM_URL = 'http://exambuff.co.uk/user/pay/confirm';
	const CANCEL_URL = 'http://exambuff.co.uk/user/pay/cancel';
	
	private $scriptToPay;

        private $scriptAmount = 9.99;
	
	public function Pay()
    {
        parent::EB_Controller();
		$this->load->model('script');
		$this->scriptToPay = $this->scriptIfReadyForPaymentOrRedirect();
    }
	/**************************
	 * Pages viewable
	 */
	function index() {

		$paymentMethod= $this->input->post('payment-method');
		
		if($paymentMethod==="Checkout with Credit/Debit Card") {
			$this->_card(true);
			return;
		}
		if($paymentMethod==="Checkout with Paypal") {
			$this->_paypal();
			return;
		}
		
		if($this->input->post('card-submit')) {
			//echp '<br>Index: '.$this->session->userdata('token').'<br>'.$this->input->post('token');
			$this->_card();
			return;
		}
		
		$viewData['progressSteps'] = $this->_progressSteps();
		$viewData['paypalURL'] = $this->config->item('app_base').'user/pay/paypal';
		$viewData['cardURL'] = $this->config->item('app_base').'user/pay/card';
		
		$viewData['scripts'] = $this->_getCartContents();
		
		$headData['ssl'] = true;
		
		$this->load->view('html_head.php',$headData);
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('user/checkout',$viewData);
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));		
	}
	/**
	 * Used to confirm PayPal Express payments. First take the returned token from the url. Use it to 
	 * get the transaction. Use the transaction data to DoExpressCheckout, and then deal with the 
	 * result, displaying it to user
	 */
	public function confirm() {
		$this->load->library('paypal');
		$this->load->helper('url');
		/*
		 * get data from url returned by paypal
		 */
		$url = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		$separateQStrings = explode('?',$url);
		$qStrings = $separateQStrings[1];
		
		$explodeQStrings = explode('&',$qStrings);
		// only expect 2 qStrings, only look for 2
		for($i = 0;$i<2;$i++) {
			$keyVal = explode('=',$explodeQStrings[$i]);
			if($keyVal[0] === 'token' || $keyVal[0] === 'PayerID') {
				$vars[$keyVal[0]] = $keyVal[1];
			}
		}
		// if we don't have both, something is wrong
		if(!isset($vars['token']) || !isset($vars['PayerID'])) {
			 die('didn\'t get both vars');
		}
		
		$getExpressResponseString = $this->_ppGetExpressDetailsString(urldecode($vars['token']));
		/*
		 * request the data from paypal
		 */
		$results = $this->paypal->hashCall($getExpressResponseString);
		
		$responseArray = $results['response'];
			
		$ack = strtoupper($responseArray["ACK"]);
		
		if($ack!=="SUCCESS") {
			 die('error - ack');			
		} 
		/*
		 * Use data to DoExpressCheckout()
		 */
		
		$doDirectString = $this->_ppDoExpressCheckoutString($responseArray);
		
		$results = $this->paypal->hashCall($doDirectString);
		
		$responseArray = $results['response'];	
				
		$ack = strtoupper($responseArray["ACK"]);
		if($ack!=="SUCCESS") {
			 die('error - ack');			
		} 
		
		$transactionID = $responseArray['TRANSACTIONID'];
		$amount = $responseArray['AMT'];
		$userEmail = $this->session->userdata($this->_sessionAuthVar);
		
		$storedTransaction = $this->session->userdata($vars['token']);
		
		// store payment
		$this->load->model('payment');
		
		// pay script
		$this->scriptToPay->retrieve($storedScript);
		$this->scriptToPay->paid();
		$this->scriptToPay->update();
		
		$payment=new Payment();
		
		$payment->paid($userEmail,$this->scriptToPay->getKey(),
					   Payment::PAYPAL,$amount,$transactionID);
		
		// send receipt
		$this->_emailReceipt($userEmail,$this->scriptToPay);
		
		$this->session->set_flashdata('newOrder','Thanks for your order. You will receive a receipt in your email.');
		redirect("/user/feedback");
	}
	/**
	 * Used to cancel PayPal Express payments
	 * @return unknown_type
	 */
	public function cancle() {
		
	}
	public function paid() {
				
		$this->load->view('html_head.php');
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('user/receipt');
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	/*********************************
	 * Controller logic
	 */
	private function _card($noCardData = false) {
		//echp '<br>Card: '.$this->session->userdata('token').'<br>'.$this->input->post('token');
		// needed for progress steps
		$viewData['progressSteps'] = $this->_progressSteps();
		$viewData['paypalURL'] = $this->config->item('app_base').'user/pay/paypal';
		$viewData['cardURL'] = $this->config->item('app_base').'user/pay/card';
		$headData['ssl'] = TRUE;
		
		$extraScripts = array('jquery.validate','jquery.validate.creditcard2','card','pay');
		$headData['js'] = $extraScripts;
		// don't need to validate, as we just want to display the form and return
		if($noCardData) {
			$token = $this->_token();
			$viewData['token'] = $token;
			$this->_cardForm($viewData,$headData);
			return;			
		}
		//////echp 'got card data';
		
		/*
		 * Set up validation
		 */
		
		$this->load->library('validation');
		$this->load->helper('validation');
		$this->load->helper('phpcreditcard');

		$fields['expDateMM'] = 'Expiration date month invalid';
		$fields['expDateYYYY'] = 'Expiration date year invalid';
		$fields['type'] = 'Card type';
		$fields['cardnum'] = 'Card number';
		$fields['secCode'] = 'Security code';
		$fields['name'] ='Cardholder\'s name';
		$fields['issueStartDate'] = 'Issue number / Start date';
		$fields['expDate'] = 'Expiration date';
		$fields['addressName'] = 'Full name';
		$fields['address1'] = 'Adress line one';
		$fields['address2'] = 	'Adress line two';
		$fields['town'] = 'Town, city, hamlet';
		$fields['county'] = 'County';
		$fields['postcode'] = 'Postcode';
		$fields['country'] =  'Country';
		$fields['phoneNum'] = 	'Phone number';
		
		$this->validation->set_fields($fields);
		
		// don't bother validating if token is invalid - it's not from the right form so ignore it
		if(!$this->_checkToken()) {
			$this->validation->run();
			$token = $this->_token();
			////echp 'TOKEN NOW '.$token;
			$viewData['token'] = $token;
			$viewData['errors']['declined'] = 'There was a problem with your card details. Please check to confirm your details were correct';
			$this->_cardForm($viewData,$headData);	
			return;
		}
		////echp 'token checked out';
		
		
		// token check done, can reset
		$token = $this->_token();
		$viewData['token'] = $token;
		
		$cardNum = $this->input->post('cardnum');
		$cardType = $this->input->post('type');

		// custom validate card
		if(validCardType($cardType)) {
			$errorNum;
			$errorText;
			// validate card
			$cardValid = checkCreditCard($cardNum,$cardType,$errorNum,$errorText);
		}
		////echp 'valid card';
		// can't pass params to call back, so this work around requires we
		// call a forced fail callback with a custom error message set below
		if(!@$cardValid) {
			$rules['cardnum'] = 'callback_invalidCard';
		} else {
			$rules['cardnum'] = 'required';
		}
		
				
		// check - do we need to require the issue/start date field?
		if($this->_requiresIssueOrStart($this->input->post('type'))) {
			$rules['issueStartDate'] = 'required|callback_issueNotStartDateMMYY';
		}
		
		$rules['name'] = 'trim|required|callback_alphaAndWhiteSpace|max_length[128]|callback_validCardNameFormat';
		$rules['type'] = 'trim|callback_validCardType|required';
		$rules['secCode'] = 'trim|required|numeric|min_length[3]|max_length[4]';
		$rules['expDateMM'] = 'required|numeric|exact_length[2]';
		$rules['expDateYYYY'] = 'required|numeric|exact_length[4]';
		$rules['address1'] = 'trim|required|callback_address|max_length[255]';
		$rules['address2'] = 'trim|callback_address|max_length[255]';
		$rules['town'] = 'trim|required|callback_alphaAndWhiteSpace|max_length[128|min_length[3]]';
		$rules['county'] = 'trim|required|callback_alphaAndWhiteSpace|max_length[128]|min_length[3]';
		$rules['postcode'] =  'trim|required|callback_alphaNumAndWhiteSpace|max_length[12]|min_length[4]';
		$rules['country'] = 'trim|required|callback_alphaAndWhiteSpace|max_length[128]';
		$rules['phoneNum'] = 'trim|required|callback_validPhone|max_length[24]|min_length[3]';


		// custom error messages
		$this->validation->set_message('validCardNameFormat','Your name was in an invalid format: Please enter it as it appears on the card, with salutation (eg. Ms, Mr)');
		$this->validation->set_message('invalidCard','Your card  number is invalid: please check you have entered the correct card number and type');
		$this->validation->set_message('alphaAndWhiteSpace','%s contains invalid characters. Please enter only letters and spaces');
		$this->validation->set_message('address','%s contains invalid characters. Please enter only letters, numbers and spaces');
		$this->validation->set_message('alphaNumAndWhiteSpace','%s contains invalid characters. Please enter only letters, numbers and spaces');
		$this->validation->set_message('issueNotStartDateMMYY','Please enter the issue number of your Switch or Maestro card. If not present, please enter the valid from date in MMYY format');
		$this->validation->set_message('validPhone','Please enter a valid full phone number');

		$this->validation->set_rules($rules);
		
		/*
		 * Go - process validation and redirect on success - remeber
		 */
		
		if ($this->validation->run() == FALSE) {
			$this->_cardForm($viewData,$headData);	
			return;
		}
		////echp 'validation checked out';
		/*
		 * Process paypal
		 */
		$this->load->library('paypal');
		
		$debug = false;
		/** pay pal vars **/
		$ipAddress = $_SERVER['REMOTE_ADDR']; 
		$currencyCode = Pay::CURR;
		
		/** STEP ONE - Test authorisation for CV2 and AVS **/
		$method = 'DoDirectPayment';
		$paymentAction = 'Authorization';
		$amount = '1.00';
		
		$authString = $this->_ppSaleString($method,$paymentAction,$ipAddress,$currencyCode,$amount);
		
		$results = $this->paypal->hashCall($authString);
		
		$responseArray = $results['response'];	
		$ack = strtoupper($responseArray["ACK"]);
		
		if($debug) print_r($responseArray);
		
		if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING") {
			$viewData['errors']['declined'] = 'Sorry, there seems to be some problem with your card details. Please check to confirm your details were correct and retry.';
			$this->_cardForm($viewData,$headData);	
			return;
		}
		
		$cardDetailsWrong = false;
		// AVS/CVV2 response codes type one - letters Visa, MasterCard, VisaElectron
		if(in_array($cardType,array('Visa,MasterCard,VisaElectron'))) { 
			// the codes that mean AVS has failed for the above cards
			$failVisaMasterAVS = array('C','E','N');
			// cvv2 N means the match has failed
		    if($responseArray['CVV2MATCH'] == 'N' || in_array($responseArray['AVSCODE'],$failVisaMasterAVS)) {
				$cardDetailsWrong = true;
		    }
		}
		// AVS/CVV2 response codes type two - numbers, for Maestro and Solo
		if(in_array($cardType,array('Maestro','Solo'))) {
		
			$allowedMaeSoloCVV2 = array(0,2,3,4);
			// if AVS has failed
		    $failMaeSoloAVS = 1;
		    if(!in_array($responseArray['AVSCODE'],$allowedMaeSoloCodes || $responseArray['AVSCODE'] === $failMaeSoloAVS)) {
				$cardDetailsWrong = true;
		    }
		}
		
		if($cardDetailsWrong) {
			$viewData['errors']['declined'] = 'Sorry, there seems to be some problem with your card details. Please check to confirm your details were correct and retry.';
			$this->_cardForm($viewData,$headData);	
			return;
		}
		
		$authorisationID = $responseArray['TRANSACTIONID'];
		
		/** STEP TWO - Void test authorisation **/
		
		
		$voidString = $this->_ppVoidString($authorisationID,$amount);
		
		$results = $this->paypal->hashCall($voidString);
		
		$responseArray = $results['response'];	
		$ack = strtoupper($responseArray["ACK"]);
		if($debug) print_r($responseArray);
		
		if($responseArray['AUTHORIZATIONID'] !== $authorisationID) {
			$viewData['errors']['declined'] = 'Sorry, there seems to be some problem with your card details. Please check to confirm your details were correct and retry.';
			$this->_cardForm($viewData,$headData);	
			return;
		}
		
		/** STEP THREE - Actual sale **/
		$amount = $this->_getCartTotal();
		
		$method = 'DoDirectPayment';
		$paymentAction = 'Sale';
		
		
		$saleString = $this->_ppSaleString($method,$paymentAction,$ipAddress,$currencyCode,$amount);
		
		$results = $this->paypal->hashCall($saleString);
		
		$responseArray = $results['response'];	
		$ack = strtoupper($responseArray["ACK"]);
		$transactionID = $responseArray['TRANSACTIONID'];
		$time = $responseArray['TIMESTAMP'];
		if($debug) print_r($responseArray);
		
		if($ack!="SUCCESS" && $ack!="SUCCESSWITHWARNING") {
			$viewData['errors']['declined'] = 'Sorry, there seems to be some problem with your card details. Please check to confirm your details were correct and retry.';
			$this->_cardForm($viewData,$headData);	
			return;
		}
		
		
		/*
		 * STEP FOUR - Successful payment! Store transaction
		 */
		
		// store payment
		$this->load->model('payment');
		$payment=new Payment();
		
		$userEmail = $this->session->userdata($this->_sessionAuthVar);
		
		// set scripts to paid
		$this->scriptToPay->paid();
		$this->scriptToPay->update();
		
		
		$payment->paid($userEmail,$this->scriptToPay->getKey(),
					   Payment::DIRECT,$amount,$transactionID);
		
		// send receipt
		$this->_emailReceipt($userEmail);
		
		$this->session->set_flashdata('newOrder','Thanks for your order, your payment was successful. You will receive a receipt in your email shortly. Our tutors can now see your essay.');
		
		redirect("/user/feedback");
	}
	/**
	 * Creates a transaction from user's cart & sends it to paypal. On successful response
	 * redirects them to PayPal to confirm the transaction.
	 * 
	 */
	private function _paypal() {
		
		//$checkoutURL = 'https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=';
		$checkoutURL = 'https://www.paypal.com/cgibin/webscr?cmd=_express-checkout&token=';
		
		$paypalString = $this->_ppSetExpressString($this->scriptToPay);
			
		$this->load->library('paypal');
		$results = $this->paypal->hashCall($paypalString);
		
		$responseArray = $results['response'];	
				
		$ack = strtoupper($responseArray["ACK"]);
		
		//debug print_r($responseArray);
		
		if($ack=="SUCCESS") {
			
			// weird solution as currently paypal getdetails isn't returning the transaction properly
			$this->session->set_userdata($responseArray['TOKEN'],array('token'=>$this->_getCartTotal()));
			
			$token = $responseArray['TOKEN'];
			
			// send to PayPal to confirm transaction. Variable useraction is set to commit, so they don't have to
			// reconfirm purchase on EB site.
			header('Location: '.$checkoutURL.$token.'&useraction=commit');
			
		} else {
			$viewData['errors']['declined'] = 'There was a problem with your card details. Please check to confirm your details were correct';
		}
	}
	private function _cardForm($viewData,$headData) {
		$this->load->view('html_head.php',$headData);
		$this->load->view('page_head.php',array('userAuth'=>@$this->session->userdata('email'),'markerAuth'=>@$this->session->userdata('markerEmail')));
		$this->load->view('user/card',$viewData);
		$this->load->view('footer',array('site_pages'=>$this->config->item('site_pages')));
	}
	private function _ppSaleString($method,$paymentAction,$ipAddress,$currencyCode,$amount) {		
		// limit to title, first, middle, last with all additional made into surname
		// this is validated to ensure only names which explode to at least 3 chunks pass (title, first, second)
		$nameChunks = explode(' ',$this->input->post('name'),4);
		// do we have a middle name? 
		if (count($nameChunks)===3) {
			$title = $nameChunks[0];
			$firstName = $nameChunks[1];
			$middleName = '';
			$lastName = $nameChunks[2];
		} else {
			$title = $nameChunks[0];
			$firstName = $nameChunks[1];
			$middleName = $nameChunks[2];
			$lastName = $nameChunks[3];
		} 
		// Transaction Section //
		// $payLItems is passed in pre-encoded, created by checkoutLItems()
		$method = 'METHOD='.urlencode($method);
		
		$subSectionAPI = $this->_ppAPIDetails();
				
		$paymentAction = '&PAYMENTACTION='.urlencode($paymentAction);
		$ipAddress = '&IPADDRESS='.urlencode($ipAddress);
		
		$amount = '&AMT='.urlencode($amount);
		$currencyCode = '&CURRENCYCODE='.urlencode(Pay::CURR);    
		$desc = '&DESC='.urlencode('Exambuff marking for essay, \''.$this->scriptToPay->get('question'));
		
		$sectionTransaction =  $method.$subSectionAPI.$paymentAction.$ipAddress.$amount.
							   $currencyCode.$desc;
		
		// EOF Transaction Section //
		// Card Section //
		$type = '&CREDITCARDTYPE='.urlencode($this->input->post('type'));
		$cardnum = '&ACCT='.urlencode($this->input->post('cardnum'));
		$expDate = '&EXPDATE='.urlencode($this->input->post('expDateMM').$this->input->post('expDateYYYY'));
		$secCode = '&CVV2='.urlencode($this->input->post('secCode'));
		
		
		// these fields are optional
		if($this->issueNotStartDateMMYY($this->input->post('issueStartDate'))) {
			$issueStartDate = '&STARTDATE='.urlencode($this->input->post('issueStartDate'));
		} else {
			$issueStartDate = '&ISSUENUMBER='.urlencode($this->input->post('issueStartDate'));
		}
		
		
		$sectionCard = $type.$cardnum.$expDate.$secCode.$issueStartDate;
		
		// EOF Card Section //
		// User Section
		$email = '&EMAIL='.urlencode($this->session->userdata('email'));
		$title = '&SALUTATION='.urlencode($title);
		$firstName = '&FIRSTNAME='.urlencode($firstName);
		$middleName = '&MIDDLENAME='.urlencode($middleName);
		$lastName = '&LASTNAME='.urlencode($lastName);
		
		
		$sectionUser = $email.$title.$firstName.$middleName.$lastName;
		
		// EOF User Section //
		// Address Section //
		$address1 = '&STREET='.urlencode($this->input->post('address1'));
		$address2 = '&STREET2='.urlencode($this->input->post('address2'));
		$town = '&CITY='.urlencode($this->input->post('town'));
		$county = '&STATE='.urlencode($this->input->post('county'));
		$postcode = '&ZIP='.urlencode($this->input->post('postcode'));
		$country = '&COUNTRYCODE='.urlencode($this->input->post('country'));
		$phoneNum = '&PHONENUM='.urlencode($this->input->post('phoneNum'));
		
		
		$sectionAddress = $address1.$address2.$town.$county.$postcode.
						  $country.$phoneNum;
		
		// EOF Address Section //
			
		return $paypalURLString = $sectionTransaction.$sectionCard.$sectionUser.$sectionAddress;
	}
	private function _ppAPIDetails() {
		$version = '&VERSION=3.2';	
		$apiPass = '&PWD='.urlencode($this->config->item('pp_live_pass'));
		$apiUser = '&USER='.urlencode($this->config->item('pp_live_user'));
		$apiSig = '&SIGNATURE='.urlencode($this->config->item('pp_live_sig'));
		
		return $version.$apiPass.$apiUser.$apiSig.$version;
	}
	private function _ppGetExpressDetailsString($token) {
		$method = 'METHOD=GetExpressCheckoutDetails'; 
		$token = '&TOKEN='.urlencode($token); 
		$apiDetails = $this->_ppAPIDetails();
		return $method.$apiDetails.$token;
	}
	/**
	 * Returns transaction string for SetExpress
	 */
	private function _ppSetExpressString() {
		$method = 'METHOD=SetExpressCheckout'; 
		
		// Details //
		$MAXAMT = '&MAXAMT='.urlencode($this->_checkoutTotal());
		$RETURNURL = '&RETURNURL='.urlencode(Pay::CONFIRM_URL); 
		$CANCELURL = '&CANCELURL='.urlencode(Pay::CANCEL_URL); 
		$REQCONFIRMSHIPPING = '&REQCONFIRMSHIPPING=0'; 
		$NOSHIPPING = '&NOSHIPPING=1'; 
		$ALLOWNOTE = '&ALLOWNOTE=0'; 
		$LOCALECODE = '&LOCALECODE=GB'; 
		$PAYMENTACTION = '&PAYMENTACTION=Sale'; 
		$EMAIL = '&EMAIL='.urlencode($this->session->userdata($this->_sessionAuthVar)); 
		
		
		$details = $MAXAMT.$RETURNURL.$CANCELURL.$REQCONFIRMSHIPPING.$NOSHIPPING.$ALLOWNOTE.$LOCALECODE.$PAYMENTACTION.$EMAIL;
		// EOF Details //
		// Transaction //
		$cartTotal = $this->_checkoutTotal();
		
		$amt = '&AMT='.urlencode($cartTotal);
		$currencyCode = '&CURRENCYCODE='.urlencode(Pay::CURR);
		
		$desc = '&DESC='.urlencode('Exambuff marking for essay, \''.$this->scriptToPay->get('question'));
		
		$transaction = $amt.$currencyCode.$desc;
		// EOF Transaction //
				
		$subSectionAPI = $this->_ppAPIDetails();
		
		return $method.$details.$subSectionAPI.$transaction;
		/*
		$PAGESTYLE = '&PAGESTYLE='.'xxxx'; 
		$HDRIMG = '&HDRIMG='.'xxxx'; 
		$HDRBORDERCOLOR = '&HDRBORDERCOLOR='.'xxxx'; 
		$HDRBACKCOLOR = '&HDRBACKCOLOR='.'xxxx'; 
		$PAYFLOWCOLOR = '&PAYFLOWCOLOR='.'xxxx'; 
		*/
	}
	/**
	 * Used to cancel a previous transaction 
	 * */
	private function _ppVoidString($transaction,$amount) {
		$method = 'METHOD=DoVoid';
		$authID = '&AUTHORIZATIONID='.$transaction;
		$subSectionAPI = $this->_ppAPIDetails();
		
		return $method.$authID.$subSectionAPI;
	}
	/**
	 * Used to finalise a transaction set by SetExpressCheckout
	 */
	private function _ppDoExpressCheckoutString($responseArray) {
		
		$checkoutData = $this->session->userdata($responseArray['TOKEN']);
		
		$method = 'METHOD=DoExpressCheckoutPayment'; 
		$paymentAction = '&PAYMENTACTION=Sale';
		// Details //
		$token = '&TOKEN='.urlencode($responseArray['TOKEN']); 
		$payerID = '&PAYERID='.urlencode($responseArray['PAYERID']);

		$amount = '&AMT='.urlencode($checkoutData['token']);
		$currencyCode = '&CURRENCYCODE='.urlencode(Pay::CURR);
		$subSectionAPI = $this->_ppAPIDetails();
		
		return $method.$subSectionAPI.$paymentAction.$token.$payerID.$amount.$currencyCode;
		
	}
	/**
	 * Email the user a receipt for their payment 
	 * 
	 * @param $email
	 * @param $items
	 * @param $time
	 * @param $transactionID
	 * @param $method
	 * @return unknown_type
	 */
	private function _emailReceipt($recipientEmail) {
		require_once($this->config->item('swift'));
		require_once($this->config->item('swift_smtp'));
		require_once($this->config->item('swift_auth'));
		
		try {
			$smtp = new Swift_Connection_SMTP("smtp.gmail.com",465, Swift_Connection_SMTP::ENC_SSL);
			$smtp->setTimeout(10);
			$smtp->setUsername("billing@exambuff.co.uk");
			$smtp->setPassword("gim3th3c@ash");
			$smtp->attachAuthenticator(new Swift_Authenticator_LOGIN());
			$swift = new Swift($smtp,'exambuff.co.uk');			
		} catch (Exception $e) {
			$msg = $e->getMessage();
			log_message('error',"Email to $recipientEmail failed due to $msg");
			return false;
		}
		
		$this->load->model('user');
		$user = new User();
		$user->retrieve($recipientEmail);
		$nameChunks = explode(' ',$user->get('name'),2);
		$firstName = $nameChunks[0];
		
		$viewData['firstName'] = $firstName;
		$viewData['question'] = $this->scriptToPay->get('question');
		$msgSubject = "Payment receipt from Exambuff";
		$msgBody = $this->load->view('email/receipt',$viewData,TRUE);
		
		$swfMessage = new Swift_Message($msgSubject,$msgBody);		
				
		try {
			if ($swift->send($swfMessage,$recipientEmail,'no-reply@exambuff.co.uk')) return true;
			return false;
		} catch (Exception $e) {
			$msg = $e->getMessage();
			log_message('error',"Email to $recipientEmail failed due to $msg");
			return false;
		}
	}
        private function _getCartContents() {
            $this->load->model('discount');
            $contents = array($this->scriptToPay->asAssoc());
            // add in any discounts etc
            $contents = array_merge($contents,$this->offer->getOffersAsArray());
            return $contents;
        }
	private function _getCartTotal() {
            $scripts = $this->_getCartContents();
            foreach($scripts as $script) {
                $total += $script['value'] ? $script['value'] : $this->scriptAmount;
            }
            return number_format($total,2);
	}
	/****************************
	 * User interface functions
	 */
	private function _progressSteps() {
		$uploadStatus = '';
		$detailsStatus = '';
		$payStatus = '';
		if($this->scriptToPay->get('subject') != '' && $this->scriptToPay->get('subject') != '') {
			$detailsStatus = 'complete';
			$pagesAdded = true;
		}
		if($this->scriptToPay->pages->getPageKeys()) {
			$uploadStatus = 'complete';
			$detailsComplete = true;
		}
		if(@$pagesAdded && @$detailsComplete) {
			$payStatus = '';
		}

		$base = $this->config->item('app_base');
		$upload = array ('Upload page images',$base.'user/upload',@$uploadStatus);
		$details = array ('Enter essay details',$base.'user/upload/details',@$detailsStatus);
		$pay = array ('Pay',$base.'user/pay',@$payStatus);
		 return array('upload'=>$upload,'details'=>$details,'pay'=>$pay);
	}
	/************************************
	 * Validation functions 
	 * 
	 */
	function alphaAndWhiteSpace($str) {
		if(!preg_match("/^([-a-z\._-\s])+$/i", $str)) {
			return false;
		}
		return true;
	}
	function alphaAndWhiteSpaceQuestion($str) {
		if(!preg_match("/^([-a-z?\._-\s])+$/i", $str)) {
			return false;
		}
		return true;
	}
	function alphaNumAndWhiteSpace($str) {
		if(!preg_match("/^([-a-z0-9?\._-\s])+$/i", $str)) {
			return false;
		}
		return true;
	}
	/*
	 * Returns true if only contains address characters - letters, spaces, numbers and '.' (for Rd. etc)
	 */
	function address($str) {
		if(!preg_match("/^([-a-z0-9\.?\._-\s])+$/i", $str)) {
			return false;
		}
		return true;
	}
	function validCardType($str) {
		$validTypes = array('Maestro'=>'Maestro','MasterCard'=>'MasterCard','Solo'=>'Solo','Switch'=>'Switch','Visa'=>'Visa','VisaElectron'=>'VisaElectron');
		if(in_array($str,$validTypes)) {
			return true;
		}
		return false;
	}
	function invalidCard($str) {
		return false;
	}
	function validPhone($str) {
		//remove all - and spaces
		$str = str_replace(array('-',' '),'',$str);
		if(is_numeric($str) && strlen($str) > 6) {
			return true;
		}
		return false;
	}
	function validCardNameFormat($str) {
		// need at least title first last
		if(count(explode(' ',$str)) < 3) return false;
		return true;
	}
	public function issueNotStartDateMMYY($str) {
		$issueReg = '#^\d{3}$#';
		$mmyyOptionalSlash = '#^[01]\d/{0,1}\d\d$#';
		if(!preg_match($issueReg,$str) && !preg_match($mmyyOptionalSlash,$str)) {
			return false;
		}
		return true;
	}
	private function _requiresCV2($type) {

	}
	private function _requiresIssueOrStart($type) {
		if($this->input->post('type') == 'Switch' ||$this->input->post('type') == 'Solo' ) return true;
		return false;
	}
	/**
	 * Gets the user's unpaid script if possible, and returns it, or returns a new script
	 * @return $script - new or active script from db
	 */
	private function scriptIfReadyForPaymentOrRedirect() {
		$script = $this->script;
		// Does the user have an unpaid script?
		if ($activeScriptKey = $script->getUnpaidScript($this->session->userdata('email'))) {
			// if so, then load and retrieve it
			$script->setKey($activeScriptKey);
			$script->retrieve();
			$keys = $script->pages->getPageKeys();
			if (empty($keys)) {
				$this->session->set_flashdata('redirectErrors',array('You haven\'t uploaded any images of your essay.'));
				redirect('/user/upload');
			}
			if($script->get('question') == '' || $script->get('question') == '') {
			   	$this->session->set_flashdata('redirectErrors',array('You haven\'t entered the subject or question of your essay.'));
				redirect('/user/upload/details');
			}

		} else {
			$this->session->set_flashdata('redirectMessages',array('You have no essays that require payment'));
			redirect('/user/feedback');
		}
		return $script;
	}
}