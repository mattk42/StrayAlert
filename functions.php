<?php

#this function returns an array containing lat and lng based off of an address
function geoloc($address){
	$uadd=urlencode($address);
	$link="http://maps.googleapis.com/maps/api/geocode/json?address=$uadd&sensor=false";
	$json=file_get_contents($link);
	$array=json_decode($json,true);
	$res=array($array['results'][0]['geometry']['location']['lat'],$array['results'][0]['geometry']['location']['lng']);
	return $res;
}

?>
