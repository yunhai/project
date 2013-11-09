<?php
class Object{

	protected $prefixField 		= "";
	protected $tableName 		= "";
        protected $categoryField        = "";
	public $categories 		= array();
        /**
	 * $primaryField is name of primary key for table
	 */
	protected $primaryField		= "";
	protected $fieldsString   	= "*";

	/**
	 * @var array $fields used for DB function that use array
	 */
	protected $fields = array();
	/**
	 * $result is a array ,this is contain status and  message after excute a methods
	 * $result['status']
	 * $result['developer]
	 */
	public $result 		= array();

	/**
	 * $query is array contain select query string
	 * $query['select'] = "*";
	 * $query['from']   = "abc";
	 * $query['where']	= "id = 4";
	 * $query['limit']  = array($start, $end);
	 *
	 * => query string: select * from abc where id = 4 limit (0, 4)
	 */
	

	protected $condition		= "";
	protected $order			= "";
	protected $groupby			= "";
	protected $having			= "";
	protected $limit			= array();
	public $basicClassName = null;
	public  $basicObject 	= null;
	protected $arrayObj = array();
	public $vsLang,$vsMenu,$vsFile,$vsRelation;

	function __construct(){
		global $vsLang,$vsMenu,$vsFile,$vsRelation;
		$this->vsMenu 		= $vsMenu;
		$this->resetResult();
		$this->resetQuery();
		$this->vsLang = $vsLang;
		$this->vsRelation = $vsRelation;
		$this->vsFile = $vsFile;
		$this->fieldsString = "*";
		$this->arrayObj = array();
	}

	function autokill(){
	}

	
	protected function __reset(){
		$this->tableName		= null;
		$this->prefixField		= null;
		$this->basicClassName	= null;
		$this->basicObject 		= null;
		$this->primaryField		= null;
		$this->fieldsString		= null;
		$this->fields			= array();
		$this->arrayObj			= array();

		$this->resetQuery();
		$this->resetResult();
	}

	


	function createBasicObject() {
		global $vsStd,$bug;
		if ($this->basicClassName) {
			$this->basicObject = new $this->basicClassName ();
			return $this->basicObject;
		}
		return false;
	}
	function resetResult(){
		$this->arrayObj = array();
		$this->result['status'] = true;
		$this->result['developer'] = "";
	}

	function resetQuery(){
		$this->fieldsString = "*";
		$this->condition 	= "";
		$this->order 		= "";
		$this->groupby 		= "";
		$this->limit 		= array();
	}

	function createMessageError($message = "Error"){
		$this->result['status'] = false;
		$this->result['developer'] .= $message;
	}

	function createMessageSuccess($message = "Success"){
		$this->result['status'] = true;
		$this->result['developer'].= $message;
	}

	function validateObject($isUpdate = false){
		if(!method_exists($this->basicObject, 'validate')) return true;

		if($this->basicObject->validate($isUpdate)){
			$this->createMessageSuccess($this->basicObject->message);
			return true;
		}

		$this->createMessageError($this->basicObject->message);
		return false;
	}


	function getNumberOfObject() {
		global $DB;
		$DB->simple_construct(
			array(	'select'	=> "COUNT(".$this->prefixField.$this->primaryField.") as total",
					'from'		=> $this->tableName,
					'where'		=> $this->condition
			)
		);
		$DB->simple_exec();
		$result = $DB->fetch_row();
		return $result['total'];
	}


	function getObjectById($id,$search=0) {
		global $DB,$vsLang,$bw;
		$this->resetResult();
		$id = intval($id);
                $cond = $this->prefixField.$this->primaryField." = ".$id;
                if($search){
                    $this->tableName = $this->tableName." left join vsf_search on ({$this->tableName}Id = searchId AND searchModule = '".$bw->input['module']."' )";
//                    $cond .= " AND searchModule = '".$bw->input['module']."'";
                }
		$DB->simple_select($this->fieldsString, $this->tableName, $cond);
		$DB->simple_exec();
		$objDB = $DB->fetch_row();
		if(is_array($objDB)) {
			$this->basicObject->convertToObject($objDB);
			$this->createMessageSuccess($vsLang->getWords('global_dev_get_obj_success',"Execute successful"));
			return $this->basicObject;
		}
		
		$this->createMessageError($vsLang->getWords('global_dev_get_obj_fail', "No object was found"));
		$this->resetQuery();
		return false;
	}

