<?php
class pages_admin extends ObjectAdmin{
	function __construct() {
		global $vsTemplate, $vsPrint, $vsStd;
		parent::__construct('pages', CORE_PATH.'pages/', 'pages');
    	$this->html = $vsTemplate->load_template('skin_pages');
	}
        function auto_run() {
		global $bw;

		switch ($bw->input ['action']) {
			case 'visible-checked-obj' :
				$this->checkShowAll(1);
				break;

			case 'home-checked-obj' :
				$this->checkShowAll(2);
				break;

			case 'hide-checked-obj' :
				$this->checkShowAll(0);
				break;

			case 'display-obj-tab' :
				$this->displayObjTab ();
				break;

			case 'display-obj-list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;

			case 'add-edit-obj-form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;

			case 'add-edit-obj-process' :
				$this->addEditObjProcess ();
				break;

			case 'change-objlist-bt' :
				$this->model->changeCateList ();
				$this->getObjList ();
				break;
			case 'insertSearch-objlist-bt' :
				$this->model->insertSearch ();	
				$this->getObjList ();
				break;
			case 'delete-obj' :
				$this->deleteObj($bw->input[2]);
				break;
                       //start virtual
                        case 'displayVirtualTab' :
					$this->displayVirtualTab ();
				break;

			case 'virtualForm' :
					$this->virtualForm($bw->input[2]);
				break;

			case 'editVirtual' :
					$this->editVirtual();
				break;

			case 'deleteVirtual' :
					$this->deleteVirtual($bw->input[2]);
				break;
			default :
				$this->loadDefault ();
				break;
		}
	}
	
function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject,$vsFile;
		
                $option['skey'] = $bw->input['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $langObject['itemFormAddButton'];
		$option ['formTitle'] = $langObject['itemFormAdd'];
		if ($objId) {
                        
			$option ['formSubmit'] = $langObject['itemFormEditButton'];
			$option ['formTitle'] = $langObject['itemFormEdit'];
			$obj = $this->model->getObjectById ( $objId ,1);
			if($obj->getImage())
           		$file.=$obj->getImage().",";
                        
           	if($obj->getFileupload())
             	$file.=$obj->getFileupload().",";
          	$file = trim($file,",");
          	if($file){
            	$vsFile->setCondition("fileId in ({$file})");
               	$option ['file'] =  $vsFile->getObjectsByCondition();
        	}
		} 
              
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		if($vsSettings->getSystemKey($option['skey'].'_intro_editor', 1, $option['skey'])){
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '150px' );
		$editor->setToolbar ( 'simple' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( "{$this->tableName}Intro" );
		$editor->setValue ( $obj->getIntro () );
		$obj->setIntro ( $editor->createHtml () );
                }else
			$obj->setIntro ('<textarea name="'.$this->tableName.'Intro" style="width:100%;height:100px;">'. strip_tags($obj->getIntro()) .'</textarea>');
        $editor = new tinyMCE ();           
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '350px' );
		$editor->setToolbar ( 'full' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( "{$this->tableName}Content" );
		if($obj->getContent()){
			$editor->setValue($obj->getContent());
		}else{
			$val=$vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1);
			if(!is_numeric($val)){
				$editor->setValue($vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1));
			}
					
		}
		$obj->setContent ( $editor->createHtml () );
		
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd, $vsLang, $vsFile,$DB,$vsSettings,$search_module,$langObject;

		$bw->input ["{$this->tableName}Status"] = $bw->input ["{$this->tableName}Status"] ? $bw->input ["{$this->tableName}Status"] : 0;
               
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
                        
		if ($bw->input ['fileId']){
			$vsFile->setCondition("fileId in ({$bw->input ['fileId']})");
           	$list =  $vsFile->getObjectsByCondition();
           	if($list)
           		foreach($list as $obj){
                	$bw->input [$obj->getField()] = $obj->getId();
               	}
            if($bw->input['txtlink'])
				$bw->input["{$this->tableName}Image"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
		}

		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
			$arrayI =  array("IntroImage"=>$obj->getImage (),
                             "Fileupload"=>$obj->getFileupload (),
                        );
            foreach($arrayI as $key => $val){
            	$vsFile= new files();            
				$imageOld = $val;
             	if($bw->input["delete".$key]){
					if($imageOld) $vsFile->deleteFile($imageOld);
                	if(!$bw->input["{$this->tableName}{$key}"]) $bw->input["{$this->tableName}{$key}"] = 0;
              	}
                if($imageOld && $bw->input[$this->tableName.$key])
                   		$vsFile->deleteFile($imageOld);
         	}         
			
			$objUpdate = $obj;

			$objUpdate->convertToObject ( $bw->input );
                  
			$this->model->updateObjectById ( $objUpdate );
			
			if ($this->model->result ['status']) {
				$alert = $langObject['itemEditSuccess'];
				$javascript = <<<EOF
						<script type='text/javascript'>
							jAlert(
								"{$alert}",
								"{$bw->vars['global_websitename']} Dialog"
							);
						</script>
EOF;
			}
		} else {
            $bw->input["{$this->tableName}PostDate"] = time();           
			$this->model->obj->convertToObject ( $bw->input );
			
			$this->model->insertObject ( $this->model->obj );
			if ($this->model->result ['status']) {
				$confirmContent = $langObject['itemAddSuccess'] . '\n' . $langObject['itemAddAnother'] ." ?";
				$javascript = <<<EOF
					<script type='text/javascript'>
						jConfirm(
							"{$confirmContent}",
							'{$bw->vars['global_websitename']} Dialog',
							function(r){
								if(r){
									vsf.get("{$bw->input[0]}/add-edit-obj-form/&pageIndex={$bw->input['pageIndex']}&pageCate={$bw->input['pageCate']}",'obj-panel');
								}
							}
						);
					</script>
EOF;
			}
		}
