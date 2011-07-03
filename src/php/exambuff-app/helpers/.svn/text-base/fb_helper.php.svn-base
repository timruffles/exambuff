<?php 
function fbProfilePic($UID) {
	$CI =& get_instance();
	if($url = $CI->session->userdata('fbProfilePic')) return $url;
	$CI->load->library('facebook');
	if($resArray = $CI->facebook->api_client->users_getInfo($UID, array('pic_square'))) {
		$url = $resArray[0]['pic_square'];
		$CI->session->set_userdata('fbProfilePic',$url);
		return $url;
	}
	return false;
}
function fbName($UID) {
	$CI =& get_instance();
	if($name = $CI->session->userdata('fbName')) return $name;
	$CI->load->library('facebook');
	if($resArray = $CI->facebook->api_client->users_getStandardInfo($UID, array('first_name','last_name'))) {
		$name = $resArray[0]['first_name'].' '.$resArray[0]['last_name'];
		$CI->session->set_userdata('fbName',$name);
		return $name;
	}
	return false;
}