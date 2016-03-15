<?php
session_start();
$configfile="";
if(isset($_GET['c'])){
	if(file_exists("./config/".$_GET['c'].".php")){
		$configfile=$_GET['c'];
	}
}
if($configfile){
	require "./config/".$_GET['c'].".php";
}else{
	require "./config/default.php";
}
/**********captcha***************/
$length = 3;
$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVW XYZ';
$charslength = strlen($chars);
$randomstring = '';
for ($i = 0; $i < $length; $i++) $randomstring .= substr($chars, rand(0, $charslength - 1), 1);
$number = rand(100, 999);
$captcha = $number . $randomstring;
$captcha = str_shuffle($captcha);
$_SESSION['vscaptcha_vscaptcaha']=$captcha;
/*******************************************/

$handle = ImageCreate ($config['width'], $config['height']) or die ("Cannot Create image");
$bgC=hex2RGB($config['bg_color']);
$bg_color = ImageColorAllocate ($handle, $bgC['red'], $bgC['green'], $bgC['blue']);
$fC=hex2RGB($config['font_color']);
$txt_color = ImageColorAllocate ($handle, $fC['red'], $fC['green'], $fC['blue']);
ImageString ($handle, $config['font_size'], 8, 5, "$captcha", $txt_color);
header ("Content-type: image/png");
ImagePng ($handle);

function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}