	function getOneObjectsByCondition($method='getId'){
		global $DB;
				
		$this->limit = array(0,1);
		$this->getObjectsByCondition($method);
		
		if($this->arrayObj)  return $this->obj = $this->basicObject = current($this->arrayObj); 
		return false;
	}


	function getObjectsByCondition($method = 'getId', $group = 0) {
		global $DB, $vsLang, $bw,$bug;
		$this->resetResult ();
		$this->createMessageSuccess ( $vsLang->getWords ( 'global_dev_get_obj_success', "Execute successful" ) );
		
		$this->autokill ();
		$query = array ('select' => $this->fieldsString, 'from' => $this->tableName, 'where' => $this->condition );
		if (count ( $this->limit ))
			$query ['limit'] = $this->limit;
		
		
		
		if ($this->groupby) {
			$query ['groupby'] = $this->groupby;
			$this->having ? $query ['having'] = $this->having : "";
		}else $query ['order'] = $this->order ? $this->order : $this->getPrimaryField () . " desc";
		
		$DB->simple_construct ( $query );
		$this->resetQuery ();
		
		if (! $DB->simple_exec ()) {
			$this->createMessageError ( $vsLang->getWords ( 'global_dev_connect_db_fail', "Cannot connect to database" ) );
			return array ();
		}
		
		$result = $DB->fetch_row ();
		if (! is_array ( $result ))			
			return array ();
		
		
		$count = 0;
		
		while ( $result ) {
			$this->createBasicObject ();

			$this->basicObject->convertToObject ( $result );
	
			$this->basicObject->stt = ++ $count;
			if ($group){
				if(method_exists($this->basicObject, 'getId')){
					$this->arrayObj [$this->basicObject->$method ()] [$this->basicObject->getId ()] = $this->basicObject;
				}
				else{
					$this->arrayObj[$this->basicObject->getRelId() ][$this->basicObject->getRelId() ] =  $this->basicObject;
				}
			}
			else
				if(method_exists($this->basicObject, 'getId'))
					$this->arrayObj [$this->basicObject->$method ()] = $this->basicObject;
				else 
					$this->arrayObj[$this->basicObject->getRelId() ] =  $this->basicObject;
			$result = $DB->fetch_row ();
		}
		
		return $this->arrayObj;
	}

	function getArrayByCondition($method='Id', $group=0) {
		global $DB,$vsLang;
		$this->resetResult();
		$this->createMessageSuccess($vsLang->getWords('global_dev_get_obj_success', "Execute successful"));
		
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
			$this->createMessageError($vsLang->getWords('global_dev_connect_db_fail', "Cannot connect to database"));
			return array();
		}

		$result = $DB->fetch_row();
		if(!is_array($result)){
			$this->createMessageError($vsLang->getWords('global_dev_get_obj_fail', "No object was found"));
			return array();
		}
		
		$count = 0;
		while($result){
			if($group)
				$return[$result[$this->primaryField]] = $result;
			else
				$return[] = $result;
			
			$result = $DB->fetch_row();
		}
		
