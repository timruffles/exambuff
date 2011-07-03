package vo
{
	[Bindable]
	public class Target
	{
		public static const STYLE:String = 'STYLE';
		public static const ARGUMENT:String = 'ARGUMENT';
		public static const INTRO_CON:String = 'INTRO';
		public static const EVIDENCE:String = 'EVIDENCE';
		public static const PLANNING:String = 'PLANNING';
		private var _text:String;
		private var _type:String;
		public function Target(type:String,text:String):void {
			if(type !== Target.STYLE &&
			   type !== Target.ARGUMENT &&
			   type !== Target.INTRO_CON &&
			   type !== Target.EVIDENCE &&
			   type !== Target.PLANNING) throw new Error('Must choose a valid type');
			this._text = text;
			this._type = type;
				
		}
		public function get text():String {
			return this._text;
		}
		public function get type():String {
			return this._type;
		}
	}
}