<?php
class Passwords extends Controller {
	function index() {
		$this->load->model('marker');
		$randomWords = array('africa','animals','architecture','art','australia','autumn','baby','band','barcelona','beach','berlin','bird','birthday','black','blackandwhite','blue','boston','bw','california','cameraphone','camping','canada','canon','car','cat','chicago','china','christmas','church','city','clouds','color','concert','cute','dance','day','de','dog','england','europe','fall','family','festival','film','florida','flower','flowers','food','football','france','friends','fun','garden','germany','graffiti','green','halloween','hawaii','hiking','holiday','home','house','india','ireland','island','italia','italy','japan','july','kids','la','lake','landscape','light','live','london','macro','may','me','mexico','mountain','mountains','museum','music','nature','new','newyork','newyorkcity','night','nikon','nyc','ocean','old','paris','park','party','people','photo','photography','photos','portrait','red','river','rock','rome','san','sanfrancisco','scotland','sea','seattle','show','sky','snow','spain','spring','street','summer','sun','sunset','taiwan','texas','thailand','tokyo','toronto','tour','travel','tree','trees','trip','uk','urban','usa','vacation','vancouver','washington','water','wedding','white','winter','yellow','york','zoo');  
		$emails = array('U.Wolski@rhul.ac.uk',	'E.Ulus@rhul.ac.uk'	,'maarit.lassander@yahoo.co.uk');
		for($i= 0;$i<count($emails);$i++) {
			$word1 =$randomWords[rand(0,count($randomWords))];
			$leetI = str_replace('i','1',$word1);
			$leetE = str_replace('e','3',$leetI);
			$word2 =  ucfirst($randomWords[rand(0,count($randomWords)-1)]);
			$hashed = md5($word2);
			$randSeed = substr($hashed,rand(0,strlen($hashed)-1),2);
			$pass = $leetE.$randSeed;
			$marker = new Marker();
			$marker->set('email',$emails[$i]);
			$marker->set('password',$marker->makePass($pass));
			$marker->create();
			echo 'marker email '.$emails[$i].' with pass '.$pass.'</br>';
			echo 'pass check '.$marker->checkPass($pass).'</br>'.'</br>';
		}
	}
}
