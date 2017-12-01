<?php
/*
	ABUSEIPDB IP CHECK
	Ver	: 1.1
	Author	: Barret
	Date	: 2017/5
	
	This script is not part of nor made by abuseipdb.com
*/

// Your AbuseIPdb.com API key (register at website to get one)
$key		= "<your api key>";

// Url to redirect user if any reports are present
$redirect 	= "http://www.google.com";

// Fetch report count with given parameters and take action if condition is met
if (abuseipdb_check($key,$_SERVER['REMOTE_ADDR'],30) > 0) { header("Location: $redirect"); }

function abuseipdb_check($key,$target,$days) {
	return count(json_decode(abuseipdb_geturl("https://www.abuseipdb.com/check/$target/json?key=$key&days=$days"),true));
}

function abuseipdb_geturl($url, $useragent='PHP/CURL', $headers=false, $follow_redirects=true, $debug=false) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	if ($headers==true){ curl_setopt($ch, CURLOPT_HEADER,1); }
    if ($headers=='headers only') { curl_setopt($ch, CURLOPT_NOBODY ,1); }
    if ($follow_redirects==true) { curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); }
    if ($debug==true) {
        $result['contents']=curl_exec($ch);
        $result['info']=curl_getinfo($ch);
    }
    else $result=curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
