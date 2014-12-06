<?php
/**
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: TuyenBui
 |	Email: tuyenbui@vietsol.net
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Productposition class builded by classbuilder for all problem contact tuyenbui@vietsol.net
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 +-----------------------------------------------------------------------------
 * 
 * @author tuyenbui
 *
 */
class Productposition extends BasicObject{
	
 	function __construct() {
 		/****contructor here****/
		parent::__construct();
	}

	function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['id'] 		= $this->getId()) 		: '';
isset ( $this->title ) 		? ($dbobj ['title'] 		= $this->getTitle()) 		: '';
isset ( $this->code ) 		? ($dbobj ['code'] 		= $this->getCode()) 		: '';
isset ( $this->index ) 		? ($dbobj ['index'] 		= $this->getIndex()) 		: '';
isset ( $this->image ) 		? ($dbobj ['image'] 		= $this->getImage()) 		: '';
return $dbobj;

	}

	function convertToObject($object) {
		isset ( $object ['id'] ) 		? $this->setId ( $object ['id'] ) 				: '';
isset ( $object ['title'] ) 		? $this->setTitle ( $object ['title'] ) 				: '';
isset ( $object ['code'] ) 		? $this->setCode ( $object ['code'] ) 				: '';
isset ( $object ['index'] ) 		? $this->setIndex ( $object ['index'] ) 				: '';
isset ( $object ['image'] ) 		? $this->setImage ( $object ['image'] ) 				: '';

		

	}
 
	

	function validate() {
		return true;
	}
	
	

	function __destruct() {
		unset ( $this );
	}
	
				protected  $id 	= NULL;
			
				protected  $title 	= NULL;
			
				protected  $code 	= NULL;
			
				protected  $index 	= NULL;
			
				protected  $image 	= NULL;
			

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
			
				function setCode($code) {
					$this->code = $code;
				}
				function getCode() {
					return $this->code;
				}
			
				function setIndex($index) {
					$this->index = $index;
				}
				function getIndex() {
					return $this->index;
				}
			
				function setImage($image) {
					$this->image = $image;
				}
				function getImage() {
					return $this->image;
				}
			

}
?>