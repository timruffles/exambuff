package events
{
	import flash.events.Event;
	public class LoginEvent extends Event
	{
		public static const LOGIN_SUCCESS:String = 'LOGIN_SUCCESS';
		public static const LOGIN_FAILURE:String = 'LOGIN_FAILURE';		
		
		public function LoginEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false) {
			super(type,bubbles,cancelable);
		}

	}
}