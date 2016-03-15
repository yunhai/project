<?php
/**
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: TuyenBui
 |	Email: tuyenbui@vietsol.net
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Tag class builded by classbuilder for all problem contact tuyenbui@vietsol.net
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 +-----------------------------------------------------------------------------
 * 
 * @author tuyenbui
 *
 */

class Tag extends BasicObject{
	
 	function __construct() {
 		/****contructor here****/
		parent::__construct();
	}

	function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['id'] 		= $this->getId()) 		: '';
isset ( $this->text ) 		? ($dbobj ['text'] 		= $this->getText()) 		: '';
isset ( $this->trimText ) 		? ($dbobj ['trimText'] 		= $this->getTrimText()) 		: '';
isset ( $this->dateTime ) 		? ($dbobj ['dateTime'] 		= $this->getDateTime()) 		: '';
return $dbobj;

	}

	function convertToObject($object) {
		isset ( $object ['id'] ) 			? $this->setId ( $object ['id'] ) 				: '';
		isset ( $object ['text'] ) 			? $this->setText ( $object ['text'] ) 				: '';
		isset ( $object ['trimText'] ) 		? $this->setTrimText ( $object ['trimText'] ) 				: '';
		isset ( $object ['dateTime'] ) 		? $this->setDateTime ( $object ['dateTime'] ) 				: '';

		

	}
 
	

	function validate() {
		return true;
	}
	
	

	function __destruct() {
		unset ( $this );
	}
	
				public  $id 	= NULL;
			
				public  $text 	= NULL;
			
				public  $trimText 	= NULL;
			
				public  $dateTime 	= NULL;
			

				function setId($id) {
					$this->id = $id;
				}
				function getId() {
					return $this->id;
				}
			
				function setText($text) {
					$this->text = $text;
				}
				function getText() {
					return $this->text;
				}
			
				function  setTrimText($trimText) {
					$this->trimText = $trimText;
				}
				function getTrimText() {
					return $this->trimText;
				}
			
				function setDateTime($dateTime) {
					$this->dateTime = $dateTime;
				}
				function getDateTime() {
					return $this->dateTime;
				}
	function getUrl($full=false){
		global $bw;
		require_once UTILS_PATH.'TextCode.class.php';
		$id =strtolower(VSFTextCode::removeAccent($this->text,"-"))."-".$this->id;
		if($full)
		return $bw->vars['board_url'] ."/tags/$id";
		else return "tags/$id";
	}		

}
?>