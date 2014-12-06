<?php
/*
+-----------------------------------------------------------------------------
|   VS FRAMEWORK 3.0.0
|	Author: BabyWolf
|	Homepage: http://vietsol.net
|	If you use this code, please don't delete these comment line!
|	Start Date: 21/09/2004
|	Finish Date: 22/09/2004
|	Version 2.0.0 Start Date: 07/02/2007
|	Version 3.0.0 Start Date: 03/29/2009
+-----------------------------------------------------------------------------
*/
//if(strpos($_SERVER['HTTP_ACCEPT'],'image/' )!==FALSE){
//		echo "no request type";exit;
//}
// Get system constant
if($maxcpu=intval(getenv('MAX_CPU'))>0){
	$over= @file_get_contents("/proc/loadavg");
	$over=explode(" ", $over);
	$percent=@floatval($over[0]);
	if($percent>$maxcpu){
		//echo $percent;
		echo "<h1>Server quá tải quý khách vui lòng quay lại sau!</h1>";
		exit;
	}
}

require_once "./constant.php";


// Application constant
define ( 'SKIN_PATH', 'skins/user/' );
define ( "LANG_PATH"	, ROOT_PATH . 'langs/user/' );
define ( 'APPLICATION_TYPE', 'user' );

require_once LIBS_PATH."Debug.class.php";
require_once LIBS_PATH."Info.class.php";
require_once ROOT_PATH."Main.php";

?>