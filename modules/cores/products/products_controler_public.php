<?php
require_once CORE_PATH . 'products/products.php';
class products_controler_public extends VSControl_public {

	function __construct($modelName) {
		global $vsTemplate, $bw;
		// $this->html=$vsTemplate->load_template("skin_product");
		parent::__construct ( $modelName, "skin_products", "product", $bw->input [0] );
		// $this->model->categoryName=$bw->input[0];
	}

	function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_get_price' :
				$this->getPrice ();
				break;
			case $this->modelName . '_label' :
				$this->showLabel ();
				break;
			case $this->modelName . '_search' :
				$this->showSearch ();
				break;
			case $this->modelName.'_tags':
				$this->getTags();
				break;	
			case $this->modelName .'_category' :
				$this->showCategory($bw->input[2]);
				break;
			
			case $this->modelName .'_categories' :
				$this->showCategories($bw->input[2]);
				break;
			case $this->modelName.'_addtshowbox':
				$this->showbox();
				break;
			default :
				
				parent::auto_run ();
				break;
		}
	}
	
	
function getTags($option=array()){
		global $vsPrint, $bw,$vsTemplate;   
		
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		
		require_once CORE_PATH.'tags/tags.php';     
		$tags=new tags();
		$tags->getObjectById($this->getIdFromUrl($bw->input[2]));
		if(!$tags->obj->getId()) $vsPrint->boink_it("");
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
//		$tags->getContentByTagId($module, $id);
		$products=new products();
		$products->setCondition("id IN (SELECT contentId FROM vsf_tagcontent WHERE tagid='{$this->getIdFromUrl($bw->input[2])}' )");
		$option=$products->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',10));
		
		$option['title']=$tags->obj->getTitle();
		$tags->obj->createSEO();
		$option['obj']=$tags->obj;
		
		
		
		$option['breakcrum']=$this->createBreakCrum(null);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
		$option['cate'] = $category->getChildren();
	
		
        return $this->output = $this->getHtml()->showDefault($option);

	}
	
	
	function showSearch($option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
//		echo 123; exit();
		$condition="1=1 ";
		if($bw->input['keyword']){
			$condition.=" and status >0 and title like '%".mysql_real_escape_string($bw->input['keyword'])."%'";	
		}

		$this->model->setCondition($condition);
		$this->model->setOrder("`index`,id desc");
		$option['pageList']=$this->model->getObjectsByCondition();

		$option['breakcrum']=$this->createBreakCrum(null);
		if($bw->input['keyword'])
		$option['title']=VSFactory::getLangs()->getWords('products_search_title','Tìm kiếm với từ khóa: ')."<i>".$bw->input['keyword']."</i>";
		else $option['title']=VSFactory::getLangs()->getWords('products_search_result','Kết quả tìm kiếm');
		$vsPrint->mainTitle=$vsPrint->pageTitle="Tìm kiếm với từ khóa: ".$option['title'];
		$option['obj']=new Menu();
		$option['obj']->setTitle("Tìm kiếm");
		foreach ( $option ['pageList'] as $abc ) {
					if ($abc->getPrice ()) {
						$abc->setPrice ( number_format ( $abc->getPrice (), 0, ',', '.' ) );
					}
					if ($abc->getPromotionPrice ()) {
						$abc->setPromotionPrice ( number_format ( $abc->getPromotionPrice (), 0, ',', '.' ) );
					}
					
				}
        return $this->output = $this->getHtml()->showSearch($option);
        
//		return $this->output="";
	}
function showCategory($catId){
		global $bw,$vsPrint;
               // $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$idcate = $this->getIdFromUrl($catId);		
		$category=VSFactory::getMenus()->getCategoryById($idcate);
		$option['url']=$category;

		if(!$category){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
		
		$this->model->setCondition("status>0 and catId in ({$ids})");
		$this->model->setOrder("`index` DESC,id desc");
		//$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_public_limit',12));
		$tmp=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_public_limit',12));
		$option=array_merge($tmp,$option);
		//$option['pageList']=$this->model->getObjectsByCondition();
		
		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
        $option['obj']=$category;
        $option['breakcrum']=$this->createBreakCrum($category);
        if($option['pageList']){
		$obj=current($option['pageList']);
         $vsPrint->boink_it($obj->getUrl($bw->input[0]));
        }
		else{
		$vsPrint->boink_it($bw->base_url);
		}
		return $this->output = $this->getHtml()->showDefault($option);
	}

	function showDefault($option = array()) {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		/*if (in_array ( $bw->input ['module'], array ('abouts', 'maps', 'helps' ) ))
			return $this->showDefault1 ();
		$category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index` desc,id desc");
//		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));
//		$option=array_merge($tmp,$option);
		$option['pageList']=$this->model->getObjectsByCondition();
		
		$option['breakcrum']=$this->createBreakCrum(null);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
        $option['cate'] = $category->getChildren();
		$option['url']=$bw->vars['board_url']."/products";*/
		//echo 123; exit();
        $category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		if (! $category) {
			$vsPrint->boink_it($bw->base_url."404.html");
		}
        if($category->getChildren()){
        	$cate=current($category->getChildren());
        }
		else{
			$cate=$category;
		}
        $ids = VSFactory::getMenus ()->getChildrenIdInTree ( $cate->getId());
        $this->model->setCondition("status > 0 and catId in ($ids)");
        $obj=$this->model->getOneObjectsByCondition();
        if($obj){
        $vsPrint->boink_it($obj->getUrl($bw->input[0]));
        }
        return $this->output = $this->getHtml()->showDefault($option);
	}
        
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate,$vsStd,$DB;     
          $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()||$obj->getStatus()<=0){
			return $this->output=VSFactory::getLangs()->getWords('not_count_item');
		}
		$obj->createSeo();
		$option['breakcrum']=$this->createBreakCrum($obj);
		//$option['other']=$this->model->getOtherList($obj);
        $option['cate'] = $category->getChildren();
        $option['cate_obj']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
       	$obj->createSeo();
		$option['url']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
		$_SESSION['active']=$obj->getCatId();
		
		if($option['cate']){
			foreach ($option['cate'] as $key => $value){
				$ids[$key] = VSFactory::getMenus ()->getChildrenIdInTree ( $value->getId());
				$this->model->setCondition("status > 0 and catId in ($ids[$key])");
	        	$option['obj'][$key]=$this->model->getObjectsByCondition();
			}
		}
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
		$this->model->setCondition("status >0 and catId in ($ids)");
		//$this->model->setFieldsString("code");
		$this->model->setOrder("`index` desc,id desc");
		$option['all']=$this->model->getObjectsByCondition();
		foreach ($option['all'] as $key=>$value){
			$option['code'][$key]=$value->getCode();
		}
		
		require_once (CORE_PATH."albums/albums.php");	
		$albums = new albums();
		$category_albums = VSFactory::getMenus ()->getCategoryGroup ('albums' );
		$ids_album =VSFactory::getMenus()->getChildrenIdInTree($category_albums);
		$albums->setCondition("status > 0 and catId in ($ids_album) and proId={$obj->getId()}");
		$option['albums']=$albums->getObjectsByCondition();
