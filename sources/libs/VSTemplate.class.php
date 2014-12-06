<?php

class VSTemplate {
	
	
	# The basics
    var $root_path   = './';
    var $cache_dir   = '';
    var $cache_id    = '1';
    var $database_id = '1';
    var $rebuilcache = '0';
    var $cache_path  = '';
    var $arrayTemplate= array();
    var $skin_path  = '';
    var $extends  = '';
    var $foreach_blocks = array();
    var $allow_php_code = 1;
    /**
     * 
     * @var VSFTemplateEngine
     */
	var $engine=null;
	/**
	 * @return VSFTemplate
	 */
	public function getEngine() {
		if( $this->engine===NULL){
			require_once UTILS_PATH . "TemplateEngine.class.php";
			$this->engine=new VSFTemplateEngine();
		}
		return $this->engine;
	}
	function __construct($tem_folder,$rebuild=1){
		$this->skin_path = $this->root_path . $tem_folder;
        $this->cache_path = $this->root_path."cache/".$tem_folder;
        if($rebuild){
        	$this->buildAllCache($this->skin_path,$this->cache_path);
        }
	}
	/**
	 * return a object skin object
	 */
	function load_template($class_name,$subfolder=""){
		if(class_exists($class_name)){
			return new $class_name();
			
		}else{
			$subfolder=rtrim($subfolder,"/")."/";
			if(file_exists($this->cache_path."/".$subfolder.$class_name.".php")){
				require $this->cache_path."/".$subfolder.$class_name.".php";
				return new $class_name();
			}else{
				 die($this->cache_path."/".$subfolder.$class_name.".php not exist!" );
			}
			
		
		}
	}
	function buildAllCache($foldersource,$folderdest){
		$folderdest=rtrim($folderdest,"/")."/";
		$logfile=CACHE_PATH."skins/".APPLICATION_TYPE."/log.php";
		if(!is_dir($folderdest)){
			mkdir($folderdest,0777,true);
		}
		if(file_exists($logfile)){
			require $logfile;
			
		}
		is_array($skinslog)?'':$skinslog=array();
		$write=false;
		$foldersource=rtrim($foldersource,"/")."/";
		$files = glob($foldersource . "/skin_*.php");
		foreach($files as $file)
		{
			$filename= basename($file) ;
			$modify=false;
			if(!file_exists($folderdest.$filename)){
				$modify=true;
			}else{
				if(filemtime ($foldersource.$filename)!=$skinslog['filemtime'][$foldersource.$filename]){//good for window
					//echo filemtime  ($foldersource.$filename).":".filemtime ($folderdest.$filename)."<br>";
//					echo 'filemtime<br>';
					$skinslog['filemtime'][$foldersource.$filename]=filemtime ($foldersource.$filename);
					$write=true;
						$modify=true;
				}
				if(getlastmod ($foldersource.$filename)!=$skinslog['getlastmod'][$foldersource.$filename]){//good for window
//					echo 'getlastmod<br>';
//					echo getlastmod ($foldersource.$filename).":".$skinslog['getlastmod'][$foldersource.$filename]."<br>";
					
					$skinslog['getlastmod'][$foldersource.$filename]=getlastmod ($foldersource.$filename);
					$write=true;
						$modify=true;
				}
				if(filectime ($foldersource.$filename)!=$skinslog['filectime'][$foldersource.$filename]){//good for window
//					echo 'filectime<br>';
					$skinslog['filectime'][$foldersource.$filename]=filectime ($foldersource.$filename);
					$write=true;
					$modify=true;
				}
			}
			if($modify){
				
				$fp = fopen($folderdest.$filename, 'w');
				$parse=$this->getEngine()->load_template(basename($file,".php"),file_get_contents($foldersource.$filename),$folderdest);
				$parse="<?php\n".$parse."\n?>";
				fwrite($fp,$parse );
				fclose($fp);
				$changed[]=$filename;
				
			}
		}
		if($write){
				$fp = fopen($logfile, 'w');
				$parse=var_export($skinslog,true);
				$parse="<?php\n\$skinslog=".$parse."\n?>";
				fwrite($fp,$parse );
				fclose($fp);
				if($changed){
					$changed=implode(",", $changed);
					//if($_SERVER["REMOTE_ADDR"]=='127.0.0.1'&&!$bw->input['ajax']){
					global $bw;
					/*if(!$bw->input['ajax']){
						echo "<div style='background: none repeat scroll 0 0 #FF5555;bottom: 0;height: 22px;position: fixed;z-index: 100;'>
						$changed  changed!
						</div>";
					}	*/
				}
		}
		chmod($folderdest,750);
	}
	/**
	 * 
	 * Enter description here ...
	 * @return skin_global
	 */
	function getGlobal(){
		if(!is_object($this->global_skin)){
			$this->global_skin=$this->load_template("skin_global");
		}
		return $this->global_skin;
	}
}

?>