<?php
/*--------------------------------------------------*/
/* FILE GENERATED BY INVISION POWER BOARD           */
/* CACHE FILE: Skin set id: 2                     */
/* CACHE FILE: Generated: Wed, 28 Jul 2004 10:38:07 GMT */
/* DO NOT EDIT DIRECTLY - THE CHANGES WILL NOT BE   */
/* WRITTEN TO THE DATABASE AUTOMATICALLY            */
/*--------------------------------------------------*/

class skin_global extends skin_board_public{
	//===========================================================================
	// vs_global
	//===========================================================================
	// {$this->SITE_MAIN_CONTENT}
	//
	function vs_global(){
		global $bw, $vsLang,$vsPrint;
		$vsLang = VSFactory::getLangs();
		$this->vsLang = VSFactory::getLangs();
		
		$this->car=Object::getObjModule("pages","car",">0");
		ksort($this->car);
		
		
		
		
		
		$fb = VSFactory::getSettings ()->getSystemKey ( "facebook", "https://www.facebook.com/", "configs" );	
		$google = VSFactory::getSettings ()->getSystemKey ( "googleplus", "http://google.com.vn/", "configs" );
		$tw = VSFactory::getSettings ()->getSystemKey ( "twitter", "http://twitter.com/", "configs" );
		$pinterest = VSFactory::getSettings ()->getSystemKey ( "pinterest", "https://www.pinterest.com/", "configs" );
		$youtube = VSFactory::getSettings ()->getSystemKey ( "youtube", "https://www.youtube.com/", "configs" );	
		$slogan = VSFactory::getSettings ()->getSystemKey ( "slogan", "Slogan here", "configs" );
		$like_Fanpage = VSFactory::getSettings ()->getSystemKey ( "like_Fanpage", "https://www.facebook.com/FacebookDevelopers", "configs" );
		$hotline = VSFactory::getSettings ()->getSystemKey ( "hotline", "0933 340 436", "configs" );
		
		
		$hotline = VSFactory::getSettings ()->getSystemKey ( "email_admin", "vuongnguyen0712@gmail.com", "configs" );
		


		$BWHTML .= <<<EOF
		
<header class="navbar navbar-inverse navbar-fixed-top wet-asphalt">
        <div class="container" style="background: linear-gradient(to right, rgb(255, 255, 255) 5%, rgb(52, 73, 94)) repeat scroll 0% 0% transparent;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand logo" href="{$bw->base_url}"><img src="{$bw->vars['img_url']}/logo.png" alt="logo"></a>
            </div>
            
            {$this->getAddon()->getMenuTop()}
            
        </div>
    </header><!--/header-->

    
    
    
    {$this->SITE_MAIN_CONTENT} 
    
    
    

    {$this->getAddon()->getContact()}

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                  {$this->vsLang->getWords("coppyright","  &copy; 2013 Weicovina. All Rights Reserved.")}
                </div>
                <div class="col-sm-6">
                    
					{$this->getAddon()->getMenuBottom()}
					
                </div>
            </div>
        </div>
    </footer><!--/#footer-->
    
    
    
    
    
    
    
EOF;
	return $BWHTML;
	}
	
	
	
	
	
	
	function getSiteBar($option=null){
		global $bw,$vsLang,$vsMenu,$vsSettings,$urlcate,$vsExperts,$vsTemplate;
		$BWHTML .= <<<EOF
EOF;
						
		return $BWHTML;
	}
	
	function addCSS($cssUrl="", $media = "") {
		$media = $media?"media='$media'":'';
		$BWHTML .= <<<EOF
<link type="text/css" rel="stylesheet" href="{$cssUrl}.css"  $media/>
EOF;
		//--endhtml--//
		return $BWHTML;
	}
	
	function importantAjaxCallBack(){
		global $bw,$vsLang;
		$BWHTML .= <<<EOF
EOF;
		return $BWHTML;
	}

