package vo
{
	import flash.display.SpreadMethod;
	
	[Bindable]
	public class SpecificComments {
		public var introConc:String;
		public var argument:String;
		public var evidence:String;
		public var style:String;
		public var planning:String;
		internal function empty():Boolean {
			
			if (this.introConc == null &&
				 this.argument == null && 
				 this.evidence == null && 
				 this.style == null && 
				 this.planning == null) trace('empty cdalled');
			if (this.introConc == null &&
				 this.argument == null && 
				 this.evidence == null && 
				 this.style == null && 
				 this.planning == null) return true;
			return false;
		}
		public function clone():SpecificComments {
			var s:SpecificComments = new SpecificComments();
			s.introConc = this.introConc;
			s.argument = this.argument;
			s.evidence = this.evidence;
			s.style = this.style;
			s.planning = this.planning;
			return s;
		}
		public static function fromJSON(o:Object):SpecificComments {
			var s:SpecificComments = new SpecificComments();
			s.introConc = o.introConc;
			s.argument = o.argument;
			s.evidence = o.evidence;
			s.style = o.style;
			s.planning = o.planning;
			return s;
		}
	}
}