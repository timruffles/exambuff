package helper
{	

	import flash.display.DisplayObject;
	
	import ui.dialogues.DialogueBase;
	import ui.dialogues.LoginBox;
	import mx.controls.Alert
	
	public class ErrorCommunicator 
	{
		private static var _stage:DisplayObject;
		
		public function ErrorCommunicator()
		{
		}
		public static function userNotLoggedIn():void {
			var loginBox:LoginBox = new LoginBox(_stage);			
		}
		public static function ioError():void {
			Alert.show('Exambuff cannot connect. Please check your connection','Connection problem');
		}	
		public static function secError():void {
			Alert.show('Exambuff cannot connect. Please login and logout.','Connection problem');
		}
		public static function set stage(s:DisplayObject):void {
			ErrorCommunicator._stage = s;
		}	
	}
}