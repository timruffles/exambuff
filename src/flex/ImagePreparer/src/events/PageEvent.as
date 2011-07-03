// ActionScript file
package events {
	import flash.events.Event;
	
	public class PageEvent extends Event {
		
		public static const PAGE_UPLOAD_SUCCESS:String = 'page_upload_success_event';
		public static const PAGE_UPLOAD_CHANGE:String = 'page_upload_change_event';
		public static const PAGE_DOWNLOAD_COMPLETE:String = 'page_download_success_event';	
		
		public var pageNum:Number;	
		
		public function PageEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false) {
			super(type,bubbles,cancelable);
		}
		
	}
}