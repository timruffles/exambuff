package ui.dialogues
{
	import flash.display.DisplayObject;
	import flash.events.Event;
	import flash.events.MouseEvent;
	
	import mx.containers.Form;
	import mx.containers.FormItem;
	import mx.containers.TitleWindow;
	import mx.controls.TextInput;
	import mx.managers.PopUpManager;
	
	import views.LoginForm;
	
	public class LoginBox extends TitleWindow
	{
		private var _stage:DisplayObject;
		public function LoginBox(stage:DisplayObject):void
		{			
			this._stage = stage;
			this.title = 'Login';
			this.width = 300;
			this.height = 175;
			var form:LoginForm = new LoginForm();
			this.addChild(form);	
			this.showCloseButton = true;
			this.addEventListener(Event.CLOSE,_close);
			PopUpManager.addPopUp(this,this._stage);
			PopUpManager.centerPopUp(this);	
		}
		
		private function _close(e:Event):void {
			PopUpManager.removePopUp(this);
		}
		private function _login(me:MouseEvent):void {
			
		}
		private function _setupForm():Form {
			var form:Form = new Form();
			var username:FormItem = new FormItem();
			var usernameInput:TextInput = new TextInput();
			usernameInput.id = 'username';
			username.addChild(usernameInput);
			username.label = 'Username';
			username.required = true;
			
			var password:FormItem = new FormItem();
			var passwordInput:TextInput = new TextInput();
			passwordInput.id = 'password';
			password.addChild(passwordInput);
			password.label = 'Password';
			password.required = true;
			
			
			form.addChild(username);
			form.addChild(password);
			return form;
		}
	}
}