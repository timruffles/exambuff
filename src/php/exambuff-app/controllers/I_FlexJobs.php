<?php
require_once('../exambuff/controllers/I_FlexIO.php');
/**
 * Interface used by Flex for adding and retrieving Jobs (scripts to load & mark).
 */
interface I_FlexJobs extends I_FlexIO {
	
	const NOT_AVAILABLE = 'NOT_AVAILABLE';
	const MARKER_ACCEPTED = 'MARKER_ACCEPTED';
	const MARKER_HAS_JOB = 'MARKER_HAS_JOB';
	
	function takeJob();
	function jobList();
}