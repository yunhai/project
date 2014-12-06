<?php 

class Module extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->version ) ? ($dbobj ['version'] = $this->version) : '';
		isset ( $this->isAdmin ) ? ($dbobj ['isAdmin'] = $this->isAdmin) : '';
		isset ( $this->isUser ) ? ($dbobj ['isUser'] = $this->isUser) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->class ) ? ($dbobj ['class'] = $this->class) : '';
		isset ( $this->virtual ) ? ($dbobj ['virtual'] = $this->virtual) : '';
		isset ( $this->parent ) ? ($dbobj ['parent'] = $this->parent) : '';
		isset ( $this->isParent ) ? ($dbobj ['isParent'] = $this->isParent) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['version'] ) ? $this->setVersion ( $object ['version'] ) : '';
		isset ( $object ['isAdmin'] ) ? $this->setIsAdmin ( $object ['isAdmin'] ) : '';
		isset ( $object ['isUser'] ) ? $this->setIsUser ( $object ['isUser'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['class'] ) ? $this->setClass ( $object ['class'] ) : '';
		isset ( $object ['virtual'] ) ? $this->setVirtual ( $object ['virtual'] ) : '';
		isset ( $object ['parent'] ) ? $this->setParent ( $object ['parent'] ) : '';
		isset ( $object ['isParent'] ) ? $this->setIsParent ( $object ['isParent'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getTitle(){
		return $this->title;
	}



	function getVersion(){
		return $this->version;
	}



	function getIsAdmin(){
		return $this->isAdmin;
	}



	function getIsUser(){
		return $this->isUser;
	}
function getUser(){
		return $this->isUser;
	}


	function getIntro(){
		return $this->intro;
	}



	function getClass(){
		return $this->class;
	}



	function getVirtual(){
		return $this->virtual;
	}



	function getParent(){
		return $this->parent;
	}



	function getIsParent(){
		return $this->isParent;
	}



	function setId($id){
		$this->id=$id;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setVersion($version){
		$this->version=$version;
	}




	function setIsAdmin($isAdmin){
		$this->isAdmin=$isAdmin;
	}




	function setIsUser($isUser){
		$this->isUser=$isUser;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setClass($class){
		$this->class=$class;
	}




	function setVirtual($virtual){
		$this->virtual=$virtual;
	}




	function setParent($parent){
		$this->parent=$parent;
	}




	function setIsParent($isParent){
		$this->isParent=$isParent;
	}
/**
	 * @return unknown
	 */
	public function getAdmin() {
		return $this->isAdmin;
	}


		var		$id;

		var		$title;

		var		$version;

		var		$isAdmin;

		var		$isUser;

		var		$intro;

		var		$class;

		var		$virtual;

		var		$parent;

		var		$isParent;
}
