<?php

class Proposal extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->catIdPro ) ? ($dbobj ['catIdPro'] = $this->catIdPro) : '';
		isset ( $this->company ) ? ($dbobj ['company'] = $this->company) : '';
		isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->mobile ) ? ($dbobj ['mobile'] = $this->mobile) : '';
		isset ( $this->website ) ? ($dbobj ['website'] = $this->website) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->number ) ? ($dbobj ['number'] = $this->number) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->postdate ) ? ($dbobj ['postdate'] = $this->postdate) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->color ) ? ($dbobj ['color'] = $this->color) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['catIdPro'] ) ? $this->setCatIdPro ( $object ['catIdPro'] ) : '';
		isset ( $object ['company'] ) ? $this->setCompany ( $object ['company'] ) : '';
		isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['mobile'] ) ? $this->setMobile ( $object ['mobile'] ) : '';
		isset ( $object ['website'] ) ? $this->setWebsite ( $object ['website'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['number'] ) ? $this->setNumber ( $object ['number'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['postdate'] ) ? $this->setPostdate ( $object ['postdate'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['color'] ) ? $this->setColor ( $object ['color'] ) : '';

	}


	var 	$code;
	
	var		$color;
	


	/**
	 * @return the $code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return the $color
	 */
	public function getColor() {
		return $this->color;
	}

	/**
	 * @param field_type $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}

	/**
	 * @param field_type $color
	 */
	public function setColor($color) {
		$this->color = $color;
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



	function getCatIdPro(){
		return $this->catIdPro;
	}



	function getCompany(){
		return $this->company;
	}



	function getAddress(){
		return $this->address;
	}



	function getPhone(){
		return $this->phone;
	}



	function getMobile(){
		return $this->mobile;
	}



	function getWebsite(){
		return $this->website;
	}



	function getEmail(){
		return $this->email;
	}



	function getNumber(){
		return $this->number;
	}



	function getContent(){
		return $this->content;
	}



	function getStatus(){
		return $this->status;
	}



	function getPostdate(){
		return $this->postdate;
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




	function setCatIdPro($catIdPro){
		$this->catIdPro=$catIdPro;
	}




	function setCompany($company){
		$this->company=$company;
	}




	function setAddress($address){
		$this->address=$address;
	}




	function setPhone($phone){
		$this->phone=$phone;
	}




	function setMobile($mobile){
		$this->mobile=$mobile;
	}




	function setWebsite($website){
		$this->website=$website;
	}




	function setEmail($email){
		$this->email=$email;
	}




	function setNumber($number){
		$this->number=$number;
	}




	function setContent($content){
		$this->content=$content;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setPostdate($postdate){
		$this->postdate=$postdate;
	}



		var		$id;

		var		$catId;

		var		$title;

		var		$catIdPro;

		var		$company;

		var		$address;

		var		$phone;

		var		$mobile;

		var		$website;

		var		$email;

		var		$number;

		var		$content;

		var		$status;

		var		$postdate;

	
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','title','catIdPro','company','address','phone','mobile','website','email','number','content','status','postdate',);
}
