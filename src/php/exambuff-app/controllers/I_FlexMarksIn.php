<?php
require_once('../exambuff/controllers/I_FlexIO.php');
/**
 * Interface used by Flex for adding and retrieving Mark data.
 */
interface I_FlexMarksIn extends I_FlexIO  {
	
	const SAVE_SUCCESSFUL = 'SAVE_SUCCESSFUL';
	
	/**
	 * Saves a Mark to DB.
	 *
	 */
	function addMark();
}