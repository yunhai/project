<?php 

class Partner extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->website ) ? ($dbobj ['website'] = $this->website) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->fileId ) ? ($dbobj ['fileId'] = $this->fileId) : '';
		isset ( $this->price ) ? ($dbobj ['price'] = $this->price) : '';
		isset ( $this->beginTime ) ? ($dbobj ['beginTime'] = $this->beginTime) : '';
		isset ( $this->expTime ) ? ($dbobj ['expTime'] = $this->expTime) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->position ) ? ($dbobj ['position'] = $this->position) : '';
		isset ( $this->hits ) ? ($dbobj ['hits'] = $this->hits) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->clearSearch ) ? ($dbobj ['clearSearch'] = $this->clearSearch) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['website'] ) ? $this->setWebsite ( $object ['website'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['fileId'] ) ? $this->setFileId ( $object ['fileId'] ) : '';
		isset ( $object ['price'] ) ? $this->setPrice ( $object ['price'] ) : '';
		isset ( $object ['beginTime'] ) ? $this->setBeginTime ( $object ['beginTime'] ) : '';
		isset ( $object ['expTime'] ) ? $this->setExpTime ( $object ['expTime'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['position'] ) ? $this->setPosition ( $object ['position'] ) : '';
		isset ( $object ['hits'] ) ? $this->setHits ( $object ['hits'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['clearSearch'] ) ? $this->setClearSearch ( $object ['clearSearch'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';

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



	function getAddress(){
		return $this->address;
	}



	function getIntro(){
		return $this->intro;
	}



	function getWebsite(){
		return $this->website;
	}



	function getContent(){
		return $this->content;
	}



	function getFileId(){
		return $this->fileId;
	}



	function getPrice(){
		return $this->price;
	}



	function getBeginTime(){
		return $this->beginTime;
	}



	function getExpTime(){
		return $this->expTime;
	}



	function getIndex(){
		return $this->index;
	}



	function getPosition(){
		return $this->position;
	}



	function getHits(){
		return $this->hits;
	}



	function getStatus(){
		return $this->status;
	}



	function getClearSearch(){
		return $this->clearSearch;
	}



	function getImage(){
		return $this->image;
	}



	function getCode(){
		return $this->code;
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




	function setAddress($address){
		$this->address=$address;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setWebsite($website){
		$this->website=$website;
	}




	function setContent($content){
		$this->content=$content;
	}




	function setFileId($fileId){
		$this->fileId=$fileId;
	}




	function setPrice($price){
		$this->price=$price;
	}




	function setBeginTime($beginTime){
		$this->beginTime=$beginTime;
	}




	function setExpTime($expTime){
		$this->expTime=$expTime;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setPosition($position){
		$this->position=$position;
	}




	function setHits($hits){
		$this->hits=$hits;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setClearSearch($clearSearch){
		$this->clearSearch=$clearSearch;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setCode($code){
		$this->code=$code;
	}



		var		$id;

		var		$catId;

		var		$title;

		var		$address;

		var		$intro;

		var		$website;

		var		$content;

		var		$fileId;

		var		$price;

		var		$beginTime;

		var		$expTime;

		var		$index;

		var		$position;

		var		$hits;

		var		$status;

		var		$clearSearch;

		var		$image;

		var		$code;

	
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','title','address','intro','website','content','fileId','price','beginTime','expTime','index','position','hits','status','clearSearch','image','code',);
}
