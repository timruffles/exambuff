<?php
class SwiftWrap {
	function SwiftWrap() {
		$CI =& get_instance();
		require_once($CI->config->item('swift'));
		require_once($CI->config->item('swift_smtp'));
		require_once($CI->config->item('swift_auth'));
	}
	/**
	 * 
	 * @param $sender
	 * @param $senderPass
	 * @param $receiver
	 * @param $subject
	 * @param $message
	 * @return unknown_type
	 */
	public function email($sender,$senderPass,$receiver,$subject,$message,$replyTo = 'no-reply@exambuff.co.uk') {
		try {
			$smtp = new Swift_Connection_SMTP("smtp.gmail.com",465, Swift_Connection_SMTP::ENC_SSL);
			$smtp->setTimeout(10);
			$smtp->setUsername($sender);
			$smtp->setPassword($senderPass);
			$smtp->attachAuthenticator(new Swift_Authenticator_LOGIN());
			$swift = new Swift($smtp,'exambuff.co.uk');			
		} catch (Exception $e) {
			$error = $e->getMessage();
		}
		
		$msgSubject = $subject;
		$msgBody =$message;
		
		$swfMessage = new Swift_Message($msgSubject,$msgBody);
		
		try {
			$swift->send($swfMessage,$receiver,$replyTo);
			return true;
		} catch (Exception $e) {
			if(!@$error) $error = '';
			$error .= $e->getMessage();
			log_message('error',$error);
		}
		return @$error;
	}
}