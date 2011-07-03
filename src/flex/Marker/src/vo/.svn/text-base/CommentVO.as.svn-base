package vo {
	// set all the props here to be bindable so this can be informed by the views that represent it
	[Bindable]	
	/**
	 * the data required for the marking boxes to be displayed, along with the comment text and type
	 * */
	public class CommentVO {
		public var x:int;
		public var y:int;
		public var width:int;
		public var height:int;		
		public var specComments:SpecificComments = new SpecificComments();
		public var spg:String;
		public function empty():Boolean {
			return this.specComments.empty();
		}
	}
}