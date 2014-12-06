<?php
/**
 * zip proccessor
 * @author tuyenbui
 *
 */
class ZipProccessor {
	private $folder=array();
	private $string=array();
	public function addFile($filepath, $zpath = "") {
		$zpath = $zpath ? $zpath : $filepath;
		$this->files [$zpath] = $filepath;
	}
	public function addString($content, $zpath) {
		$this->string [$zpath] = $content;
	}
	public function createZip($tofile, $overwrite = true) {
		//if the zip file already exists and overwrite is false, return false
		if (file_exists ( $tofile ) && ! $overwrite) {
			return false;
		}
		//vars
		$valid_files = array ();
		//if files were passed in...
		if (is_array ( $this->files )) {
			//cycle through each file
			foreach ( $this->files as $zindex => $file ) {
				//make sure the file exists
				if (file_exists ( $file )) {
					$valid_files [$zindex] = $file;
				}
			}
		}
//		echo "<pre>";
//			print_r($this->files);
//			echo "</pre>";
//			exit;
		$zip = new ZipArchive ();
		//if we have good files...
		if (count ( $valid_files )) {
			//create the archive
			
			if ($zip->open ( $tofile, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE ) !== true) {
				return false;
			}
			//add the files
			foreach ( $valid_files as $zindex => $file ) {
				$zip->addFile ( $file, $zindex );
			}
			//debug
			
			

			//close the zip -- done!
			
		} else {
		}
		foreach ($this->folder as $zindex=>$folder) {
			$this->recurse_zip($folder,$zip,$zindex);
		}
		foreach ($this->string as $index=>$value) {
			$zip->addFromString($index,$value);
		}
		$zip->close ();
			
		//check to make sure the file exists
		return file_exists ( $tofile );
	}
	function zipFolder(){
		
	}
	/**
	 * add folder to root path
	 * @param $folderName
	 */
	function addFolder($folderPath,$zippath=""){
		$zippath=$zippath?$zippath:$folderPath;
		$this->folder[$zippath]=$folderPath;
		
	}
	function recurse_zip($src,&$zip,$zpath) {
			$src=rtrim($src,"/");
			$zpath=rtrim($zpath,"/");
	        $dir = opendir($src);
	        while(false !== ( $file = readdir($dir)) ) {
	            if (( $file != '.' ) && ( $file != '..' )&&($file != '.svn')) {
	                if ( is_dir($src . '/' . $file) ) {
	                    $this->recurse_zip($src . '/' . $file,$zip,$zpath . '/' . $file);
	                }else {
	                    $zip->addFile($src . '/' . $file,$zpath . '/' . $file);
	                }
	            }
	        }
	        closedir($dir);
	}
}

?>