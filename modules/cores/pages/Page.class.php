<?php
class Page extends BasicObject{ 
		private $cleanContent = NULL; 
		private $fileupload = NULL;
		private $module = NULL; 
		private $count = NULL; 
		
		function __construct(){
			parent::__construct();
	    }
	    function __destruct(){
	    	parent::__destruct();
	    	unset ( $this->fileupload );
	    	unset ( $this->cleanContent);
	    }
  		function convertToDB() {
  			global $bw;
       		$dbobj = parent::convertToDB('page');
        	isset ( $this->postdate )     ? ($dbobj ["pagePostDate"] = $this->postdate) : "";
        	isset ( $this->fileupload)	? ($dbobj ['pageFileupload']	 = $this->fileupload) : '';
        	isset ( $this->module )     ? ($dbobj ["pageModule"] = $this->module) : "";
			isset ( $this->count)     ? ($dbobj ["pageCount"] = $this->count) : "";
        	
        	
        	isset ( $this->cleanContent )  ? ($dbobj ['pageCleanContent']       = $this->cleanContent) : '';
            if(isset ( $this->intro ) || isset($this->content) || isset ( $this->title )){
			$cleanContent = VSFTextCode::removeAccent($this->title)." ";
			$cleanContent .= VSFTextCode::removeAccent(strip_tags($this->getIntro()))." ";
			$cleanContent.= VSFTextCode::removeAccent(strip_tags($this->getContent()));	
			$dbobj ['pageCleanContent'] = $cleanContent;	
        }
		return $dbobj;
		}
		
		function convertToObject($object) {
       		global $vsFile,$DB,$bw;
           	parent::convertToObject($object,'page');
           	isset ( $object ['pageIntroImage'] )   ? $this->setImage( $object ['pageIntroImage'] ) : '';
          	isset ( $object ["pagePostDate"] )  ? $this->setPostDate($object ["pagePostDate"])              : '';
          	isset ( $object ['pageFileupload'] )   ? $this->setFileupload( $object ['pageFileupload'] ) : '';
           	isset ( $object ['pageCleanContent'] )   ? $this->setCleanContent ( $object ['pageCleanContent'] ) : '';
           	isset ( $object ["pageModule"] )  ? $this->setModule($object ["pageModule"])              : '';
       		isset ( $object ["pageCount"] )  ? $this->setCount($object ["pageCount"])              : '';
           	
		}
		
		public function getColorTitle() {
			return VSFTextCode::removeAccent(trim($this->title),"_");
		}
		
		public function getCleanContent() {
			return $this->cleanContent;
		}
	
		public function setCleanContent($cleanSearch) {
			$this->cleanContent = $cleanSearch;
		}
		
		public function setFileupload($file) {
			$this->fileupload = $file;
		}
	
	  	public function getFileupload() {
			return $this->fileupload;
		}
		
		public function getFUllImage($arr=array(),$id=0,$dele="deleteImage") {
			global $vsLang;
			if($arr[$id]){
	       	return "{$vsLang->getWordsGlobal('obj_deletefile','Delete')} :<input type='checkbox' name='{$dele}' id='{$dele}' />{$arr[$id]->getTitle()}.{$arr[$id]->getType()}";
	      	}
		}
		
		
		
	public function getModule() {
			return $this->module;
		}
	
		public function setModule($module) {
			$this->module = $module;
		}
		public function getCount() {
			return $this->count;
		}
	
		public function setCount($count) {
			$this->count = $count;
		}	
}
?>