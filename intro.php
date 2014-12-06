<?php
require_once "./constant.php";

// Application constant
define ( 'SKIN_PATH', 'skins/user/' );
define ( "LANG_PATH", ROOT_PATH . 'langs/user/' );
define ( 'APPLICATION_TYPE', 'user' );

require_once LIBS_PATH . "Debug.class.php";
require_once LIBS_PATH . "Info.class.php";

session_start ();

// Initialize configuration
global $INFO;
$INFO = array ();
require ROOT_PATH . "conf_global.php";
// Starting debug
$Debug = new Debug ();
$Debug->startTimer ();

require_once LIBS_PATH . 'Factory.class.php';
require_once LIBS_PATH . 'plugin.php';
require_once LIBS_PATH . 'boards/Control.board.php';
// Connection Database

$DB = VSFactory::createConnectionDB ();
$DB->obj ['debug'] = ($INFO ['sql_debug'] == 1) ? $_GET ['debug'] : 0;
// --------------------------------
// Make CONSTANT
// --------------------------------

$bw = new infos ();
require_once LIBS_PATH . "Component.class.php";

require_once LIBS_PATH . "Functions.class.php";
require_once LIBS_PATH . "Session.class.php";
$vsStd = new VSFFunction ();

// $vsLang = VSFactory::getLangs();

require_once LIBS_PATH . "Object.class.php";
require_once LIBS_PATH . "boards/BasicObject.board.php";

require_once LIBS_PATH . "Skin.class.php";
require_once LIBS_PATH . "VSTemplate.class.php";
require_once LIBS_PATH . "Display.class.php";

require_once LIBS_PATH . "Path.class.php";

$vsStd->requireFile ( LIBS_PATH . "boards/Control.board.php" );
$vsStd->requireFile ( LIBS_PATH . "boards/skins/skins_board.php" );

require_once LIBS_PATH . 'boards/skins/skin_board_public.php';
require_once LIBS_PATH . 'boards/skins/skin_board_public.php';
require_once LIBS_PATH . 'boards/Control_public.board.php';
$vsStd->requireFile ( CORE_PATH . "users/users.php" );
$vsUser = VSFactory::getUsers ();
// Starting session
$vsSess = new VSFSession ();

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>



<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


<title>Under Construction</title>
<style type="text/css">
<!--
.style5 {
	color: #FF0000
}

body {
	margin: 0;
	padding: 0;
}

#main_contents {
	background: url("images/top.png") no-repeat scroll 0 0,
		url("images/bottom.png") no-repeat scroll right bottom;
	display: block;
	height: 640px;
}
#main_contents {
	
	display: block;
	height: 640px;
}
.contents{
	display: block;
    height: 640px;
    margin: 0 auto;
    position: relative;
    width: 1000px;
}
.main {
	background: url("images/main.jpg") no-repeat scroll 0 0;
	display: block;
	height: 625px;
}
.logo{position: absolute;top:40%;}
.js-fix {
	position: absolute;
	top: 50%;left:50%;
}
-->
</style>
<script type="text/javascript"
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
$("body div.main").each(function(){
	  //get height and width (unitless) and divide by 2
	  var hWide = ($(this).width())/2; //half the image's width
	  var hTall = ($(this).height())/2; //half the image's height, etc.
	  // attach negative and pixel for CSS rule
	  hWide = '-' + hWide + 'px';
	  hTall = '-' + hTall + 'px';
		
	  $(this).addClass("js-fix").css({
		  "margin-left" : hWide,
		    "margin-top" : hTall
	  });
	});	});
</script>
</head>
<body>
	<div class="main"
		style="width: 100%; margin: 0 auto; text-align: center">
		<div id="main_content">
			<div class="content">
			</div>
		</div>
	</div>
</body>
</html>