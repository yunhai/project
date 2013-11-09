<?php
class OrderItem extends BasicObject{
	private $orderId 	= NULL;
	private $productId 	= NULL;
	private $unitprice	= NULL;
	private $quantity	= NULL;
	private $info		= NULL;
	private $charge 	= NULL;
	private $refprice 	= NULL;

	
	
	
	public function convertToDB() {
		isset ( $this->id) 				? ($object["itemId"]			= $this->id)			:"" ;
		isset ( $this->orderId ) 		? ($dbobj ['orderId'] 			= $this->orderId) 		: '';
		isset ( $this->productId ) 		? ($dbobj ['productId'] 		= $this->productId) 	: '';
		isset ( $this->title )			? ($dbobj ['itemTitle'] 		= $this->title) 		: "";
		isset ( $this->unitprice ) 		? ($dbobj ['itemUnitPrice'] 	= $this->unitprice) 	: '';
		isset ( $this->quantity ) 		? ($dbobj ['itemQuantity'] 		= $this->quantity) 		: "";
		isset ( $this->price ) 			? ($dbobj ['itemPrice'] 		= $this->price) 		: '';
		isset ( $this->postdate ) 		? ($dbobj ['itemDate'] 			= $this->postdate) 		: '';
		isset ( $this->status ) 		? ($dbobj ['itemStatus'] 		= $this->status) 		: '';
		isset ( $this->info ) 			? ($dbobj ['itemInfo'] 			= $this->info) 			: '';
		isset ( $this->charge ) 		? ($dbobj ['itemCharge'] 		= $this->charge) 		: "";
		isset ( $this->refprice ) 		? ($dbobj ['itemRefPrice'] 		= $this->refprice) 		: "";
		return $dbobj;
	}
	
	function convertToObject($object) {
		isset ( $object ['itemId'] ) 		? $this->setId ( $object ['itemId'] ) 				: '';
		isset ( $object ['orderId'] ) 		? $this->setOrderId( $object ['orderId'] ) 			: '';
		isset ( $object ['productId'] ) 	? $this->setProductId ( $object ['productId'] ) 	: '';
		isset ( $object ['itemTitle'])		? $this->setTitle ( $object ['itemTitle'] ) 		: '';
		isset ( $object ['itemUnitPrice'])	? $this->setUnitprice( $object ['itemUnitPrice'] ) 	: '';
		isset ( $object ['itemQuantity'] ) 	? $this->setQuantity ( $object ['itemQuantity'])	: '';
		isset ( $object ['itemPrice'])		? $this->setPrice( $object ['itemPrice'] ) 			: '';
		
		isset ( $object ['itemDate'])		? $this->setPostDate ( $object ['itemDate'] ) 		: '';
		isset ( $object ['itemStatus'])		? $this->setStatus ( $object ['itemStatus'] ) 		: '';
		isset ( $object ['itemInfo'])		? $this->setInfo($object ['itemInfo']) 				: '';
		isset ( $object ['itemCharge'])		? $this->setCharge($object ['itemCharge']) 			: '';
		isset ( $object ['itemRefPrice'])	? $this->setRefprice($object ['itemRefPrice']) 		: '';
	}

	function __construct(){
	}
	
	function __destruct(){
	}
	public function getOrderId() {
		return $this->orderId;
	}

	public function getProductId() {
		return $this->productId;
	}

	public function getUnitprice() {
		return $this->unitprice;
	}

	public function getQuantity() {
		return $this->quantity;
	}
	
	function getPrice($number = true){
		if($number){
			global $vsLang;
			if(!$this->price) return $vsLang->getWords ( 'callprice', 'Call');
			return number_format($this->price, 2, ".", ",");
		}
		return $this->price;
	}

	public function getInfo($array = false){
		if($array){
			global $vsLang;
			$info = unserialize($this->info);
			
			return <<<EOF
				<p>
					<b>{$vsLang->getWords('width','Width')}:</b> &nbsp;{$info['width']}
				</p>
				<p>
					<b>{$vsLang->getWords('drop','Drop')}:</b>&nbsp;{$info['drop']}
				</p>
				<p>
					<b>{$vsLang->getWords('color','Color')}:</b>&nbsp;{$info['color']}
				</p>
				<p>
					<b>{$vsLang->getWords('mounttype','Mount Type')}:</b>&nbsp;{$info['mounttype']}
				</p>
				<p>
					<b>{$vsLang->getWords('operatingside','Operating Side')}:</b>&nbsp;{$info['operatingside']}
				</p>
EOF;
		}
		return $this->info;
		
	}

	public function getCharge() {
		return $this->charge;
	}

	public function getRefprice() {
		return $this->refprice;
	}

	public function setOrderId($orderId) {
		$this->orderId = $orderId;
	}

	public function setProductId($productId) {
		$this->productId = $productId;
	}

	public function setUnitprice($unitprice) {
		$this->unitprice = $unitprice;
	}

	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}
	public function setPrice($charge) {
		$this->price = $charge;
	}
	public function setInfo($info) {
		$this->info = $info;
	}

	public function setCharge($charge) {
		$this->charge = $charge;
	}

	public function setRefprice($refprice) {
		$this->refprice = $refprice;
	}
}
?>