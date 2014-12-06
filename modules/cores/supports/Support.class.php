<?php 

class Support extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->nickName ) ? ($dbobj ['nickName'] = $this->nickName) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->yahoo ) ? ($dbobj ['yahoo'] = $this->yahoo) : '';
		isset ( $this->skype ) ? ($dbobj ['skype'] = $this->skype) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['nickName'] ) ? $this->setNickName ( $object ['nickName'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['yahoo'] ) ? $this->setYahoo ( $object ['yahoo'] ) : '';
		isset ( $object ['skype'] ) ? $this->setSkype ( $object ['skype'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getNickName(){
		return $this->nickName;
	}



	function getPhone(){
		return $this->phone;
	}



	function getEmail(){
		return $this->email;
	}



	function getYahoo(){
		return $this->yahoo;
	}



	function getSkype(){
		return $this->skype;
	}



	function getTitle(){
		return $this->title;
	}



	function getIndex(){
		return $this->index;
	}



	function getType(){
		return $this->type;
	}



	function getStatus(){
		return $this->status;
	}



	function getCatId(){
		return $this->catId;
	}



	function setId($id){
		$this->id=$id;
	}




	function setNickName($nickName){
		$this->nickName=$nickName;
	}




	function setPhone($phone){
		$this->phone=$phone;
	}




	function setEmail($email){
		$this->email=$email;
	}




	function setYahoo($yahoo){
		$this->yahoo=$yahoo;
	}




	function setSkype($skype){
		$this->skype=$skype;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setType($type){
		$this->type=$type;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setCatId($catId){
		$this->catId=$catId;
	}



		var		$id;

		var		$nickName;

		var		$phone;

		var		$email;

		var		$yahoo;

		var		$skype;

		var		$title;

		var		$index;

		var		$type;

		var		$status;

		var		$catId;
}
