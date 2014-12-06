<?php
$gmdate_mod = gmdate("D, d M Y H:i:s", 1324429674);
if (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"])) {
					            // check for updates
					            $if_modified_since = preg_replace ("/;.*$/", "", $_SERVER["HTTP_IF_MODIFIED_SINCE"]);
					           
					            if ($if_modified_since == $gmdate_mod) {
					            	header ('Cache-Control:max-age=31449600, must-revalidat');
					                header("HTTP/1.1 304 Not Modified");
					                exit;
					                die();
					            }
					        }
							clearstatcache();

$array=find();
foreach ($array as $value) {
	
	$info=pathinfo($value);
//	echo "<pre>";
//	print_r($info);
//	echo "</pre>";
//	exit;
	$extension=strtolower( $info['extension']);
	if($extension=='otf'||$extension=='ttf'){
		if(!file_exists($info['filename'].".eot")){
			exec("./exe/ttf2eot <{$info['basename']}> {$info['filename']}.eot");
			//echo "./exe/ttf2eot <{$info['basename']}> {$info['filename']}.eot<br>";
			@chmod("{$info['basename']}.eot ", 0644);
		}
		if(!file_exists($info['filename'].".woff")){
			exec("./exe/sfnt2woff {$info['basename']} ");
			if(file_exists("{$info['basename']}.woff")){
				rename("{$info['basename']}.woff", $info['filename'].".woff");
			}
			@chmod($info['filename'].".woff", 0644);
		}
	}
	echo 
"
@font-face {
  font-family: {$info['filename']}; 
  src: url('./{$info['basename']}');				
}
";
	
	
	
}
					        header ('Accept-Ranges: bytes');
					        header ('Last-Modified: ' . $gmdate_mod);
					        //header ('Content-Length: ' . $fileSize);
					        $expires = 60*60*24*14;
					        header ("Cache-Control:max-age=$expires, must-revalidat");
					        header("Pragma: public");
					        header ('Expires: ' . $gmdate_mod);

header("Content-type: text/css");


function find($direct='./'){
		$files = array();
			if ($dir = opendir($direct)) {
				
				while (false !== ($file = readdir($dir))) {
					if ($file != "." && $file != ".."&&$file!='.svn'&&$file!='index.php'&&!$file!='exe') {
						if(is_dir($file)){
							//$images=array_merge($images,$this->find($file,$pattern,$file."/"));
						}else{
							//if(preg_match($pattern,$file)){
								$files[] = $file;
							//}
						}
					}
				}
				closedir($dir);
			}
	    return $files;
}