	function addJavaScriptFile($file="",$type='file') {
		global $bw;
		$BWHTML .= <<<EOF
    <if="$type=='cur_file'">
		<script type="text/javascript" src='{$bw->vars['cur_scripts']}/{$file}.js'></script>
		<else />
		<if="$type=='external'">
			<script type="text/javascript" src='{$file}'></script>
			<else />
			<if="$type=='file'">
				<script type="text/javascript" src='{$bw->vars['board_url']}/javascripts/{$file}.js'></script>
			</if>
		</if>
	</if>
	
EOF;
		return $BWHTML;
	}

	function addJavaScript($script="") {
		$BWHTML = "";
		$BWHTML .= <<<EOF
<script language="javascript" type="text/javascript">
		{$script}
</script>
EOF;
		return $BWHTML;
	}

	function addDropDownScript($id="") {
		$BWHTML = "";
		//--starthtml--//

		$BWHTML .= <<<EOF
ddsmoothmenu.init({
	mainmenuid: "{$id}", //Menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menus outer DIV
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup", //"markup" or ["container_id", "path_to_menu_file"]
})
EOF;

		//--endhtml--//
		return $BWHTML;
	}

	function PermissionDenied($error="") {
		$BWHTML .= <<<EOF
<div class="red">
		{$error}</div>
EOF;
		return $BWHTML;
	}

	function displayFatalError($message="",$line="",$file="", $trace="") {
		$BWHTML .= <<<EOF
<div class="vs-common">
	<div class="red" align="left" style="padding: 20px">
		Error: {$message}<br />
		Line: {$line}<br />
		File: {$file}<br />
		Trace: <pre>{$trace}</pre><br />
	</div>
</div>
EOF;
		return $BWHTML;
	}
	function global_main_title() {
		global $bw, $vsPrint;
		$BWHTML = "";
		//--starthtml--//
		$BWHTML .= <<<EOF
	<span class="{$bw->input['module']}">{$vsPrint->mainTitle}</span>
EOF;

		//--endhtml--//
		return $BWHTML;
	}
	
	//===========================================================================
	// pop_up_window
	//===========================================================================
	function pop_up_window($title="",$css="",$text="") {
		$IPBHTML = "";
		//--starthtml--//


		$IPBHTML .= <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
 <head> 
  <meta http-equiv="content-type" content="text/html; utf-8" /> 
  <title>$title</title>
  $css
 </head>
 <body>
 <div style='text-align:left'>
 $text
 </div>
 </body>
</html>
EOF;

 //--endhtml--//
 return $IPBHTML;
	}

	//===========================================================================
	// Redirect
	//===========================================================================
	function Redirect($Text="",$Url="",$css="") {
		global $bw;
		$BWHTML = "";
		$BWHTML .= <<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html40/loose.dtd">
<html>
	<head>
	<title>Redirecting...</title>
	<meta http-equiv='refresh' content='2; url=$Url' />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$css
	<style type="text/css">
		.title
		{
			color:red;
		}
		.text
		{
			padding:10px;
			color:#009F3C;
		}
	</style>
	</head>
  	<body >
		<center>
		<table style="background-color:#6ac3cb" cellpadding="0" cellspacing="0" width="100%" height="100%"> 
			<tr>
				<td width="416px" align="center" valign="middle" style="background:url({$bw->vars ['board_url']}/styles/redirect/direct.jpg) no-repeat center  top;" height="432px">
						<br/><br/><br/><br/>
					<img src="{$bw->vars ['board_url']}/styles/redirect/turtle.gif">
					<br/><br/>
					<p class="text">{$Text}</p>
				    <a href='$Url' title="{$Url}" class="title">( Click here if you do not wish to wait )</a>
				 </td>
			</tr>  
		</table> 
		</center>
	</body>
</html>
EOF;

	//--endhtml--//
	return $BWHTML;
	}

}

?>