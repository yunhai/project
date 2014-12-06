<?php
class VSControl_admin extends VSControl {
	protected $output;
	public $section = "";
	/**
	 *
	 *
	 * Enter description here ...
	 * 
	 * @var VSFObject
	 */
	protected $model;

	function __construct($modelName, $skinName, $tableName, $categoryName = '') {
		$this->modelName = $modelName;
		$this->model = new $modelName ( $categoryName );
		$this->tableName = $tableName;
		global $vsTemplate;
		$this->html = $vsTemplate->load_template ( $skinName );
		$this->html->modelName = $modelName;
		$this->html->model = $this->model;
		// //////////
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
			case $this->modelName . '_home_checked' :
				$this->checkShowAll ( 2 );
				break;
			case $this->modelName . '_index_change' :
				$this->indexChange();
				break;
				
			case $this->modelName.'_home_checked' :
				$this->checkShowAll(2);
				break;
			case $this->modelName.'_highlight_checked' :
				$this->checkShowAll(3);
				break;	
				
			case $this->modelName.'_trash_checked' :
				$this->checkTrash();
				break;
			
			case $this->modelName.'_hide_checked' :
				$this->checkShowAll(0);
				break;
			case $this->modelName.'_display_list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case $this->modelName.'_add_edit_form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case $this->modelName.'_add_edit_process' :
				$this->addEditObjProcess ();
				break;
			
			case $this->modelName.'_delete' :
				$this->deleteObj($bw->input[2]);
				break;
			case $this->modelName.'_change_cate' :
				$this->changeCate($bw->input[2]);
				break;	
				
			case $this->modelName."_display_answer_tab":
				$this->displayAnswer();
				break;
			case $this->modelName."_upload_image":
				$this->uploadImage();
				break;	
				
			case $this->modelName."_checkPermalink":
				$this->checkPermalink();
				break;
			default :
				$this->loadDefault ();
				break;
				
		}
	}
	
