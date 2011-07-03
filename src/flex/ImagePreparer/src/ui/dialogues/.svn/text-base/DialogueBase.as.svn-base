package ui.dialogues
{
	import flash.display.DisplayObject;
	import flash.events.MouseEvent;
	
	import mx.containers.HBox;
	import mx.containers.TitleWindow;
	import mx.containers.VBox;
	import mx.controls.Button;
	import mx.controls.Label;
	
	public class DialogueBase extends TitleWindow
	{
		private var _label:Label = new Label();
		public function DialogueBase(title:String,description:String,buttons:Array = null,contents:DisplayObject=null):void {				
				_label.text = description;
				this.title = title;
				this.width = 200;
				this.height = 200;				
				if(contents) {
					this.addChild(contents);
					return;
				}
				var labelAndButtons:VBox = new VBox();				
				labelAndButtons.addChild(_label);				
				for (var i:String in buttons) {
					var buttonSpace:HBox = new HBox();
					buttonSpace.addChild(buttons[i]);
				}
				labelAndButtons.addChild(buttonSpace);
		}
		public static function button(label:String,listener:Function):Button {
			var b:Button = new Button();
			b.label = label;
			b.addEventListener(MouseEvent.CLICK,listener);
			return b;
		}
		

	}
}