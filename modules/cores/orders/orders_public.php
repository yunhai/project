<?php

if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}

global $vsStd;
$vsStd->requireFile ( CORE_PATH . "orders/orders.php" );

class orders_public {
	function auto_run() {
		global $bw;
		$this->model->getNavigator();
		
		switch ($bw->input ['action']) {
			case 'cartsummary' :
				$this->cartSummary();
				break;
			
			case 'addtocart' :
				$this->addtocart($bw->input[2]);
				break;
				
			case 'deleteitem':
				$this->deleteItem();
				break;
				
			case 'updateitem' :
				$this->updateItem();
				break;
			
			case 'deleteallcart':
				$this->item = array();
				$this->saveItemstoSession();
				$this->cartSummary();
				break;
				
			case 'checkout':
				$this->checkOut();
				break;    
			
			case 'order':
				$this->order();
				break;    
			
			case 'vieworder':
				$this->viewOrder($bw->input[2]);
				break;
			default :
				$this->cartSummary ();
		}
	}
	
	function checkOut(){
		if(!$this->item){
			global $vsLang;
			$message = $vsLang->getWords('no_products', 'There isnot any item in your cart');
			return $this->output = $this->html->orderLoading($message);
		}
		
		$option['orderItem'] = $this->getObjectsItem();
		$option['total'] = number_format($this->total, 2, ".",",");
		$option['total1'] = $this->total;
		
		if($this->item){
			$cond = 'productId IN ('.implode(',', array_keys($this->item)).')';
			global $vsStd, $vsMenu;
			$vsStd->requireFile(CORE_PATH.'products/products.php');
			$products = new products();
			
			$products->setCondition($cond);
			$option['products'] = $products->getObjectsByCondition();
			$option['colors'] = $vsMenu->getCategoryGroup("color")->getChildren();
		}
		$location = $vsMenu->getCategoryGroup("shipping")->getChildren();
		$shipping = array();
		foreach($location as $l1){
			foreach($l1->getChildren() as $l2){
				$shipping[$l2->getId()] = number_format($l2->getValue(), 2, ".",",");
			}
		}
		$option['location'] = $location;
		$option['shippingjs'] = json_encode($shipping);
		$this->output = $this->html->checkOut($option);
	}
	
	function deleteItem() {
		global $bw, $vsTemplate, $vsPrint;

		unset($this->item[$bw->input[2]][$bw->input[3]]);
		if(!$this->item[$bw->input[2]]) unset($this->item[$bw->input[2]]);
		
		$this->saveItemstoSession();
                 
		$vsPrint->boink_it($bw->base_url.'orders');
	}

	function updateItem() {
		global $bw, $vsPrint;
                
		foreach($bw->input['quantity'] as $key=>$value){
			$name = array();
			$name = explode('pandog', $key);
			
			$newprice = $this->item[$name[0]][$name[1]]['itemUnitPrice']*$value;
			$this->item[$name[0]][$name[1]]['itemPrice'] = $newprice;
			$this->item[$name[0]][$name[1]]['itemQuantity'] = $value;
			
			$this->item[$name[0]][$name[1]]['itemInfo']['price'] = $newprice;
			$this->item[$name[0]][$name[1]]['itemInfo']['quantity'] = $value;
		}
		
		
        $this->saveItemstoSession();
        $vsPrint->boink_it($bw->base_url.'orders');
	}

	function orderProccess($orderId = 0) {
		global $bw;
		if(!count($this->objItems)) return array();
		
		foreach($this->objItems as $element)
			foreach($element as $item){
				$item->setOrderId($orderId);
				$this->model->orderitems->insertObject($item);
			}
	}
	
	function order(){
		global $bw, $vsLang, $vsPrint, $vsMenu;

		if(!$this->item){
			$message = $vsLang->getWords('no_products', 'There isnot any item in your cart');
			return $this->output = $this->html->orderLoading($message);
		}
		$this->getObjectsItem();
		
		$location = $vsMenu->getCategoryById($bw->input['orderLocation']);
		if($location){
			$shipping = $location->getValue();
			$this->total += $shipping;
			$bw->input['orderLocation'] = $location->getId();
			$bw->input['orderShipping'] = $shipping;
		}
		
		$this->model->obj->convertToObject($bw->input);
		$this->model->obj->setPostDate(time());
		$this->model->obj->setTotal($this->total);
		$this->model->insertObject();
		if($this->model->result) {
			global $DB;
			$this->orderProccess($DB->get_insert_id());
			$message = sprintf($vsLang->getWords("order_add_success","Đơn hàng được tạo thành công"), $this->model->obj->getName());
		}
		$this->viewOrder($this->model->obj->getId(), $message);
	}