		$this->resetQuery();
		return $return;
	}
	
	function deleteObjectByCondition() {
		global $DB,$vsLang;
		$this->resetResult();

		$this->createMessageSuccess($vsLang->getWords('global_dev_delete_object_success',"Delete object successfully!"));
		$DB->simple_delete($this->tableName, $this->condition);
		if(!$DB->simple_exec()) {
			$this->createMessageError($vsLang->getWords('global_dev_connect_db_fail', "Cannot connect to database"));
		}

		$this->resetQuery();
		return $this->result['status'];
	}

	function deleteObjectById($id) {
		$this->condition = $this->prefixField.$this->primaryField ."=".intval($id);
		return $this->deleteObjectByCondition();
	}

	function updateObjectByCondition($updateFields = array()) {
		global $DB,$vsLang;
		$this->resetResult();
		$this->createMessageSuccess($vsLang->getWords('global_dev_update_object_success', "Updated object successfully!"));

		$updateFields  = $updateFields ? $updateFields : $this->fields;
		if(!$DB->do_update($this->tableName,$updateFields, $this->condition)) {
			$this->createMessageError($vsLang->getWords('global_dev_connect_db_fail', "Cannot connect to database"));
		}
		$this->resetQuery();
		return $this->result['status'];
	}


	function updateObjectById($obj = null){
		if($obj) $this->basicObject = $obj;
		if(!$this->validateObject(true)) return false;
		$this->condition = $this->prefixField.$this->primaryField ."=".intval($this->basicObject->getId());
		return $this->updateObjectByCondition($this->basicObject->convertToDB());
	}
	
	function updateObject($obj = null){
		if($obj) $this->basicObject = $obj;
		if(!$this->validateObject(true)) return false;
		$this->condition = $this->prefixField.$this->primaryField ."=".intval($this->basicObject->getId());
		return $this->updateObjectByCondition($this->basicObject->convertToDB());
	}


	function insertObject($object = null) {
		global $DB,$vsLang;
		$this->resetResult();
	
		if($object instanceof $this->basicClassName && is_object($object) && $object)
			$this->basicObject = $object;
		
		if(!$this->validateObject()) return false;

		$dbObj = $this->basicObject->convertToDB();
		if($DB->do_insert($this->tableName,$dbObj)){
			$this->createMessageSuccess($vsLang->getWords('insert_success','Insert Object success'));
			$this->basicObject->setId($DB->get_insert_id());
			return  $this->result['status'];
		}
		
		$this->createMessageError($vsLang->getWords('global_dev_connect_db_fail', "Cannot connect to database"));
		unset($dbObj);
		return $this->result['status'];
	}

	function executeQuery($query = "", $obj = 1, $method = "Id"){
		if(!$query) return false;
		global $DB;
		$DB->cur_query = $query;
		$DB->simple_exec();
		
		
		$count = 0;
		$record = $DB->fetch_row();
		$this->resetQuery();
		while($record){
			if($obj){
				$obj = $this->createBasicObject();
				$obj->convertToObject($record);
				$obj->stt = ++$count;
				$func = "get".$method;
				$result[$obj->$func()] = $obj;
			}else
				$result[] = $record;
			$record = $DB->fetch_row();
		}
		
		$this->resetQuery();
		return $result;
	}

	function executeNoneQuery($query = ""){
		if(!$query) return false;
		global $DB;
		$DB->cur_query = $query;
		$DB->simple_exec();
		return true;
	}
	
