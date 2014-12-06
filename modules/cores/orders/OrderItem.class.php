<?php
class OrderItem extends BasicObject{
	private $orderId 	= NULL;
	private $productId 	= NULL;
	private $quantity 	= 0;
	private $saleOff 	= NULL;
	private $price		= 0;
	private $info		= NULL;
	
	/**
	 * CONSTRUCT
	 */
	function __construct(){
		
	}
	
	function __destruct(){
		unset($this->id);
		unset($this->orderId);
		unset($this->productId);
		unset($this->quantity);
		unset($this->saleOff);
		unset($this->price);
	}
	
	/**
	 * change order detail to array to insert database
	 *
	 * @return array $dbObj
	 */
	public function convertToDB() {
		isset ( $this->id) 				? ($object["itemId"]			= $this->id)			:"" ;
		isset ( $this->orderId ) 		? ($dbobj ['orderId'] 			= $this->orderId) 		: '';
		isset ( $this->productId ) 		? ($dbobj ['productId'] 		= $this->productId) 	: '';
		isset ( $this->quantity ) 		? ($dbobj ['itemQuantity'] 		= $this->quantity) 		: "";
		isset ( $this->price ) 			? ($dbobj ['itemPrice'] 		= $this->price) 		: '';
		isset ( $this->saleOff ) 		? ($dbobj ['itemSaleOff'] 		= $this->saleOff) 		: "";
		isset ( $this->title )			? ($dbobj ['itemTitle'] 		= $this->title) 		: "";
		isset ( $this->postdate ) 		? ($dbobj ['itemDate'] 			= $this->postdate) 		: '';
		isset ( $this->status ) 		? ($dbobj ['itemStatus'] 		= $this->status) 		: '';
		isset ( $this->info ) 			? ($dbobj ['itemInfo'] 			= $this->info) 			: '';
		return $dbobj;
	}
	/**
	 * Change order item form database object to orderitem object
	 * @param unknown_type $object
	 */
	function convertToObject($object) {
		isset ( $object ['itemId'] ) 		? $this->setId ( $object ['itemId'] ) 				: '';
		isset ( $object ['orderId'] ) 		? $this->setOrderId( $object ['orderId'] ) 			: '';
		isset ( $object ['productId'] ) 	? $this->setProductId ( $object ['productId'] ) 	: '';
		isset ( $object ['itemQuantity'] ) 	? $this->setQuantity ( $object ['itemQuantity'])	: '';
		isset ( $object ['itemSaleOff'] ) 	? $this->setSaleOff ( $object ['itemSaleOff'] ) 	: '';
		isset ( $object ['itemPrice'])		? $this->setPrice( $object ['itemPrice'] ) 			: '';
		isset ( $object ['itemTitle'])		? $this->setTitle ( $object ['itemTitle'] ) 		: '';
		isset ( $object ['itemDate'])		? $this->setPostDate ( $object ['itemDate'] ) 		: '';
		isset ( $object ['itemStatus'])		? $this->setStatus ( $object ['itemStatus'] ) 		: '';
		isset ( $object ['itemInfo'])		? $this->setInfo ( $object ['itemInfo'] ) 			: '';
	}
	/**
	 * @return the $orderId
	 */
	/**
	 * @return the $price
	 */
	/**
	 * @return the $info
	 */
	public function getInfo() {
		return $this->info;
	}

	/**
	 * @param field_type $info
	 */
	public function setInfo($info) {
		$this->info = $info;
	}

	public function getPrice($number = true) {
		global $vsLang;
		if ($number) {
			if ($this->price > 0) {
				return number_format ( $this->price,0,"","." ) ;//number_format ( $this->price,2,".","" );
			}
			return $vsLang->getWords ( 'callprice', 'Call' );
		}
		return $number;
	}
        public function getTotal($number = true){
            if($number&&$this->price&&$this->quantity)return number_format ( $this->price *$this->quantity ,0,"","." );
            return $this->price *$this->quantity;
        }
	/**
	 * @param $price the $price to set
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	public function getOrderId() {
		return $this->orderId;
	}

	/**
	 * @return the $productId
	 */
	public function getProductId() {
		return $this->productId;
	}

	/**
	 * @return the $quantity
	 */
	public function getQuantity() {
		return $this->quantity;
	}

	/**
	 * @return the $saleOff
	 */
	public function getSaleOff() {
		return $this->saleOff;
	}

	/**
	 * @param $orderId the $orderId to set
	 */
	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	/**
	 * @param $productId the $productId to set
	 */
	public function setProductId($productId) {
		$this->productId = $productId;
	}

	/**
	 * @param $quantity the $quantity to set
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}

	/**
	 * @param $saleOff the $saleOff to set
	 */
	public function setSaleOff($saleOff) {
		$this->saleOff = $saleOff;
	}


}
?>