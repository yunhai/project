<?php
class Option extends BasicObject {
	private $default = NULL;

	private $priceOld = NULL;
	private $productId = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		unset ( $this->price );
		unset ( $this->default );
		unset ( $this->productId );
	}

	public function convertToDB() {
		//		isset ( $this->id ) 	? ($dbobj ['optId'] 	= $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['optTitle'] = $this->title) : '';
		isset ( $this->default ) ? ($dbobj ['optDefault'] = $this->default) : '';
		isset ( $this->productId ) ? ($dbobj ['productId'] = $this->productId) : '';
		isset ( $this->price ) ? ($dbobj ['optPrice'] = $this->price) : '';
		isset ( $this->priceOld ) ? ($dbobj ['optPriceOld'] = $this->priceOld) : '';
		isset ( $this->status ) ? ($dbobj ['optStatus'] = $this->status) : '';
		return $dbobj;
	}

	function convertToObject($object) {
		global $vsMenu;
		isset ( $object ['optId'] ) ? $this->setId ( $object ['optId'] ) : '';
		isset ( $object ['optTitle'] ) ? $this->setTitle ( $object ['optTitle'] ) : '';
		isset ( $object ['optDefault'] ) ? $this->setDefault ( $object ['optDefault'] ) : '';
		isset ( $object ['productId'] ) ? $this->setProductId ( $object ['productId'] ) : '';
		isset ( $object ['optPrice'] ) ? $this->setPrice ( $object ['optPrice'] ) : '';
		isset ( $object ['optPriceOld'] ) ? $this->setPriceOld ( $object ['optPriceOld'] ) : '';
		isset ( $object ['optStatus'] ) ? $this->setStatus ( $object ['optStatus'] ) : '';
	}

	function validate() {
		$status = true;

		if ($this->title == "") {
			$this->message .= "Title can not be blank!";
			$status = false;
		}
		return $status;
	}
	/**
	 * @return the $default
	 */
	public function getDefault() {
		return $this->default;
	}

	/**
	 * @return the $price
	 */
	public function getPrice($number = true) {
		global $vsLang;
		if (APPLICATION_TYPE == 'user' && $number) {
			if ($this->price > 0) {
				return number_format ( $this->price ,0, "", ",");
			}
			return $vsLang->getWords ( 'callprice', 'Call' );
		}
		return $number ? number_format ($this->price ,0, "", ",") : $this->price;
	}

	/**
	 * @return the $productId
	 */
	public function getPriceOld($number = true) {
		global $vsLang;
		if (APPLICATION_TYPE == 'user' && $number) {
			if ($this->priceOld > 0) {
				return number_format ( $this->priceOld,0,"","," );
			}
		}
		return $this->priceOld;
	}

	public function setPriceOld($priceOld) {
		$this->priceOld = $priceOld;
	}

	public function getProductId() {
		return $this->productId;
	}

	/**
	 * @param $default the $default to set
	 */
	public function setDefault($default) {
		$this->default = $default;
	}

	/**
	 * @param $price the $price to set
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @param $productId the $productId to set
	 */
	public function setProductId($productId) {
		$this->productId = $productId;
	}

}
