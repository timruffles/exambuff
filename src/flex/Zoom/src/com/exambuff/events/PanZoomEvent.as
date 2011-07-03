package com.exambuff.events
{
	import flash.events.Event;
	
	public class PanZoomEvent extends Event
	{
		public static const ZOOM:String = 'pz_zoom';
		public static const PAN:String = 'pz_pan';
		public var xMod:int;
		public var yMod:int;
		public var scaleMod:Number;
		public function PanZoomEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}