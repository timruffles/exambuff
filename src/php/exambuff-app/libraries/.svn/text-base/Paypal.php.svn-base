<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Paypal {	
	/**
	# Endpoint: this is the server URL which you have to connect for submitting your API request.
	*/	
	const END_POINT =  'https://api-3t.paypal.com/nvp';
	// sandbox const END_POINT =  'https://api-3t.sandbox.paypal.com/nvp';
	
	/**
	USE_PROXY: Set this variable to TRUE to route all the API requests through proxy.
	like const USE_PROXY = TRUE;
	*/
	const USE_PROXY = FALSE;
	/**
	PROXY_HOST: Set the host name or the IP address of proxy server.
	PROXY_PORT: Set proxy port.
	
	PROXY_HOST and PROXY_PORT will be read only if USE_PROXY is set to TRUE
	*/
	const PROXY_HOST =  '127.0.0.1';
	const PROXY_PORT =  '808';
	
	/* Define the PayPal URL. This is the URL that the buyer is
	   first sent to to authorize payment with their paypal account
	   change the URL depending if you are testing on the sandbox
	   or going to the live PayPal site
	   For the sandbox, the URL is
	   https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=
	   For the live site, the URL is
	   https://www.paypal.com/webscr&cmd=_express-checkout&token=
	   */
	const PAYPAL_URL =  'https://www.paypal.com/webscr&cmd=_express-checkout&token=';
	
	/**
	# Version: this is the API version in the request.
	# It is a mandatory parameter for each API request.
	# The only supported value at this time is 2.3
	*/
	
	const VERSION =  '54.0';
	
	
	
	
	/**
	  * hash_call: Function to perform the API call to PayPal using API signature
	  * @methodName is name of API  method.
	  * @nvpStr is nvp string.
 	 * returns an associtive array containing the response from the server.
 	 * 
	 * @param $nvpStr - urlencoded string
	 * @return unknown_type
	 */
	function hashCall($nvpStr) {
		
		//setting the curl parameters.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,Paypal::END_POINT);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		//turning off the server and peer verification(TrustManager Concept).
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POST, 1);
	    //if Paypal::USE_PROXY constant set to Paypal::TRUE in Constants.php, then only proxy will be enabled.
	   //Set proxy name to Paypal::PROXY_HOST and port number to Paypal::PROXY_PORT in constants.php 
		if(Paypal::USE_PROXY) curl_setopt ($ch, CURLOPT_PROXY, Paypal::PROXY_HOST.":".Paypal::PROXY_PORT); 
	
		//Paypal::NVPRequest for submitting to server
		$nvpreq=$nvpStr;
	
		//setting the nvpreq as Paypal::POST Paypal::FIELD to curl
		curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);
		
		//getting response from server
		$response = curl_exec($ch);
	
		//convrting NVPResponse to an Associative Array
		$nvpResArray=$this->deformatNVP($response);
	
		if (curl_errno($ch)) {
			// moving to display page to display curl errors
			  $error['number']=curl_errno($ch) ;
			  $error['message']=curl_error($ch);
		 } else {
			 //closing the curl
			curl_close($ch);
		  }
	return array('response'=>$nvpResArray,'error'=>@$error);
	}
	/** This function will take NVPString and convert it to an Associative Array and it will decode the response.
	  * It is usefull to search for a particular key and displaying arrays.
	  * @nvpstr is NVPString.
	  * @nvpArray is Associative Array.
	  */
	
	function deformatNVP($nvpstr) {
	
		$intial=0;
	 	$nvpArray = array();
	
	
		while(strlen($nvpstr)){
			//postion of Key
			$keypos= strpos($nvpstr,'=');
			//position of value
			$valuepos = strpos($nvpstr,'&') ? strpos($nvpstr,'&'): strlen($nvpstr);
	
			/*getting the Key and Value values and storing in a Associative Array*/
			$keyval=substr($nvpstr,$intial,$keypos);
			$valval=substr($nvpstr,$keypos+1,$valuepos-$keypos-1);
			//decoding the respose
			$nvpArray[urldecode($keyval)] =urldecode( $valval);
			$nvpstr=substr($nvpstr,$valuepos+1,strlen($nvpstr));
	     }
		return $nvpArray;
	}
}