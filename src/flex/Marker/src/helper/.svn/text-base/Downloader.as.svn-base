package helper
{
	import flash.display.Loader;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.URLRequest;

	/**
	 * Provides a common way of downloading. Ques downloads, and deals with all error events. Especially good for 
	 * avoiding the classic - forgot the asyncronous errors, and therefore can't work out wth is wrong bugs. :)
	 * */
	public class Downloader extends EventDispatcher
	{
		private var _downloads:Array = new Array();
		public function Downloader()
		{
		}
		/**
		 * Ques a new url loader and returns it for success listeners. Actual downloading is done by download object
		 * */
		public function download(request:URLRequest):Download {			
			var dl:Download = new Download(request);
			this._downloads.push(dl);
			if(this._downloads.length===1) {
				this._next();
			}
			return dl;
		}
		private function _next():void {
			if(this._downloads.length > 0) {
				var downloadObj:Download = this._downloads[0]
				var dl:Loader = downloadObj.loader;
				dl.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR,_catchIOError,false,0,true);
				dl.contentLoaderInfo.addEventListener(SecurityErrorEvent.SECURITY_ERROR,_catchSecError,false,0,true);
				dl.contentLoaderInfo.addEventListener(Event.COMPLETE,_complete,false,0,true);
				downloadObj.download();		
			}
		}	
		private function _cancel():void {
			this._downloads.shift();
			this._next();
		}
		private function _complete(e:Event):void {
			this._downloads.shift();
			this._next();
		}
		/**
		 * Error handlers use the ErrorCommunicator to tell the user, inform data loaders of all they need to know: that an
		 * error has occured, and cancels the current download
		 * */
		private function _catchSecError(e:SecurityErrorEvent):void {
			this._cancel();
		}
		private function _catchIOError(e:IOErrorEvent):void {	
			this._cancel();
		}

	}
}