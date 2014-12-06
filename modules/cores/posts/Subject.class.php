<?php
/**
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: TuyenBui
 |	Email: tuyenbui@vietsol.net
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Subject class builded by classbuilder for all problem contact tuyenbui@vietsol.net
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 +-----------------------------------------------------------------------------
 * 
 * @author tuyenbui
 *
 */
class Subject extends BasicObject{
	
 	function __construct() {
 		/****contructor here****/
		parent::__construct();
	}

	function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['id'] 		= $this->getId()) 		: '';
isset ( $this->title ) 		? ($dbobj ['title'] 		= $this->getTitle()) 		: '';
isset ( $this->intro ) 		? ($dbobj ['intro'] 		= $this->getIntro()) 		: '';
isset ( $this->removedText ) 		? ($dbobj ['removedText'] 		= $this->getRemovedText()) 		: '';
isset ( $this->slug ) 		? ($dbobj ['slug'] 		= $this->getSlug()) 		: '';
return $dbobj;

	}

	function convertToObject($object) {
		isset ( $object ['id'] ) 		? $this->setId ( $object ['id'] ) 				: '';
isset ( $object ['title'] ) 		? $this->setTitle ( $object ['title'] ) 				: '';
isset ( $object ['intro'] ) 		? $this->setIntro ( $object ['intro'] ) 				: '';
isset ( $object ['removedText'] ) 		? $this->setRemovedText ( $object ['removedText'] ) 				: '';
isset ( $object ['slug'] ) 		? $this->setSlug ( $object ['slug'] ) 				: '';

		

	}
 
	

	function validate() {
		return true;
	}
	
	

	function __destruct() {
		unset ( $this );
	}
	
				protected  $id 	= NULL;
			
				protected  $title 	= NULL;
			
				protected  $intro 	= NULL;
			
				protected  $removedText 	= NULL;
			
				protected  $slug 	= NULL;
			

				function setId($id) {
					$this->id = $id;
				}
				function getId() {
					return $this->id;
				}
			
				function setTitle($title) {
					$this->title = $title;
				}
				function getTitle() {
					return $this->title;
				}
			
				function setIntro($intro) {
					$this->intro = $intro;
				}
				function getIntro() {
					return $this->intro;
				}
			
				function setRemovedText($removedText) {
					$this->removedText = $removedText;
				}
				function getRemovedText() {
					return $this->removedText;
				}
			
				function setSlug($slug) {
					$this->slug = $slug;
				}
				function getSlug() {
					return $this->slug;
				}
			

}
?>