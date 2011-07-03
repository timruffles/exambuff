package helper
{
    import flash.display.Stage;
    import flash.events.Event;
    import flash.events.KeyboardEvent;
    
    /**
     * The Key class recreates functionality of
     * Key.isDown of ActionScript 1 and 2. Before using
     * Key.isDown, you first need to initialize the
     * Key class with a reference to the stage using
     * its Key.initialize() method. For key
     * codes use the flash.ui.Keyboard class.
     *
     * Usage:
     * Key.initialize(stage);
     * if (Key.isDown(Keyboard.LEFT)) {
     *    // Left key is being pressed
     * }
     */
    public class Key {
        
        private static var initialized:Boolean = false;  // marks whether or not the class has been initialized
        private static var keysDown:Object = new Object();  // stores key codes of all keys pressed
        
        /**
         * Initializes the key class creating assigning event
         * handlers to capture necessary key events from the stage
         */
        public static function initialize(stage:Stage) {
            if (!initialized) {
                // assign listeners for key presses and deactivation of the player
                stage.addEventListener(KeyboardEvent.KEY_DOWN, keyPressed);
                stage.addEventListener(KeyboardEvent.KEY_UP, keyReleased);
                stage.addEventListener(Event.DEACTIVATE, clearKeys);
                
                // mark initialization as true so redundant
                // calls do not reassign the event handlers
                initialized = true;
            }
        }
        
        /**
         * Returns true or false if the key represented by the
         * keyCode passed is being pressed
         */
        public static function isDown(keyCode:uint):Boolean {
            if (!initialized) {
                // throw an error if isDown is used
                // prior to Key class initialization
                throw new Error("Key class has yet been initialized.");
            }
            return Boolean(keyCode in keysDown);
        }
        
        /**
         * Event handler for capturing keys being pressed
         */
        private static function keyPressed(event:KeyboardEvent):void {
            // create a property in keysDown with the name of the keyCode
            keysDown[event.keyCode] = true;
        }
        
        /**
         * Event handler for capturing keys being released
         */
        private static function keyReleased(event:KeyboardEvent):void {
            if (event.keyCode in keysDown) {
                // delete the property in keysDown if it exists
                delete keysDown[event.keyCode];
            }
        }
        
        /**
         * Event handler for Flash Player deactivation
         */
        private static function clearKeys(event:Event):void {
            // clear all keys in keysDown since the player cannot
            // detect keys being pressed or released when not focused
            keysDown = new Object();
        }
    }
}