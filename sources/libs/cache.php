<?php

class cache {
	private $cachePath="";
	function __construct(){
		$this->cachePath=CACHE_PATH."var_cache/";
	}
	function write_cache($group,$file,$array=array()){
		if(APPLICATION_TYPE=='admin'){
			return true;
		}
		$cache_path=$this->cachePath.$group."/";
		$content = "<?php\n";
			$content .= "\$arrayvalue = ";
			$content .= 'unserialize('.var_export(serialize($array), true).')';
			$content .= ";\n";
			
		$content .= "?>";
		if(!is_dir($cache_path)){
			mkdir($cache_path,0775,true);
		}
		if(file_exists($cache_path.$file)){
			@chmod ( $cache_path.$file, 0777 );
			if(!is_writeable($cache_path.$file)){
				echo $cache_path.$file." not writeable!";exit;
			}
		}
		$wf = fopen ($cache_path.$file, "w" );
		fwrite ( $wf, $content );
		fclose ( $wf );
		@chmod ( $cache_path.$file, 0644 );
	}
	private $cacheresult=array();
	function read_cache($group,$file){
		$file_path=$cache_path=$this->cachePath.$group."/$file";
		if($this->cacheresult[$group][$file]===NULL){
			if(file_exists($file_path)&&!is_dir($file_path)){
				require $file_path;
				
			}
			$this->cacheresult[$group][$file]= is_array($arrayvalue)?$arrayvalue:array();
		}
		return $this->cacheresult[$group][$file];
	}
	private $changed=array();
	function setCache($group,$file,$value=array()){
		$this->read_cache($group,$file);
		foreach ($value as $index => $value) {
				if(!isset($this->cacheresult[$group][$file][$index])){
					$this->cacheresult[$group][$file][$index]=$value;
					$this->changed[$group][$file]=true;
				}
		}
		
		
	}
	function getCache($group,$file,$index){
		if(APPLICATION_TYPE=='admin') return NULL;
		$array=$this->read_cache($group,$file);
		return $array[$index];
	}
	
	function updateCache(){
		if(count($this->changed)){
			foreach ($this->changed as $folder => $value) {
				if(count($value))
				foreach ($value as $file => $val) {
					$this->write_cache($folder,$file,$this->cacheresult[$folder][$file]);;
				}
				
			}
		}
	}
	function deleteCache($group,$file=""){
		$cache_path=$this->cachePath.$group."/";
		//echo $cache_path;exit;
		if($file){
			chmod($cache_path.$file,0777);
			if(!is_writable($cache_path.$file)){
				echo $cache_path.$file." not writeable";exit;
			}else{
				unlink($cache_path.$file);
			}
		}else{
			if(is_dir($cache_path)){
				chmod($cache_path,0777);
				if(!is_writable($cache_path)){
					echo $cache_path." not writeable";exit;
				}
				 $objects = scandir($cache_path);
			     foreach ($objects as $object) {
			       if ($object != "." && $object != "..") {
			         if (filetype($cache_path.$object) == "dir") rrmdir($cache_path.$object); else unlink($cache_path.$object);
			       }
			     }
			     reset($objects);
			     rmdir($cache_path);
			}
			
		}
		
	}
}

?>