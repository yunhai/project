<?php 

class Page extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->infoUser ) ? ($dbobj ['infoUser'] = $this->infoUser) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->mTitle ) ? ($dbobj ['mTitle'] = $this->mTitle) : '';
		isset ( $this->mKeyWord ) ? ($dbobj ['mKeyWord'] = $this->mKeyWord) : '';
		isset ( $this->mIntro ) ? ($dbobj ['mIntro'] = $this->mIntro) : '';
		isset ( $this->mUrl ) ? ($dbobj ['mUrl'] = $this->mUrl) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['mTitle'] ) ? $this->setMTitle ( $object ['mTitle'] ) : '';
		isset ( $object ['mKeyWord'] ) ? $this->setMKeyWord ( $object ['mKeyWord'] ) : '';
		isset ( $object ['mIntro'] ) ? $this->setMIntro ( $object ['mIntro'] ) : '';
		isset ( $object ['mUrl'] ) ? $this->setMUrl ( $object ['mUrl'] ) : '';

	}


	var $type;



	function getId(){
		return $this->id;
	}



	function getCatId(){
		return $this->catId;
	}



	function getTitle(){
		return $this->title;
	}



	function getIntro(){
		return $this->intro;
	}



	function getImage(){
		return $this->image;
	}




	function getContent(){
		return $this->content;
	}


	function getPostDate(){
		return $this->postDate;
	}



	function getStatus(){
		return $this->status;
	}



	function getIndex(){
		return $this->index;
	}



	function getCode(){
		return $this->code;
	}



	function getModule(){
		return $this->module;
	}



	function getMTitle(){
		return $this->mTitle;
	}



	function getMKeyWord(){
		return $this->mKeyWord;
	}



	function getMIntro(){
		return $this->mIntro;
	}



	function getMUrl(){
		return $this->mUrl;
	}



	function setId($id){
		$this->id=$id;
	}




	function setCatId($catId){
		$this->catId=$catId;
	}




	function setTitle($title){
		$this->title=$title;
	}



	function setIntro($intro){
		$this->intro=$intro;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setContent($content){
		$this->content=$content;
	}




	function setInfoUser($infoUser){
		$this->infoUser=$infoUser;
	}




	function setPostDate($postDate){
		$this->postDate=$postDate;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setCode($code){
		$this->code=$code;
	}




	function setModule($module){
		$this->module=$module;
	}




	function setMTitle($mTitle){
		$this->mTitle=$mTitle;
	}




	function setMKeyWord($mKeyWord){
		$this->mKeyWord=$mKeyWord;
	}




	function setMIntro($mIntro){
		$this->mIntro=$mIntro;
	}




	function setMUrl($mUrl){
		$this->mUrl=$mUrl;
	}



		var		$id;

		var		$catId;

		var		$title;


		var		$intro;

		var		$image;

		var		$content;


		var		$postDate;

		var		$status;

		var		$index;

		var		$code;

		var		$module;

		var		$mTitle;

		var		$mKeyWord;

		var		$mIntro;

		var		$mUrl;

	
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','title','intro','image','content','postDate','status','index','code','module','mTitle','mKeyWord','mIntro','mUrl',);
}
