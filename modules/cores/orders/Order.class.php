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
	public $message	= NULL;
	private $userId = NULL;
	private $address= NULL;
	private $phone	= NULL;
	private $info 	= NULL;
	private $infoU 	= NULL;
	private $seri 	= NULL;
	private $total 	= NULL;
	private $UR		= NULL;

	public function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['orderId'] 		= $this->id) 		: '';
		isset ( $this->name ) 		? ($dbobj ['orderName'] 	= $this->name) 		: '';
		isset ( $this->address ) 	? ($dbobj ['orderAddress'] 	= $this->address) 	: '';
		isset ( $this->email ) 		? ($dbobj ['orderEmail'] 	= $this->email) 	: "";
		isset ( $this->message )	? ($dbobj ['orderMessage'] 	= $this->message) 	: "";
		isset ( $this->postdate ) 	? ($dbobj ['orderTime'] 	= $this->postdate) 	: '';
		isset ( $this->info ) 		? ($dbobj ['orderInfo'] 	= $this->info) 		: '';
		isset ( $this->infoU ) 		? ($dbobj ['orderInfoU'] 	= $this->infoU) 	: '';
		isset ( $this->phone ) 		? ($dbobj ['orderPhone'] 	= $this->phone) 	: '';
		isset ( $this->userId )		? ($dbobj ['userId'] 		= $this->userId) 	: "";
		isset ( $this->seri )		? ($dbobj ['orderSeri'] 	= $this->seri) 		: "";
		isset ( $this->status )		? ($dbobj ['orderStatus'] 	= $this->seri) 		: "";
		isset ( $this->UR )			? ($dbobj ['orderUR'] 		= $this->UR) 		: "";
		isset ( $this->total )		? ($dbobj ['orderTotal'] 	= $this->total) 	: "";
		return $dbobj;
	}
	/**
	 * @param $UR the $UR to set
	 */
	public function setUR($UR) {
		$this->UR = $UR;
	}
	public function getPayment(){
		global $bw,$vsLang;
		if($this->info)return "<a href='".$bw->vars['board_url']."/orders/infoPay/".$this->id."/' title='View payment'>View</a>";
//		else if($this->UR)return "<a href='".$bw->vars['board_url']."/orders/ReviewOrder/?".$this->UR."' title='View payment'>Confim</a>";
		return "<a href='".$bw->vars['board_url']."/orders/paymentpal/".$this->id."/' title='View payment'>Payment</a>";;
	}

	/**
	 * @return the $UR
	 */
	public function getUR() {
		return $this->UR;
	}

	/**
	 * @param $total the $total to set
	 */
	public function setTotal($total) {
		$this->total = $total;
	}

	/**
	 * @return the $total
	 */
	public function getTotal($number = true) {
            global $vsLang;
            if (APPLICATION_TYPE=='user' && $number){
			if ($this->total > 0){
				return number_format ( $this->total,0,"","." );
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->total;
	}

	/**
	 * @param $seri the $seri to set
	 */
	public function setSeri($seri) {
		$this->seri = $seri;
	}

	/**
	 * @return the $seri
	 */
	public function getSeri() {
		return $this->seri;
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
		isset ( $object ['orderInfo'] ) 	? $this->setInfo ( $object ['orderInfo'] )		: '';
		isset ( $object ['orderInfoU'] ) 	? $this->setInfoU ( $object ['orderInfoU'] )	: '';
		isset ( $object ['orderSeri'] ) 	? $this->setSeri ( $object ['orderSeri'] )		: '';
		isset ( $object ['orderUR'] ) 		? $this->setUR ( $object ['orderUR'] )			: '';
		isset ( $object ['orderTotal'] ) 	? $this->setTotal ( $object ['orderTotal'] )	: '';

	}

	/**
	 * @return the $info
	 */
	public function getInfo() {
		return unserialize($this->info);
	}

	/**
	 * @param $info the $info to set
	 */
	public function setInfo($info) {
		$this->info = serialize($info);
	}


        public function getInfoU() {
		return unserialize($this->infoU);
	}

	public function getU($fu = '') {
		$temp = unserialize($this->getInfoU());
		return $fu ? $temp[$fu] : $tmp;
	}

	/**
	 * @param $info the $info to set
	 */
	public function setInfoU($infoU) {
		$this->infoU = serialize($infoU);
	}

	public function getAddress() {
		return $this->address;
	}

	/**
	 * @param $address the $address to set
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	public function getName() {
		return $this->name;
	}

	/**
	 * @return the $phone
	 */
	public function getPhone() {
		return str_replace("#", "", $this->phone);
	}

	/**
	 * @return the $fax
	 */
	public function getFax() {
		return $this->fax;
	}

	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}

	/**
	 * @return the $note
	 */
	public function getNote() {
		return $this->note;
	}

	/**
	 * @return the $message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return the $userId
	 */
	public function getUserId() {
		return $this->userId;
	}

	/**
	 * @param $name the $name to set
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param $phone the $phone to set
	 */
	public function setPhone($phone) {
		$this->phone = "#".$phone;
	}

	/**
	 * @param $fax the $fax to set
	 */
	public function setFax($fax) {
		$this->fax = $fax;
	}

	/**
	 * @param $email the $email to set
	 */
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param $note the $note to set
	 */
	public function setNote($note) {
		$this->note = $note;
	}

	/**
	 * @param $message the $message to set
	 */
	public function setMessage($message) {
		$this->message = $message;
	}

	/**
	 * @param $userId the $userId to set
	 */
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
}
?>
