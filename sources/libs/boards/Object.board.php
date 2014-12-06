<?php
class Object {
	protected $imageField = "";
	protected $prefixField = "";
	protected $tableName = "";
	protected $categoryField = "";
	protected  $categories = NULL;
	public $categoryName;
	/**
	 * $primaryField is name of primary key for table
	 */
	protected $primaryField = "";
	protected $fieldsString = "*";
	
	/**
	 * @var array $fields used for DB function that use array
	 */
	protected $fields = array ();
	/**
	 * $result is a array ,this is contain status and  message after excute a methods
	 * $result['status']
	 * $result['developer]
	 */
	public $result = array ();
	
	/**
	 * $query is array contain select query string
	 * $query['select'] = "*";
	 * $query['from']   = "abc";
	 * $query['where']	= "id = 4";
	 * $query['limit']  = array($start, $end);
	 *
	 * => query string: select * from abc where id = 4 limit (0, 4)
	 */
	
	protected $condition = "";
	protected $order = "";
	protected $groupby = "";
	protected $having = "";
	protected $limit = array ();
	public $basicClassName = null;
	/**
	 * 
	 * Enter description here ...
	 * @var BasicObject
	 */
	public $basicObject = null;
	public $arrayObj = array ();
	
	function __construct() {
		$this->resetResult ();
		$this->resetQuery ();
		$this->fieldsString = "*";
		$this->arrayObj = array ();
	}
	
	function autokill() {
	}
	
	protected function __reset() {
		$this->tableName = null;
		$this->prefixField = null;
		$this->basicClassName = null;
		$this->basicObject = null;
		$this->primaryField = null;
		$this->fieldsString = null;
		$this->fields = array ();
		$this->arrayObj = array ();
		
		$this->resetQuery ();
		$this->resetResult ();
	}
	/**
	 * 
	 * @return VSFObject
	 */
	function createBasicObject() {
		global $vsStd, $bug;
		if ($this->basicClassName) {
			$this->basicObject = new $this->basicClassName ();
			return $this->obj=$this->basicObject;
		}
		$this->createMessageError($this->basicClassName . " class not found at function createBasicObjectObject()");
		return false;
	}
	function resetResult() {
		$this->arrayObj = array ();
		$this->result ['status'] = true;
		$this->result ['developer'] = "";
	}
	
	function resetQuery() {
		$this->fieldsString = "*";
		$this->condition = "";
		$this->order = "";
		$this->groupby = "";
		$this->limit = array ();
	}
	
	function createMessageError($message = "Error") {
		$this->result ['status'] = false;
		$this->result ['developer'] .= $message;
	}
	
	function createMessageSuccess($message = "Success") {
		$this->result ['status'] = true;
		$this->result ['developer'] .= $message;
	}
	
	function validateObject($isUpdate = false) {
		if (! method_exists ( $this->basicObject, 'validate' ))
			return true;
		
		if ($this->basicObject->validate ( $isUpdate )) {
			$this->createMessageSuccess ( $this->basicObject->message );
			return true;
		}
		
		$this->createMessageError ( $this->basicObject->message );
		return false;
	}
	
	public function getarrayGallery($id = "", $module = "pages") {
		global $vsStd;
		if (! id)
			return "";
		
		$vsStd->requireFile ( CORE_PATH . "gallerys/gallerys.php" );
		$this->gallerys = new gallerys ();
		$vsRelation = VSFactory::getRelation();
		$vsRelation->setRelId ( $id );
		$vsRelation->setTableName ( "gallery_" . $module );
		$strId = $vsRelation->getObjectByRel ();
		if ($strId) {
			$arrayFile = $this->gallerys->getFileByAlbumId ( $strId );
		}
		return $arrayFile;
	}
	