//		print  "<pre>";
//		print_r ($option['albums']);
//		print  "<pre>";
//		exit();
//		print  "<pre>";
//		print_r ($ids_album);
//		print  "<pre>";
//		exit();
		
		
		$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
		$image = new VsCaptcha ();
		$option['code']=array_unique($option['code']);
		if($bw->input['proposals']['submit']){
//			print  "<pre>";
//			print_r ($bw->input['proposals']);
//			print  "<pre>";
//			exit();
		$option['proposals']=$bw->input['proposals'];
		
		if ($image->check ( $bw->input ['sec_code'] )) {
       		require_once (CORE_PATH."proposals/proposals.php");	
			$proposals = new proposals();
       		
			$bw->input['proposals']['postdate']=time();
			$bw->input['proposals']['status']=0;
			$proposals->basicObject->convertToObject($bw->input['proposals']);		
//			print  "<pre>";
//			print_r ($proposals);
//			print  "<pre>";
//			exit();	
			$proposals->insertObject();
			
			$option['error'] = VSFactory::getLangs()->getWords('thanks_proposals')."!";
			unset($option['proposals']);
			}
			else{
				$option['error'] = VSFactory::getLangs()->getWords('captcha_not_match')."!";
			}
			
		}
//		print  "<pre>";
//		print_r ($option['code']);
//		print  "<pre>";
//		exit();

		$category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		if (! $category) {
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("RAND()");
		$this->model->setLimit( array (0, 12 ));
//		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));
//		$option=array_merge($tmp,$option);
		$option['other']=$this->model->getObjectsByCondition();














    	$this->output = $this->getHtml()->showDetail($obj,$option);
	}
function showbox($option=array()){			
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$bw->input['ajax']=1;
	
		$arrayObj=array();
		$oldIds = $bw->input[2];
		require_once (CORE_PATH."albums/albums.php");	
		$albums = new albums();
		$category_albums = VSFactory::getMenus ()->getCategoryGroup ('albums' );
		$ids_album =VSFactory::getMenus()->getChildrenIdInTree($category_albums);
		$albums->setCondition("status > 0 and catId in ($ids_album) and id={$oldIds}");
		$obj=$albums->getOneObjectsByCondition();
		
		require_once CORE_PATH.'gallerys/gallerys.php';
		$gallerys=new gallerys();
		$option['galary']=$gallerys->getAlbumByCode('albums'.'_'.$oldIds);

		return $this->output =$this->getHtml()->showbox($option,$obj);
		

	}	
public function getOtherList($obj) {
		global $bw;
		$vsMenu = VSFactory::getMenus();
		$cat = $vsMenu->getCategoryById ( $obj->getCatId () );
		$ids = $vsMenu->getChildrenIdInTree ( $cat );
		
		//$this->setFieldsString ( "id,title,postDate,catId" );
		$this->setOrder ( "`index` Desc, id Desc" );
		$this->condition = "id <> {$obj->getId()} and status >0";
		$size = VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit_other',12);
		$this->setLimit ( array (0, $size ) );
		if ($ids)
			$this->condition .= " and catId in ( {$ids})";
		
		return $this->getObjectsByCondition ();
	}
	/*
	 * Show detail action
	 */
	function getListLangObject() {
	}

	/**
	 *
	 * @param
	 *        	BasicObject
	 */
	protected function onDeleteObject($obj) {
	}

	public function getHtml() {
		return $this->html;
	}

	public function getOutput() {
		return $this->output;
	}

	public function setHtml($html) {
		$this->html = $html;
	}

	public function setOutput($output) {
		$this->output = $output;
	}
	/**
	 *
	 *
	 *
	 *
	 *
	 *
	 * Enter description here ...
	 *
	 * @var skin_products
	 */
	public $html;
}

?>