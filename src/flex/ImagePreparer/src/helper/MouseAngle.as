package helper
{
	import flash.geom.Point;
	
	public class MouseAngle
	{	
		/**
		 * Returns the mouse angle relative to another point in the same coordiante space, in radians
		 * */
		public static function mouseAngle(origin:Point,current:Point):Number {
			// right angle of the triangle			
			var dx:Number = current.x - origin.x;
			var dy:Number = current.y - origin.y;
						
			var angleRad:Number = Math.atan2(dy,dx);		
			
			return angleRad;	
		}
		public static function rad2Deg(radians:Number):Number {
			var degrees:Number =  radians *  180/Math.PI;
			return degrees;
		}
		public static function deg2Rad(degrees:Number):Number {
			var radians:Number =  degrees *  Math.PI/180;
			return radians; 
		}

	}
}