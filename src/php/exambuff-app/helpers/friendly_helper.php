<?php
/**
 * Produces a more vernacular version of the date: less than an hour ago, a day ago, two days ago etc
 * @return unknown_type
 */
function friendly_date($timeStamp) {
	$friendlyTimes = array('less than a minute ago',
							'less than ten minutes ago',
							'less than half an hour ago',
							'less than an hour ago',
							'a few hours ago');
	$time = time();
	$elapsed = time() - $timeStamp;
	switch(TRUE) {
		case ($elapsed < 60):
			return $friendlyTimes[0];
		break;
		case $elapsed < 600:
			return $friendlyTimes[1];
		break;
		case $elapsed < 1800:
			return $friendlyTimes[2];
		break;
		case $elapsed < 3600:
			return $friendlyTimes[3];
		break;
		case $elapsed < 10800:
			return $friendlyTimes[4];
		break;
	}
	$friendlyDays = array('earlier today','yesterday','day before yesterday');
	$days = date('j',$time) - date('j', $timeStamp);
	switch (TRUE) {
		case $days < 1:
			return $friendlyDays[0];
		break;
		case $days < 2:
			return $friendlyDays[1];
		break;
		case $days < 3:
			return $friendlyDays[2];
		break;
	}
	// Mon 14th Feb
	$giveUp = date('D jS M',$timeStamp);
	return $giveUp;
}