//		if ($imageOld && $bw->input ['fileId']) {
//			$vsFile->deleteFile ( $imageOld );
//		}
		
        //convert to Search
		if (in_array($bw->input['module'], $search_module)){
                    if($bw->input['searchRecord']){
                        $vsStd->requireFile(CORE_PATH."searchs/searchs.php");
                        $search = new searchs();
                        $search->setCondition("searchRecord  = ".$bw->input['searchRecord']);
                        $search->updateObjectByCondition($this->model->obj->convertSearchDB());
                    }
                    elseif(isset ($bw->input['searchRecord'])){
                        $DB->do_insert("search",$this->model->obj->convertSearchDB());
                    }
		}
		      
        //end convert to Search
		$cat = $bw->input ['pageCate'] ? $bw->input ['pageCate'] : $bw->input ['pageCatId'];
		$vsFile->buildCacheFile ( $bw->input ['module'] );
		return $this->output = $javascript . $this->getObjList ();
	}
	
        function checkVitualModule($module_check=""){
            global $bw, $vsLang, $vsMenu, $vsSettings,$vsStd;
            $vsStd->requireFile(CORE_PATH . 'modules/modules_admin.php' );
            $module = new modules_admin();
            $list = $module->getVirtualModuleList();
               foreach($list as $obj)
                   if($obj->getClass()==$module_check)
                       return $obj->getClass();
                return "";
        }

    
	
	function deleteVirtual($modIds = 0){
		global $bw, $vsLang, $vsStd, $vsSettings;

				
		$vsStd->requireFile(CORE_PATH.'modules/modules.php');
		$module = new modules();
		$modules = $module->getModuleByIds($modIds);
		
		
		$module->setCondition("moduleId in ({$modIds})");
		$module->deleteObjectByCondition();


		if($modules){
			$str = "";
			foreach(explode(",", $modules) as $key=>$val)
				$str .= "'".$val."',";
			$str = trim($str, ","); 
			
			$vsSettings->deleteByModule($str);
			

			$menus = new menus();		
			$menus->setCondition("menuAlt in ({$str})");
			$menus->deleteObjectByCondition();
		}
		
		$this->displayVirtualTab();
	}
	
	function editVirtual() {
		global $bw, $vsLang, $vsStd, $vsMenu;
		
		$vsStd->requireFile ( CORE_PATH . 'modules/modules.php' );
		$module = new modules();
		
		$bw->input['moduleVirtual'] = 1;
		$bw->input['moduleClass'] = $bw->input['moduleTitle'];
		
		$bw->input ['moduleIsUser'] = $bw->input['moduleIsUser'] ? $bw->input['moduleIsUser'] : 0;
		$bw->input ['moduleIsAdmin'] = $bw->input['moduleIsAdmin'] ? $bw->input['moduleIsAdmin'] : 0;
		
		$module->obj->convertToObject($bw->input);
		
		if (empty($bw->input['moduleId'])) {
			$module->insertObject ( $module->obj );
			$vsMenu->getCategoryGroup ( $bw->input ['moduleTitle'] );
			if($module->result ['status'])
				$alert = $vsLang->getWords('add_virtual_module_successfully', 'you have successfully add a virtual module' );
		}
		else {
			$module->updateObjectById($module->obj);
			if($module->result['status'])
				$alert = $vsLang->getWords('edit_virtual_module_successful', 'you have successfully edit a virtual module');
		}
		if($alert)
			$javascript = <<<EOF
						<script type='text/javascript'>
							jAlert(
								"{$alert}",							
								"{$bw->vars['global_websitename']} Dialog"
							);
						</script>
EOF;
		return $this->output = $javascript.$this->displayVirtualTab();
	}
	
	function displayVirtualTab() {
		global $vsLang, $vsStd;
		$vsStd->requireFile(CORE_PATH . 'modules/modules_admin.php' );
		$module = new modules_admin();
		
		$option ['list'] = $this->html->displayVirtualItemContainer($module->getVirtualModuleList());
		$option ['form'] = $this->virtualForm();
		return $this->output = $this->html->displayVirtualTab ( $option );
	}
	
	function virtualForm($moduleId = 0) {
		global $bw, $vsLang, $vsStd;
		$vsStd->requireFile ( CORE_PATH . 'modules/modules.php' );
		$option ['submitValue'] = $vsLang->getWords ( 'bt_add', 'Add' );
		$option ['formTitle'] = $vsLang->getWords ( 'pages_addVirtual', 'Add Virtual Module' );
		
		$module = new modules();
		if (! empty ( $moduleId )) {
			$option ['submitValue'] = $vsLang->getWords ( 'bt_edit', 'Edit' );
			$option ['formTitle'] = $vsLang->getWords ( 'pages_editVirtual', 'Edit Virtual Module' );
			$module->getObjectById($moduleId);
		}
		
		return $this->output = $this->html->virtualForm($module->obj, $option);
	}
	
}
?>