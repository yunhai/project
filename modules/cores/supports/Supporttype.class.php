<?php

class Supporttype extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->path ) ? ($dbobj ['path'] = $this->path) : '';
		isset ( $this->offImage ) ? ($dbobj ['offImage'] = $this->offImage) : '';
		isset ( $this->onImage ) ? ($dbobj ['onImage'] = $this->onImage) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['path'] ) ? $this->setPath ( $object ['path'] ) : '';
		isset ( $object ['offImage'] ) ? $this->setOffImage ( $object ['offImage'] ) : '';
		isset ( $object ['onImage'] ) ? $this->setOnImage ( $object ['onImage'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getTitle(){
		return $this->title;
	}



	function getPath(){
		return $this->path;
	}



	function getOffImage(){
		return $this->offImage;
	}



	function getOnImage(){
		return $this->onImage;
	}



	function getCode(){
		return $this->code;
	}



	function setId($id){
		$this->id=$id;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setPath($path){
		$this->path=$path;
	}




	function setOffImage($offImage){
		$this->offImage=$offImage;
	}




	function setOnImage($onImage){
		$this->onImage=$onImage;
	}




	function setCode($code){
		$this->code=$code;
	}



		var		$id;

		var		$title;

		var		$path;

		var		$offImage;

		var		$onImage;

		var		$code;
}
