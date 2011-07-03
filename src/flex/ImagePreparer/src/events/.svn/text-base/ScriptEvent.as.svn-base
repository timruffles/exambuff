package events
{
	import flash.display.BitmapData;
	import flash.events.Event;
	
	public class ScriptEvent extends Event {
		
		public static const PAGE_ADDED:String = 'page_added_event';
		public static const PAGE_BMD_READY:String = 'page_bmd_added';
		private var _pageNum:int;			
		
		public function ScriptEvent(type:String, bubbles:Boolean = false, cancelable:Boolean = false) {
			super(type,bubbles,cancelable);
		}
		public function set pageNum(toIndex:int):void {
			this._pageNum = toIndex;
		}
		public function get pageNum():int {
			return this._pageNum;
		}
		
	}
}