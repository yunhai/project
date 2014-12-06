<?php
require_once (CORE_PATH . 'orders/orders.php');
require_once (CORE_PATH . 'orders/order_items.php');
require_once (CORE_PATH . 'orders/carts.php');
class orders_controler_public extends VSControl_public {

	function __construct($modelName) {
		global $vsTemplate, $bw;
		// $this->html=$vsTemplate->load_template("skin_product");
		parent::__construct ( $modelName, "skin_orders", "order", $bw->input [0] );
		// $this->model->categoryName=$bw->input[0];
	}

	public function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_addcart' :
				$this->addToCart ( $bw->input [2], $bw->input [3] );
				break;
			case $this->modelName . '_review' :
				$this->reviewCart ();
				break;
			case $this->modelName . '_delete_item' :
				$this->deleteItem ();
				break;
			case $this->modelName . '_delete_cart' :
				$this->deleteItem ();
				break;
			case $this->modelName . '_update' :
				$this->updateCart ();
				break;
			case $this->modelName . '_payment' :
				$this->payment ();
				break;
			case $this->modelName . '_payment_finish' :
				$this->paymentFinish ();
				break;
			case $this->modelName . '_address':
				$this->address();
				break;
			case $this->modelName . '_chek':
				$this->chek();
				break;
			default :
				parent::auto_run ();
				break;
		}
	}

	function showDefault() {
		
		return $this->reviewCart ( $_SESSION['message'] );
	}

	function reviewCart($option = array()) {
		global $bw,$vsStd;
		unset($_SESSION['message']);
		//echo 123;exit();
		
		if($bw->input['ok']){
				
				
			$this->model->obj->convertToObject($bw->input);
			$this->model->obj->setPostDate(time());
			$this->model->obj->setTotal($_SESSION['total']);
			carts::insertToDB($this->model->obj);
				
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
// 			$this->email = new Emailer ();
// 			$this->email->setTo ( $bw->input['email'] );
		
// 			$this->email->setFrom ( VSFactory::getSettings ()->getSystemKey ( "email_sender_sales", "sales@myphamthanhthuy.vn", "configs" ),"Idea Mobile" );
// 			$this->email->setSubject ( "Đặt hàng thành công!" );
// 			$this->email->setBody ( $this->html->showEmail($this->html->showOrderItem($_SESSION['vs_item_cart'],1,$this->model->obj)) );
// 			$this->email->sendMail ();
				
			$this->email = new Emailer ();
			$this->email->setTo ( VSFactory::getSettings ()->getSystemKey ( "email_receive_sales", "sales@myphamthanhthuy.vn", "configs" ) );
				
			$this->email->setFrom ( VSFactory::getSettings ()->getSystemKey ( "email_sender_sales", "sales@myphamthanhthuy.vn", "configs" ),"Idea Mobile" );
			$this->email->setSubject ( "Khách hàng '{$array['title']}' đặt hàng!" );
			$this->email->setBody ( $this->html->showOrderItem($_SESSION['vs_item_cart'],0,$this->model->obj) );
			$this->email->sendMail ();
				
			unset($_SESSION['vs_item_cart']);
			unset($_SESSION['total']);
			return $this->paymentFinish();
		}
		
		return $this->output = $this->html->reviewCart ( $option );
	}

	function deleteItem() {
		global $bw,$vsPrint;
		carts::removeItem ( $bw->input[2] );
		$result['status']=1;
		echo json_encode($result);exit();
		$vsPrint->boink_it($bw->base_url."orders");
		$_SESSION['message'] = "Đã xóa sản phẩm khỏi giỏ hàng";
		echo "ok";die;
	}

	function deleteCart() {
		global $bw;
		carts::resetCart ();
		return $this->reviewCart ( $option );
		// return $this->output=$this->html->deleteCart($option);
	}

	function updateCart() {
		global $bw;
		
	
		carts::setQuantity ( $bw->input[2], $bw->input[3] );
		$_SESSION['message'] = "Giỏ hàng cập nhật thành công";
		echo "ok";die;
	}

	function payment() {
		global $vsPrint,$vsUser,$bw,$vsStd;
		$vsPrint->mainTitle = $vsPrint->pageTitle = "Checkout";
		
		if($bw->input['ok']){
			$array = array("title"=>$bw->input['title'],"address"=>$bw->input['address'],"phone"=>$bw->input['phone'],"province"=>$_POST['province']['key']."|".$_POST['province']['name'],"city"=>$_POST['city']['key']."|".$_POST['city']['name']);
			
			
			
			$array['address'] = $array['address'].",".$_POST['city']['name'].",".$_POST['province']['name'];
			$this->model->obj->convertToObject($array);
			$this->model->obj->setPostDate(time()); 
			$this->model->obj->setTotal($_SESSION['total']);
			carts::insertToDB($this->model->obj);
			
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
			$this->email = new Emailer ();
			$this->email->setTo ( $bw->input['email'] );
				
			$this->email->setFrom ( VSFactory::getSettings ()->getSystemKey ( "email_sender_sales", "sales@myphamthanhthuy.vn", "configs" ),"Idea Mobile" );
			$this->email->setSubject ( "Đặt hàng thành công!" );
			$this->email->setBody ( $this->html->showEmail($this->html->showOrderItem($_SESSION['vs_item_cart'],1,$this->model->obj)) );
			$this->email->sendMail ();
			
			$this->email = new Emailer ();
			$this->email->setTo ( VSFactory::getSettings ()->getSystemKey ( "email_receive_sales", "sales@myphamthanhthuy.vn", "configs" ) );
			
			$this->email->setFrom ( VSFactory::getSettings ()->getSystemKey ( "email_sender_sales", "sales@myphamthanhthuy.vn", "configs" ),"Idea Mobile" );
			$this->email->setSubject ( "Khách hàng '{$vsUser->obj->getFirstName()}' đặt hàng!" );
			$this->email->setBody ( $this->html->showEmail($this->html->showOrderItem($_SESSION['vs_item_cart'],0,$this->model->obj)) );
			$this->email->sendMail ();
			
			unset($_SESSION['vs_item_cart']);
			unset($_SESSION['total']);
			return $this->paymentFinish();
		}
		
		return $this->output = $this->html->payment ( $option );
	}

	function chek(){
		return $this->output = $this->html->chek ( );
	}
	
	function paymentFinish() {
		return $this->output = $this->html->paymentFinish ( $option );
	}

	function addToCart($productId, $type =0) { 
		global $bw, $vsPrint;
		$productId=$bw->input['id'];
		
	
		
		intval ( $bw->input ['quantity'] ) ? $bw->input ['quantity'] = intval ( $bw->input ['quantity'] ) : $bw->input ['quantity'] = 1;
		if (! carts::addItem ( $productId, $type, $bw->input ['quantity'] )) {
			$result ['status'] = 0;
			$result ['message'] = carts::$message;
		} else {
			$result ['status'] = 1;
			$result ['message'] = VSFactory::getLangs ()->getWords ( 'order_item_added', 'Sản phẩm vừa được thêm vào giỏ hàng' );
		}
		if ($bw->input ['json']) {
			$result = array_merge ( $result, carts::getCartInfo ()->convertToDB () );
			echo json_encode ( $result );
			$vsPrint->_finish ();
		}
		
		$_SESSION['message'] = $result ['message'];
		
		
		
		
		$vsPrint->boink_it($bw->base_url."orders/");
	}

	function address(){
		global $bw;
		
		return $this->output = $this->html->address_payment ( $bw->input[2] );
	}
	
	function getHtml() {
		return $this->html;
	}

	function setHtml($html) {
		$this->html = $html;
	}
	
	/**
	 *
	 * @var orders
	 *
	 */
	var $model;
	
	/**
	 *
	 * @var skin_orders
	 *
	 */
	var $html;
}