	function viewOrder($id=0, $message=""){
		global $bw, $vsPrint, $vsLang;
               
		
		$option = $this->getCartInfo();
    	$this->model->setCondition("orderId in ({$id})");
    	$option['order'] = $this->model->getOneObjectsByCondition();
    	
       	if(!$option['order']) return $this->output = $this->html->viewOrder($option);
       	unset($_SESSION [$_SESSION [APPLICATION_TYPE]['language']['currentLang']['langFolder']] ['cart']); 
       	$this->sendEmail($option);
    	$this->output = $this->html->viewOrder($option);
	}
	
	function getCartInfo(){
		global $vsMenu;
		$option['orderItem'] = $this->getObjectsItem();
		
		$option['total'] = number_format($this->total, 2, ".", ",");
		$option['total1'] = $this->total;
		
		if($this->item){
			$cond = 'productId IN ('.implode(',', array_keys($this->item)).')';
			global $vsStd, $vsMenu;
			$vsStd->requireFile(CORE_PATH.'products/products.php');
			$products = new products();
			
			$products->setCondition($cond);
			$option['products'] = $products->getObjectsByCondition();
			$option['colors'] = $vsMenu->getCategoryGroup("color")->getChildren();
		}
		return $option;
	}
	
	function sendEmail($option = array()){
		global $vsStd, $vsSettings, $bw, $vsLang;
		$htmlsendemail =  $this->html->viewSendEmail($option);
     	$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		$this->email = new Emailer ();

   		$this->email->setTo ($bw->input['orderEmail']);
   		$this->email->addBCC($vsSettings->getSystemKey("contact_emailrecerver", "sangpm@vietsol.net", $bw->input['module']));
		$this->email->setFrom ($vsSettings->getSystemKey("contact_emailrecerver", "sangpm@vietsol.net", $bw->input['module']),$bw->vars['global_websitename']);
		$this->email->setSubject ($bw->vars['global_websitename']." - ". $vsLang->getWordsGlobal('global_xacnhandonhang','Xác nhận đơn hàng') );
		$this->email->setBody ( $htmlsendemail );		
		$this->email->sendMail ();
	}
	
	

	function cartSummary(){
		if(!$this->item){
			global $vsLang;
			$message = $vsLang->getWords('no_products', 'There isnot any item in your cart');
			return $this->output = $this->html->orderLoading($message);
		}
		$option['orderItem'] = $this->getObjectsItem();
		
		$option['total'] = number_format($this->total, 2, ".", ",");
		$option['total1'] = $this->total;
		
		if($this->item){
			$cond = 'productId IN ('.implode(',', array_keys($this->item)).')';
			global $vsStd, $vsMenu;
			$vsStd->requireFile(CORE_PATH.'products/products.php');
			$products = new products();
			
			$products->setCondition($cond);
			$option['products'] = $products->getObjectsByCondition();
			$option['colors'] = $vsMenu->getCategoryGroup("color")->getChildren();
		}
		return $this->output = $this->html->cartSummary($option) ;
	}
	
	function getObjectsItem(){
		if(!$this->item) return array();
		
		$this->total = 0;
		require_once(CORE_PATH."orders/OrderItem.class.php");
		foreach ($this->item as $key => $element){
			foreach($element as $key2=>$item){
				$infoarray = array();
				$infoarray = $item['itemInfo'];
				$str = serialize($item['itemInfo']);
				$item['itemInfo'] = $str;
				$item['itemRefPrice'] = $item['productPrice'];
				$item['itemCharge'] = $item['productSub'];
				
				$orderItem = new OrderItem();
				$orderItem->convertToObject($item);
				$this->total += $item['itemPrice'];
				
				$orderItem->infoarray = array();
				$orderItem->infoarray = $infoarray;
				$this->objItems[$key][$key2] = $orderItem;
			}
		}
		
		return $this->objItems;
	}

