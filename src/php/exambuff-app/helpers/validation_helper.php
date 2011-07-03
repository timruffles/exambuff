<?php
function alphaAndWhiteSpace($str) {
	if(!preg_match("/^([-a-z\._-\s])+$/i", $str)) {
		return false;
	}
	return true;
}
function alphaAndWhiteSpaceQuestion($str) {
	if(!preg_match("/^([-a-z?\._-\s])+$/i", $str)) {
		return false;
	}
	return true;
}
function alphaNumAndWhiteSpace($str) {
	if(!preg_match("/^([-a-z0-9?\._-\s])+$/i", $str)) {
		return false;
	}
	return true;
}
/*
 * Returns true if only contains address characters - letters, spaces, numbers and '.' (for Rd. etc)
 */
function address($str) {
	if(!preg_match("/^([-a-z0-9\.?\._-\s])+$/i", $str)) {
		return false;
	}
	return true;
}
function validCardType($str) {
	$validTypes = array('AmEx'=>'AmEx','CarteBlanche'=>'CarteBlanche','DinersClub'=>'DinersClub','Discover'=>'Discover','enRoute'=>'enRoute','JCB'=>'JCB','Maestro'=>'Maestro','MasterCard'=>'MasterCard','Solo'=>'Solo','Switch'=>'Switch','Visa'=>'Visa','VisaElectron'=>'VisaElectron');
	if(in_array($str,$validTypes)) {
		return true;
	}
	return false;
}
function fail($str) {
	return false;
}