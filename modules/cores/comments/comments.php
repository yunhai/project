<?php
require_once(CORE_PATH."comments/Comment.class.php");
class comments extends VSFObject {
	public $obj;
	//protected $categoryField 	="";
	//protected $categories 		= array();

	function __construct(){
            global $vsMenu;
           
        $this->requireFileUseFull();
		parent::__construct();
		$this->categoryField 	= "commentCatId";
		$this->primaryField 	= 'commentId';
		$this->basicClassName 	= 'Comment';
		$this->tableName 		= 'comment';
		$this->obj = $this->createBasicObject();
		$this->obj	=&$this->basicObject;
		$this->fields = $this->obj->convertToDB();
		$this->categories = array();
		$this->categories = $vsMenu->getCategoryGroup(($this->tableName));

	}

	function writeComment(){
		global $bw, $vsSettings,$DB,$vsRelation;

		$bw->input['commentStatus'] = $vsSettings->getSystemKey('comment_default_status', 1, $bw->input[0], 0, 0);
		$bw->input['commentPostdate'] = time();
		$bw->input['commentProfile'] = $this->createProfile();
		$this->obj->convertToObject($bw->input);
	
		$this->insertObject($this->cpost->obj);
		$obj = $vsRelation->createBasicObject();
		$vsRelation->setObjectId($bw->input['commentObjId']);
		$vsRelation->setRelId($this->obj->getId());
		$vsRelation->setTableName("products_comments");
		$vsRelation->insertRel2(NULL,NULL, false);
	
		return $this->result;
	}
	
	public function getRelTableName() {
		return $this->relTableName;
	}

	public function setRelTableName($relTableName) {
		$this->relTableName = $relTableName;
	}

	public function setCategories($categories) {
		$this->categories = $categories;
	}

	function requireFileUseFull() {
		global $vsStd;
		$vsStd->requireFile(UTILS_PATH."TextCode.class.php");
	}


	public function setCategoryField($categoryField) {
		$this->categoryField = $categoryField;
	}

	/**
	 * @return the $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	/**
	 * @return the $categoryField
	 */
	public function getCategoryField() {
		return $this->categoryField;
	}
	/**
	 * @return the $categoryField
	 */
	public function getListWithCat($treeCat) {
            global $vsMenu;
            if(!is_object($treeCat))
		return false;
		$ids=$vsMenu->getChildrenIdInTree($treeCat);
		if($ids)
		$this->condition = "commentCatId in ( {$ids})";
		$this->setOrder("commentIndex DESC, commentId Desc");
		$this->limit=array(0,30);
		return $this->getObjectsByCondition();
	}


	public function getOtherList($obj) {
		global  $vsSettings,$vsMenu;
		$cat=$vsMenu->getCategoryById($obj->getCatId());
		$ids=$vsMenu->getChildrenIdInTree($cat);
		$this->condition = "commentId < {$obj->getId()} and commentStatus <>0";
		$this->setOrder("commentIndex DESC, commentId Desc");
                $this->setFieldsString("commentTitle,commentId, commentPostDate");
		$size =  $vsSettings->getSystemKey("user_{$bw->input[0]}_list_number_other",10);
		$this->setLimit(array(0,$size));
		if($ids)
		$this->condition .= " and commentCatId in ( {$ids})";
		return $this->getObjectsByCondition();
	}


	public function getHotList() {
            global $vsMenu;
            $ids=$vsMenu->getChildrenIdInTree($this->getCategories());
		$this->condition .= " commentStatus > 0 and commentCatId in ( {$ids})";
                $this->setFieldsString("commentTitle,commentId");
		$this->setOrder("commentIndex DESC, commentId Desc");
		$this->setLimit(array(0,15));
		return $this->getObjectsByCondition();
	}

	function getLastest($limit=1){
		$this->condition .= " commentStatus > 0";
		$this->setOrder("commentId Desc");
		$this->setLimit(array(0, $limit));
		return $this->getObjectsByCondition();
	}
	
	function __destruct(){
		unset($this);
	}

	function deleteObjInCategory($catIds = 0){
		global $vsStd;
		
		$query = "SELECT commentId, commentImage from vsf_comment where commentCatId in(".$catIds.")";
		$list = $this->executeQuery($query, 0);

		if(!count($list)) return false;
		
		$this->condition = "commentCatId IN (".$catIds.")";
		if(!$this->deleteObjectByCondition()) return false;
		
		foreach ($list as $news)
			$this->vsFile->deleteFile($news['commentImage']);

		return true;
	}
	
		function createRSS($id=""){
            global $vsMenu,$vsStd,$vsLang;
            $vsStd->requireFile(UTILS_PATH."/class_rss.php");
            $rss = new VSSRss();

            $categories = $this->getCategories();
            if($id){
                $result = $vsMenu->extractNodeInTree($id, $categories->getChildren());
                if($result){
                    $strIds = trim($idCate.",".$vsMenu->getChildrenIdInTree($result['category']),",");
                    $rss->cate =$result['category'];
                }
            }
            if(!$strIds){
                $strIds = $vsMenu->getChildrenIdInTree($categories);
                $rss->cate =$categories;
            }
               $this->setFieldsString("commentTitle,commentImage,commentId,commentIntro,commentPostDate,commentCatId,vsf_file.*");
               $this->setTableName ("comment left join vsf_file on commentImage = fileId");
        
            $this->setOrder("commentIndex DESC,commentId DESC");
            $this->setCondition("commentStatus > 0 and commentCatId in ({$strIds})");
            $this->setLimit(array(0,10));
            $arr = $this->getObjectsByCondition();
           
            $rss->arrayObj = $arr;
            $rss->buildRss();
           	print "<script>alert('".$vsLang->getWordsGlobal("alert_RSS","Bạn đã tạo RSS thành công")."')</script>";

        }
        
	function createProfile(){
		global $bw;
		$profile['name'] = $bw->input['commentName'];
		$profile['email'] = $bw->input['commentEmail'];
		return serialize($profile); 
	}
}
?>