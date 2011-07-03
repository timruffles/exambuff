package models
{
	import events.PageEvent;
	import events.UploadHelperEvent;
	
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.display.Loader;
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.ProgressEvent;
	import flash.net.FileReference;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	
	
	import helper.UploadHelper;

	public class Page extends EventDispatcher
	{
		
		private var _uploadHelper:UploadHelper;
		
		private var _fileRef:FileReference;		
		private var _progress:String;
		private var _BMD:BitmapData;
	
		
		private var _index:int;
		private var _id:String;
		
		public static const  UPLOAD_COMPLETE:String = 'complete';
		
		public function Page(index:int = 0,id:String = null):void {
			this._id = id;
			this._index = index;
		}
		
		public function set index(toIndex:int):void {
			this._index = toIndex;
		}
		public function get index():int {
			return this._index;
		}
		public function setFileRef(fileRef:FileReference):void {
			this._fileRef = fileRef;
		}
		/**
		 * Returns the progress of the upload.
		 * */
		public function get progress():String {
			return this._progress;
		}
		/**
		 * Attempts upload and sets listeners to broadcast its progress - copied
		 * */
		public function upload():void {		
					
			this._uploadHelper.upload(this._fileRef);				
			
		}
		/**
		 * Downloads Bitmapdata for the page, or dispatches a download complete event straight away if it
		 * has already been downloaded. Will dispatch a pageEvent if the page is downloaded successfully, 
		 * from which the bmp can be taken.
		 * */
		public function downloadPageBMD():void {			
			if(this._BMD == null) {
				
				// this will be changed to request getscript/scriptid/pageid - maybe in a POST to hide details?
				var request:URLRequest = new URLRequest('http://localhost:8080/CI/index.php/flex/getscript');	
				request.contentType = 'image/jpeg';
				request.method = URLRequestMethod.GET;
				
				var loader:Loader = new Loader();
							
				loader.contentLoaderInfo.addEventListener(Event.COMPLETE,this._downloadComplete);			
				
				try {
					loader.load(request);
				} catch (e:SecurityError) {
					
				} 				
			} else {
				this.dispatchEvent(new PageEvent(PageEvent.PAGE_DOWNLOAD_COMPLETE));
			}			
		}
		public function get BMD():BitmapData {					
			return this._BMD;
		} 
		private function _downloadComplete(event:Event):void {
			var bitmap:Bitmap = event.target.content;
			this._BMD = bitmap.bitmapData;
			
			var e:PageEvent = new PageEvent(PageEvent.PAGE_DOWNLOAD_COMPLETE);
			e.pageNum = this._index;
			this.dispatchEvent(e);
			
			
		}
		public function set uploadHelper(uploadHelper:UploadHelper):void {	
			this._uploadHelper = uploadHelper;
			this._uploadHelper.addEventListener(UploadHelperEvent.UPLOAD_SUCCESS,_pageUploaded);
			this._uploadHelper.addEventListener(ProgressEvent.PROGRESS,_monitorUpload);
		}	
		private function _pageUploaded(event:Event):void {		
			var evt:PageEvent = new PageEvent(PageEvent.PAGE_UPLOAD_SUCCESS);
			evt.pageNum = this._index;		
			this._progress = Page.UPLOAD_COMPLETE;
			this.dispatchEvent(evt);			
			//this.downloadPageBMD(this._pageNum);		
				
		}
		private function _uploadResult(de:DataEvent):void {
		//	trace('hi');
		//	trace('upload complete '+de.data);
		}
		private function _monitorUpload(event:ProgressEvent):void {
			this._progress = (event.bytesLoaded / event.bytesTotal).toString();		
			this.dispatchEvent(event);	
		}
		
	}
}