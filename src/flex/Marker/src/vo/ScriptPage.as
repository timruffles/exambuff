package vo
{
	/**
	 * Script page holds the marking data for each page:
	 * marking boxes & image manipulations.
	 * */
	public class ScriptPage
	{
		[Bindable]
		public var comments:Array = new Array();
		public var rotation:int = 0;
		public function ScriptPage() {
		}
		public function addJSONComment(jsonComment:Object):void {
			var comt:CommentVO = new CommentVO();
			comt.spg = jsonComment.spg;
			comt.specComments = SpecificComments.fromJSON(jsonComment.specComments);
			comt.x = jsonComment.x;
			comt.y = jsonComment.y;
			comt.height = jsonComment.height;
			comt.width = jsonComment.width;
			//trace('added JSON comment:'+comt.x+comt.height);
			this.comments.push(comt);
		}
		public function addComment(comment:CommentVO):void {
			this.comments.push(comment);
		}
		public function removeComment(comment:CommentVO):void {
			var pageNum:int = this.comments.indexOf(comment);
			this.comments.splice(pageNum,1);
		}
		public function rotateRight():void {
			this.rotation += 90;
		}
		public function rotateLeft():void {
			this.rotation -= 90;
		}	
	}
}