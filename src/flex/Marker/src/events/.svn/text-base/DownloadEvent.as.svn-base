package events
{
	import flash.display.Loader;
	import flash.events.Event;

	public class DownloadEvent extends Event
	{
		
		public static const SUCCESS:String = 'DE_SUCCESS';
		public static const FAIL:String = 'DE_FAIL';
		public static const PROGRESS:String = 'DE_PROGRESS';
		public var loader:Loader;
		public var bytesLoaded:int;
		public var bytesTotal:int;
		public function DownloadEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}