	function getNumberOfObject() {
		$DB = VSFactory::createConnectionDB();
		$DB->simple_construct ( array ('select' => "COUNT(*) as total", 'from' => $this->tableName, 'where' => $this->condition ) );
		$DB->simple_exec ();
		$result = $DB->fetch_row ();
		return $result ['total'];
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $id
	 * @param unknown_type $search
	 * @return Character
	 */
	
	function getObjectById($id) {
		global $bw;
		$vsLang = VSFactory::getLangs();
		$this->resetResult ();
		$id = intval ( $id );
		$cond = $this->prefixField . $this->primaryField . " = " . $id;
//		if ($search) {
//			$this->tableName = $this->tableName . " left join vsf_search on ({$this->tableName}Id = searchId AND searchModule = '" . $bw->input ['module'] . "' )";
//		}
		$DB = VSFactory::createConnectionDB();
		$DB->simple_select ( $this->fieldsString, $this->tableName, $cond );
		$DB->simple_exec ();
		
		$objDB = $DB->fetch_row ();
		if (is_array ( $objDB )) {
			$this->basicObject->convertToObject ( $objDB );
			$this->createMessageSuccess ( $vsLang->getWords ( 'develop_get_obj_success', "Execute successful" ) );
			return $this->basicObject;
		}
		
		$this->createMessageError ( $vsLang->getWords ( 'develop_get_obj_fail', "No object was found" ) );
		$this->resetQuery ();
		return $this->basicObject;
	}
	
	function getOneObjectsByCondition($method = 'getId') {
		$DB = VSFactory::createConnectionDB();
		
		$this->limit = array (0, 1 );
		$this->getObjectsByCondition ( $method );
		
		if ($this->arrayObj)
			return $this->basicObject = current ( $this->arrayObj );
		return false;
	}
	
	function getObjectsByCondition($method = 'getId', $group = 0) {
		global  $bw, $bug;
		$DB = VSFactory::createConnectionDB();
		$this->resetResult ();
		$this->createMessageSuccess ( "Execute successful");
		
		$this->autokill ();
		$query = array ('select' => $this->fieldsString, 'from' => $this->tableName, 'where' => $this->condition );
		if (count ( $this->limit ))
			$query ['limit'] = $this->limit;
		
		$query ['order'] = $this->order ? $this->order : $this->getPrimaryField () . " desc";
		
		if ($this->groupby) {
			$query ['groupby'] = $this->groupby;
			$this->having ? $query ['having'] = $this->having : "";
		}
		$DB->simple_construct ( $query );
		$this->resetQuery ();
		if (! $DB->simple_exec ()) {
			$this->createMessageError ( "Cannot connect to database"  );
			return array ();
		}
	
		$result = $DB->fetch_row ();
		if (! is_array ( $result )) {
			$this->createMessageError (  "No object was found"  );
			return array ();
		}
	
		$count = 0;
		
		while ( $result ) {
			$this->createBasicObject ();
			
			$this->basicObject->convertToObject ( $result );
			$this->basicObject->stt = ++ $count;
			if ($group) {
				if (method_exists ( $this->basicObject, 'getId' )) {
					$this->arrayObj [$this->basicObject->$method ()] [$this->basicObject->getId ()] = $this->basicObject;
				} else {
					$this->arrayObj [$this->basicObject->getRelId ()] [$this->basicObject->getRelId ()] = $this->basicObject;
				}
			
			} else if (method_exists ( $this->basicObject, 'getId' ))
				$this->arrayObj [$this->basicObject->$method ()] = $this->basicObject;
			else
				$this->arrayObj [$this->basicObject->getRelId ()] = $this->basicObject;
			$result = $DB->fetch_row ();
		}
		
		return $this->arrayObj;
	}
	function getObjectsByConditionWithImage($method = 'getId', $group = 0) {
		global  $bw, $bug;
		$DB = VSFactory::createConnectionDB();
		$this->resetResult ();
		$this->createMessageSuccess ( "Execute successful");
		
		$this->autokill ();
//		$query = array ('select' => $this->fieldsString, 'from' => $this->tableName, 'where' => $this->condition );
//		if (count ( $this->limit ))
//			$query ['limit'] = $this->limit;
		
		$query ['order'] = $this->order ? $this->order : $this->getPrimaryField () . " desc";
		
//		if ($this->groupby) {
//			$query ['groupby'] = $this->groupby;
//			$this->having ? $query ['having'] = $this->having : "";
//		}
		$condition=$this->condition?"WHERE {$this->condition}":"";
		$this->imageField=$this->imageField?$this->imageField:"image";
		$query ['limit']=count($this->limit)>=2?("LIMIT ".$this->limit[0].",".$this->limit[1]):"";
		$_query="
			SELECT T.*,vsf_file.id AS fid ,vsf_file.intro AS fintro,vsf_file.name AS fname,vsf_file.path AS fpath,
			vsf_file.title AS ftitle,
			vsf_file.type AS ftype,vsf_file.url AS furl
			FROM (SELECT {$this->fieldsString} 
			FROM vsf_{$this->tableName} $condition ORDER BY {$query ['order']}
			{$query ['limit']}
			) AS T LEFT JOIN vsf_file ON T.{$this->imageField}=vsf_file.id
		";
		$DB->query ( $_query );
//		$this->resetQuery ();
//		if (! $DB->simple_exec ()) {
//			$this->createMessageError ( "Cannot connect to database"  );
//			return array ();
//		}
	
		$result = $DB->fetch_row ();
		if (! is_array ( $result )) {
			$this->createMessageError (  "No object was found"  );
			return array ();
		}
	
		$count = 0;
		while ( $result ) {
			$this->createBasicObject ();
			
			$this->basicObject->convertToObject ( $result );
			$this->basicObject->vsImage=new File();
			$this->basicObject->vsImage->convertToObjectDelta ( $result );
			$this->basicObject->stt = ++ $count;
			if ($group) {
				if (method_exists ( $this->basicObject, 'getId' )) {
					$this->arrayObj [$this->basicObject->$method ()] [$this->basicObject->getId ()] = $this->basicObject;
				} else {
					$this->arrayObj [$this->basicObject->getRelId ()] [$this->basicObject->getRelId ()] = $this->basicObject;
				}
			
			} else if (method_exists ( $this->basicObject, 'getId' ))
				$this->arrayObj [$this->basicObject->$method ()] = $this->basicObject;
			else
				$this->arrayObj [$this->basicObject->getRelId ()] = $this->basicObject;
			$result = $DB->fetch_row ();
		}
		
		return $this->arrayObj;
	}
	function getArrayByCondition($method = 'Id', $group = 0) {
		$DB=VSFactory::createConnectionDB();
		$this->resetResult ();
		$this->createMessageSuccess ( "Execute successful"  );
		
		$this->autokill ();
		$query = array ('select' => $this->fieldsString, 'from' => $this->tableName, 'where' => $this->condition );
		
		if (count ( $this->limit ))
			$query ['limit'] = $this->limit;
		
		$query ['order'] = $this->order ? $this->order : $this->getPrimaryField () . " desc";
		
		if ($this->groupby) {
			$query ['groupby'] = $this->groupby;
			$this->having ? $query ['having'] = $this->having : "";
		}
		$DB->simple_construct ( $query );
		$this->resetQuery ();
		
		if (! $DB->simple_exec ()) {
			$this->createMessageError (  'Cannot connect to database' );
			return array ();
		}
		
		$result = $DB->fetch_row ();
		if (! is_array ( $result )) {
			$this->createMessageError ( 'No object was found' );
			return array ();
		}
		
		$count = 0;
		while ( $result ) {
			if ($group)
				$return [$result [$this->primaryField]] = $result;
			else
				$return [] = $result;
			
			$result = $DB->fetch_row ();
		}
		
		$this->resetQuery ();
		return $return;
	}
	
	function deleteObjectByCondition() {
		$DB = VSFactory::createConnectionDB();
		$this->onDeleteObjectByCondition($this->condition);
		$this->resetResult ();
		call_plugin("plugin_".get_class($this)."_delete_by_condition",array(&$this->condition));
		$this->createMessageSuccess ( 'Delete object successfully!' );
		$DB->simple_delete ( $this->tableName, $this->condition );
		if (! $DB->simple_exec ()) {
			$this->createMessageError ( 'Cannot connect to database' );
		}
		
		$this->resetQuery ();
		return $this->result ['status'];
	}
	
	function deleteObjectById($id) {
		$this->onDeleteObjectById($id);
		call_plugin("plugin_".get_class($this)."_delete",array(&$this->condition));
		$this->condition = $this->prefixField . $this->primaryField . "=" . intval ( $id );
		return $this->deleteObjectByCondition ();
	}
	
	function updateObjectByCondition($updateFields = array()) {
		$DB = VSFactory::createConnectionDB();
		$this->resetResult ();
		call_plugin("plugin_".get_class($this)."_update_by_condition",array(&$updateFields));
		$this->createMessageSuccess ( 'Updated object successfully!');
		$updateFields = $updateFields ? $updateFields : $this->fields;
		
		
		if (! $DB->do_update ( $this->tableName, $updateFields, $this->condition )) {
			$this->createMessageError ( 'Cannot connect to database' );
		}
		$this->resetQuery ();
		return $this->result ['status'];
	}
	
	function updateObjectById($obj = null) {
		if ($obj)
			$this->basicObject = $obj;
		if (!$this->validateObject ( true )){
			return false;
		}
		$this->onUpdateObject($this->basicObject );	
		call_plugin("plugin_".get_class($this)."_update",array(&$this->basicObject));
		$this->condition = $this->prefixField . $this->primaryField . "=" . intval ( $this->basicObject->getId () );
		
		return $this->updateObjectByCondition ( $this->basicObject->convertToDB () );
	}
	
	function updateObject($obj = null) {
		if ($obj)
			$this->basicObject = $obj;
		if (! $this->validateObject ( true ))
			return false;
		call_plugin("plugin_".get_class($this)."_update",array(&$this->basicObject));
		$this->onUpdateObject($this->basicObject );
		$this->condition = $this->prefixField . $this->primaryField . "=" . intval ( $this->basicObject->getId () );
		return $this->updateObjectByCondition ( $this->basicObject->convertToDB () );
	}
	
	function insertObject($object = null) {
		$DB = VSFactory::createConnectionDB();
		$vsLang = VSFactory::getLangs();
		$this->resetResult ();
		if(!$this->basicObject->getPostDate()){
			$this->basicObject->setPostDate(time());
		}
		if ($object instanceof $this->basicClassName && is_object ( $object ) && $object)
			$this->basicObject = $object;
		call_plugin("plugin_".get_class($this)."_insert",array(&$this->basicObject));
		
		if (! $this->validateObject ())
			return false;
		$this->onInsertObject($this->basicObject);
		$dbObj = $this->basicObject->convertToDB ();
		if ($DB->do_insert ( $this->tableName, $dbObj )) {
			$this->createMessageSuccess ( 'Insert Object success' );
			$this->basicObject->setId ( $DB->get_insert_id () );
			return $this->result ['status'];
		}
		
		$this->createMessageError ( 'Cannot connect to database' );
		unset ( $dbObj );
		return $this->result ['status'];
	}
	
	function executeQuery($query = "", $obj = 1, $method = "Id") {
		if (! $query)
			return false;
			
		$DB = VSFactory::createConnectionDB();
		$DB->cur_query = $query;
		$DB->simple_exec ();
		
		$count = 0;
		$record = $DB->fetch_row ();
		$this->resetQuery ();
		while ( $record ) {
			if ($obj) {
				$obj = $this->createBasicObject ();
				$obj->convertToObject ( $record );
				$obj->stt = ++ $count;
				$func = "get" . $method;
				$result [$obj->$func ()] = $obj;
			} else
				$result [] = $record;
			$record = $DB->fetch_row ();
		}
		
		$this->resetQuery ();
		return $result;
	}
	
	function executeNoneQuery($query = "") {
		if (! $query)
			return false;
		$DB = VSFactory::createConnectionDB();
		$DB->cur_query = $query;
		$DB->simple_exec ();
		return true;
	}
	
//	function getNavigator($idCate = 0) {
//		global $bw, $vsTemplate, $vsPrint;
//		$vsLang = VSFactory::getLangs();
//		$vsMenu = VSFactory::getMenus();
//		$re = "<a href='{$bw->base_url}{$bw->input['module']}/'>{$vsLang->getWords('pageTitle', 'sangpm')}</a>";
//		if ($idCate) {
//			$result = $vsMenu->extractNodeInTree ( $idCate, $this->getCategories ()->getChildren () );
//			if ($result ['ids']) { //
//				$vsPrint->mainTitle = $vsPrint->pageTitle = $result ['category']->getTitle ();
//				$result ['ids'] = array_reverse ( $result ['ids'] );
//				foreach ( $result ['ids'] as $b ) {
//					$Obj = $vsMenu->getCategoryById ( $b );
//					if ($Obj)
//						$re .= " / <a href='{$Obj->getCatUrl($bw->input['module'])}'>{$Obj->getTitle()}</a>";
//				}
//			
//			}
//		
//		}
//		$vsTemplate->global_template->navigator = $re;
//		return $re;
//	
//	}
//	///hàm này để làm gì?????
//	function convertFileObject($array, $module) {
//		global $imgfile;
//		$vsLang = VSFactory::getLangs();
//		if (! $imgfile [$module]) {
//			if (! file_exists ( CACHE_PATH . "file/" . $vsLang->currentLang->getFoldername () . "/" . $module . ".cache" ))
//				VSFactory::getFiles()->buildCacheFile ( $module );
//			require_once (CACHE_PATH . "file/" . $vsLang->currentLang->getFoldername () . "/" . $module . ".cache");
//			$imgfile [$module] = $arrayFile;
//		}
//		
//		foreach ( $array as $value ) {
//			$value->convertToObject ( $imgfile [$module] [$value->getImage ()] );
//		}
//	
//	}
	
//	function changeCateList() {
//		global $bw;
//		$this->setCondition ( $this->primaryField . " in ({$bw->input[2]})" );
//		$this->updateObjectByCondition ( array ($this->categoryField => $bw->input [3] ) );
//	
//	}
	
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
	
	function __destruct() {
		unset ( $this );
	}
	/**
	 * @return the $prefixField
	 */
	public function getPrefixField() {
		return $this->prefixField;
	}
	
	public function getCategoryField() {
		return $this->categoryField;
	}
	
	/**
	 * @return the $tableName
	 */
	public function getTableName() {
		return $this->tableName;
	}
	
	/**
	 * @return the $primaryField
	 */
	public function getPrimaryField() {
		return $this->primaryField;
	}
	
	/**
	 * @return the $fieldsString
	 */
	public function getFieldsString() {
		return $this->fieldsString;
	}
	
	/**
	 * @return the $fields
	 */
	public function getFields() {
		return $this->fields;
	}
	
	/**
	 * @return the $result
	 */
	public function getResult() {
		return $this->result;
	}
	
	/**
	 * @return the $condition
	 */
	public function getCondition() {
		return $this->condition;
	}
	
	/**
	 * @return the $order
	 */
	public function getOrder() {
		return $this->order;
	}
	
	/**
	 * @return the $groupby
	 */
	public function getGroupby() {
		return $this->groupby;
	}
	
	/**
	 * @return the $having
	 */
	public function getHaving() {
		return $this->having;
	}
	
	/**
	 * @return the $limit
	 */
	public function getLimit() {
		return $this->limit;
	}
	
	/**
	 * @return the $basicClassName
	 */
	public function getBasicClassName() {
		return $this->basicClassName;
	}
	
	/**
	 * @return the $basicObject
	 */
	public function getBasicObject() {
		return $this->basicObject;
	}
	
	/**
	 * @return the $arrayObj
	 */
	public function getArrayObj() {
		return $this->arrayObj;
	}
	
	/**
	 * @param field_type $prefixField
	 */
	public function setPrefixField($prefixField) {
		$this->prefixField = $prefixField;
	}
	
	/**
	 * @param field_type $tableName
	 */
	public function setTableName($tableName) {
		$this->tableName = $tableName;
	}
	
	/**
	 * @param field_type $primaryField
	 */
	public function setPrimaryField($primaryField) {
		$this->primaryField = $primaryField;
	}
	
	/**
	 * @param field_type $fieldsString
	 */
	public function setFieldsString($fieldsString) {
		$this->fieldsString = $fieldsString;
	}
	
	/**
	 * @param array $fields
	 */
	public function setFields($fields) {
		$this->fields = $fields;
	}
	
	/**
	 * @param field_type $result
	 */
	public function setResult($result) {
		$this->result = $result;
	}
	
	/**
	 * @param field_type $condition
	 */
	public function setCondition($condition) {
		$this->condition = $condition;
	}
	
	/**
	 * @param field_type $order
	 */
	public function setOrder($order) {
		$this->order = $order;
	}
	
	/**
	 * @param field_type $groupby
	 */
	public function setGroupby($groupby) {
		$this->groupby = $groupby;
	}
	
	/**
	 * @param field_type $having
	 */
	public function setHaving($having) {
		$this->having = $having;
	}
	
	/**
	 * @param field_type $limit
	 */
	public function setLimit($limit) {
		$this->limit = $limit;
	}
	
	/**
	 * @param field_type $basicClassName
	 */
	public function setBasicClassName($basicClassName) {
		$this->basicClassName = $basicClassName;
	}
	
	/**
	 * @param field_type $basicObject
	 */
	public function setBasicObject($basicObject) {
		$this->basicObject = $basicObject;
	}
	
	/**
	 * @param field_type $arrayObj
	 */
	public function setArrayObj($arrayObj) {
		$this->arrayObj = $arrayObj;
	}
	
	function getObjPage($module = "", $status = 1, $limit = 10) {
		$vsMenu = VSFactory::getMenus();
		if ($module)
			$categories = $vsMenu->getCategoryGroup ( $module );
		else
			$categories = $this->getCategories ();
		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
		$this->setFieldsString ( "{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}Image" );
		$this->setLimit ( array (0, $limit ) );
		$this->setOrder ( "{$this->tableName}Index ASC , {$this->tableName}Id DESC" );
		$cond = "{$this->tableName}Status >={$status} and {$this->tableName}CatId in ({$strIds}) ";
		if ($this->getCondition ())
			$cond .= " and " . $this->getCondition ();
		$this->setCondition ( $cond );
		$list = $this->getObjectsByCondition ();
		if ($list)
			$this->convertFileObject ( $list, $module );
		
		return $list;
	}
//	function getObjByCode($code, $module = "", $limit = 1) {
//		$vsMenu = VSFactory::getMenus();
//		if ($module)
//			$categories = $vsMenu->getCategoryGroup ( $module );
//		else
//			$categories = $this->getCategories ();
//		
//		$strIds = $vsMenu->getChildrenIdInTree ( $categories );
//		$this->setCondition ( "{$this->tableName}Code='" . $code . "' AND {$this->tableName}CatId in (" . $strIds . ") AND {$this->tableName}Status > 0" );
//		$this->setLimit ( array (0, $limit ) );
//		$list = $this->getObjectsByCondition ();
//		if ($list)
//			$this->convertFileObject ( $list, $module );
//		
//		return $list;
//	}
	
	/**
	 * @param $categories the $categories to set
	 */
	public function setCategories($categories) {
		$this->categories = $categories;
	}
	
	/**
	 * @return Menu
	 */
	public function getCategories() {
		if($this->categories===NULL){
			if(!$this->categoryName) throw  new Exception("categoryName has not been set");
			$this->categories=VSFactory::getMenus()->getCategoryGroup($this->categoryName);
		}
		return $this->categories;
	}
	
	function getPageList($url = "", $objIndex = 3, $size = 10, $ajax = 0, $callack = "") {
		global $vsStd, $bw;
		$vsStd->requireFile ( LIBS_PATH . "/Pagination.class.php" );
		
		$total = $this->getNumberOfObject ();
		if ($size < $total) {
			$pagination = new VSFPagination ();
			$pagination->ajax = $ajax;
			$pagination->callbackobjectId = $callack;
			$pagination->url = $ajax ? ltrim ( $url, '/' ) . "/" : $bw->base_url . (trim ( $url, '/' ) . "/");
			
			$pagination->p_Size = $size;
			$pagination->p_TotalRow = $total;
			$pagination->SetCurrentPage ( $objIndex );
			$pagination->BuildPageLinks ();
			$this->setLimit ( array ($pagination->p_StartRow, $pagination->p_Size ) );
		}
		$option ['paging'] = $pagination->p_Links;
		
		$option ['pageList'] = $this->getObjectsByCondition ();
		$option ['total'] = $total;
		return $option;
	}
	
	function getAdvancePageList($url, $objIndex=3, $size=10, $ajax = 0, $callack="", $method='getId', $group=0, $type = 0, $extend = array()){
		global $vsStd,$bw;
		$vsStd->requireFile(LIBS_PATH."Pagination.class.php");
		$total = $this->getNumberOfObject();
		if($size < $total){
			$pagination = new VSFPagination();
			$pagination->text['p_Page']		= "";
			$pagination->ajax				= $ajax;
			$pagination->callbackobjectId 	= $callack;
			$pagination->url 				= $ajax?ltrim($url,'/')."/":$bw->base_url.(trim($url,'/')."/");
		
			$pagination->p_Size 			= $size;
			$pagination->p_TotalRow 		= $total;
			$pagination->SetCurrentPage($objIndex);
			$pagination->BuildPageLinks();
			$this->setLimit(array($pagination->p_StartRow, $pagination->p_Size));
		}

		
		$option['current'] = $pagination->p_Current;
		$option['paging'] = $pagination->p_Links;

		$option['pageList'] = $this->getAdvanceObjectsByCondition($method, $group, $type, $extend);
		$option['total'] = $total;
		return $option;
	}
	
	function getAdvanceObjectsByCondition($method='getId', $group=0, $type = 0, $extend = array()){
		$vsLang = VSFactory::getLangs();
		$DB=VSFactory::createConnectionDB();
		$this->resetResult();
		$this->createMessageSuccess('Execute successful');
		
		$this->autokill();
		$query = array(
					'select'=> $this->fieldsString,
					'from'	=> $this->tableName,
					'where'	=> $this->condition
		);

		if(count($this->limit)) $query['limit'] = $this->limit;

		$query['order'] = $this->order ? $this->order : $this->getPrimaryField()." desc";
		
		if($this->groupby){
			$query['groupby'] = $this->groupby;
			$this->having ? $query['having'] = $this->having : "";
		} 
		$DB->simple_construct($query);
		$this->resetQuery();

		
		if(!$DB->simple_exec()) {
			$this->createMessageError('Cannot connect to database');
			return array();
		}

		$result = $DB->fetch_row();
		if(!is_array($result)){
			$this->createMessageError('No object was found');
			return array();
		}
		
		$count = 0;
		while($result) {
			$obj = $this->createBasicObject();
			$obj->convertToObject($result);
			
			if($type){
				if($type == 1){
					foreach($extend as $key => $exp){
						$temp = new $exp();
						$temp->convertToObject($result);
						$obj->$key = $temp;
					}
				}
				if($type == 2){
					foreach($extend as $key => $exp){
						$obj->$key = $result[$exp];
					}
				}
			}
			
			$obj->stt = ++$count;
			if($method){
				if($group) $this->arrayObj[$obj->$method()][$obj->getId()] = $obj;
				else $this->arrayObj[$obj->$method()] = $obj;
			}else $this->arrayObj[] = $obj;
			
			$result = $DB->fetch_row();
		}

		$this->resetQuery();
		return $this->arrayObj;
	}
	
	function multiInsert($data){
		if(!is_array($data)){
			$this->result['status'] = 'No data to insert';
			return $this->result['status'] = false; 
		}
		
		if(!VSFactory::createConnectionDB()->insert_multi_record($this->tableName, $data)){
			$this->result['status'] = 'error while execute query';
			return $this->result['status'] = false; 
		}
		return $this->result['status'] = true;
	}
	
	function singleInsert($data, &$returnId = 0){
		$this->result['status'] = true;
		if(!is_array($data)){
			$this->result['status'] = 'No data to insert';
			return $this->result['status'] = false; 
		}
		
		if(!VSFactory::createConnectionDB()->do_insert($this->tableName, $data)){
			$this->result['status'] = 'error while execute query';
			return $this->result['status'] = false; 
		}
		
		$returnId = VSFactory::createConnectionDB()->get_insert_id();
		return true;
	}
	
	function singleUpdate($data, $cond){
		$this->result['status'] = true;
		if(!is_array($data)){
			$this->result['status'] = 'No data to insert';
			return $this->result['status'] = false; 
		}
		if(!VSFactory::createConnectionDB()->do_update($this->tableName, $data, $cond)){
			$this->result['status'] = 'error while execute query';
			return $this->result['status'] = false; 
		}
		
		$returnId = VSFactory::createConnectionDB()->get_insert_id();
		return true;
	}
	/**
	 * even when basicObject update
	 * @param $obj BasicObject
	 */
	function onUpdateObject($obj){
		return ;
	}
/**
	 * even when basicObject insert
	 * @param $obj BasicObject
	 */
	function onInsertObject($obj){
		return ;
	}
	/**
	 * even when delete one object
	 * @param $id int
	 */
	function onDeleteObjectById($id){
		return ;
	}
	/**
	 * even when delete multiobject
	 * @param $condition string
	 */
	function onDeleteObjectByCondition(&$condition){
		return ;
	}
	function registerSearch($title,$intro,$link,$module){
		
	}
	static function getObjModule($root,$module,$status, $limit, $type) {
		require_once CORE_PATH . $root . "/" . $root . '.php';		
		$pages = new $root ();
		
		$category = VSFactory::getMenus ()->getCategoryGroup ($module );
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category );
		if($pages->getCategoryField())
		$pages->setCondition ( "status{$status} and catId in ($ids)" );
		else 
		$pages->setCondition ( "status{$status}");
		$pages->setOrder ( "`index` DESC ,id DESC" );
		if ($limit)
			$pages->setLimit ( array (0, $limit ) );
		if ($type == 1)
			return $pages->getOneObjectsByCondition ();
		else
			return $pages->getObjectsByCondition ();
	}
	static function getObjModule2($root,$module,$status, $limit, $type) {
		require_once CORE_PATH . $root . "/" . $root . '.php';		
		$pages = new $root ();
		$category = VSFactory::getMenus ()->getCategoryGroup ( $module );
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category );
		if($pages->getCategoryField())
		$pages->setCondition ( "status{$status} and catId in ($ids)" );
		else 
		$pages->setCondition ( "status{$status}");
		$pages->setOrder ( "`index` asc,id DESC" );
		if ($limit)
			$pages->setLimit ( array (0, $limit ) );
		if ($type == 1)
			return $pages->getOneObjectsByCondition ();
		else
			return $pages->getObjectsByCondition ();
	}
}