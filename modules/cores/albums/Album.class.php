<?php

class Album extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->subTitle ) ? ($dbobj ['subTitle'] = $this->subTitle) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->price ) ? ($dbobj ['price'] = $this->price) : '';
		isset ( $this->vote ) ? ($dbobj ['vote'] = $this->vote) : '';
		isset ( $this->visit ) ? ($dbobj ['visit'] = $this->visit) : '';
		isset ( $this->option ) ? ($dbobj ['option'] = $this->option) : '';
		isset ( $this->number ) ? ($dbobj ['number'] = $this->number) : '';
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
		isset ( $this->deadline ) ? ($dbobj ['deadline'] = $this->deadline) : '';
		isset ( $this->website ) ? ($dbobj ['website'] = $this->website) : '';
		isset ( $this->catproId ) ? ($dbobj ['catproId'] = $this->catproId) : '';
		isset ( $this->proId ) ? ($dbobj ['proId'] = $this->proId) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['subTitle'] ) ? $this->setSubTitle ( $object ['subTitle'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['price'] ) ? $this->setPrice ( $object ['price'] ) : '';
		isset ( $object ['vote'] ) ? $this->setVote ( $object ['vote'] ) : '';
		isset ( $object ['visit'] ) ? $this->setVisit ( $object ['visit'] ) : '';
		isset ( $object ['option'] ) ? $this->setOption ( $object ['option'] ) : '';
		isset ( $object ['number'] ) ? $this->setNumber ( $object ['number'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['infoUser'] ) ? $this->setInfoUser ( $object ['infoUser'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['mTitle'] ) ? $this->setMTitle ( $object ['mTitle'] ) : '';
		isset ( $object ['mKeyWord'] ) ? $this->setMKeyWord ( $object ['mKeyWord'] ) : '';
		isset ( $object ['mIntro'] ) ? $this->setMIntro ( $object ['mIntro'] ) : '';
		isset ( $object ['mUrl'] ) ? $this->setMUrl ( $object ['mUrl'] ) : '';
		isset ( $object ['deadline'] ) ? $this->setDeadline ( $object ['deadline'] ) : '';
		isset ( $object ['website'] ) ? $this->setWebsite ( $object ['website'] ) : '';
		isset ( $object ['catproId'] ) ? $this->setCatproId ( $object ['catproId'] ) : '';
		isset ( $object ['proId'] ) ? $this->setProId ( $object ['proId'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getCatId(){
		return $this->catId;
	}



	function getTitle(){
		return $this->title;
	}



	function getSubTitle(){
		return $this->subTitle;
	}



	function getIntro(){
		return $this->intro;
	}



	function getImage(){
		return $this->image;
	}



	function getPhone(){
		return $this->phone;
	}



	function getPrice(){
		return $this->price;
	}



	function getVote(){
		return $this->vote;
	}



	function getVisit(){
		return $this->visit;
	}



	function getOption(){
		return $this->option;
	}



	function getNumber(){
		return $this->number;
	}



	function getContent(){
		return $this->content;
	}



	function getInfoUser(){
		return $this->infoUser;
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



	function getDeadline(){
		return $this->deadline;
	}



	function getWebsite(){
		return $this->website;
	}



	function getCatproId(){
		return $this->catproId;
	}



	function getProId(){
		return $this->proId;
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




	function setSubTitle($subTitle){
		$this->subTitle=$subTitle;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setPhone($phone){
		$this->phone=$phone;
	}




	function setPrice($price){
		$this->price=$price;
	}




	function setVote($vote){
		$this->vote=$vote;
	}




	function setVisit($visit){
		$this->visit=$visit;
	}




	function setOption($option){
		$this->option=$option;
	}




	function setNumber($number){
		$this->number=$number;
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




	function setDeadline($deadline){
		$this->deadline=$deadline;
	}




	function setWebsite($website){
		$this->website=$website;
	}




	function setCatproId($catproId){
		$this->catproId=$catproId;
	}




	function setProId($proId){
		$this->proId=$proId;
	}



		var		$id;

		var		$catId;

		var		$title;

		var		$subTitle;

		var		$intro;

		var		$image;

		var		$phone;

		var		$price;

		var		$vote;

		var		$visit;

		var		$option;

		var		$number;

		var		$content;

		var		$infoUser;

		var		$postDate;

		var		$status;

		var		$index;

		var		$code;

		var		$module;

		var		$mTitle;

		var		$mKeyWord;

		var		$mIntro;

		var		$mUrl;

		var		$deadline;

		var		$website;

		var		$catproId;

		var		$proId;

	
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','title','subTitle','intro','image','phone','price','vote','visit','option','number','content','infoUser','postDate','status','index','code','module','mTitle','mKeyWord','mIntro','mUrl','deadline','website','catproId','proId',);
}
