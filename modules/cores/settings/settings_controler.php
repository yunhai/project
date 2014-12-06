<?php
require_once(CORE_PATH.'settings/settings.php');

class settings_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_settings");
		parent::__construct($modelName,"skin_settings","setting");
		$this->model->categoryName="settings";

	}
	function auto_run() {
		global $bw;
		switch ($bw->input [1]) {
			case $this->modelName . '_update_root_status' :
				$this->updateRootStatus ();
				break;
			case $this->modelName . '_value_change' :
				$this->valueChange();
				break;
			case $this->modelName . '_quick_update_form' :
				$this->quickUpdateForm ();
				break;
			case $this->modelName . '_quick_save' :
				$this->quickSave ();
				break;
			case $this->modelName . '_quick_update_form_group' :
				$this->quickUpdateFormGroup ($bw->input [2]);
				break;
				case $this->modelName . '_quick_save_group' :
				$this->quickSaveGroup ();
				break;
			
			default :
				parent::auto_run();
				break;
				
		}
	}
	
function addEditObjProcess() {
		global $bw, $vsStd;
		/****file processing**************/
		
		//$bw->input[$this->modelName]['module'] = $bw->input[0];
		
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
	
	
	
	
	
	
	
	
function afterProcess($model){
		//edit objec here for after process
		global $bw;
		$groups=explode("\n",$bw->input['group']);
		VSFactory::createConnectionDB()->query("delete  from vsf_setting_group where `key`='{$model->obj->getKey()}'");
		if(count($groups)){
			foreach ($groups as $line){
				$group=explode(":", $line);
				if($group[0]){
					$line=substr($line, strlen($group[0].":"),strlen($line.":")-strlen($group[0]));
					$line=mysql_real_escape_string($line);
					$group[0]=mysql_real_escape_string($group[0]);
					VSFactory::createConnectionDB()->query("
					INSERT INTO `vsf_setting_group` (
					`group` ,
					`key` ,
					`value`
					)
					VALUES (
					'{$group[0]}', '{$model->obj->getKey()}', '{$line}'
					);
					");
				}
			}
			
		}
		VSFactory::getSettings()->buildCache("admin");
		VSFactory::getSettings()->buildCache("user");
		return true;
	}
function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		
//		return parent::addEditObjForm($objId,$option);
		$obj=$this->model->getObjectById($objId);
		$option['vdata']=$_REQUEST['vdata'];
		if(count($_GET['search'])){
			$tmp['search']=$_GET['search'];
	        $bw->input['back']=$bw->input['back']="/".$bw->input[0]."/".$this->modelName."_search&".urldecode( http_build_query($tmp	));
		}else{
			$bw->input['back']="/{$bw->input[0]}/{$this->modelName}_display_tab/";
		}
		$bw->input['back'].="&pageIndex=".$bw->input['pageIndex'];
//		$objId=$this->getIdFromUrl($objId);
		if($obj->getId()){
			VSFactory::createConnectionDB()->query("select * from vsf_setting_group where `key`='{$obj->getKey()}'");
			$option['group']=array();
			while ($row=VSFactory::createConnectionDB()->fetch_row()){
				$option['group'][]=$row;
			}
			foreach ($option['group'] as $index => $array) {
				$option['group_string'].=$option['group'][$index]['group'].":".$option['group'][$index]['value']."\n";
			}
			//$option['group_string']
		}
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
function valueChange(){
		global $bw;
		if(is_array($bw->input['value']))
		foreach ($bw->input['value'] as $id => $value) {
			$this->model->setCondition("`{$this->model->getPrimaryField()}` IN (".$id .")");
			$this->model->updateObjectByCondition(array('value'=>$value));
		}
		$this->lastModifyChange();
		VSFactory::getSettings()->buildCache("admin");
		VSFactory::getSettings()->buildCache("user");
		return $this->output = $this->getObjList($bw->input[3]);
	}
	function quickSave(){
		global $bw;
		$result=array();
		if($bw->input['settings'])
		foreach ($bw->input['settings'] as $index => $value){
			$this->model->setCondition("id=".intval($index));
			$this->model->updateObjectByCondition(array(
			'value'=>$value,
			));
		}
		$result['status']=1;
		$result['message']="Cập nhật thành công!";
		VSFactory::getSettings()->buildCache();
		return $this->output=json_encode($result);
		
	}
	function quickSaveGroup(){
		global $bw;
		$result=array();
		if($bw->input['settings'])
		foreach ($bw->input['settings'] as $index => $value){
			$index=mysql_real_escape_string($index);
			$value=mysql_real_escape_string($value);
			VSFactory::createConnectionDB()->query("
					update vsf_setting_group set value='$value' where `key`='$index'
			");
		}
		$result['status']=1;
		$result['message']="Cập nhật thành công!";
		VSFactory::getSettings()->buildCache();
		return $this->output=json_encode($result);
		
	}
	function quickUpdateFormGroup($group){
		global $bw;
		if(!count($group)) return;
		$group=mysql_real_escape_string($group);
		$list=array();
		VSFactory::createConnectionDB()->query(
		"SELECT s.id,s.title,g.key,g.value FROM `vsf_setting_group` AS g LEFT JOIN `vsf_setting` AS s ON s.`key`=g.`key`
			WHERE g.`group`='$group' and s.value>0");
		while($row=VSFactory::createConnectionDB()->fetch_row()){
			$setting=new Setting();
			$setting->convertToObject($row);
			$list[]=$setting;
		}
		
		//$list=$this->model->getObjectsByCondition();
		$html="";
		foreach ($list as $value) {
			$checked="";
			if($value->value) $checked="checked='checked'";
			$html.=<<<EOF
			<li><label><input type="checkbox" name="settings[{$value->getKey()}]" $checked value="1"/>{$value->getTitle()}</label></li>
EOF;
		}
		$html.="<input type='hidden' name='group' value='$group'/>";
		return $this->output=$html;
		
	}
	function quickUpdateForm(){
		global $bw;
		$key=explode(",", $bw->input['key']);
		if(!count($key)) return;
		foreach ($key as $index=> $value) {
			$key[$index]="'".mysql_real_escape_string($value)."'";
		}
		$key=implode(",", $key);
		$this->model->setCondition("`key` in ($key)");
		$list=$this->model->getObjectsByCondition();
		$html="";
		foreach ($list as $value) {
			$checked="";
			if($value->value) $checked="checked='checked'";
			$html.=<<<EOF
			<li><label><input type="checkbox" name="settings[{$value->getId()}]" $checked value="1"/>{$value->getTitle()}</label></li>
EOF;
		}
		return $this->output=$html;
		
	}
	function updateRootStatus(){
		global $bw;
		$array=array();
		$array['status']=1;
		$this->model->getObjectById($bw->input['id']);
		if(!$this->model->obj->getId()) {
			$array['status']=0;
			$array['message']="Object id not exist!";
		}
		$this->model->obj->setRoot($bw->input['value']);
		$this->model->updateObject();
		$array['value']=$this->model->obj->getRoot();
		$array['id']=$this->model->obj->getId();
		return $this->output= json_encode($array);
	}
function initModuleSearch(&$option){
			$option['categorys']=$this->model->getCategories()->getChildren();
			
			$modules=new modules();
			$modulelist=$modules->getObjectsByCondition("getClass");
			$root_access=VSFactory::getAdmins()->obj->checkPermission("root_access");
			$denymodule=array("modules","menus","seos","pages","files","skins","components","admins");
			
			foreach ($option['categorys'] as $index=>$cate) {
				if($modulelist[$cate->url]){
					$cate->setTitle($modulelist[$cate->url]->getTitle()." ({$cate->url})");
				}
				if(!$root_access){
					if(in_array($cate->url, $denymodule)){
						unset($option['categorys'][$index]);
					}
					
				}
			}
			
			
}
function getObjList($catId = '', $message = "",$option=array()) {
		global $bw,$DB;
		$this->initModuleSearch($option);
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
			
//			if($this->model->getCategoryField()){
//				$ids=VSFactory::getMenus()->getChildrenIdInTree($this->model->getCategories());
//				if($ids)
//				$this->model->setCondition("{$this->model->getCategoryField()} in ($ids)");
//			}
//           $result = $DB->query("SHOW COLUMNS FROM `".$bw->vars['sql_tbl_prefix_0'].$this->tableName."` LIKE 'status'");
//			$exists = (mysql_num_rows($result))?TRUE:FALSE;
//			if($exists)
//				if($this->model->getCondition())
//					$this->model->setCondition($this->model->getCondition().' AND status>=0');
//					else $this->model->setCondition('status>=0');
            	$this->model->setOrder("`id`");
			$option=array_merge($option, $this->model->getPageListHash($this->modelName."/".$bw->input [0]."/{$this->modelName}_display_tab/{$catId}/",3,
			
			VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20)));

			$option['s_order'] = $bw->input['search']['s_order']=='ASC'?'DESC':'ASC';
        	$option['s_ofield'] = $bw->input['search']['s_ofield'];
			$bw->input['pageIndex']=$bw->input[3];
			$bw->input['back']="&pageIndex=".$bw->input['pageIndex'];
			$option['table']=$this->html->getListItemTable ($this->model->getArrayObj (), $option );
			///some here..................
		
		}
		return $this->output = $this->html->objListHtml ( $option );
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
        	
			if(isset($bw->input['search']['catName']) and $bw->input['search']['catName']!=-1 )
        	if($bw->input['search']['catName']!=""){
        		$where.=" and `module` = '{$bw->input['search']['catName']}'";
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
        	$this->initModuleSearch($option);
		return $this->output = $this->html->getListItemTable ($itemList, $option );
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
	*Skins for setting ...
	*@var skin_settings
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
