package helper
{
	import events.ServerDataEvent;
	
	import flash.events.Event;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	public class Login extends ServerData
	{
		public static const SUCCESS:String = 'login succ';
		public static const FAIL:String = 'login fail';
		
		// from php
		private static const FLEX_LOGIN = 'flex login';
		private static const FLEX_FAIL = 'flex fail';	
			
		private var loginURL = '/marker/login/flexlogin';
		
		public function Login(baseURL:String):void {
			super();
			this.loginURL = baseURL+loginURL;
		}
		
		public function loginAttempt(email:String,password:String):void {
			this.addEventListener(ServerDataEvent.LOADED,this.checkResult);
			this.addEventListener(ServerDataEvent.FAILED,this.failed);
			var req:URLRequest = new URLRequest(this.loginURL);
			var vars:URLVariables = new URLVariables();
			req.method = URLRequestMethod.POST;
			vars.email = email;
			vars.password = password;
			req.data = vars;
			 
			this.load(null,req);
		}
		private function checkResult(sde:ServerDataEvent):void {
			if(sde.data.result === Login.FLEX_LOGIN) {
				this.dispatchEvent(new Event(Login.SUCCESS));
				return;
			}
			this.dispatchEvent(new Event(Login.FAIL));
		}
		private function failed(sde:ServerDataEvent):void {
			trace('failed login, io error etc? requested:'+this.loginURL+' and got data:'+sde.data);
		}
	}
}