	function getProductArray($id) {
		global $bw, $DB,$vsPrint;
		$this->products->setFieldsString("productId, productTitle, productPrice, productImage, productType, productSub, productImage");
		$obj = $this->products->getObjectById($id);
		return $obj->convertOrderItem();
	}
 //save list Item to session  
        
        function saveItemstoSession(){
            $_SESSION [$_SESSION [APPLICATION_TYPE]['language']['currentLang']['langFolder']] ['cart'] ['item'] = $this->item;
        }
// lấy array sessionItem to ObjecItems        
        
        

	function addtocart($idP = 0) {
		global $bw, $vsPrint,$vsLang,$vsTemplate;
				$itemkey = $bw->input['width'.$bw->input['windowsize']].'_'.$bw->input['drop'.$bw->input['windowsize']].'_'.$bw->input['color'];
				if(is_numeric($idP)){
					 if($this->item[$idP][$itemkey]){
					 	$item = $this->item[$idP][$itemkey];
					 	
                        $item['itemQuantity'] += $bw->input['quantity'.$bw->input['windowsize']];
                        $item['itemInfo']['quantity'] += $bw->input['quantity'.$bw->input['windowsize']];
                        
                        
                        $quantity = $bw->input['quantity'.$bw->input['windowsize']];
                        $price =  $item['itemUnitPrice']*$quantity;
                        $item['itemPrice'] += $price;
                        $item['itemInfo']['price'] += $price;
                        
                        $this->item[$idP][$itemkey] = array();
                        $this->item[$idP][$itemkey] = $item;
                    }else{
                    	$item = array();
                        $item = $this->getProductArray($idP);
                        
                        $item['productPrice'] = $item['itemPrice'];
                        $item['itemQuantity'] = $bw->input['quantity'.$bw->input['windowsize']];
                        
                        
                        $width = $bw->input['width'.$bw->input['windowsize']]/1000;
                        $drop = $bw->input['drop'.$bw->input['windowsize']]/1000;
                        $quantity = $bw->input['quantity'.$bw->input['windowsize']];
                        $charge = $item['productSub'];
                        
                        $unitprice = $width*$drop*$item['productPrice'] + $charge;
                        $price = $unitprice*$quantity;
                        
                        $item['itemUnitPrice'] = $unitprice;
                        $item['itemPrice'] = $price;
                        
                        global $vsMenu;
                        $colors = $vsMenu->getCategoryGroup("color")->getChildren();
                        $color = $bw->input['color'];
                        if($colors[$bw->input['color']]) $color = $colors[$bw->input['color']]->getTitle();
                    
                        $info = array();
                        $info['width'] = $bw->input['width'.$bw->input['windowsize']];
                        $info['drop'] = $bw->input['drop'.$bw->input['windowsize']];
                        $info['quantity'] = $bw->input['quantity'.$bw->input['windowsize']];
                        $info['color'] = $bw->input['color'];
                        $info['mounttype'] = $bw->input['mounttype'];
                        $info['operatingside'] = $bw->input['operatingside'];
                        $info['charge'] = $item['productSub'];
                        $info['price'] = $price;
                        $info['unitprice'] = $unitprice;
                        $info['rawprice'] = $item['productPrice'];
                        $info['colorname'] = $color;
                        
                        $item['itemInfo'] = $info;
                    
						$this->item[$idP][$itemkey] = $item;			
                    }
                        
                $message = sprintf($vsLang->getWords("order_addtocart_added","[%s] added to your cart"),$item['itemTitle']);   
                $this->saveItemstoSession();
		}else 	$message = $vsLang->getWords('order_messages_none','Error! This page donesnot existed');
		return $this->output = $this->html->orderLoading($message);
	}

	

	


	protected $html;
	protected $module;
	protected $output;
	private $products;

	function __construct() {
		global $vsTemplate,$bw,$vsModule,$vsStd;
		$vsStd->requireFile ( CORE_PATH . "products/products.php" );
		$this->model = new orders();
		$this->products = new products();
		$this->item = $_SESSION [$_SESSION [APPLICATION_TYPE]['language']['currentLang']['langFolder']] ['cart'] ['item'];
		$this->total = 0;
		$this->objItems = array();
		$this->html = $vsTemplate->load_template('skin_orders');
	}


	public function getOutput() {
		return $this->output;
	}

}
?>