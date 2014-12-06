<?php
class VSControl_public extends VSControl {

	function __construct($modelName, $skinName, $tableName, $categoryName = '') {
		global $bw, $vsPrint;
		$this->modelName = $modelName;
		$this->model = new $modelName ( $categoryName );
		$this->tableName = $tableName;
		global $vsTemplate;
		$this->html = $vsTemplate->load_template ( $skinName );
		$this->html->modelName = $modelName;
		$this->html->model = $this->model;
		$vsPrint->pageTitle = $vsPrint->mainTitle = VSFactory::getLangs ()->getWords ( $bw->input [0] );
		// //////////
	}
	/*
	 * @description function auto_run, it's a router for actions in model
	 */
	function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_detail' :
				$this->showDetail ( $bw->input [2] );
				break;
			
			case $this->modelName . '_category' :
				$this->showCategory ( $bw->input [2] );
				break;
			case $this->modelName . '_review' :
				$this->showReview ( $bw->input [2] );
				break;
			case $this->modelName . '_search' :
				$this->showSearch ();
				break;
			default :
			
				$this->showDefault ();
				break;
		}
	}

	function showSearch() {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		
		$option['breakcrum']=$this->createBreakCrum(null);
		$category = VSFactory::getMenus ()->getCategoryGroup ($bw->input [0]);
		//echo 123; exit();
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
//		echo "<pre>";
//		print_r($ids);
//		echo "</pre>";
//		exit();
		if($bw->input[2])
			$bw->input['keyword']=$bw->input[2];
		if($bw->input['keyword']){
			$condition.=" status >0  and catId in({$ids}) and title like '%".mysql_real_escape_string($bw->input['keyword'])."%'";	
		}

		$this->model->setCondition($condition);
		$this->model->setOrder("`index`,id desc");
		$option['pageList']=$this->model->getObjectsByCondition();
	
		
		if($bw->input['keyword'])
		$option['title']=VSFactory::getLangs()->getWords('products_search_keyword','Từ khóa: ')."<i>".$bw->input['keyword']."</i>";
		else $option['title']=VSFactory::getLangs()->getWords('products_search_result','Kết quả tìm kiếm');
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
		
		return $this->output = $this->getHtml()->showDefault($option);
	}

	function showReview($id) {
		return $this->output = "No thing to do!";
	}
	/*
	 * Show default action
	 */
	function showDefault($option = array()) {

		global $bw, $vsTemplate, $vsStd, $vsPrint;
		if (in_array ( $bw->input ['module'], array ('abouts', 'maps', 'helps' ) ))
			return $this->showDefault1 ();
		$category = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] );
		if (! $category) {
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index`,id desc");
		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum(null);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
                $option['cate'] = $category->getChildren();
        return $this->output = $this->getHtml()->showDefault($option);
	}
        
    function showDefault1(){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		if(!$ids){
			$this->output =VSFactory::getLangs()->getWords('not_count_item');
		}
		$option['breakcrum']=$this->createBreakCrum(null);
		$this->model->setCondition("catId in ($ids) and status >0");
		$this->model->setOrder("`index`");
		$this->model->getOneObjectsByCondition();
        return $this->output = $this->getHtml()->showDetail($this->model->basicObject,$option);
	}
	
	/*
	 * Show detail action 
	 */
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate;     
                $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()||$obj->getStatus()<=0){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$obj->createSeo();
		$option['breakcrum']=$this->createBreakCrum($obj);
		$option['other']=$this->model->getOtherList($obj);
        $option['cate'] = $category->getChildren();
        $option['cate_obj']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
       	$obj->createSeo();
    	$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
	/*
	 * Show category action 
	 */
function showCategory($catId){
		global $bw,$vsPrint;
               // $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$idcate = $this->getIdFromUrl($catId);		
		$category=VSFactory::getMenus()->getCategoryById($idcate);
		if(!$category){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ({$idcate})");
		$this->model->setOrder("`index`,id desc");
		$option=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',10));

		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
        $option['obj']=$category;
        $option['breakcrum']=$this->createBreakCrum($category);
		return $this->output = $this->getHtml()->showDefault($option);
	}
/*	
function createBreakCrum($obj){
		global $bw;
		$lang=VSFactory::getLangs();
		$html='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'." <a class='home' href='{$bw->base_url}' itemprop='url'><span itemprop='title'>{$lang->getWords('home','Trang chủ')}</span></a>".'</div>';
		$html.='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'." <a  href='{$bw->base_url}{$bw->input[0]}' itemprop='url'><span itemprop='title'>{$lang->getWords($bw->input[0],$bw->input[0])}</span></a>".'</div>';
		//$html.=" <a href='{$bw->base_url}{$bw->input[0]}'>{$lang->getWords($bw->input[0],$bw->input[0])}</a>";
		
		$array=array();
		if(is_object($obj)){
			if(get_class($obj)=='Menu'){
				while($obj->getLevel()>1){
					//$array[]=" <a href='{$bw->base_url}{$obj->getUrl()}/category/{$obj->getSlugId()}'>{$obj->getTitle()}</a>";
					$array[]='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'." <a href='{$bw->base_url}{$obj->getUrl()}/category/{$obj->getSlugId()}' itemprop='url'><span itemprop='title'>{$obj->getTitle()}</span></a>".'</div>';
					$obj=VSFactory::getMenus()->getCategoryById($obj->getParentId());	
				}
			}else{
				//$array[]=" <a href='{$bw->base_url}{$bw->input[0]}detail/{$obj->getSlugId()}'>{$obj->getTitle()}</a>";
			if($cate=VSFactory::getMenus()->getCategoryById($obj->getCatId()) ){
				while($cate->getLevel()>1){
						if($bw->input[0]=='products')
						$array[]='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'." <a href='{$bw->base_url}home/show_menu' itemprop='url'><span itemprop='title'>{$cate->getTitle()}</span></a>".'</div>';
						else
                        $array[]='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'." <a href='{$bw->base_url}{$cate->getUrl()}/category/{$cate->getSlugId()}' itemprop='url'><span itemprop='title'>{$cate->getTitle()}</span></a>".'</div>';
					
					$cate=VSFactory::getMenus()->getCategoryById($cate->getParentId());
					
				}
			}
			}
		}
                
                
                 
		for($i=count($array)-1;$i>=0;$i--){
			$html.='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'.$array[$i].'</div>';;
		}
		
		if(in_array($bw->input[0],array('car','abouts'))){
			$html.='<div itemtype="http://data-vocabulary.org/Breadcrumb" itemscope="">'.$obj->getTitle().'</div>';;
		}
		
		
		
		
		return $html;	
	}*/
	
function createBreakCrum($obj){
		global $bw;
		$lang = VSFactory::getLangs ();
		$html = '<li>' . " <a class='first' href='{$bw->base_url}' itemprop='url'><span itemprop='title'>{$lang->getWords('home','Trang chủ')}</span></a>" . '</li>';
		$html .= '<li>' . " <a  href='{$bw->base_url}{$bw->input[0]}' itemprop='url'><span itemprop='title'>{$lang->getWords($bw->input[0],$bw->input[0])}</span></a>" . '</li>';
		//$html.=" <a href='{$bw->base_url}{$bw->input[0]}'>{$lang->getWords($bw->input[0],$bw->input[0])}</a>";
		

		$array = array ();
		if (is_object ( $obj )) {
			if (get_class ( $obj ) == 'Menu') {
				while ( $obj->getLevel () > 1 ) {
					//$array[]=" <a href='{$bw->base_url}{$obj->getUrl()}/category/{$obj->getSlugId()}'>{$obj->getTitle()}</a>";
					$array [] = " <a href='{$bw->base_url}{$obj->getUrl()}/category/{$obj->getId()}' itemprop='url'><span itemprop='title'>{$obj->getTitle()}</span></a>";
					$obj = VSFactory::getMenus ()->getCategoryById ( $obj->getParentId () );
				}
			} else {
				//$array[]=" <a href='{$bw->base_url}{$bw->input[0]}detail/{$obj->getSlugId()}'>{$obj->getTitle()}</a>";
				if ($cate = VSFactory::getMenus ()->getCategoryById ( $obj->getCatId () )) {
					while ( $cate->getLevel () > 1 ) {
						
						$array [] = " <a href='{$bw->base_url}{$cate->getUrl()}/category/{$cate->getSlugId()}' itemprop='url'><span itemprop='title'>{$cate->getTitle()}</span></a>";
						$cate = VSFactory::getMenus ()->getCategoryById ( $cate->getParentId () );
					
					}
				}
			}
		}
		
		if ($bw->input [1] == 'category' or $bw->input [1] == 'child' or $bw->input [1] == 'fashion')
			$array [0] = "<a class=last'><span >" . preg_replace ( "/<[^>]*>/", "", $array [0] ) . "</span></a>";
		
		for($i = count ( $array ) - 1; $i >= 0; $i --) {
			$html .= '<li>' . $array [$i] . '</li>';
			;
		}
	
		return $html;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var skin_objectpublic
	 */
	public $html;
	/**
	 * (non-PHPdoc)
	 * @see sources/libs/boards/VSControl::getHtml()
	 *@return skin_objectpublic
	 */
	public function getHtml() {
		return $this->html;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var VSFObject
	 */
	protected  $model;
}
?>