package helper
{
	import events.JobLoaderEvent;
	import events.ServerDataEvent;
	
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	import mx.collections.ArrayCollection;
	
		
	public class JobLoader extends ServerData
	{
		
		/**
		 * These constants mirror I_FlexJobs, I_FlexIO
		 */
		private static const NOT_AVAILABLE:String = 'NOT_AVAILABLE';
		private static const MARKER_ACCEPTED:String = 'MARKER_ACCEPTED';
		private static const MARKER_HAS_JOB:String = 'MARKER_HAS_JOB';
		private static const ERROR:String = 'ERROR';
		private static const NOT_AUTH:String = 'NOT_AUTH';
	
		private var _jobListURL:String;
		private var _jobAssignURL:String;
		private var _jobs:Array;
		
		private var _marking:Boolean = false;
		
		
		public function JobLoader(baseURL:String,marking:Boolean = false):void {
			trace('starting job loader: marking= '+marking);
			this._jobListURL = baseURL +'/joblist';
			this._jobAssignURL = baseURL + '/takejob';
			this._marking = marking;
		}
		public function loadJobs():void {
			trace('loading jobs from '+this._jobListURL);
			this._jobs = new Array();
			this.addEventListener(ServerDataEvent.LOADED,this._getJobInfo);
			this.addEventListener(ServerDataEvent.FAILED,this._loadFailed);
			this.load(_jobListURL);
		}
		public function takeJob(script:int):void {
			trace('attempting to take job from '+this._jobAssignURL);
			
			var req:URLRequest = new URLRequest(this._jobAssignURL);
			var vars:URLVariables = new URLVariables;
			
			vars.script = script;
			
			req.method = URLRequestMethod.POST;
			req.data = vars;
			
			this.addEventListener(ServerDataEvent.LOADED,this._checkResult);
			this.addEventListener(ServerDataEvent.FAILED,this._loadFailed);
			this.load(null,req);
		}
		private function _checkResult(event:ServerDataEvent):void {
			this.removeEventListener(ServerDataEvent.LOADED,this._checkResult);
			this.removeEventListener(ServerDataEvent.FAILED,this._loadFailed);
			trace('got takeJob result '+event.data.result);
			if(event.data.result === JobLoader.MARKER_ACCEPTED) {
				this.dispatchEvent(new JobLoaderEvent(JobLoaderEvent.SUCCESSFULLY_ASSIGNED_JOB));
				return;
			}
			this.dispatchEvent(new JobLoaderEvent(JobLoaderEvent.JOB_ALREADY_TAKEN));
		}
		private function _getJobInfo(event:ServerDataEvent):void {
			this.removeEventListener(ServerDataEvent.LOADED,this._getJobInfo);
			this.removeEventListener(ServerDataEvent.FAILED,this._loadFailed);
			if(this._marking) {
				if(event.data.hasOwnProperty('result')) {
					if(event.data.result === JobLoader.MARKER_HAS_JOB) {
						var e:JobLoaderEvent = new JobLoaderEvent(JobLoaderEvent.MARKER_HAS_JOB);
						e.lastPage = event.data.lastPage;
						e.script = event.data.script;
						this.dispatchEvent(e);
						return;
					}
					if(event.data.result === 'NOT LOGGED IN') {
						this._loadFailed();
						return;
					}
				}
			}
			trace('storing objects');
			var i:int = 0;
			for each(var obj:Object in event.data) {
				this._jobs.push(obj);
				i++;
			}
			if(i===0) {
				this.dispatchEvent(new JobLoaderEvent(JobLoaderEvent.NO_JOBS));
				return;
			}
			this.dispatchEvent(new JobLoaderEvent(JobLoaderEvent.JOBS_LOADED));			
		}
		private function _loadFailed(event:ServerDataEvent = null):void {
			trace('job loader dispatching NOT_AUTH');
			this.dispatchEvent(new JobLoaderEvent(JobLoaderEvent.NOT_AUTH));
		}
		public function get jobs():ArrayCollection {
			return new ArrayCollection(this._jobs);
		}
	}
}