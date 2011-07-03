// ActionScript file
package models {
	
	import events.ScriptEvent;
	
	import flash.display.BitmapData;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.geom.Matrix;
	import flash.geom.Point;
	import flash.geom.Rectangle;
	
	import states.CropState;
	import states.ImagePreparerState;
	import states.RotateState;
	
	public class ImagePreparerPM extends EventDispatcher {
		
		// these values are related to the DMs
		private var _currentPage:int;
		private var _currentPageEdited:Boolean;
		private var _state:ImagePreparerState;
		private var _BMD:BitmapData;
		
		// these values are edited by the states
		private var _rotationRad:Number;
		private var _cropRect:Rectangle;
		
		// these values are updated by the view, and passed to the states
		private var _imageCentre:Point;
		
		private var _script:Script;
				
		private const MAX_WIDTH:int = 2000;
		private const MAX_HEIGHT:int = 2000;
		
		public static const ROTATE:String = 'rotate';
		public static const CROP:String = 'crop';
				
		public function mouseDown(e:MouseEvent):void {
			this._state.mouseDown(e);
		}
		public function mouseUp(e:MouseEvent):void {
			this._state.mouseUp(e);
		}
		public function mouseMove(e:MouseEvent):void {
			this._state.addEventListener(Event.CHANGE,this._updateFromState);
			this._state.mouseMove(e);
		}			
		public function pageAdded(event:ScriptEvent):void {			
			// if we have no page, load the one added
			if (this._currentPage != undefined) {				
				this._changeLoadedPageTo(event.pageNum);
			} 
		}	
		private function _updateFromState(e:Event):void {
			if(e.target is RotateState) {			
				this._rotationRad = e.target.rotationRad;
			} else {
				this._cropRect = e.target.cropRect;
			}
		}
		private function _getConfirmationOfChangeTo(index:int):void {
			
		}
		public function changePage(index:int):void {
			if(this._currentPageEdited) {
				this._getConfirmationOfChangeTo(index);
			} else {
				this._changeLoadedPageTo(index);
			}
		}		
		private function _changeLoadedPageTo(index:int):void {
		
			this._script.addEventListener(ScriptEvent.PAGE_BMD_READY,this._updateBMD);
			this._script.downloadPage(index);			
		}		
		private function _updateBMD(e:ScriptEvent):void {	
		
			var bmd:BitmapData = this._script.getBMDAt(e.pageNum);			
			this._BMD = bmd;		
			this.dispatchEvent(new Event(Event.CHANGE));						
		}
		private function _prepareBMD(bmd:BitmapData):BitmapData {						
		 	var originalWidth:Number = bmd.width;
		 	var originalHeight:Number = bmd.height;
		 	
		 	var newWidth:Number;
		 	var newHeight:Number;
		 			
		 	var m:Matrix = new Matrix();
		 					 
		 	if (originalWidth > this.MAX_WIDTH || originalHeight >  this.MAX_HEIGHT) {
		  		var sx:Number =   this.MAX_WIDTH / originalWidth;
		  		var sy:Number = this.MAX_HEIGHT / originalHeight;
		  		var scale:Number = Math.min(sx, sy);
		  		newWidth = originalWidth * scale;
		  		newHeight = originalHeight * scale;	
		  	}
		 	m.scale(scale, scale);
		 	var returnBMD:BitmapData = new BitmapData( newWidth, newHeight); 
		 	
		 	return returnBMD;
		}
		public function set script(script:Script):void {
			this._script = script;
		}		
		public function set state(state:String):void {
			if(state!=ImagePreparerPM.ROTATE && state!=ImagePreparerPM.CROP) {
				throw new Error('Set state requires one of two state constants');
			}
			state == ROTATE ? this._state = new RotateState(this._imageCentre) : this._state = new CropState();			 
		}
		public function get state():String {
			var stringRepresentationOfState:String;
			this._state is RotateState ? stringRepresentationOfState = ImagePreparerPM.ROTATE : 
												  stringRepresentationOfState = ImagePreparerPM.CROP;
			return stringRepresentationOfState;
		}
		public function get BMD():BitmapData {
			return this._BMD;
		}
		public function set rotationRad(angle:Number):void {
			this._rotationRad = angle;
		}
		public function get rotationRad():Number {
			return this._rotationRad;
		}
		public function set imageCentre(centre:Point):void {
			this._imageCentre = centre;
		}
		public function get imageCentre():Point {
			return this._imageCentre;
		}
		
	}
}