package models
{
	import events.PageEvent;
	import events.ScriptEvent;
	
	import flash.display.BitmapData;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.ProgressEvent;
	import flash.net.FileReference;
	import flash.net.FileReferenceList;
	
	import helper.UploadHelper;
	
	import mx.controls.Alert;
	
	public class Script extends EventDispatcher
	{

		private var _fileRef:FileReferenceList=  new FileReferenceList();
		private var _pages:Array = new Array();
		private var _uploadHelper:UploadHelper;
		
		/**
		 * Allow the user to select multiple files to upload. Each will then be turned into a page
		 * 
		 **/
		public function selectFiles():void {								
			_fileRef.addEventListener(Event.SELECT, _selectHandler);		
			try
			{
			    var success:Boolean = _fileRef.browse();
			}
			catch (error:Error)
			{
			    Alert.show('Sorry, unable to browse for files, please check security settings');
			}
		}
		private function _selectHandler(event:Event):void {		
				
			for (var i:uint = 0; i < _fileRef.fileList.length;i++) {				
				
				this._pageUpload(_fileRef.fileList[i]);
			
			}
		}
		/**
		 * Create page model, save in script _pages array, dispatch page_added event and attempt upload. Add event listener
		 * for updates to page model
		 * */
		private function _pageUpload(fileRef:FileReference):void {		
			var page:Page = new Page();
			this._pages.push(page);		
			
			// page.setPageNum(this._pages.length);
						
			page.setFileRef(fileRef);
			
			page.addEventListener(PageEvent.PAGE_UPLOAD_SUCCESS,this._pageUploaded);
			page.addEventListener(ProgressEvent.PROGRESS,this._pageChange);
					
			// add token to ensure that 
			page.uploadHelper = this._uploadHelper;
			
			page.upload();			
		}
		private function _pageUploaded(event:PageEvent):void {
					
			var scriptEvent:ScriptEvent = new ScriptEvent(ScriptEvent.PAGE_ADDED);		
			scriptEvent.pageNum = event.pageNum;
			this.dispatchEvent(scriptEvent);
			
		}
		private function _pageChange(event:ProgressEvent):void {	
			this.dispatchEvent(event);
		}
		public function latestPage():Page {
			return this._pages[this._pages.length];
		}
		public function getPages():Array {
			return this._pages;
		}		
		public function set uploadHelper(uploadHelper:UploadHelper):void {
			this._uploadHelper = uploadHelper;
		}	
		public function downloadPage(index:int):void {
			var page:Page =  this._pages[index];
			page.addEventListener(PageEvent.PAGE_DOWNLOAD_COMPLETE,this._pageBMDReady);
			page.downloadPageBMD();			
		}
		private function _pageBMDReady(e:PageEvent):void {
			
			var event:ScriptEvent = new ScriptEvent(ScriptEvent.PAGE_BMD_READY);
			event.pageNum = e.pageNum;
			this.dispatchEvent(event);
		
		}
		public function getBMDAt(index:int):BitmapData {
			var page:Page = this._pages[index];
			var bmd:BitmapData = page.BMD;
			return bmd;
		}
	}
}