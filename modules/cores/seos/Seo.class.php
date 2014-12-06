<?php

class Seo extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->aliasUrl ) ? ($dbobj ['aliasUrl'] = $this->aliasUrl) : '';
		isset ( $this->realUrl ) ? ($dbobj ['realUrl'] = $this->realUrl) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->keyword ) ? ($dbobj ['keyword'] = $this->keyword) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['aliasUrl'] ) ? $this->setAliasUrl ( $object ['aliasUrl'] ) : '';
		isset ( $object ['realUrl'] ) ? $this->setRealUrl ( $object ['realUrl'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['keyword'] ) ? $this->setKeyword ( $object ['keyword'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getType(){
		return $this->type;
	}



	function getAliasUrl(){
		return $this->aliasUrl;
	}



	function getRealUrl(){
		return $this->realUrl;
	}



	function getTitle(){
		return $this->title;
	}



	function getKeyword(){
		return $this->keyword;
	}



	function getIntro(){
		return $this->intro;
	}



	function getStatus(){
		return $this->status;
	}



	function setId($id){
		$this->id=$id;
	}




	function setType($type){
		$this->type=$type;
	}




	function setAliasUrl($aliasUrl){
		$this->aliasUrl=$aliasUrl;
	}




	function setRealUrl($realUrl){
		$this->realUrl=$realUrl;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setKeyword($keyword){
		$this->keyword=$keyword;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setStatus($status){
		$this->status=$status;
	}



		var		$id;

		var		$type;

		var		$aliasUrl;

		var		$realUrl;

		var		$title;

		var		$keyword;

		var		$intro;

		var		$status;
}
