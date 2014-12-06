<?php 

class User extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->password ) ? ($dbobj ['password'] = $this->password) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->firstName ) ? ($dbobj ['firstName'] = $this->firstName) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->gender ) ? ($dbobj ['gender'] = $this->gender) : '';
		isset ( $this->minutes ) ? ($dbobj ['minutes'] = $this->minutes) : '';
		isset ( $this->hour ) ? ($dbobj ['hour'] = $this->hour) : '';
		isset ( $this->day ) ? ($dbobj ['day'] = $this->day) : '';
		isset ( $this->month ) ? ($dbobj ['month'] = $this->month) : '';
		isset ( $this->year ) ? ($dbobj ['year'] = $this->year) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->mobile ) ? ($dbobj ['mobile'] = $this->mobile) : '';
		isset ( $this->company ) ? ($dbobj ['company'] = $this->company) : '';
		isset ( $this->interested ) ? ($dbobj ['interested'] = $this->interested) : '';
		isset ( $this->fax ) ? ($dbobj ['fax'] = $this->fax) : '';
		isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
		isset ( $this->province ) ? ($dbobj ['province'] = $this->province) : '';
		isset ( $this->skype ) ? ($dbobj ['skype'] = $this->skype) : '';
		isset ( $this->yahoo ) ? ($dbobj ['yahoo'] = $this->yahoo) : '';
		isset ( $this->country ) ? ($dbobj ['country'] = $this->country) : '';
		isset ( $this->score ) ? ($dbobj ['score'] = $this->score) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->location ) ? ($dbobj ['location'] = $this->location) : '';
		
		isset ( $this->catecity ) ? ($dbobj ['catecity'] = $this->catecity) : '';
		
		isset ( $this->idthue ) ? ($dbobj ['idthue'] = $this->idthue) : '';
		
		isset ( $this->bophan ) ? ($dbobj ['bophan'] = $this->bophan) : '';
		
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		
		return $dbobj;

	}





	public	function convertToObject($object = array()){
//		print  "<pre>";
//		print_r ($object);
//		print  "<pre>";
//		exit();
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['password'] ) ? $this->setPassword ( $object ['password'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['firstName'] ) ? $this->setFirstName ( $object ['firstName'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['gender'] ) ? $this->setGender ( $object ['gender'] ) : '';
		isset ( $object ['minutes'] ) ? $this->setMinutes ( $object ['minutes'] ) : '';
		isset ( $object ['hour'] ) ? $this->setHour ( $object ['hour'] ) : '';
		isset ( $object ['day'] ) ? $this->setDay ( $object ['day'] ) : '';
		isset ( $object ['month'] ) ? $this->setMonth ( $object ['month'] ) : '';
		isset ( $object ['year'] ) ? $this->setYear ( $object ['year'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['mobile'] ) ? $this->setMobile ( $object ['mobile'] ) : '';
		isset ( $object ['company'] ) ? $this->setCompany ( $object ['company'] ) : '';
		isset ( $object ['interested'] ) ? $this->setInterested ( $object ['interested'] ) : '';
		isset ( $object ['fax'] ) ? $this->setFax ( $object ['fax'] ) : '';
		isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
		isset ( $object ['province'] ) ? $this->setProvince ( $object ['province'] ) : '';
		isset ( $object ['skype'] ) ? $this->setSkype ( $object ['skype'] ) : '';
		isset ( $object ['yahoo'] ) ? $this->setYahoo ( $object ['yahoo'] ) : '';
		isset ( $object ['country'] ) ? $this->setCountry ( $object ['country'] ) : '';
		isset ( $object ['score'] ) ? $this->setScore ( $object ['score'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['location'] ) ? $this->setLocation ( $object ['location'] ) : '';
		isset ( $object ['catecity'] ) ? $this->setcatecity ( $object ['catecity'] ) : '';
		
		isset ( $object ['idthue'] ) ? $this->setIdThue ( $object ['idthue'] ) : '';
		
		isset ( $object ['bophan'] ) ? $this->setBophan ( $object ['bophan'] ) : '';
		
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';

	}

	var $timeStart;
	
	var $timeEnd;
	
	var $type;



	/**
	 * @return the $timeStart
	 */
	/**
	 * @return the $type
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * @param field_type $type
	 */
	public function setType($type) {
		$this->type = $type;
	}


	function getId(){
		return $this->id;
	}



	function getName(){
		return $this->name;
	}



	function getPassword(){
		return $this->password;
	}



	function getEmail(){
		return $this->email;
	}



	function getPostDate(){
		return $this->postDate;
	}



	function getStatus(){
		return $this->status;
	}



	function getImage(){
		return $this->image;
	}



	function getFirstName(){
		return $this->firstName;
	}



	function getTitle(){
		return $this->title;
	}



	function getGender(){
		return $this->gender;
	}



	function getMinutes(){
		return $this->minutes;
	}



	function getHour(){
		return $this->hour;
	}



	function getDay(){
		return $this->day;
	}



	function getMonth(){
		return $this->month;
	}



	function getYear(){
		return $this->year;
	}



	function getPhone(){
		return $this->phone;
	}



	function getMobile(){
		return $this->mobile;
	}



	function getCompany(){
		return $this->company;
	}



	function getInterested(){
		return $this->interested;
	}



	function getFax(){
		return $this->fax;
	}



	function getAddress(){
		return $this->address;
	}



	function getProvince(){
		return $this->province;
	}



	function getSkype(){
		return $this->skype;
	}



	function getYahoo(){
		return $this->yahoo;
	}



	function getCountry(){
		return $this->country;
	}



	function getScore(){
		return $this->score;
	}



	function getIntro(){
		return $this->intro;
	}



	function getLocation(){
		return $this->location;
	}



	function setId($id){
		$this->id=$id;
	}




	function setName($name){
		$this->name=$name;
	}




	function setPassword($password){
		$this->password=$password;
	}




	function setEmail($email){
		$this->email=$email;
	}




	function setPostDate($postDate){
		$this->postDate=$postDate;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setFirstName($firstName){
		$this->firstName=$firstName;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setGender($gender){
		$this->gender=$gender;
	}




	function setMinutes($minutes){
		$this->minutes=$minutes;
	}




	function setHour($hour){
		$this->hour=$hour;
	}




	function setDay($day){
		$this->day=$day;
	}




	function setMonth($month){
		$this->month=$month;
	}




	function setYear($year){
		$this->year=$year;
	}




	function setPhone($phone){
		$this->phone=$phone;
	}




	function setMobile($mobile){
		$this->mobile=$mobile;
	}




	function setCompany($company){
		$this->company=$company;
	}




	function setInterested($interested){
		$this->interested=$interested;
	}




	function setFax($fax){
		$this->fax=$fax;
	}




	function setAddress($address){
		$this->address=$address;
	}




	function setProvince($province){
		$this->province=$province;
	}




	function setSkype($skype){
		$this->skype=$skype;
	}




	function setYahoo($yahoo){
		$this->yahoo=$yahoo;
	}




	function setCountry($country){
		$this->country=$country;
	}




	function setScore($score){
		$this->score=$score;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setLocation($location){
		$this->location=$location;
	}
	
	
	
	function getCatecity(){
			return $this->catecity;
		}
		
	function setCatecity($catecity){
			$this->catecity=$catecity;
	}
	
function getIdThue(){
			return $this->idthue;
		}
		
	function setIdThue($idthue){
			$this->idthue=$idthue;
	}
	
	
	function getBophan(){
			return $this->bophan;
		}
		
	function setBophan($bophan){
			$this->bophan=$bophan;
	}	
		


		var		$id;

		var		$name;

		var		$password;

		var		$email;

		var		$postDate;

		var		$status;

		var		$image;

		var		$firstName;

		var		$title;

		var		$gender;

		var		$minutes;

		var		$hour;

		var		$day;

		var		$month;

		var		$year;

		var		$phone;

		var		$mobile;

		var		$company;

		var		$interested;

		var		$fax;

		var		$address;

		var		$province;

		var		$skype;

		var		$yahoo;

		var		$country;

		var		$score;

		var		$intro;

		var		$location;
		
		var		$catecity;
		
		var		$idthue;
		
		
		function getComment(){
			VSFactory::createConnectionDB()->query("select count(*) as vscount from vsf_comment where userId='{$this->getId()}'");
			$row=VSFactory::createConnectionDB()->fetch_row();
			return intval($row['vscount']);
		}
}
