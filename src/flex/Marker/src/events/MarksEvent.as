package events
{
	import flash.events.Event;

	public class MarksEvent extends Event
	{
		public static const MARKS_LOADED:String = 'ME_MARKS_LOADED';
		public static const MARKS_SAVED:String = 'ME_MARKS_SAVED';
		
		public function MarksEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}