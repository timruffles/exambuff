package views
{
	import events.CommentViewEvent;
	import events.MarkingAreaEvent;
	
	import flash.events.Event;
	import flash.events.MouseEvent;
	import flash.geom.Point;
	
	import mx.binding.utils.BindingUtils;
	import mx.binding.utils.ChangeWatcher;
	import mx.containers.Canvas;
	import mx.controls.Image;
	import mx.events.FlexEvent;
	
	import vo.CommentVO;
	
	public class MarkingBoxView extends Canvas
	{
		public static const SET_UP:String = 'mbv set up';
		
		private var state:String;
		
		[Bindable]
		private var VO:CommentVO;
		
		private var markingView:MarkingAreaView;
		
		private var startX:int;
		private var startY:int;
		
		private var colours:Object = {inactive:{fill:0x94b8ef,line:0x2770f6},active:{fill:0xffde00,line:0xffde00}};
		
		[Bindable]
		public var pageOffset:Point;
		
		private var boxes:MarkingBoxes;
		
		private var activeComment:Boolean = false;
		
		private var confirmed:Boolean = false;
		
		[Bindable]
		[Embed(source='/../img/cross.png')]
		private var cross:Class;
		
		[Bindable]
		[Embed(source='/../img/tick.png')]
		private var tick:Class;
		
		// storage for offset in dragging
		private var offsetX:int;
		private var offsetY:int;
		
		public function MarkingBoxView(markingView:MarkingAreaView,boxes:MarkingBoxes = null,comment:CommentVO = null)	{
			trace(this+ ' new mbv with mav '+markingView);
			this.markingView = markingView;
			this.state = this.markingView.state;
			this.boxes = boxes;
			// if a comment has been set
			if(!comment) {
				this.addEventListener(FlexEvent.CREATION_COMPLETE,this.newCommentCC);
				return;
			}
			this.VO = comment;	
			this.confirmed = true;
			this.addEventListener(FlexEvent.CREATION_COMPLETE,this.redrawComment);		
			
		}		
		private function redrawComment(e:FlexEvent):void {
			this.drawFromVO();
		}
		public function dragStart(e:MouseEvent):void {
			var local:Point = this.globalToLocal(new Point(e.stageX,e.stageY));
			this.offsetX = local.x;
			this.offsetY = local.y;
			stage.addEventListener(MouseEvent.MOUSE_MOVE,this.drag);
		}
		public function dragStop():void {
			stage.removeEventListener(MouseEvent.MOUSE_MOVE,this.drag);
		}
		private function drag(e:MouseEvent):void {
			// get the x y for mouse rel 2 parent
			var local:Point = this.parent.globalToLocal(new Point(e.stageX,e.stageY));
			this.x = local.x - this.offsetX ;
			this.y = local.y - this.offsetY ;
			e.updateAfterEvent();
		}
		/**
		 * When the box is for a new, unset comment, it needs to be bound to the new comment.
		 * 
		 * Listen to mouse moves to resize the box until mouse-up.
		 * */
		private function newCommentCC(e:Event):void {
			this.VO = new CommentVO();
			var bX:ChangeWatcher = BindingUtils.bindSetter(this.updateVO,this,"x");
			var bY:ChangeWatcher = BindingUtils.bindSetter(this.updateVO,this,"y");
			BindingUtils.bindProperty(this.VO,"width",this,"width");
			BindingUtils.bindProperty(this.VO,"height",this,"height");					
			
			// mouse moves will now resize the box		
			stage.addEventListener(MouseEvent.MOUSE_MOVE,this.resize); 
			stage.addEventListener(MouseEvent.MOUSE_UP,this.stopDrawing);
			this.startDrawing(stage.mouseX,stage.mouseY);	
		}
		private function updateVO(v:int):void {
			this.VO.x = this.x - this.pageOffset.x;
			this.VO.y = this.y - this.pageOffset.y;
		}
		/**
   		 * Draws the box. Since we use the dimensions and position to set up the box correctly,
		 * we just need to draw those dimensions
   		 * */
		private function draw():void {
			var fill:uint;
			var line:uint;
			if (this.activeComment || !this.confirmed) {
				fill = this.colours.active.fill;
				line = this.colours.active.line;
			} else {
				fill = this.colours.inactive.fill;
				line = this.colours.inactive.line;
			}
			this.graphics.moveTo(0,0);
			this.graphics.clear();
			this.graphics.lineStyle(1,line);
			this.graphics.beginFill(fill,0.2);
			this.graphics.lineTo(0,this.height);
			this.graphics.lineTo(this.width,this.height);
			this.graphics.lineTo(this.width,0);
			this.graphics.lineTo(0,0);			
		}
		/**
		 * This is bound to the user's click event by the main view
		 * */
		private function startDrawing(x:int,y:int):void {
			var local:Point = this.parent.globalToLocal(new Point(x,y));		
			// save start positions
			this.x = this.startX = local.x;
			this.y = this.startY = local.y;
		}
		/**
		 * Removes the listeners that were set up to process drawing, to finialise the box's shape
		 * and position
		 * */
		private function stopDrawing(event:MouseEvent):void {	
			// we don't need to restop, or resize it now
			stage.removeEventListener(MouseEvent.MOUSE_UP,this.stopDrawing);
			stage.removeEventListener(MouseEvent.MOUSE_MOVE,this.resize);
			// but check the box is a sensible size, not a single click, 1px area for instance
			if (this.checkSizeIsSensibleOrRemove()) {
				this.setUpBoxAsConfirmed();
				this.dispatchEvent(new CommentViewEvent(CommentViewEvent.RESTORE,this.VO));
			}  
		}
		/**
		 * @returns Boolean on good size/not
		 * */
		private function checkSizeIsSensibleOrRemove():Boolean {
			if(this.width > 5 && this.height > 5) {
				return true;
			}			
			this.close();		
			return false;	
		}		
		private function setUpBoxAsConfirmed():void {
			trace(this.VO + ' has been confirmed');
			if(this.confirmed == true) return;
			this.setUpUI();	
			// this.markingView.addEventListener(MarkingAreaEvent.CLOSE,this.closeHandler);
			this.markingView.addEventListener(MarkingAreaEvent.DONE,this.doneHandler);	
			this.dispatchEvent(new CommentViewEvent(CommentViewEvent.CONFIRMED,this.VO));
			this.confirmed = true;
		}
		
		/**
		 * Deals with events coming down informing of a focus change
		 * */
		private function focusChangeHandler(event:MarkingAreaEvent):void {
			trace('focus change handle');
			if(event.comment != this.VO) {
				this.activeComment = false;
				this.draw();
				return;
			}
			this.activeComment = true;
			this.draw();
		}		
		/**
		 * Adds user interface when added to stage 
		 * */
		 private function setUpUI():void {
		 	this.markingView.addEventListener(MarkingAreaEvent.HAS_FOCUS,this.focusChangeHandler);	
		 	this.markingView.addEventListener(MarkingAreaEvent.CLOSE,this.closeHandler);
		 	this.addEventListener(MouseEvent.CLICK,this.restore);		
		 	
		 	if(this.state == MarkingAreaView.MARKING_STATE) {
			 	var button:Image = new Image;
			 	button.addEventListener(MouseEvent.CLICK,this.closeRequest);
			 	button.useHandCursor = true;
			 	button.buttonMode = true;
			 	button.source = this.cross;
				button.visible = false;			
				this.addChild(button);
				button.x = this.width - 20 - button.width;
				button.y = button.height + 10;
				button.visible = true;	
		 	}
		 }
   		/**
   		 * Informs PM of a request to restore the focus to MarkingBox
   		 * */
   		 private function restore(event:Event = null):void {
   		 	var e:CommentViewEvent = new CommentViewEvent(CommentViewEvent.RESTORE);
   		 	e.comment = this.VO;
   		 	this.dispatchEvent(e);
   		 }
   		 /**
		 * Dispatches a CVE Close, which may cause the MAV to dispatch a MAV close event
		 * */
		private function closeRequest(e:MouseEvent):void {
			this.dispatchEvent(new CommentViewEvent(CommentViewEvent.CLOSE,this.VO));
		}
		private function closeHandler(e:MarkingAreaEvent):void {
			if(e.comment === this.VO) {
				this.close();
			}
		}
		public function close(event:Event = null):void {	
			this.markingView.removeEventListener(MarkingAreaEvent.CLOSE,this.closeHandler);
			this.markingView.removeEventListener(MarkingAreaEvent.HAS_FOCUS,this.focusChangeHandler);	
			this.markingView.removeEventListener(MarkingAreaEvent.DONE,this.doneHandler);
			this.markingView = null;
			this.boxes = null;
	 		this.parent.removeChild(this);	 	
		}
		/**
		 * Resizes the box on the mouse move, around the point at which the mouse was first 
		 * down
		 * */
		private function resize(event:MouseEvent):void {		
			var local:Point = this.parent.globalToLocal(new Point(event.stageX,event.stageY));				
			// the width/h is always going to be the distance from the starting mouse down to the current mouse pos
			this.width = this.getDiff(local.x,this.startX);
			this.height = this.getDiff(local.y,this.startY);	
			
			// if we're to the left of the start pos, we need to move the box left and let its width connect it to start pos
			if(local.x < this.startX) { 
				this.x = local.x;
			} else {
				this.x = this.startX;
			}
			// if we're above, move it up and let height connect it to start pos
			if(local.y < this.startY) {
				this.y = local.y;
			} else {
				this.y = this.startY;
			}
					
			// now we're done setting up the position, draw the object in its new position	
			this.draw();
		}
   		/**
   		 * Helper function for draw()
   		 * */
		private function getDiff(one:int,two:int):int {
			var rValue:int = one - two;         
        	return  rValue > 0 ? rValue : -rValue;
   		}	
   		/**
   		 * When user has finished comment, clicked done & comment box hides, draws restore button 
   		 * */
   		private function doneHandler(e:MarkingAreaEvent):void {
   		}
   		private function drawFromVO():void {
   			trace(this + ' now to draw with '+this.markingView);
   			this.width = this.VO.width;
   			this.height = this.VO.height;
   			this.x = this.VO.x + this.pageOffset.x;
   			this.y = this.VO.y + this.pageOffset.y;   
			this.draw();
			this.setUpUI();
			this.dispatchEvent(new Event( MarkingBoxView.SET_UP) );
   		}
	}
}