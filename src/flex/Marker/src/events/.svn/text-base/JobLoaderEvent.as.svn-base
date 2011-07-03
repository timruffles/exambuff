package events
{
	import flash.events.Event;

	public class JobLoaderEvent extends Event
	{
		public static const JOBS_LOADED:String = 'JS_JOBS_LOADED';
		public static const NO_JOBS:String = 'JL_NO_JOBS';
		public static const NOT_AUTH:String = 'JL_NOT_AUTH';
		public static const JOB_ALREADY_TAKEN:String = 'JL_JOB_TAKEN';
		public static const SUCCESSFULLY_ASSIGNED_JOB:String = 'SUCCESSFULLY_ASSIGNED_JOB';
		public static const MARKER_HAS_JOB:String = 'MARKER_HAS_JOB';
		
		public var script:int = 0;
		public var lastPage:int = 0;
		
		public function JobLoaderEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}