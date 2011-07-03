package helper
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLVariables;
	
	public class ScriptDataLoader extends EventDispatcher
	{
		private const requestURL:String = 'http://localhost:8080/CI/index.php/upload/script';
		private var _pages:Array;
		private var _question:String;
		private var _subject:String;
		
		public function ScriptDataLoader() {
		}
		public function load():void {
			var req:URLRequest = new URLRequest(this.requestURL);
			var loader:URLLoader = new URLLoader();
			loader.addEventListener(Event.COMPLETE,_readData);
			loader.addEventListener(IOErrorEvent.IO_ERROR,_catchIOError);
			try {
			loader.load(req);
			} catch (e:SecurityError) {
				
			} catch (e:Error) {
				
			}
		}
		private function _readData(e:Event):void {
			var loader:URLLoader = URLLoader(e.target);
			var scriptData:URLVariables = new URLVariables;
			
			scriptData.parse(loader.data);
			
			// was nothing returned?
			if(scriptData.pageKeys == null) {
				// we weren't authenticated
				Alert.show('You are not currently authenticated, please login');
				return;
			}
			var pageKeys:String = scriptData.pageKeys;			
			this._pages = pageKeys.split(',');
			this._subject = scriptData.subject;
			this._question = scriptData.question;			
			this.dispatchEvent(new Event(Event.COMPLETE));
		}		
		private function _catchIOError(e:IOErrorEvent):void {		
			Alert.show('ExamBuff cannot connect. Please check the status of your internet connection');
		}		
		public function get pages():Array {
			return this._pages;
		}
		public function get subject():String {
			return this._subject;
		}
		public function get question():String {
			return this._question;
		}
	}
}