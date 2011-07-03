package helper
{
	import events.DownloadEvent;
	
	import flash.display.Loader;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.net.URLRequest;

	
	public class Download extends EventDispatcher
	{
		private var _loader:Loader;
		private var _request:URLRequest;
		private var _downloadInfo:Object;
		
		public function Download(request:URLRequest)	{
			this._loader = new Loader();
			this._request = request;
		}
		public function download():Loader {			
			this._download();
			return this._loader;
		}
		private function _download():void {
			this._loader.contentLoaderInfo.addEventListener(Event.COMPLETE,_complete);
			this._loader.contentLoaderInfo.addEventListener(IOErrorEvent.IO_ERROR,_fail);
			this._loader.contentLoaderInfo.addEventListener(ProgressEvent.PROGRESS,_progress);
			try {
				this._loader.load(this._request);
			} catch (e:Error) {
				this._cancel();
			}
		}
		private function _progress(e:ProgressEvent):void {
			var prog:DownloadEvent = new DownloadEvent(DownloadEvent.PROGRESS);
			prog.bytesLoaded = e.bytesLoaded;
			prog.bytesTotal = e.bytesTotal;
			this.dispatchEvent(prog);
		}
		private function _complete(e:Event):void {
			var sucEve:DownloadEvent = new DownloadEvent(DownloadEvent.SUCCESS);
			sucEve.loader = this._loader;
			this.dispatchEvent(sucEve);
			
		}
		private function _fail(e:Event):void {
			this._cancel();
			this.dispatchEvent(new DownloadEvent(DownloadEvent.FAIL));
		}
		public function get loader():Loader {
			return this._loader;
		}
		public function _cancel():void {
			this._loader= null;
		}
		public function get request():URLRequest {
			return this._request;
		}
		public function get downloadInfo():Object {
			return this._downloadInfo
		}
		public function set downloadInfo(o:Object):void {
			this._downloadInfo = o;
		}
	}
}