function getNavigator($idCate=0){
		global $bw,$vsLang,$vsMenu,$vsTemplate,$vsPrint;
                
		$re = "<div itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a itemprop=\"url\" href='{$bw->base_url}/'><span itemprop=\"title\">{$vsLang->getWords('global_navigator_home', 'Home')}</span></a></div>";
				if($bw->input['module']!='home')
      		$re .= "<div itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a itemprop=\"url\" href='{$bw->base_url}{$bw->input['module']}/'><span itemprop=\"title\">{$vsLang->getWords('pageTitle', $bw->input[0])}</span></a></div>";
			
    	if($idCate){
       		$result = $vsMenu->extractNodeInTree($idCate, $this->getCategories()->getChildren());
         	if($result['ids']){//
           		$result['ids'] = array_reverse($result['ids']);
           		$javascript ="<script>var urlcate ='{$result['category']->getCatUrl($bw->input['module'])}'</script>";
             	foreach($result['ids'] as $b){
              		$Obj = $vsMenu->getCategoryById($b);
                 	if($Obj)$re.= "<div itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\"><a itemprop=\"url\" href='{$Obj->getCatUrl($bw->input['module'])}' class='sub'>  <span itemprop=\"title\">{$Obj->getTitle()}</span></a></div>";
             	}
      		}
    	}
            
      	$vsTemplate->global_template->navigator = $re.$javascript;
           
      	return $re;

	}
        
	function convertFileObject($array, $module, $func = 'getImage'){
		global $imgfile,$vsFile,$vsLang;
		
		if(!$imgfile[$module]){
			$arrayFile = array();
			if(!file_exists(CACHE_PATH."file/".$vsLang->currentLang->getFoldername()."/".$module.".cache"))
			$vsFile->buildCacheFile($module);
			require_once(CACHE_PATH."file/".$vsLang->currentLang->getFoldername()."/".$module.".cache");
			$imgfile[$module] = $arrayFile;
		}
		
		if(is_array($array))
			foreach ($array as $value) {
				$value->convertToObject($imgfile[$module][$value->$func()]);
			}
		else $array->convertToObject($imgfile[$module][$value->$func()]);
		
	}
	
		function changeCateList(){
            global $bw, $vsSettings;
            $this->setCondition($this->primaryField." in ({$bw->input[2]})");
            $this->updateObjectByCondition(array($this->categoryField => $bw->input[3]));

        }

	function insertSearch() {
		global $bw, $vsSettings,$DB;
		
		$categories = $this->getCategories ();

		if ($bw->input ['pageCate'])
			$bw->input [2] = $catId = $bw->input ['pageCate'];
		if ($bw->input ['pageIndex'])
			$bw->input [3] = $bw->input ['pageIndex'];
		else $bw->input [3] = 1 ; 
	
		if (intval ( $catId )) {
			$result = $this->vsMenu->extractNodeInTree ( $catId, $categories->getChildren () );
			if ($result)
				$strIds = trim ( $catId . "," . $this->vsMenu->getChildrenIdInTree ( $result ['category'] ), "," );
		}
		
		if (! $strIds)
			$strIds = $this->vsMenu->getChildrenIdInTree ( $categories );
			
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
		
		$this->setCondition ("{$this->getCategoryField ()} in ({$strIds}) and {$this->tableName}Status >0");
		$this->tableName = $this->tableName." left join vsf_search on ({$this->tableName}Id = searchId AND searchModule = '".$bw->input['module']."' )";
		
		if($bw->input [3]==1)
			$this->setLimit(array(0,$size*$bw->input [3]));
		else 
			$this->setLimit(array(($size*$bw->input [3]) - $size,$size*$bw->input [3]));
		$option = $this->getObjectsByCondition();

         foreach ($option as $obj) {
         	if($obj->record==NULL){
            	$DB->do_insert("search",$obj->convertSearchDB());
         	}  
         } 

	}
	
	function getOtherList($obj) {
		global  $vsSettings, $vsMenu, $bw;
      
		$category = $vsMenu->getCategoryById($obj->getCatId());
		$ids = $vsMenu->getChildrenIdInTree($category);

		if(!$this->order)
			$this->order = "{$this->tableName}Index, {$this->tableName}Id DESC";
		
		if(!$this->condition)
			$this->condition = "{$this->tableName}Status >0 AND {$this->tableName}Id  < {$obj->getId()} AND {$this->tableName}CatId IN ({$ids}) ";
		
		$size = $vsSettings->getSystemKey("{$bw->input['module']}_user_list_number_other", 10, $bw->input['module']);
		
		$this->setLimit(array(0,$size));
		return $this->getObjectsByCondition();
	}
	
	function getOtherListFull($obj) {
		global  $vsSettings, $vsMenu, $bw;
      
		$category = $vsMenu->getCategoryById($obj->getCatId());
		$ids = $vsMenu->getChildrenIdInTree($category);

		if(!$this->condition)
			$this->condition = "{$this->tableName}Status >0 AND {$this->tableName}Id  <> {$obj->getId()} AND {$this->tableName}CatId IN ({$ids})";
		

		if(!$this->order)
			$this->order = "{$this->tableName}Index, {$this->tableName}Id DESC";
		$size = $vsSettings->getSystemKey("{$bw->input['module']}_user_list_number_other", 10, $bw->input['module']);
		
		$this->setLimit(array(0,$size));
		return $this->getObjectsByCondition();
	}
	
	function getLastestList($limit=1) {
		global $vsMenu;
		$ids = $vsMenu->getChildrenIdInTree($this->getCategories());
		if(!$ids) return array();
		
        $this->setFieldsString("{$this->tableName}Id, {$this->tableName}Title, {$this->tableName}Image, {$this->tableName}PostDate,{$this->tableName}CatId, {$this->tableName}Intro, {$this->tableName}Content");
		$this->setOrder("{$this->tableName}Id DESC");
        $this->setCondition("{$this->tableName}CatId IN ({$ids}) AND {$this->tableName}Status > 0");
        $this->setLimit(array(0, $limit));
        
       	$result = $this->getObjectsByCondition();  
       	if($result) $this->convertFileObject($result, "news"); 
       	return $result;
	}
	
	function getGallery($id = "", $module="pages"){
		global $vsStd;
		if(!id) return "";
		
		$vsStd->requireFile(CORE_PATH."gallerys/gallerys.php");
		$this->gallerys = new gallerys();
		$this->vsRelation->setRelId($id);
		$this->vsRelation->setTableName("gallery_".$module);
		$strId=$this->vsRelation->getObjectByRel();
               
		if($strId) return $this->gallerys->getFileByAlbumId($strId);
		
		return array();
	}
	
	function getObjPageCate($module = "",$status = 1,$limit = 10) {
		global $vsMenu;
		if($module)
			$categories = $this->vsMenu->getCategoryGroup($module);
		else $categories = $this->getCategories();
                
                $option['cate']=$categories->getChildren();
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}Image");
                $this->setLimit(array(0, $limit));
                $this->setOrder("{$this->tableName}Index ASC , {$this->tableName}Id DESC");
                $cond = "{$this->tableName}Status >={$status} and {$this->tableName}CatId in ({$strIds}) ";
                if($this->getCondition())
        	$cond .= " and ".$this->getCondition();
		$this->setCondition ( $cond );
                $list = $this->getObjectsByCondition();
                if($list)
                    $this->convertFileObject($list,$module);
                $option['item']=$list;
		return $option;
	}
	
	function getObjPage($module = "",$status = 1,$limit = 10) {
		global $vsMenu;
		if($module)
			$categories = $this->vsMenu->getCategoryGroup($module);
		else $categories = $this->getCategories();
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}Image");
                $this->setLimit(array(0, $limit));
                $this->setOrder("{$this->tableName}Index ASC , {$this->tableName}Id DESC");
                $cond = "{$this->tableName}Status >={$status} and {$this->tableName}CatId in ({$strIds}) ";
                if($this->getCondition())
        	$cond .= " and ".$this->getCondition();
		$this->setCondition ( $cond );
                $list = $this->getObjectsByCondition();
                if($list)
                    $this->convertFileObject($list,$module);

		return $list;
	}
	
	function getObjByCode($code, $module = "", $limit=1){
		global $vsMenu;

		if($module) $categories = $vsMenu->getCategoryGroup($module);
		else $categories = $this->getCategories();

		$strIds = $vsMenu->getChildrenIdInTree($categories);
		$this->setCondition("{$this->tableName}Code='".$code."' AND {$this->tableName}CatId in (".$strIds.") AND {$this->tableName}Status > 0");
		$this->setLimit(array(0, $limit));
		return $this->getOneObjectsByCondition();
	}
	
	function __destruct() {
		unset($this);
	}

	function getPrefixField() {
		return $this->prefixField;
	}
        
        function getCategoryField() {
		return $this->categoryField;
	}

	function getTableName() {
		return $this->tableName;
	}

	function getPrimaryField() {
		return $this->primaryField;
	}

	function getFieldsString() {
		return $this->fieldsString;
	}

	function getFields() {
		return $this->fields;
	}

	function getResult() {
		return $this->result;
	}

	function getCondition() {
		return $this->condition;
	}

	function getOrder() {
		return $this->order;
	}

	function getGroupby() {
		return $this->groupby;
	}

	function getHaving() {
		return $this->having;
	}

	function getLimit() {
		return $this->limit;
	}

	function getBasicClassName() {
		return $this->basicClassName;
	}

	function getBasicObject() {
		return $this->basicObject;
	}

	function getArrayObj() {
		return $this->arrayObj;
	}

	function getVsLang() {
		return $this->vsLang;
	}

	function getVsMenu() {
		return $this->vsMenu;
	}

	function getVsFile() {
		return $this->vsFile;
	}

	function getVsRelation() {
		return $this->vsRelation;
	}

	function setPrefixField($prefixField) {
		$this->prefixField = $prefixField;
	}

	function setTableName($tableName) {
		$this->tableName = $tableName;
	}

	function setPrimaryField($primaryField) {
		$this->primaryField = $primaryField;
	}

	function setFieldsString($fieldsString) {
		$this->fieldsString = $fieldsString;
	}

	function setFields($fields) {
		$this->fields = $fields;
	}

	function setResult($result) {
		$this->result = $result;
	}

	function setCondition($condition) {
		$this->condition = $condition;
	}

	function setOrder($order) {
		$this->order = $order;
	}

	function setGroupby($groupby) {
		$this->groupby = $groupby;
	}

	function setHaving($having) {
		$this->having = $having;
	}

	function setLimit($limit) {
		$this->limit = $limit;
	}

	function setBasicClassName($basicClassName) {
		$this->basicClassName = $basicClassName;
	}

	function setBasicObject($basicObject) {
		$this->basicObject = $basicObject;
	}

	function setArrayObj($arrayObj) {
		$this->arrayObj = $arrayObj;
	}

	function setVsLang($vsLang) {
		$this->vsLang = $vsLang;
	}

	function setVsMenu($vsMenu) {
		$this->vsMenu = $vsMenu;
	}

	function setVsFile($vsFile) {
		$this->vsFile = $vsFile;
	}
	
	function setVsRelation($vsRelation) {
		$this->vsRelation = $vsRelation;
	}

	

	function setCategories($categories) {
		$this->categories = $categories;
	}

	function getCategories() {
		return $this->categories;
	}
	
	

	
}