<?php
	class Page extends BasicObject{
		private $document 	= NULL;
		
		function __construct(){
			parent::__construct();
	    }
	    function __destruct(){
	    	parent::__destruct();
	    	
	    }
  		function convertToDB() {
       		$dbobj = parent::convertToDB('page');
        	isset ( $this->postdate )     ? ($dbobj ["pagePostDate"] = $this->postdate) : "";
        	isset ( $this->document )     ? ($dbobj ["pageDocument"] = $this->document) : "";
        	
        	if(isset ( $this->intro ) || isset($this->content) || isset ( $this->title )){
                            $cleanContent = VSFTextCode::removeAccent($this->title)." ";
                            $cleanContent .= VSFTextCode::removeAccent(strip_tags($this->getIntro()))." ";
                            $cleanContent.= VSFTextCode::removeAccent(strip_tags($this->getContent()));	
                            $dbobj ['pageCleanContent'] = strtolower($cleanContent);	
            }
		return $dbobj;
		}
		
		function convertToObject($object) {
                    global $vsFile,$DB;
                    parent::convertToObject($object,'page');
                    isset ( $object ["pageDocument"] )  ? ($this->document = $object ["pageDocument"])              : '';
                    isset ( $object ["pagePostDate"] )  ? $this->setPostDate($object ["pagePostDate"])              : '';
		}
		function getDocument() {
		return $this->document;
	}

		function setDocument($document) {
		$this->document = $document;
	}
	}
?>