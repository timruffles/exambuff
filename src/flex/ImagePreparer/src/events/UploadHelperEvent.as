package events
{
	import flash.events.Event;
	
	public class UploadHelperEvent extends Event
	{
		public static const UPLOAD_SUCCESS:String = 'UPLOAD_SUCCESS';
		public static const UPLOAD_FAILURE:String = 'UPLOAD_FAILURE';
		public function UploadHelperEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false) {
			super(type,bubbles,cancelable);
		}

	}
}