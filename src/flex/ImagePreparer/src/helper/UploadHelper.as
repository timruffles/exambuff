package helper
{
	import events.UploadHelperEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.FileReference;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	import mx.controls.Alert;	
	public class UploadHelper extends EventDispatcher
	{
		private const UPLOAD:String = 'UPLOAD';
		private const UPLOAD_RESULT:String = 'UPLOAD_RESULT';
		private const PAGE_UPLOAD_URL:String = 'http://localhost:8080/CI/index.php/user/upload/async';
		private const PAGE_UPLOAD_RESULTS_URL:String = 'http://localhost:8080/CI/index.php/user/upload/result/';
		private var _token:String;
		private var _uploadQue:Array = new Array();
		private var _uploading:Boolean;

		/**
		 * Upload data takes file references in at upload(), which it then ques and uploads in turn, using the new token 
		 * received from the server to upload the next on completion.
		 * 
		 * UploadHelper wraps the uploading process so data can be returned from the server, regardless of whether
		 * Flex DataEvent.UPLOAD_DATA_COMPLETE fires or not (it doesn't)
		 * */
		public function UploadHelper()
		{
		}
		/**
		 * Attempts upload and sets listeners to broadcast its progress
		 * */
		public function upload(fileRef:FileReference):void {
			// push returns the number of elements in the array 
			var currentlyQued:int = this._uploadQue.push(fileRef);
			
			// if we only have one element, we can start uploading straight away
			if (currentlyQued == 1) {			
				this._startUpload(this._uploadQue[0]);
			}
		}
		private function _uploadNext():void {
			if(this._uploadQue.length >= 1) {
				this._startUpload(this._uploadQue[0]);
			}
		}		
		private function _startUpload(fileRef:FileReference):void {
			var request:URLRequest =new URLRequest(this.PAGE_UPLOAD_RESULTS_URL);
			request.method = URLRequestMethod.POST;
			
			fileRef.addEventListener(IOErrorEvent.IO_ERROR,_catchIOError);
			fileRef.addEventListener(Event.COMPLETE,_getResult);
			fileRef.addEventListener(ProgressEvent.PROGRESS,_communicateProgress);
			try {
				
				fileRef.upload(request,'exambuff');		
				trace('started upload');	
			} catch (e:Error) {
				this._cancelCurrentUpload();
			}

		}	
		
		/**
		 * Ensures that the file has actually been accepted by the server, rather than rejected with an error code
		 * */
		private function _getResult(e:Event):void {
				this._uploadQue.shift();
		 		this._uploadNext();
				trace('attempting to get results for ');
				trace(this._uploadQue.toString());
		 		var request:URLRequest = this._getRequest(this.UPLOAD_RESULT);
		 		
	 			var resultLoader:URLLoader = new URLLoader();
	 			resultLoader.addEventListener(IOErrorEvent.IO_ERROR,_catchIOError);
		 		resultLoader.addEventListener(Event.COMPLETE,_resultReceived);
		 		
		 		try {
					resultLoader.load(request);			
				} catch (e:Error) {
					this._cancelCurrentUpload();					
				} 	
		}
			 /**
		 * Gets and stores the new token from the server. Starts the next upload
		 * */
		 private function _resultReceived(e:Event):void {
		 		 
		 	var resultLoader:URLLoader = URLLoader(e.target);	
		 			 	
		 	if(resultLoader.data == "") {
		 		ErrorCommunicator.userNotLoggedIn();
		 		this._cancelCurrentUpload();
		 		return;
		 	} 
		 		
	 		var resultData:URLVariables = new URLVariables;	
	 			 	
		 	try {		 			 			
				resultData.decode(resultLoader.data);
		 	} catch(e:Error){
		 		this._cancelCurrentUpload();
		 	}				
		 	
		 	/* token code removed till later 07-11-08
			if(resultData.result == 'no token') {
				//trace('no token sent');
			} else {
				//trace('token received:'+resultData.token);
			}
		 	this._token = resultData.token;	
		 	*/
		 	
		 	// interrogate results
		 	Alert.show(resultLoader.data.toString());
		 	switch(resultData.result) {
		 		case 'SUCCESSFUL':
		 			var completeEvent:Event = new UploadHelperEvent(UploadHelperEvent.UPLOAD_SUCCESS);
			 		this.dispatchEvent(completeEvent);
		 		break;
		 		case 'MOVE_FAILED':
		 			Alert.show('Error uploading, please retry');
		 		break;
		 		case 'TOO_LARGE':
		 			Alert.show('The file you tried to upload was too large: please ensure your file is under 10mb');
		 		break;
		 		case 'WRONG_TYPE':
		 			Alert.show('The file you tried to upload was not one of those used. Please upload in .jpg format');
		 		break;
		 		default:
		 			Alert.show('Error uploading, please retry');
		 		break;
		 	}
		 	
		 }
		 private function _getRequest(type:String):URLRequest {
			if(type !== this.UPLOAD && type!==this.UPLOAD_RESULT) {
				throw new Error('Get request requires one of two valid request types');
			}
			var url:String;
			type===this.UPLOAD ? url = this.PAGE_UPLOAD_URL : url = this.PAGE_UPLOAD_RESULTS_URL;
						this.PAGE_UPLOAD_RESULTS_URL
			var request:URLRequest = new URLRequest(url);
			//var requestVars:URLVariables = new URLVariables('token='+this._token);
			request.method = URLRequestMethod.POST;					
			//request.data = requestVars;
			return request;
		}
		private function _catchSecError(e:SecurityErrorEvent):void {
			Alert.show('fatal');
			this._cancelCurrentUpload();
		}
		private function _catchIOError(e:IOErrorEvent):void {		
			Alert.show('ExamBuff cannot connect. Please check the status of your internet connection');
			// cancel the current upload, as it isn't recoverable. This will allow qued uploads to attempt, or new ones
			this._cancelCurrentUpload();
		}
		private function _cancelCurrentUpload():void {			
			this._uploadQue.shift();		
			this._uploadNext();	
		}
		/**
		 * Dispatches a new progress event
		 */
		private function _communicateProgress(pe:ProgressEvent):void {
			var peForDispatch:ProgressEvent = new ProgressEvent(ProgressEvent.PROGRESS);
			peForDispatch.bytesLoaded = pe.bytesLoaded;
			peForDispatch.bytesTotal = pe.bytesTotal;
			this.dispatchEvent(peForDispatch);
		}
		/**
		 * Requests upload data for the upload from this token
		 * */
		 private function _pageUploaded():void {
		 		// remove first element		 		
		 }	
		 public function set token(token:String):void {
			this._token  = token;
		}
	}
}