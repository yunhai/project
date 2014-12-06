<?php
$allow_plugin=array("cache"=>1,"timthumb"=>1);
$directory = ROOT_PATH."plugins/";
$files = glob($directory . "*.php");
$vsPlugins=array();
foreach($files as $file)
{
	if($allow_plugin[ basename($file,".php")]){
		$vsPlugins[]=basename($file,".php");
		require_once $file;
	}
}
function call_plugin($function="",$param=array()){
	global $vsPlugins;
		foreach ($vsPlugins as $p_name) {
			//echo $p_name."_".$function."\n";
			if(function_exists($p_name."_".$function)){
				call_user_func_array($p_name."_".$function,$param) ;
			}
			
		}
}