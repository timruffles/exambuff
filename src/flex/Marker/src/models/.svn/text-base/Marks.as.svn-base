package models
{
	import events.MarksEvent;
	import events.ServerDataEvent;
	
	import flash.events.EventDispatcher;
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	import helper.ServerData;
	
	import vo.CommentVO;
	import vo.ScriptPage;
	
	/**
	 * 'Marks' is actually a container for all marking data: 
	 * everything created by the marker, and done to the 
	 * marking images. It has nothing to do with image data
	 * */
	public class Marks extends EventDispatcher
	{
		[Bindable]
		public var generalComment:String;
		public var classification:String;
		public var targets:Array;
		
		private var _pages:Array;
		private var _saver:ServerData;
		
		private var _script:int;
		
		private var _baseURL:String;
		
		private const SAVE_URL:String = '/addMark';
		private const LOAD_URL:String = '/mark';
		
		/**
		 * PHP result vars
		 * */
		private static const SAVE_SUCCESSFUL = 'SAVE_SUCCESSFUL';
		// dispatched when marker isn't correct marker for mark they're saving
		private static const NOT_AUTH = 'NOT_AUTH';

		public function Marks(baseURL:String) {
			this._baseURL = baseURL;
			this._pages = new Array();
		}
		public function addComment(comment:CommentVO,page:int):void {
			if(!(this._pages[page]  is ScriptPage)) {
				this._pages[page] = new ScriptPage();
			}
			this._pages[page].addComment(comment);
			trace('adding comment '+comment.x);
		}		
		public function removeComment(comment:CommentVO,page:int):void {
			this._pages[page].removeComment(comment);
		}
		public function page(page:int):ScriptPage {
			if(this._pages[page] == null) {
				this._pages[page] = new ScriptPage();
			}
			return this._pages[page];
		}
		/**
		 * Saves to server and updates LSO
		 * */
		public function save():void {
			if(!this._saver) {
				this._saver = new ServerData();
			}
			var req:URLRequest = new URLRequest(this._baseURL+SAVE_URL);
			var vars:URLVariables = new URLVariables;
			vars.jsonData = ServerData.encode(this);
			req.method = URLRequestMethod.POST;
			req.data = vars;
			
			// has to be strong ref. y? not sure
			this._saver.addEventListener(ServerDataEvent.SAVED,_saved,false,0,false);
			this._saver.save(req);
		}
		/**
		 * Handles save succes
		 * */
		 private function _saved(sde:ServerDataEvent):void {
		 	/*if(!sde.data.hasOwnProperty('result')) {
		 		trace('marks save failed');
		 		// @todo add error handeling here
		 	}*/
		 	if(sde.data.result === Marks.SAVE_SUCCESSFUL) {
		 		trace('marks _saved successful, disp evt');
		 		this.dispatchEvent(new MarksEvent(MarksEvent.MARKS_SAVED));
		 		return;
	 		}
	 		if(sde.data.result === ServerData.NOT_LOGGED_IN) {
	 			trace('marks _saved not logged in, disp evt');
	 			this.dispatchEvent(new ServerDataEvent(ServerDataEvent.NEED_TO_LOGIN));
	 			return;
	 		}
	 		if(sde.data.result === Marks.NOT_AUTH) {
	 			trace('marker not correct');
		 		return;
	 		}
	 		trace('Marks tried to save, but didn\'t get either a success or fail it recognised:'+sde.data.result);
		 }
		/**
		 * Uses ServerData helper to attempt loadingd of the 
		 * 'Marks' object stored on the server
		 * */
		public function load():void {
			trace('Marks attempting to load mark from '+this._baseURL+LOAD_URL);
			if(!this._saver) {
				this._saver = new ServerData();
			}
			var loadReq:URLRequest = new URLRequest(this._baseURL+LOAD_URL);
			var vars:URLVariables = new URLVariables;
			vars.script = this._script;
			loadReq.method = URLRequestMethod.POST;
			loadReq.data = vars;
			
			// has to be strong ref. y? not sure
			this._saver.addEventListener(ServerDataEvent.LOADED,_loaded,false,0,false);
			this._saver.load(null,loadReq);
		}
		/**
		 * Handles loaded 'Mark' data from ServerData helper
		 * */
		 private function _loaded(sde:ServerDataEvent):void {
		 	trace('Marks loaded');
		 	// each mark, and there should be only one, is encoded as an object
		 	for each(var pageAsGeneric:Object in sde.data.pages) {
		 		var page:ScriptPage = new ScriptPage();
		 		for each(var o:Object in pageAsGeneric.comments) {
		 			page.addJSONComment(o);
		 		}
		 		page.rotation = pageAsGeneric.rotation;
		 		this._pages.push(page);
		 	}
	 		this.classification = sde.data.classification;
	 		this.generalComment = sde.data.generalComment;
		 	this.dispatchEvent(new MarksEvent(MarksEvent.MARKS_LOADED));
		 }				
		/**
		 * Auto-saves to LSO
		 * */
		public function autosave():void {
			
		}
		/**
		 * Saves to Local Shared Object
		 * */
		private function _lsoSave():void {
			
		}
		/**
		 * Loads from Local Shared Object
		 * */
		private function _lsoLoad():void {
			
		}
		/**
		 * Get set
		 * */
		 public function get script():int {
		 	return this._script;
		 }
		 public function set script(s:int):void {
		 	this._script = s;
		 }
		 
		 public function get pages():Array {
		 	return this._pages;
		 }
	}
}