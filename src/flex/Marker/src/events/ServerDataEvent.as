package events
{
	import flash.events.Event;
	
	public class ServerDataEvent extends Event
	{
		
		public static const LOADED:String = 'SD_LOADED';
		public static const SAVED:String = 'SD_SAVED';
		public static const FAILED:String = 'SD_FAILED';
		public static const NEED_TO_LOGIN:String = 'SD_NEED_TO_LOGIN';
		public var data:Object;
			
		public function ServerDataEvent(type:String,data:Object=null)	{
			super(type);		
			this.data = data;	
		}		
		
	}
}