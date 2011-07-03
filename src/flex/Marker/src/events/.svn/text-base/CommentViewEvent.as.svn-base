package events
{
	import flash.events.Event;
	
	import vo.CommentVO;
	
	public class CommentViewEvent extends Event
	{
		
		public var comment:CommentVO;
		public static const RESTORE:String = 'CV_RESTORE';
		public static const CLOSE:String = 'CV_CLOSE';
		public static const DONE:String = 'CV_DONE';
		public static const CONFIRMED:String = 'CV_CONFIRMED';
		
		public function CommentViewEvent(type:String,comment:CommentVO=null)	{
			super(type,true);		
			this.comment = comment;	
		}
	}
}