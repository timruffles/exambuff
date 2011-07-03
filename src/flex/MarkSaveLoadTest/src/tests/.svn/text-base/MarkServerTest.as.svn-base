package tests
{
	import events.MarksEvent;
	
	import flash.events.Event;
	
	import flexunit.framework.TestCase;
	import flexunit.framework.TestSuite;
	
	import models.Marks;
	
	import vo.CommentVO;
	
	public class MarkServerTest extends TestCase
	{
		
		
		public function MarkServerTest(methodName:String):void 
		{
			super(methodName);
		}
		public static function suite():TestSuite {
			var testSuite:TestSuite = new TestSuite();
			testSuite.addTest(new MarkServerTest('testAddData'));
			testSuite.addTest(new MarkServerTest('testLoadData'));
			testSuite.addTest(new MarkServerTest('testSaveAndLoad'));
			return testSuite;
		}
		public function testLoadData():void {
			var ml:Marks = new Marks()
			ml.addEventListener(MarksEvent.MARKS_LOADED,addAsync(_loadedMarks,2000,null,_error));
			ml.load(2);		
		}
		private function _loadedMarks(e:Event):void {
			var marks:Marks = Marks(e.target);
			assertNotNull('Loaded mark data',marks.generalComment);
			trace('Got general comment:'+marks.generalComment);
		}
		private function _error(e:Event = null):void {
			fail('Failed to load within 2 seconds');
		}
		private static function exampleData():Array {
			var a:Array = new Array();
			var c1:CommentVO = new CommentVO();
			c1.x = 100;
			c1.y = 125;
			c1.width = 300;
			c1.height = 400;
			c1.commentText = 'This sentance is shoddy.';
			c1.commentType = 'Style';
			var c2:CommentVO = new CommentVO();
			c2.x = 422;
			c2.y = 124;
			c2.width = 555;
			c2.height = 430;
			c2.commentText = 'This sentance is excellent. Score!';
			c2.commentType = 'Boo';
			a.push(c2);
			a.push(c1);
			return a;
		}
		public function testAddData():void {
			var m:Marks = new Marks();
			var a:Array = MarkServerTest.exampleData();
			var c:CommentVO = a[0];
			m.addComment(c,0);
			
			assertEquals('Check data added successully',m.page(0).comments[0],c);
			
			var c2:CommentVO = CommentVO(a[1]);
			m.addComment(c2,0);
			
			m.removeComment(c2,0);
			assertTrue('Check remove comment successfully by object',m.page(0).comments.length==1);
		}
		public function testSaveAndLoad():void {
			var m:Marks = new Marks();
			var a:Array = MarkServerTest.exampleData();
			var c:CommentVO = a[0];
			var c2:CommentVO = a[1];
			
			m.addComment(c,0);
			m.addComment(c2,1);
			m.classification = '1';
			m.generalComment = 'Excellent sniffy!';
			m.script = 5;
			m.addEventListener(MarksEvent.MARKS_SAVED,addAsync(_checkSave,2000,null,_saveFailed));
			m.save();
			
		}
		private function _saveFailed():void {
			fail('Failed to save');
		}
		private function _checkSave(me:MarksEvent):void {
			var m:Marks = Marks(me.target);
			assertTrue('Check data saved successfully');
			
		}

	}
}