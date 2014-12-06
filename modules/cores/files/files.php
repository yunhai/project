<?php

global $vsStd;
//$vsStd->requireFile ( CORE_PATH . "files/filetypes.php" );
$vsStd->requireFile ( CORE_PATH . "files/File.class.php" );

class files extends VSFObject {
	/**
	 * 
	 * Enter description here ...
	 * @var File
	 */
	public $basicObject;
	public $arrayFiles = array ();
	public $obj;
	public $currentPath = "";
	public $rootPath = "";
	public $result = array ();
	//public $objType;
	/**
	 * 
	 * message when upload false
	 * @var string
	 */
	public  $message="";
	
	function __construct() {
		parent::__construct ();
		$this->primaryField = 'id';
		$this->basicClassName = 'File';
		$this->tableName = 'file';
		$this->createBasicObject ();
		//$this->objType = new filetypes ();
		$this->rootPath = ROOT_PATH . "uploads/";
	}
	
	function __destruct() {
		unset ( $this );
	}
	function filter_extension($type){
		return true;
	}
	function deleteFile($id = 0) {
		$this->result ['status'] = true;
		if (! $id)
			return $this->result ['status'] = false;
		$this->setCondition ( "`id` in ($id)" );
		$arrFile = $this->getObjectsByCondition ();
		$this->setCondition ( "`id` in ($id)" );
		if (! $this->result ['status'])
			return;
		$this->deleteObjectByCondition ();
		foreach ( $arrFile as $file ) {
			$this->currentPath = $file->getPath ();
			@unlink ( $file->getPathView ( false ) );
		}
	
	}
	
	function convertVideoToFlv($source, $des, $extension = '') {
		global $_SERVER;
		$dynamic_path = $_SERVER ['DOCUMENT_ROOT'];
		
		if (! file_exists ( $source ))
			return false;
		else if ($extension == '') {
			$fileNameParts = explode ( ".", $source );
			$extension = end ( $fileNameParts );
		}
		$sourcevideo = $dynamic_path . trim ( $source, '.' );
		$desvideo = $dynamic_path . trim ( $des, '.' );
		/******************create thumbnail***************/
		
		$desimg = str_replace ( 'flv', 'png', $desvideo );
		$fileNameParts = explode ( "/", $desimg );
		$name = end ( $fileNameParts );
		//$desimg=str_replace($name,"{$name}",$desimg);
		exec ( "ffmpeg -y -i " . $sourcevideo . " -vframes 1 -ss 00:00:05 -an -vcodec png -f rawvideo -s 800x600 " . $desimg );
		if ($extension == "wav") {
			exec ( "ffmpeg -i $sourcevideo -acodec mp3 -ab 128k $desvideo" );
			if (file_exists ( $des ))
				return true;
		}
		if ($extension == "wmv") {
			exec ( "ffmpeg -i " . $sourcevideo . " -sameq -acodec libmp3lame -ar 22050 -ab 32 -f flv -s 320x240 " . $desvideo );
			if (file_exists ( $des ))
				return true;
		
		} elseif ($extension == "mp4") {
			exec ( "ffmpeg -i " . $sourcevideo . " -ar 22050 -ab 32 -acodec libmp3lame -r 25 -f flv -b 400 -s 320x240 " . $desvideo );
			if (file_exists ( $des ))
				return true;
		}
		
		if ($extension == "avi" || $extension == "mpg" || $extension == "mpeg" || $extension == "mov") {
			exec ( "ffmpeg -i $sourcevideo -ar 22050 -ab 32 -f flv -s 320x240 $desvideo" );
			if (file_exists ( $des ))
				return true;
		}
		
		return false;
	}
	
	function readDir($dir = "", $ignoreFiles = array(), $showfile = false) {
		$dh = opendir ( $dir );
		
		$objs = array ();
		// Start read files list
		while ( $obj = readdir ( $dh ) ) {
			if ($obj == "." || $obj == "..")
				continue;
			if (! $showfile && ! is_dir ( $dir . $obj ))
				continue;
			if (count ( $ignoreFiles ) > 0 && in_array ( $obj, $ignoreFiles ))
				continue;
			
			$objs [] .= $obj;
		}
		closedir ( $dh );
		
		rsort ( $objs );
		
		return $objs;
	}
	
	function getFileExtension($obj) {
		return strtolower ( str_replace ( ".", "", substr ( $obj, strrpos ( $obj, '.' ) ) ) );
	}
	
