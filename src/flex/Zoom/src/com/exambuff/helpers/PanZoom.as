package com.exambuff.helpers
{
	import com.exambuff.events.PanZoomEvent;
	
	import flash.geom.Point;
	
	public class PanZoom
	{
		public function PanZoom()
		{
		}/*
		public static function zoomIn(amount:Number):PanZoomEvent {
			
		} 
		public static function zoomOut(amount:Number):PanZoomEvent {
			
		}
		public static function zoomXYMove(d:DisplayObject,e:PanZoomEvent):Array {
			
		}		
		public static function zoomScaleXY(d:DisplayObject,e:PanZoomEvent):Array {
			return 
		}*/
		public static function pan(start:Point,end:Point):PanZoomEvent {
			var pze:PanZoomEvent = new PanZoomEvent(PanZoomEvent.PAN);
			var xMove:int = Math.abs(start.x-end.x);
			start.x < end.x ? pze.xMod = xMove : pze.xMod = -xMove;
			var yMove:int = Math.abs(start.y-end.y);
			start.y < end.y ? pze.yMod = yMove : pze.yMod = -yMove;
			return pze;
		}
	}
}