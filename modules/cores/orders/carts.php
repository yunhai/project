<?php

class carts {
	static function setQuantity($key,$quantity){
		if(isset($_SESSION['vs_item_cart'][$key])){
			
			$item = $_SESSION['vs_item_cart'][$key];
			$_SESSION['total'] += ($quantity-$item['quantity'])*($item['saleOff']?$item['saleOff']:$item['price']);
			$_SESSION['vs_item_cart'][$key]['quantity']=$quantity;
			if($quantity===0) unset($_SESSION['vs_item_cart'][$key]['quantity']);
			
		}
	}
	/**
	 * @param Order_item $order_item
	 * Enter description here ...
	 */
	
	
	static function addItem($productId,$type="",$quantity=1){
		global $bw;
		if(isset($_SESSION['vs_item_cart'][$productId.$type])){
			$_SESSION['vs_item_cart'][$productId.$type]['quantity']+=$quantity;
			$item = $_SESSION['vs_item_cart'][$productId.$type];
			$_SESSION['total'] += $item['quantity']*$item['saleOff']?$item['saleOff']:$item['price'];
			return true;
		}
		
		require_once CORE_PATH.'products/products.php';
		$products=new products();
		$products->getObjectById($productId);
		if(!$products->basicObject->getId()){
			carts::$message=VSFactory::getLangs()->getWords('product_not_found','Không tìm thấy sản phẩm');
			return false;
		}
		
		$order_items=new order_items();
		
		$price = $products->basicObject->getPrice();
		$info = $products->basicObject->getInfo();
		
		$order_items->basicObject->setProductId($products->basicObject->getId());
		$order_items->basicObject->setType($type);
		$order_items->basicObject->setTitle($products->basicObject->getTitle());
		$order_items->basicObject->setQuantity($quantity);
		$order_items->basicObject->setPrice($products->basicObject->getPrice());
		if($products->basicObject->getPromotionPrice())
			$order_items->basicObject->setSaleOff($price-($price*($products->basicObject->getPromotionPrice()/100)));
		
		$item = $order_items->basicObject->convertToDB();
		$_SESSION['total'] += $item['saleOff']?$item['saleOff']:$item['price'];
		$item['size'] = $bw->input['size'];
		$item['code'] = $products->basicObject->getCode();
		$_SESSION['vs_item_cart'][$order_items->basicObject->getProductId().$order_items->basicObject->getType()]=$item;
		$_SESSION['vs_item_cart'][$order_items->basicObject->getProductId().$order_items->basicObject->getType()]['image']=$products->basicObject->getImage();
		return true;
	}
	/**
	 * 
	 * Enter description here ...
	 * @param int
	 */
	static function resetCart(){
		$_SESSION['vs_item_cart']=array();
	}
	/**
	 * 
	 * Enter description here ...
	 * @param int
	 */
	static function removeItem($key){
		$item = $_SESSION['vs_item_cart'][$key];
		
		$_SESSION['total'] = $_SESSION['total'] - $item['quantity']*($item['saleOff']?$item['saleOff']:$item['price']);
		unset($_SESSION['vs_item_cart'][$key]);
	}
	static function update(){
		
	}
	/**
	 * 
	 * Enter description here ...
	 * @param Order $order
	 */
	static function insertToDB($order){
		global $bw;
		if(!$order->getId()){
			$orders=new orders();
			$orders->insertObject($order);
			$order=$orders->basicObject;
		}
		$order_items=new order_items();
		if(array($_SESSION['vs_item_cart'])){
			foreach ($_SESSION['vs_item_cart'] as $index=> $value) {
				$order_item=new Order_item();
				$order_item->convertToObject($value);
				$order_item->setOrderId($order->getId());
				$order_item->setInfo($value['size']);
				$order_items->insertObject($order_item);
			}
		}
	}
	/**
	 * @return Order
	 * Enter description here ...
	 */
	static function getCartInfo(){
		$order=new Order();
		if(is_array($_SESSION['vs_item_cart'])){
			foreach ($_SESSION['vs_item_cart'] as $index=> $value) {
				$order->total+=$value['quantity']*$value['price'];
				$order->quantity+=$value['quantity'];
			}
		}
		return $order;
		
	}
	/**
	 * 
	 * Enter description here ...
	 * @var string
	 */
	static  $message;
}

?>