	/**
	 * Download file function
	 * @param integer $id the id of file in databases
	 * @return array error if fail and file streaming if success
	 */
	function downloadFile($id = 0) {
		global $vsStd, $vsLang, $bw, $DB;
		
		$this->basicObject = $this->getObjectById ( intval ( $id ) );
		
		if (! $this->result ['status'])
			return;
		
		$this->result ['message'] = $vsLang->getWords ( 'file_download_success', "Download file successfully!" );
		$this->result ['status'] = true;
		
		// Output file name
		$objName = VSFTextCode::removeAccent ( $bw->vars ['global_websitename'] . " " . $this->basicObject->getTitle (), "-" ) . "." . $this->basicObject->getType ();
		
		if (file_exists ( $this->basicObject->getPathView ( 0 ) )) {
			header ( 'Content-Description: File Transfer' );
			header ( 'Content-Type: application/octet-stream' );
			header ( 'Content-Disposition: attachment; filename=' . basename ( $objName ) );
			header ( 'Content-Transfer-Encoding: binary' );
			header ( 'Expires: 0' );
			header ( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
			header ( 'Pragma: public' );
			header ( 'Content-Length: ' . $this->basicObject->getSize () );
			ob_clean ();
			flush ();
			readfile ( $this->basicObject->getPathView () );
			exit ();
		}
	}
	
	function getFileInfo($fileName) {
		$imageDim = getimagesize ( $fileName );
		$returnDim = array ('width' => $imageDim [0], 'height' => $imageDim [1], 'mime' => $imageDim ['mime'] );
		$tmp=explode("/", $imageDim ['mime']);
		$returnDim ['type']=$tmp[1];
		return $returnDim;
	}
	function formatbytes($file, $type = NULL) {
		switch ($type) {
			case "KB" :
				$filesize = filesize ( $file ) * .0009765625; // bytes to KB
				break;
			case "MB" :
				$filesize = (filesize ( $file ) * .0009765625) * .0009765625; // bytes to MB
				break;
			case "GB" :
				$filesize = ((filesize ( $file ) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
				break;
			default :
				$filesize = filesize ( $file );
		}
		if ($filesize <= 0) {
			return $filesize = 'unknown file size';
		} else
			return round ( $filesize, 2 ) . ' ' . $type;
	}
	/**
	 * Upload file function
	 * @param string $uploadName the name of file in input
	 * @param string $objName the name of file
	 * @param string $pathFile the path of file can upload
	 * @return error if fail and `id` streaming if success
	 */
	function copyFile($sourceName, $pathFile = "",$name="") {
		global $vsStd, $bw;
		$checkFile = $this->getFileInfo ( $sourceName );
		if (! is_array ( $checkFile )){
			$this->message="Remote path not available";
			return false;
			return false;
		}
		if(!$this->filter_extension($checkFile['type'])){
			$this->message="Extension '{$checkFile['type']}' not allowed!";
			return false;
		}
		$time = time ();
		if(!$name) $name=$sourceName;
		$info=pathinfo($name);
//		$info['dirname']
//		$info['basename']
//		$info['extension']
//		$info['filename']

		if(!$info['filename']){
				 $tmp=explode(".",$info['basename']);
				 $info['filename']=$tmp[0];
		}

		//$info['extension']=$checkFile['type'];
		$cachefile=CACHE_PATH."images/{$info['filename']}.{$info['extension']}";
		if (! copy ( $sourceName, $cachefile )) {
			return false;
		}
		$size = $this->formatbytes ( $cachefile );
		if ($size < 0)
			return false;
		if($this->uploadLocalToHost($cachefile, $pathFile, "{$info['filename']}.{$info['extension']}", $this->basicObject)){
//			$this->basicObject->setModule ( $bw->input [0] );
//			$this->basicObject->setTitle ( '~' . $info['filename'] );
//			$this->basicObject->setName ( '~' . $info['filename'] );
//			$this->insertObject ();
			
		};
		@unlink($cachefile);
		unset($cachefile);
		return  $this->basicObject->getId ();
		
	}
	/**
	 * Upload file function
	 * @param string $uploadName the name of file in input
	 * @param string $objName the name of file
	 * @param string $pathFile the path of file can upload
	 * @return error if fail and `id` streaming if success
	 */
	function uploadFile($uploadName, $pathFile = "", $type= 1) {
		global $vsStd, $bw;
		$this->basicObject->convertToObject ( $bw->input );
		$this->basicObject->setModule ( $bw->input ['table'] );
		$pathFile=$this->uploadLocalToHost( $_FILES[$uploadName]['tmp_name'], $pathFile,$_FILES[$uploadName]['name'],$this->basicObject);
		if(!$pathFile){
			$message=$this->message;
		}else{
//			$fileinfo=pathinfo($pathFile );
			/**
			 *$fileinfo['dirname'] => .
		     *$fileinfo['basename'] => Sunset.jpg
		     *$fileinfo['extension'] => jpg
		     *$fileinfo['filename'] => Sunset 
			 */
			
			
			
		}
		
			
		$bw->show_callback = 1;
		if ($bw->input ['ajax']){
			$return['error']=$message;
			$return['success']=true;
			$return['id']=$this->basicObject->getId();
			$return['ext']=$this->basicObject->getType();
			$return['name']=$bw->input['uploadName'];
			echo json_encode($return);
		}else return $this->basicObject;
	}
	/**
	 * 
	 * copy souce file from local to host in destpath
	 * @param $source
	 * @param $destPath
	 * @param $destName file-name.jpg
	 * @param $fileObj File
	 * @return string products/2011/11/02/file-name.jpg
	 */
	function uploadLocalToHost($source,$destPath,$destName,&$fileObj){
		global $vsStd;
		$uploadDirectory = ltrim (trim(date("Y/m/d"),"/"),"/")."/";
		$destPath =rtrim($destPath,"/")."/". $uploadDirectory;
		if(!is_dir($destPath)){
				@mkdir ($this->rootPath.$destPath, 0777, true );
				$flist=explode("/", $destPath);
				$f=ltrim($this->rootPath,"/");
				foreach ($flist as $index => $value) {
					$f.="/".$value;
					chmod( $f,0777);
				}
				unset($f);
				unset($flist);
				
		}
		$fileinfo=pathinfo(strtolower( $destName) );
			/**
			 *$fileinfo['dirname'] => .
		     *$fileinfo['basename'] => Sunset.jpg
		     *$fileinfo['extension'] => jpg
		     *$fileinfo['filename'] => Sunset 
			 */
			 if(!$fileinfo['filename']){
				 $tmp=explode(".",$fileinfo['basename']);
				 $fileinfo['filename']=$tmp[0];
			 }
			
		if(!$this->filter_extension($fileinfo['extension'])){
			$this->message="Extension '{$fileinfo['extension']}' not allowed!";
			return false;
		}
		//$objName = str_replace ( substr ( $_FILES [$uploadName] ['name'], strrpos ( $_FILES [$uploadName] ['name'], '.' ) ), "", $_FILES [$uploadName] ['name'] );
		$vsStd->requireFile ( UTILS_PATH . "TextCode.class.php" );
		$fileName=$fileinfo['filename'] ;
		$fileinfo['filename'] = str_replace ( "/", " ", $fileinfo['filename']  );
		$fileinfo['filename'] = VSFTextCode::removeAccent ( trim ( $fileinfo['filename'] ), "_" );
		$destFile=$destPath.$fileinfo['filename'];
		$upladedName=$fileinfo['filename'];
		if(file_exists( $this->rootPath.$destFile.".".$fileinfo['extension'])){
			$i=0;
			while(file_exists( $this->rootPath.$destFile."_$i.".$fileinfo['extension'])){
				$i++;
			}
			$destFile=$destFile."_$i";
			$upladedName=$fileinfo['filename']."_$i";
		}
		$destFile.=".".$fileinfo['extension'];
		//$vsStd->requireFile ( UTILS_PATH . "class_upload.php" );
		$ok=true;
		if(!move_uploaded_file($source,$this->rootPath.$destFile)){
			if(file_exists($source)){
				if(!copy($source, $this->rootPath.$destFile)){
					$this->message=sprintf(VSFactory::getLangs()->getWords ( 'Can_not_copy', 'Can not copy file from %s to %s' ),
						$source,$this->rootPath.$destFile
					);
					return false;
				}
			}elseif($source=='php://input'){
				$input = @fopen($source, "r");
				if(!$input) {
					$ok=false;
				}else{
			   		$target = fopen($this->rootPath.$destFile, "w");
					$fileSize = stream_copy_to_stream($input, $target);
					if(!$fileSize){
						$ok=false;
					}
				}
			}else{
					$ok=false;
			}
			
		}
		if(!$ok){
			$this->message=sprintf(VSFactory::getLangs()->getWords ( 'Can_not_copy', 'Can not copy file from %s to %s' ),
				$source,$this->rootPath.$destFile
			);
			return false;
		}
		//$fileObj->convertToObject ( $bw->input );
			$fileObj->setPath ( rtrim ( $destPath, '/' ) . "/" );
			//$fileObj->setModule ( $bw->input ['table'] );
			$fileObj->setSize ( filesize($this->rootPath.$destFile) );
				
			if ($fileObj->getTitle () == "" or $fileObj->getTitle () == "undefined")
					$fileObj->setTitle ( str_replace(array('_','-'), " ", $fileName) );
			if ($fileObj->getIntro () == "" || $fileObj->getIntro () == "undefined"){
					$fileObj->setIntro ( str_replace(array('_','-'), " ", $fileName) );
			}
			$fileObj->setName ($upladedName);
			$fileObj->setType ( $this->getFileExtension ( $fileinfo['extension'] ) );
			$fileObj->setUploadTime ( time() );
			@chmod ( $fileObj->getPathView ( 0 ), 0775 );
			if (stristr ( "wmv mpg mpeg avi mp4 flv", $fileObj->getType () )) {
				$desFile = UPLOAD_PATH . "{$fileObj->getPath()}{$fileinfo['filename']}.flv";
					
				if ($this->convertVideoToFlv ( $fileObj->getPathView ( 0 ), $desFile, $fileObj->getType () )) {
						@unlink ( $fileObj->getPathView ( 0 ) );
						$fileObj->setType ( "flv" );
				}
			}
			
			$this->insertObject ($fileObj);
		return $destFile;
			
	}
	function buildCacheFile($module) {
		$vsLang = VSFactory::getLangs ();
		$this->makeFilefolder ( $vsLang->currentLang->getFoldername () );
		$this->setCondition ( "fileModule = '{$module}'" );
		$list = $this->getArrayByCondition ();

		$vars = array ();
		foreach ( $list as $element )
			$vars [$element ['id']] = $element;

		$cache_content = "<?php\n";
		$cache_content .= "\$arrayFile = " . var_export ( $vars, true ) . ";\n";
		
		$cache_content .= "?>";
		$cache_path = CACHE_PATH . "file/" . $vsLang->currentLang->getFoldername () . "/" . $module . ".cache";
		$cache_content = preg_replace ( '/\s\s+/', '', $cache_content );
		$file = fopen ( $cache_path, "w" );
		fwrite ( $file, $cache_content );
		fclose ( $file );
		unset ( $vars );
	}
	
	function makeFilefolder($name) {
		$linkname = CACHE_PATH . "file/" . $name;
		if (! is_dir ( $linkname )) {
			mkdir ( $linkname, 0777, true );
			
			return 1;
		} else {
			$this->result ['message'] .= " folder[" . $name . "] has been exits";
			return;
		}
	
	}
	/**
	 * 
	 * @param File $obj
	 */
	function updateObject($obj=NULL){
		if($obj==NULL){
			$obj=$this->basicObject;
		}
		$files=new files();
		$files->getObjectById($obj->getId());
		if($obj->getName()!=$files->basicObject->getName()){
			rename($files->basicObject->getPathView(0),$obj->getPathView(0));
			
		}
		parent::updateObject($obj);
	}
	function deleteObjectById($id=''){
		//VSFactory::getCacheVar()->deleteCache("files");
		if($id){
			$files=new files();
			$files->getObjectById($id);
			$files->basicObject->getName();
			if(file_exists($files->basicObject->getPathView(0))){
				unlink($files->basicObject->getPathView(0));
			}
		}else{
			if(file_exists($this->basicObject->getPathView(0))){
				unlink($this->basicObject->getPathView(0));
			}
		}
		return parent::deleteObjectById();
	}
	function deleteObjectByCondition(){
		//VSFactory::getCacheVar()->deleteCache("files");
		$files=new files();
		$files->setCondition($this->condition);
		$list=$files->getObjectsByCondition();
		foreach ($list as $value) {
			if(file_exists($value->getPathView(0))){
				unlink($value->getPathView(0));
			}
		}
		return parent::deleteObjectByCondition();
	}
	function getObjectById($id=''){
		return parent::getObjectById($id);
	}
}