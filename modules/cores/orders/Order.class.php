<?php
/*
+-----------------------------------------------------------------------------
|   VIET SOLUTION SJC  base on IPB Code version 3.0.0
|	Author: tongnguyen
|	Start Date: 5/04/2009
|	Finish Date: 11/04/2009
|	moduleName Description: This module is for management all languages in system.
+-----------------------------------------------------------------------------
*/

class Order extends BasicObject{
	private $name 	= NULL;
	private $email 	= NULL;
	public 	$message	= NULL;
	private $userId = NULL;
	private $address= NULL;
	private $phone	= NULL;
	private $info 	= NULL;
	private $total 	= NULL;
	private $location = NULL;
	private $shipping = NULL;
	
	public function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['orderId'] 		= $this->id) 		: '';
		isset ( $this->name ) 		? ($dbobj ['orderName'] 	= $this->name) 		: '';
		isset ( $this->address ) 	? ($dbobj ['orderAddress'] 	= $this->address) 	: '';
		isset ( $this->email ) 		? ($dbobj ['orderEmail'] 	= $this->email) 	: "";
		isset ( $this->postdate ) 	? ($dbobj ['orderTime'] 	= $this->postdate) 	: '';
		isset ( $this->info ) 		? ($dbobj ['orderInfo'] 	= $this->info) 		: '';
		isset ( $this->phone ) 		? ($dbobj ['orderPhone'] 	= $this->phone) 	: '';
		isset ( $this->userId )		? ($dbobj ['userId'] 		= $this->userId) 	: "";
		isset ( $this->status )		? ($dbobj ['orderStatus'] 	= $this->status) 	: "";
		isset ( $this->total )		? ($dbobj ['orderTotal'] 	= $this->total) 	: "";
		isset ( $this->location )	? ($dbobj ['orderLocation'] 	= $this->location) 	: "";
		isset ( $this->shipping )	? ($dbobj ['orderShipping'] 	= $this->shipping) 	: "";
		return $dbobj;
	}
	
function convertToObject($object) {
		isset ( $object ['orderId'] ) 		? $this->setId ( $object ['orderId'] ) 			: '';
		isset ( $object ['orderName'] ) 	? $this->setName( $object ['orderName'] ) 		: '';
		isset ( $object ['orderAddress'] ) 	? $this->setAddress ( $object ['orderAddress'] ): '';
		isset ( $object ['orderEmail'] ) 	? $this->setEmail ( $object ['orderEmail'] ) 	: '';
		isset ( $object ['orderMessage'] ) 	? $this->setMessage ( $object ['orderMessage'] ): '';
		isset ( $object ['userId'] ) 		? $this->setUserId ( $object ['userId'] )		: '';
		isset ( $object ['orderTime'] ) 	? $this->setPostDate ( $object ['orderTime'] )	: '';
		isset ( $object ['orderPhone'] ) 	? $this->setPhone ( $object ['orderPhone'] )	: '';
		isset ( $object ['orderLocation'] ) ? $this->setLocation ( $object ['orderLocation'] )	: '';
		isset ( $object ['orderLocation'] ) ? $this->setLocation ( $object ['orderLocation'] )	: '';
		isset ( $object ['orderInfo'] ) 	? $this->setInfo ( $object ['orderInfo'] )		: '';
		isset ( $object ['orderInfoU'] ) 	? $this->setInfoU ( $object ['orderInfoU'] )	: '';
		isset ( $object ['orderSeri'] ) 	? $this->setSeri ( $object ['orderSeri'] )		: '';
		isset ( $object ['orderUR'] ) 		? $this->setUR ( $object ['orderUR'] )			: '';
		isset ( $object ['orderTotal'] ) 	? $this->setTotal ( $object ['orderTotal'] )	: '';
        isset ( $object ['orderLocation'] ) ?( $this->location = $object ['orderLocation'] )	: '';
        isset ( $object ['orderShipping'] ) ?( $this->shipping = $object ['orderShipping'] )	: '';        
	}
	
	public function getPayment(){
		global $bw,$vsLang;
		if($this->info)return "<a href='".$bw->vars['board_url']."/orders/infoPay/".$this->id."/' title='View payment'>View</a>";
//		else if($this->UR)return "<a href='".$bw->vars['board_url']."/orders/ReviewOrder/?".$this->UR."' title='View payment'>Confim</a>";
		return "<a href='".$bw->vars['board_url']."/orders/paymentpal/".$this->id."/' title='View payment'>Payment</a>";;
	}

	public function setTotal($total) {
		$this->total = $total;
	}


	function getTotal($number = true) {
		global $vsLang;
		if(APPLICATION_TYPE=='user' && $number){
			if ($this->total > 0){
				return number_format ( $this->total, 2, ",", "." );
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->total;
	}


	

	public function getInfo() {
		return unserialize($this->info);
	}

	public function setInfo($info) {
		$this->info = serialize($info);
	}
	

      
	public function getAddress() {
		return $this->address;
	}


	public function setAddress($address) {
		$this->address = $address;
	}

	public function getName() {
		return $this->name;
	}

	public function getPhone() {
		return $this->phone;
	}

	
	public function getEmail() {
		return $this->email;
	}

	
	public function getUserId() {
		return $this->userId;
	}


	public function setName($name) {
		$this->name = $name;
	}


	public function setPhone($phone) {
		$this->phone = $phone;
	}

	
	public function setEmail($email) {
		$this->email = $email;
	}

	
	public function setUserId($userId) {
		$this->userId = $userId;
	}

	 function validate() {
		$status = true;
		if ($this->name == "") {
			$this->message .= " title can not be blank!";
			$status = false;
		}
		return $status;
	}
	public function getLocation() {
		return $this->location;
	}

	public function getShipping($format = false){
		
		if ($this->shipping > 0 && $format){
			return number_format($this->shipping, 2, ". ", ", ");
		}
		return $this->shipping;
	}

	public function setLocation($location) {
		$this->location = $location;
	}

	public function setShipping($shipping) {
		$this->shipping = $shipping;
	}

}
?>