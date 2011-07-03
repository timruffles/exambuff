package events
{
	import flash.events.Event;
	
	import vo.CommentVO;
	
	public class MarkingAreaEvent extends Event
	{
		public var comment:CommentVO;
		public static const HAS_FOCUS:String = 'MA_HAS_FOCUS';
		public static const CLOSE:String = 'MA_CLOSE';
		public static const DONE:String = 'MA_DONE';
		public static const FINISHED:String = 'MA_FINISHED';
		public function MarkingAreaEvent(type:String,comment:CommentVO = null)	{
			var bubbles:Boolean = false;
			if(type == MarkingAreaEvent.FINISHED) {
				bubbles = true;
			}
			super(type,bubbles);
			this.comment = comment;		
		}
	
	}
}