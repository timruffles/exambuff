package states
{
	import flash.display.BitmapData;
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.geom.Point;
	
	import helper.MouseAngle;
	
	public class RotateState extends ImagePreparerState
	{
		
		private var _BMD:BitmapData;				
		private var _imageCentre:Point;
		private var _last:Point;
			
		[Bindable]
		public var rotationRad:Number;
		public function RotateState(imgCentre:Point):void {
			this._imageCentre = imgCentre;
		}
		override public function mouseDown(e:MouseEvent):void {	
			this._last = new Point(e.stageX,e.stageY);
		}
		override public function mouseMove(e:MouseEvent):void {			
			var current:Point = new Point(e.stageX,e.stageY);
			
			var currentAngle:Number = MouseAngle.mouseAngle(this._imageCentre,current);
			var lastAngle:Number = MouseAngle.mouseAngle(this._imageCentre,this._last);
			var angleDifference:Number = lastAngle - currentAngle;	
			
			this.rotationRad = -angleDifference;
			this._last = current;
			var newEvent:Event = new Event(Event.CHANGE);
			this.dispatchEvent(newEvent);
		}			
		override public function mouseUp(e:MouseEvent):void {
			
		}	
		public function set imageCentre(centre:Point):void {
			this._imageCentre = centre;
		}
		public function set BMD(bmd:BitmapData):void {
			this._BMD = bmd;
		}
		public function get BMD():BitmapData {
			return this._BMD;
		}
	}
}