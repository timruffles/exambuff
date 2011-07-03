package models
{
	
	import events.DownloadEvent;
	import events.ScriptPagesEvent;
	
	import flash.display.Bitmap;
	import flash.display.BitmapData;
	import flash.events.EventDispatcher;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	
	import helper.Download;
	import helper.Downloader;
	
	/**
	 * Downloads script pages and stores the BMD. These BMDs are not
	 * altered.
	 * */	
	public class ScriptPages extends EventDispatcher
	{
		private var _pageURL:String;
		private var _pageIDs:Array = new Array();
		private var _pageBMDs:Array = new Array();
		private var _dler:Downloader;
		private var _script:int;
		private const PAGE_URL:String = '/page/';
		
		public function ScriptPages(baseURL:String)	{
			this._pageURL = baseURL+PAGE_URL;
			this._dler = new Downloader();		
		}		
		/**
		 * If BMD has not already been loaded, start the download process. If it has, immediately dispatch a loaded
		 * event
		 * */
		public function loadPage(script:int,pagenum:int):void {
			//trace('Attempting to loading page image from '+ this._imageURL(script,pagenum));
			if(this._pageBMDs[pagenum] == undefined) {
				this._script = script;
				var downloadURL:String = this._imageURL(script,pagenum);
				var downloadReq:URLRequest = new URLRequest(downloadURL);
				
				downloadReq.contentType = 'image/jpeg';
				
				downloadReq.method = URLRequestMethod.GET;
				
				// this download will be activated asap by the downloader; not doing it now allows queing
				var download:Download = this._dler.download(downloadReq);
				download.downloadInfo = {page:pagenum};
				download.addEventListener(DownloadEvent.SUCCESS,_pageLoaded,false,0,true);
				download.addEventListener(DownloadEvent.FAIL,_failed,false,0,true);
				return;
			}
			this._successfulLoad(pagenum);
		}
		private function _failed(e:DownloadEvent):void {
			this.dispatchEvent(new ScriptPagesEvent(ScriptPagesEvent.PAGE_LOAD_FAILED));
		}
		/**
		 * 'Image' name, which is used by the server to pull up the images
		 * */
		private function _imageURL(script:int,pageNum:int):String {
			return this._pageURL+script+'-'+pageNum+'.jpg';
		}
		private function _pageLoaded(e:DownloadEvent):void {
			//trace('Page image loaded');
			var dl:Download = Download(e.target);	
			try {
				var bitmap:Bitmap = Bitmap(e.loader.content);
			} catch (e:Error) {
				this.dispatchEvent(new ScriptPagesEvent(ScriptPagesEvent.PAGE_LOAD_FAILED));
				return;
			}
			
			this._pageBMDs.push(bitmap.bitmapData);
			this._successfulLoad(dl.downloadInfo.page);
		}
		public function getPageBMD(index:int):BitmapData {
			return this._pageBMDs[index];
		}
		private function _successfulLoad(pagenum:int):void {
			var suc:ScriptPagesEvent = new ScriptPagesEvent(ScriptPagesEvent.PAGE_LOADED);
			suc.page = pagenum;
			this.dispatchEvent(suc);
		}
	}
}