function uploadImage(){
		global $bw,$vsPrint;
			$file=new files();
			
			
			if (isset($_GET['qqfile'])) {
	            if($file->uploadLocalToHost("php://input",$bw->input[0], $_GET['qqfile'], $file->obj)){
	            	//$file->basicObject->setstatus(-5);
	            	//$file->updateObject($file->basicObject);
	            	
	            	$result['id']=$file->obj->getId();
	            	$result['image']=$file->obj->createImageCache($file->obj->getId(),150,150);
	            	$result['success']=1;
	            }else{
	            	$result['message'].=$this->model->message;
	            	$result['success']=0;
	            }	      
	       echo json_encode($result);exit();
		}
		
	}
	
	
	function checkPermalink(){
		global $bw,$vsPrint;
		
		$title = VSFactory::getTextCode()->removeAccent($bw->input['title'],'-');
		
		if($bw->input['id']) $content = " and id<>".$bw->input['id'];
		
		$this->model->setCondition("mUrl='$title' $content");
		$total = $this->model->getNumberOfObject();
		
		if($total) $title .= "-".$total;
		
		echo strtolower($title);
		$vsPrint->_finish();
		
	}
	
	function changeCate($ids){
		global $bw;
		if($bw->input['toCatId']&&trim($ids)){
		$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$ids .")");
		$this->model->updateObjectByCondition(array($this->model->getCategoryField()=>$bw->input['toCatId']));
		$this->lastModifyChange();
		return $this->getObjList($bw->input['catId'],VSFactory::getLangs()->getWords('cate_change_success','Category have been changed!'));
		}else{
			return $this->getObjList($bw->input['catId'],VSFactory::getLangs()->getWords('cate_not_change','No Category  changed!'));
		}
		
	}
	function deleteObj($ids,$cate = 0){
		global $bw,$vsStd;
		if(!$ids){
			return $this->output = $this->getObjList($cate);
		}
		$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$ids .")");
		$list = $this->model->getObjectsByCondition();
		if(!count($list)) return false;
		$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$ids .")");
		if(!$this->model->deleteObjectByCondition()) return false;
		foreach ($list as $news){
			$this->model->onDeleteObjectById($news);
			VSFactory::getFiles()->deleteFile($news->getImage());
			
		}
		$this->lastModifyChange();
		return $this->output = $this->getObjList($cate);
	}
	
	function checkShowAll($val = 0){
		global $bw,$vsStd,$DB;
		$this->model->setCondition("`{$this->model->getPrimaryField()}` in ({$bw->input[2]})");
		$this->model->updateObjectByCondition(array("Status"=>$val));
		
//		if (in_array($bw->input['module'], $search_module)){
//        	$vsStd->requireFile(CORE_PATH."searchs/searchs.php");
//          	$search = new searchs();
//          	$search->setCondition("searchId in ({$bw->input[2]}) and searchModule = '{$bw->input['module']}'");
//          	$search->updateObjectByCondition(array("searchStatus"=>$val));
//		}
		$this->lastModifyChange();
		return $this->output = $this->getObjList($bw->input[3]);
	}
	
	function checkTrash(){
		global $bw,$vsStd,$DB;
		$vsStd->requireFile(CORE_PATH."trashs/trashs.php");
		$trashs = new trashs();
		$this->model->setCondition("`{$this->model->getPrimaryField()}` in ({$bw->input[2]})");
		$this->model->updateObjectByCondition(array("Status"=>"-1"));
		$idList = explode(',', $bw->input[2]);
		if(count($idList))
			foreach($idList as $id)
			{
				$obj = $trashs->createBasicObject();
				$obj->setTitle($this->model->getObjectById($id)->getTitle());
				$obj->setModule($bw->input[0]);
				$obj->setObjectid($id);
				$obj->setTable($this->model->getTableName());
				$obj->setDate(time());
				$obj->setUsername(VSFactory::getAdmins()->basicObject->getName());
				$trashs->insertObject($obj);
			}		
		return $this->output = $this->getObjList($bw->input[3]);
	}
	
	function indexChange(){
		global $bw;
		if(is_array($bw->input['indexitem']))
		foreach ($bw->input['indexitem'] as $id => $value) {
			$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$id .")");
			$this->model->updateObjectByCondition(array('index'=>$value));
		}
		$this->lastModifyChange();
		return $this->output = $this->getObjList($bw->input[3]);
	}
	function displaySearch(){
		global $bw;
		if($bw->input['search']['s_order']&&$bw->input['search']['s_ofield'])
        	$order=$bw->input['search']['s_ofield'].' '.$bw->input['search']['s_order'];
        	$from="vsf_".$this->tableName;
        	$where="1=1";
        	if($bw->input['search']['title']){
        		$where.=" and `title` like '%{$bw->input['search']['title']}%'";
        	}
        	if($bw->input['search']['id']){
        		$where.=" and `id`='{$bw->input['search']['id']}' ";
        	}
        	if(isset($bw->input['search']['catId']))
        	if($bw->input['search']['catId']>0){
        		$category=VSFactory::getMenus()->getCategoryById($bw->input['search']['catId']);
        		if($category){
	        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
	        		$where.=" and `catId` in ({$idns})";
        		}
        	}else{
        		if($this->model->categoryName){
        			$category=VSFactory::getMenus()->getCategoryGroup($this->model->categoryName);
        			if($category){
		        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
		        		$where.=" and `catId` in ({$idns})";
        			}
        		}
        	}
        	if($bw->input['search']['status']!=-1&&$bw->input['search']['status']!==NULL){
	        		$where.=" and `status`='{$bw->input['search']['status']}'";
        		
        	}
        	$this->model->setCondition($where);
        	$this->model->setOrder($order);
        	
        	$itemList=$this->model->getObjectsByCondition();
        	$vdata['search']=$bw->input['search'];
        	$option['vdata']=json_encode($vdata);
        	//if(!is_object($_GET['search'])) $_GET['search']=array();
        	$tmp['search']=$_GET['search'];
        	$bw->input['back']=urldecode( http_build_query($tmp	))."&pageIndex=".$bw->input['pageIndex'];
        	
        	$option['s_order'] = $bw->input['search']['s_order']=='ASC'?'DESC':'ASC';
        	$option['s_ofield'] = $bw->input['search']['s_ofield'];
		return $this->output = $this->html->getListItemTable ($itemList, $option );
	}
	function displayObjTab() {
		global $bw;

		$option ['objList'] = $this->getObjList ();
               
		return $this->output = $this->html->displayObjTab ( $option );
	}
	
	function getObjList($catId = '', $message = "",$option=array()) {
		global $bw,$DB;
		$option['message']=str_replace(array("'","\n"),array("\\'","\\n"), $message) ;
		$catId=intval($catId);
		if($_REQUEST['vdata']){
			$vdata=json_decode($_REQUEST['vdata'],true);
		}
		if($vdata['search']){//last query search
			$bw->input['search']=$vdata['search'];
			$option['table']=$this->displaySearch();
		}else{
			if($bw->input['pageIndex']){
				$bw->input[3]=$bw->input['pageIndex'];
			}
			
			if($this->model->getCategoryField()){
				$ids=VSFactory::getMenus()->getChildrenIdInTree($this->model->getCategories());
				if($ids)
				$this->model->setCondition("{$this->model->getCategoryField()} in ($ids)");
			}
                        if($bw->input['module']=='products'){
                           // $this->model->setOrder('`index` ASC');
                        }
           $result = $DB->query("SHOW COLUMNS FROM `".$bw->vars['sql_tbl_prefix_0'].$this->tableName."` LIKE 'status'");
			$exists = (mysql_num_rows($result))?TRUE:FALSE;
			if($exists)
				if($this->model->getCondition())
					$this->model->setCondition($this->model->getCondition().' AND status>=0');
					else $this->model->setCondition('status>=0');
            	
			$option=array_merge($option, $this->model->getPageListHash($this->modelName."/".$bw->input [0]."/{$this->modelName}_display_tab/{$catId}/",3,
			
			VSFactory::getSettings()->getSystemKey("{$this->modelName}_admin_paging_limit",20)));

			$option['s_order'] = $bw->input['search']['s_order']=='ASC'?'DESC':'ASC';
        	$option['s_ofield'] = $bw->input['search']['s_ofield'];
			$bw->input['pageIndex']=$bw->input[3];
			$bw->input['back']="&pageIndex=".$bw->input['pageIndex'];
			$option['table']=$this->html->getListItemTable ($this->model->getArrayObj (), $option );
			///some here..................
		}
		return $this->output = $this->html->objListHtml ( $option );
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		$obj=$this->model->getObjectById($objId);
		$option['vdata']=$_REQUEST['vdata'];
		if(count($_GET['search'])){
			$tmp['search']=$_GET['search'];
	        $bw->input['back']=$bw->input['back']="/".$bw->input[0]."/".$this->modelName."_search&".urldecode( http_build_query($tmp	));
		}else{
			$bw->input['back']="/{$bw->input[0]}/{$this->modelName}_display_tab/";
		}
		$bw->input['back'].="&pageIndex=".$bw->input['pageIndex'];
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
       
	function addEditObjProcess() {
		global $bw, $vsStd;
		/****file processing**************/
		
		$bw->input[$this->modelName]['module'] = $bw->input[0];
		
		if(is_array($bw->input['files'])){
			foreach ($bw->input['files'] as $name=> $file) {
				$bw->input[$this->modelName][$name]=$file;
			}
			
		}
        if(is_array($bw->input['links'])){
			foreach ($bw->input['links'] as $name=> $value) {
				$url=parse_url($value);
				if($bw->input['filetype'][$name]=='link'&&$url['host']){
					$files=new files();
					$fid=$files->copyFile($value,$bw->input[0]);
					if($fid)
					$bw->input[$this->modelName][$name]=$fid;
				}
				unset($url);
			}
			
		}
		
		/****end file processing**************/
		if($bw->input[$this->modelName]['id']){
			$this->model->getObjectById($bw->input[$this->modelName]['id']);
			if(!$this->model->basicObject->getId()){
				return $this->output =  $this->getObjList ($bw->input['pageIndex'],"Not define object of id={$bw->input[$this->modelName]['id']} submited!");
			}
			if($bw->input[$this->modelName]['image']){
				$files=new files();
				$files->deleteFile($this->model->basicObject->getImage());				
			}
			/////delete some here..........................................
		}else{
			$bw->input[$this->modelName]['postDate']=time();
			
			/////delete some here before inserting...................
		}
		
		
		$bw->input[$this->modelName]['mUrl']=$bw->input[$this->modelName]['mUrl']?$bw->input[$this->modelName]['mUrl']:$bw->input[$this->modelName]['slug'];
		
		$this->model->basicObject->convertToObject($bw->input[$this->modelName]);
		if(!$this->model->basicObject->getCatId()){
			if($this->model->getCategoryField()){
				$this->model->basicObject->setCatId($this->model->getCategories()->getId());
			}
		}
		if($this->model->basicObject->getId()){
			$this->model->updateObject();
			$message= VSFactory::getLangs()->getWords('update_success');
		}else{
			$this->model->insertObject();
			$message=VSFactory::getLangs()->getWords('insert_success');
		}
		/**add tags process***/
		require_once CORE_PATH.'tags/tags.php';
		$tags=new tags();
		$tags->addTagForContentId($bw->input[0], $this->model->basicObject->getId(), $bw->input['tags_submit_list']);
		/****/
		$this->afterProcess($this->model);
		if(!$this->model->result['status']){
			$message=$this->model->result['developer'];
			
		}
		///////some here.....................
		$this->lastModifyChange();
		return $this->output =  $this->getObjList ($bw->input['pageIndex'],$message);
	}
	/**
	 * 
	 * Enter description here ...
	 * @param VSObject
	 */
	function afterProcess($model){
		//edit objec here for after process
		return true;
	}
	function loadDefault(){
		return $this->exitDenyAccess('action not found!');
	}
	function getCategoryBox($message = "") {
		global $bw;
		$data['message'] = $message;

		$option = array('listStyle' => "| - -",
						'id'		=> 'obj-category',
						'size'		=> 10,
		);
//		$menu = VSFactory::getMenus();
		$menu = $this->model->getCategories();
		$data['html'] =  VSFactory::getMenus()->displaySelectBox($menu->getChildren(), $option);

		return $this->html->categoryList($data);
	}
	
	
	
	function setOutput($out) {
			return $this->output = $out;
		}
		
		function getOutput() {
			return $this->output;
		}
	function exitDenyAccess($error=''){
		return $this->output=$error?$error:VSFactory::getLangs()->getWords('exitDenyAccess','Access denied!');
	}
	/**
	 * @return skins_board
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * @param $html string file name
	 */
	public function setHtml($html) {
		$this->html = $html;
	}


}
?>