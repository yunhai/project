<?php 

class Pcontact extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
		isset ( $this->longitude ) ? ($dbobj ['longitude'] = $this->longitude) : '';
		isset ( $this->latitude ) ? ($dbobj ['latitude'] = $this->latitude) : '';
		isset ( $this->zoom ) ? ($dbobj ['zoom'] = $this->zoom) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->sname ) ? ($dbobj ['sname'] = $this->sname) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->pcontactMtTitle ) ? ($dbobj ['pcontactMtTitle'] = $this->pcontactMtTitle) : '';
		isset ( $this->mtKeyWord ) ? ($dbobj ['mtKeyWord'] = $this->mtKeyWord) : '';
		isset ( $this->mtDesc ) ? ($dbobj ['mtDesc'] = $this->mtDesc) : '';
		isset ( $this->mtUrl ) ? ($dbobj ['mtUrl'] = $this->mtUrl) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
		isset ( $object ['longitude'] ) ? $this->setLongitude ( $object ['longitude'] ) : '';
		isset ( $object ['latitude'] ) ? $this->setLatitude ( $object ['latitude'] ) : '';
		isset ( $object ['zoom'] ) ? $this->setZoom ( $object ['zoom'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['sname'] ) ? $this->setSname ( $object ['sname'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['pcontactMtTitle'] ) ? $this->setPcontactMtTitle ( $object ['pcontactMtTitle'] ) : '';
		isset ( $object ['mtKeyWord'] ) ? $this->setMtKeyWord ( $object ['mtKeyWord'] ) : '';
		isset ( $object ['mtDesc'] ) ? $this->setMtDesc ( $object ['mtDesc'] ) : '';
		isset ( $object ['mtUrl'] ) ? $this->setMtUrl ( $object ['mtUrl'] ) : '';

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



	function getIntro(){
		return $this->intro;
	}



	function getContent(){
		return $this->content;
	}



	function getImage(){
		return $this->image;
	}



	function getCode(){
		return $this->code;
	}



	function getIndex(){
		return $this->index;
	}



	function getAddress(){
		return $this->address;
	}



	function getLongitude(){
		return $this->longitude;
	}



	function getLatitude(){
		return $this->latitude;
	}



	function getZoom(){
		return $this->zoom;
	}



	function getEmail(){
		return $this->email;
	}



	function getSname(){
		return $this->sname;
	}



	function getStatus(){
		return $this->status;
	}



	function getPostDate(){
		return $this->postDate;
	}



	function getPcontactMtTitle(){
		return $this->pcontactMtTitle;
	}



	function getMtKeyWord(){
		return $this->mtKeyWord;
	}



	function getMtDesc(){
		return $this->mtDesc;
	}



	function getMtUrl(){
		return $this->mtUrl;
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




	function setContent($content){
		$this->content=$content;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setCode($code){
		$this->code=$code;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setAddress($address){
		$this->address=$address;
	}




	function setLongitude($longitude){
		$this->longitude=$longitude;
	}




	function setLatitude($latitude){
		$this->latitude=$latitude;
	}




	function setZoom($zoom){
		$this->zoom=$zoom;
	}




	function setEmail($email){
		$this->email=$email;
	}




	function setSname($sname){
		$this->sname=$sname;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setPostDate($postDate){
		$this->postDate=$postDate;
	}




	function setPcontactMtTitle($pcontactMtTitle){
		$this->pcontactMtTitle=$pcontactMtTitle;
	}




	function setMtKeyWord($mtKeyWord){
		$this->mtKeyWord=$mtKeyWord;
	}




	function setMtDesc($mtDesc){
		$this->mtDesc=$mtDesc;
	}




	function setMtUrl($mtUrl){
		$this->mtUrl=$mtUrl;
	}



		var		$id;

		var		$catId;

		var		$title;

		var		$intro;

		var		$content;

		var		$image;

		var		$code;

		var		$index;

		var		$address;

		var		$longitude;

		var		$latitude;

		var		$zoom;

		var		$email;

		var		$sname;

		var		$status;

		var		$postDate;

		var		$pcontactMtTitle;

		var		$mtKeyWord;

		var		$mtDesc;

		var		$mtUrl;
}
