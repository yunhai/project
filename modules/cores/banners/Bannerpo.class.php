<?php

class Bannerpo extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getTitle(){
		return $this->title;
	}



	function getImage(){
		return $this->image;
	}



	function getIndex(){
		return $this->index;
	}



	function getStatus(){
		return $this->status;
	}



	function getCode(){
		return $this->code;
	}



	function getIntro(){
		return $this->intro;
	}



	function setId($id){
		$this->id=$id;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setCode($code){
		$this->code=$code;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}



		var		$id;

		var		$title;

		var		$image;

		var		$index;

		var		$status;

		var		$code;

		var		$intro;
}
