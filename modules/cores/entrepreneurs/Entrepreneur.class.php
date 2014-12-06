<?php

class Entrepreneur extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->idObjEn ) ? ($dbobj ['idObjEn'] = $this->idObjEn) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->document ) ? ($dbobj ['document'] = $this->document) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->infoUser ) ? ($dbobj ['infoUser'] = $this->infoUser) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->subPages ) ? ($dbobj ['subPages'] = $this->subPages) : '';
		isset ( $this->cleanTitle ) ? ($dbobj ['cleanTitle'] = $this->cleanTitle) : '';
		isset ( $this->cleanContent ) ? ($dbobj ['cleanContent'] = $this->cleanContent) : '';
		isset ( $this->mTitle ) ? ($dbobj ['mTitle'] = $this->mTitle) : '';
		isset ( $this->mKeyword ) ? ($dbobj ['mKeyword'] = $this->mKeyword) : '';
		isset ( $this->mIntro ) ? ($dbobj ['mIntro'] = $this->mIntro) : '';
		isset ( $this->mUrl ) ? ($dbobj ['mUrl'] = $this->mUrl) : '';
		isset ( $this->source ) ? ($dbobj ['source'] = $this->source) : '';
		isset ( $this->videos ) ? ($dbobj ['videos'] = $this->videos) : '';
		isset ( $this->gender ) ? ($dbobj ['gender'] = $this->gender) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->company ) ? ($dbobj ['company'] = $this->company) : '';
		isset ( $this->positions ) ? ($dbobj ['positions'] = $this->positions) : '';
		isset ( $this->website ) ? ($dbobj ['website'] = $this->website) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->userId ) ? ($dbobj ['userId'] = $this->userId) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['idObjEn'] ) ? $this->setIdObjEn ( $object ['idObjEn'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['document'] ) ? $this->setDocument ( $object ['document'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['infoUser'] ) ? $this->setInfoUser ( $object ['infoUser'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['subPages'] ) ? $this->setSubPages ( $object ['subPages'] ) : '';
		isset ( $object ['cleanTitle'] ) ? $this->setCleanTitle ( $object ['cleanTitle'] ) : '';
		isset ( $object ['cleanContent'] ) ? $this->setCleanContent ( $object ['cleanContent'] ) : '';
		isset ( $object ['mTitle'] ) ? $this->setMTitle ( $object ['mTitle'] ) : '';
		isset ( $object ['mKeyword'] ) ? $this->setMKeyword ( $object ['mKeyword'] ) : '';
		isset ( $object ['mIntro'] ) ? $this->setMIntro ( $object ['mIntro'] ) : '';
		isset ( $object ['mUrl'] ) ? $this->setMUrl ( $object ['mUrl'] ) : '';
		isset ( $object ['source'] ) ? $this->setSource ( $object ['source'] ) : '';
		isset ( $object ['videos'] ) ? $this->setVideos ( $object ['videos'] ) : '';
		isset ( $object ['gender'] ) ? $this->setGender ( $object ['gender'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['company'] ) ? $this->setCompany ( $object ['company'] ) : '';
		isset ( $object ['positions'] ) ? $this->setPositions ( $object ['positions'] ) : '';
		isset ( $object ['website'] ) ? $this->setWebsite ( $object ['website'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['userId'] ) ? $this->setUserId ( $object ['userId'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getIdObjEn(){
		return $this->idObjEn;
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



	function getDocument(){
		return $this->document;
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



	function getSubPages(){
		return $this->subPages;
	}



	function getCleanTitle(){
		return $this->cleanTitle;
	}



	function getCleanContent(){
		return $this->cleanContent;
	}



	function getMTitle(){
		return $this->mTitle;
	}



	function getMKeyword(){
		return $this->mKeyword;
	}



	function getMIntro(){
		return $this->mIntro;
	}



	function getMUrl(){
		return $this->mUrl;
	}



	function getSource(){
		return $this->source;
	}



	function getVideos(){
		return $this->videos;
	}



	function getGender(){
		return $this->gender;
	}



	function getEmail(){
		return $this->email;
	}



	function getCompany(){
		return $this->company;
	}



	function getPositions(){
		return $this->positions;
	}



	function getWebsite(){
		return $this->website;
	}



	function getPhone(){
		return $this->phone;
	}



	function getUserId(){
		return $this->userId;
	}



	function setId($id){
		$this->id=$id;
	}




	function setIdObjEn($idObjEn){
		$this->idObjEn=$idObjEn;
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




	function setDocument($document){
		$this->document=$document;
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




	function setSubPages($subPages){
		$this->subPages=$subPages;
	}




	function setCleanTitle($cleanTitle){
		$this->cleanTitle=$cleanTitle;
	}




	function setCleanContent($cleanContent){
		$this->cleanContent=$cleanContent;
	}




	function setMTitle($mTitle){
		$this->mTitle=$mTitle;
	}




	function setMKeyword($mKeyword){
		$this->mKeyword=$mKeyword;
	}




	function setMIntro($mIntro){
		$this->mIntro=$mIntro;
	}




	function setMUrl($mUrl){
		$this->mUrl=$mUrl;
	}




	function setSource($source){
		$this->source=$source;
	}




	function setVideos($videos){
		$this->videos=$videos;
	}




	function setGender($gender){
		$this->gender=$gender;
	}




	function setEmail($email){
		$this->email=$email;
	}




	function setCompany($company){
		$this->company=$company;
	}




	function setPositions($positions){
		$this->positions=$positions;
	}




	function setWebsite($website){
		$this->website=$website;
	}




	function setPhone($phone){
		$this->phone=$phone;
	}




	function setUserId($userId){
		$this->userId=$userId;
	}



		var		$id;

		var		$idObjEn;

		var		$catId;

		var		$title;

		var		$intro;

		var		$image;

		var		$document;

		var		$content;

		var		$infoUser;

		var		$postDate;

		var		$status;

		var		$index;

		var		$code;

		var		$subPages;

		var		$cleanTitle;

		var		$cleanContent;

		var		$mTitle;

		var		$mKeyword;

		var		$mIntro;

		var		$mUrl;

		var		$source;

		var		$videos;

		var		$gender;

		var		$email;

		var		$company;

		var		$positions;

		var		$website;

		var		$phone;

		var		$userId;
		
		var 	$module;

	
	/**
	*List fields in table
	**/
	var		$fields=array('id','idObjEn','catId','title','intro','image','document','content','infoUser','postDate','status','index','code','subPages','cleanTitle','cleanContent','mTitle','mKeyword','mIntro','mUrl','source','videos','gender','email','company','positions','website','phone','userId',);
	/**
	 * @return the $module
	 */
	public function getModule() {
		return $this->module;
	}

	/**
	 * @param field_type $module
	 */
	public function setModule($module) {
		$this->module = $module;
	}

}
