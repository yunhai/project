<?php
require_once(CORE_PATH.'orders/orders.php');

class orders_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_orders");
		parent::__construct($modelName,"skin_orders","order");
		$this->model->categoryName="orders";

	}
	function auto_run() {
		global $bw;
		
		
		switch ($bw->input [1]) {
			case $this->modelName . '_display_tab' :
				$this->displayObjTab ();
				break;
			case $this->modelName . '_search' :
				$this->displaySearch ();
				break;
			case $this->modelName . '_visible_checked' :
				$this->checkShowAll ( 1 );
				break;
			case $this->modelName . '_prints' :
				$this->prints ( 2 );
				break;
			case $this->modelName . '_index_change' :
				$this->indexChange ();
				break;
			
			case $this->modelName . '_home_checked' :
				$this->checkShowAll ( 2 );
				break;
			
			case $this->modelName . '_hide_checked' :
				$this->checkShowAll ( 0 );
				break;
			case $this->modelName . '_display_list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case $this->modelName . '_add_edit_form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case $this->modelName . '_add_edit_process' :
				$this->addEditObjProcess ();
				break;
			
			case $this->modelName . '_delete' :
			
				$this->deleteObj ( $bw->input [2] );
				break;
			case $this->modelName . '_huy_checked' :
				$this->checkShowAll ( -1 );
				break;
			
			case $this->modelName . "_display_answer_tab" :
				$this->displayAnswer ();
				break;
			default :
				$this->loadDefault ();
				break;
		}
	}
	
	function displayObjTab() {
		global $bw;
	
		if($bw->input['q']) {
			require_once CORE_PATH.'orders/order_items.php';
			$order_items=new order_items();
			$order_items->setCondition("	orderId={$bw->input['q']}");
			$option['order_items']=$order_items->getObjectsByCondition();
			$option['total']=0;
			foreach ($option['order_items'] as $value) {
				$price = $value->getSaleoff()?$value->getSaleoff():$value->getPrice();
				$value->total=$value->getQuantity()*$price;
				$value->price = $price;
				$option['total']+=$value->total;
			}
			$obj = $this->model->getObjectById ( $bw->input['q'] );
			echo $this->html->showPrints($obj,$option);die;
		}
		
		$option ['objList'] = $this->getObjList ();
	
		return $this->output = $this->html->displayObjTab ( $option );
	}
	
	function getObjList($catId = '', $message = "") {
		global $bw;
		$option ['message'] = str_replace ( array ("'", "\n" ), array ("\\'", "\\n" ), $message );
		$catId = intval ( $catId );
		if ($_REQUEST ['vdata']) {
			$vdata = json_decode ( $_REQUEST ['vdata'], true );
		}
		if ($vdata ['search']) { // last query search
			$bw->input ['search'] = $vdata ['search'];
			$option ['table'] = $this->displaySearch ();
		} else {
			if ($bw->input ['pageIndex']) {
				$bw->input [3] = $bw->input ['pageIndex'];
			}
				
			if ($this->model->getCategoryField ()) {
				$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $this->model->getCategories () );
				if ($ids)
					$this->model->setCondition ( "{$this->model->getCategoryField()} in ($ids)" );
			}
			if ($bw->input ['module'] == 'products') {
				$this->model->setOrder ( '`index` ASC' );
			}
				
				
			$option = array_merge ( $option, $this->model->getPageListHash ( $this->modelName . "/" . $bw->input [0] . "/{$this->modelName}_display_tab/{$catId}/", 3, VSFactory::getSettings ()->getSystemKey ( "{$this->modelName}_paging_limit", 20 ) ) );
			$bw->input ['pageIndex'] = $bw->input [3];
			$bw->input ['back'] = "&pageIndex=" . $bw->input ['pageIndex'];
			
			$option ['table'] = $this->html->getListItemTable ( $this->model->getArrayObj (), $option );
			// /some here..................
		}
		return $this->output = $this->html->objListHtml ( $option );
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		
		require_once CORE_PATH.'orders/order_items.php';
		$order_items=new order_items();
		$order_items->setCondition("	orderId='$objId'");
		$option['order_items']=$order_items->getObjectsByCondition();
		$option['total']=0;
		foreach ($option['order_items'] as $value) {
			$price = $value->getSaleoff()?$value->getSaleoff():$value->getPrice();
			$value->total=$value->getQuantity()*$price;
			$value->price = $price;
			$option['total']+=$value->total;
		}
		
		return parent::addEditObjForm($objId,$option);
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd;
		
		
		$this->model->setCondition ( "`{$this->model->getPrimaryField()}` = {$bw->input [$this->modelName] ['id']}" );
		$this->model->updateObjectByCondition ( array ("Status" => $bw->input [$this->modelName] ['status'] ) );
	
		return $this->output = $this->getObjList ( $bw->input ['pageIndex'], $message );
	}

	function deleteObj($ids, $cate = 0) {
		global $bw, $vsStd;
		if (! $ids) {
			return $this->output = $this->getObjList ( $cate );
		}
		$this->model->setCondition ( "`{$this->model->getPrimaryField()}` IN (" . $ids . ")" );
		$list = $this->model->getObjectsByCondition ();
		if (! count ( $list ))
			return false;
		$this->model->setCondition ( "`{$this->model->getPrimaryField()}` IN (" . $ids . ")" );
		if (! $this->model->deleteObjectByCondition ())
			return false;
		foreach ( $list as $news ) {
			$this->model->onDeleteObjectById ( $news );
			VSFactory::getFiles ()->deleteFile ( $news->getImage () );
		}
		return $this->output = $this->getObjList ( $cate );
	}
	
	function getHtml(){
		return $this->html;
	}



	function getOutput(){
		return $this->output;
	}



	function setHtml($html){
		$this->html=$html;
	}




	function setOutput($output){
		$this->output=$output;
	}



	
	/**
	*Skins for order ...
	*@var skin_orders
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
