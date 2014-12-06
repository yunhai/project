<?php

class Admingroup extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->homepath ) ? ($dbobj ['homepath'] = $this->homepath) : '';
		isset ( $this->default ) ? ($dbobj ['default'] = $this->default) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
			isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['homepath'] ) ? $this->setHomepath ( $object ['homepath'] ) : '';
		isset ( $object ['default'] ) ? $this->setDefault ( $object ['default'] ) : '';

	}


function validate() {
		return true;
	}


	function getId(){
		return $this->id;
	}



	function getName(){
		return $this->name;
	}



	function getIntro(){
		return $this->intro;
	}



	function getHomepath(){
		return $this->homepath;
	}



	function setId($id){
		$this->id=$id;
	}




	function setName($name){
		$this->name=$name;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setHomepath($homepath){
		$this->homepath=$homepath;
	}

/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->name;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->name = $title;
	}
/**
	 * @return the $default
	 */
	public function getDefault() {
		return $this->default;
	}

		/**
	 * @param field_type $default
	 */
	public function setDefault($default) {
		$this->default = $default;
	}
		var		$id;

		var		$name;

		var		$intro;

		var		$homepath;
		var		$default;

}
