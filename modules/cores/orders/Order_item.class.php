<?php 

class Order_item extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->orderId ) ? ($dbobj ['orderId'] = $this->orderId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->productId ) ? ($dbobj ['productId'] = $this->productId) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->quantity ) ? ($dbobj ['quantity'] = $this->quantity) : '';
		isset ( $this->price ) ? ($dbobj ['price'] = $this->price) : '';
		isset ( $this->saleOff ) ? ($dbobj ['saleOff'] = $this->saleOff) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->info ) ? ($dbobj ['info'] = $this->info) : '';
		return $dbobj;

	}

	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['orderId'] ) ? $this->setOrderId ( $object ['orderId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['productId'] ) ? $this->setProductId ( $object ['productId'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['quantity'] ) ? $this->setQuantity ( $object ['quantity'] ) : '';
		isset ( $object ['price'] ) ? $this->setPrice ( $object ['price'] ) : '';
		isset ( $object ['saleOff'] ) ? $this->setSaleOff ( $object ['saleOff'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['info'] ) ? $this->setInfo ( $object ['info'] ) : '';

	}

	function getId(){
		return $this->id;
	}

	function getOrderId(){
		return $this->orderId;
	}



	function getTitle(){
		return $this->title;
	}



	function getProductId(){
		return $this->productId;
	}



	function getType(){
		return $this->type;
	}



	function getQuantity(){
		return $this->quantity;
	}



	function getPrice(){
		return $this->price;
	}



	function getSaleOff(){
		return $this->saleOff;
	}



	function getDate(){
		return $this->date;
	}



	function getStatus(){
		return $this->status;
	}



	function getInfo(){
		return $this->info;
	}



	function setId($id){
		$this->id=$id;
	}




	function setOrderId($orderId){
		$this->orderId=$orderId;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setProductId($productId){
		$this->productId=$productId;
	}




	function setType($type){
		$this->type=$type;
	}




	function setQuantity($quantity){
		$this->quantity=$quantity;
	}




	function setPrice($price){
		$this->price=$price;
	}




	function setSaleOff($saleOff){
		$this->saleOff=$saleOff;
	}




	function setDate($date){
		$this->date=$date;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setInfo($info){
		$this->info=$info;
	}



		var		$id;

		var		$orderId;

		var		$title;

		var		$productId;

		var		$type;

		var		$quantity;

		var		$price;

		var		$saleOff;

		var		$date;

		var		$status;

		var		$info;
}
