<?php
/*
 * @author Luu Quang Vu
 * This class is used to describle the genaral for objects admin of VSF
 */
class ObjectAdmin{
	public $html;
	public $modelName;
	public $model;
	public $output;
	public $tableName;
	public $classNameModel;

	function __construct($modelName, $pathModel, $classModelName){
		global $vsStd, $vsTemplate,$tableName, $vsModule;

		$this->modelName = $modelName;
		$vsStd->requireFile($pathModel. $this->modelName.'.php');
		$this->classNameModel = $classModelName;
		
		$this->model = new $this->classNameModel;
		$this->tableName = $this->model->getTableName();
		$tableName = $this->tableName;
		$this->getListLangObject();
		$this->html = $vsTemplate->load_template('skin_objectadmin');
		
	}
        
	function auto_run() {
		global $bw,$search_module,$vsSettings;
		
	
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
			case 'display_list_news_comments':
				$this->displayListNewsComments($bw->input [2], $this->module->result ['message'] );
				break;
			default :
				$this->loadDefault ();
				break;
		}
	}
	function deleteObj($ids,$cate = 0){
		global $bw,$search_module,$vsStd;
	
		$this->model->setCondition("{$this->tableName}Id IN (".$ids .")");
		$list = $this->model->getObjectsByCondition();
		if(!count($list)) return false;
		$this->model->setCondition("{$this->tableName}Id IN (".$ids .")");
		if(!$this->model->deleteObjectByCondition()) return false;
		foreach ($list as $news)
			$this->model->vsFile->deleteFile($news->getImage());
		if (in_array($bw->input['module'], $search_module)){
        	$vsStd->requireFile(CORE_PATH."searchs/searchs.php");
          	$search = new searchs();
          	$search->setCondition("searchId in ({$ids}) and searchModule = '{$bw->input['module']}'");
          	$search->deleteObjectByCondition();
		}
		return $this->output = $this->getObjList($cate);
	}
	
	function checkShowAll($val = 0){
		global $bw,$search_module,$vsStd,$DB;
		$this->model->setCondition("{$this->tableName}Id in ({$bw->input[2]})");
		$this->model->updateObjectByCondition(array("{$this->tableName}Status"=>$val));
		
		if (in_array($bw->input['module'], $search_module)){
        	$vsStd->requireFile(CORE_PATH."searchs/searchs.php");
          	$search = new searchs();
          	$search->setCondition("searchId in ({$bw->input[2]}) and searchModule = '{$bw->input['module']}'");
          	$search->updateObjectByCondition(array("searchStatus"=>$val));
		}
		return $this->output = $this->getObjList($bw->input[3]);
	}
	
	function displayObjTab() {
		global $bw, $vsSettings;
		if ($vsSettings->getSystemKey ( $bw->input [0] . '_category_list', 0, $bw->input[0] ))
			$option ['categoryList'] = $this->getCategoryBox ();
		$option ['objList'] = $this->getObjList ();
               
		$this->output = $this->html->displayObjTab ( $option );
	}
	
	function getObjList($catId = '', $message = "") {
		global $bw, $vsSettings;
		$catId = intval ( $catId );
            
		$categories = $this->model->getCategories ();

		if ($bw->input ['pageCate'])
			$bw->input [2] = $catId = $bw->input ['pageCate'];
		if ($bw->input ['pageIndex'])
			$bw->input [3] = $bw->input ['pageIndex'];
		
		// Check if the catIds is specified
		// If not just get all product
		if (intval ( $catId )) {
			$result = $this->model->vsMenu->extractNodeInTree ( $catId, $categories->getChildren () );
			if ($result)
				$strIds = trim ( $catId . "," . $this->model->vsMenu->getChildrenIdInTree ( $result ['category'] ), "," );
		}
		if (! $strIds)
			$strIds = $this->model->vsMenu->getChildrenIdInTree ( $categories );		
		// Set the condition to get all product in specified category and its chidlren
		$this->model->setCondition ( $this->model->getCategoryField () . " in (" . $strIds . ") and {$this->tableName}Status > -1" );
		
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
		
		$option = $this->model->getPageList ( "{$bw->input[0]}/display-obj-list/{$catId}", 3, $size, 1, 'obj-panel' );
		$option ['message'] = $message;
		$option ['categoryId'] = $catId;
            
		return $this->output = $this->html->objListHtml ( $this->model->getArrayObj (), $option );
	}
	
	function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject;
		
                $option['skey'] = $bw->input['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $langObject['itemFormAddButton'];
		$option ['formTitle'] = $langObject['itemFormAdd'];
		if ($objId) {
                        
			$option ['formSubmit'] = $langObject['itemFormEditButton'];
			$option ['formTitle'] = $langObject['itemFormEdit'];
			$obj = $this->model->getObjectById ( $objId ,1);
		} 
              
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		if($vsSettings->getSystemKey($option['skey'].'_intro_editor', 0, $option['skey'])){
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
		$bw->input ["{$this->tableName}Hot"] = $bw->input ["{$this->tableName}Hot"] ? $bw->input ["{$this->tableName}Hot"] : 0;                
		
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
                        
		if ($bw->input ['fileId'])
			$bw->input ["{$this->tableName}Image"] = $bw->input ['fileId'];
                elseif($bw->input['txtlink'])
			$bw->input["{$this->tableName}Image"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
		
		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
                        
			$imageOld = $obj->getImage ();
                        if($bw->input['deleteImage']){
				$imageOld = $obj->getImage();
				if($imageOld) $vsFile->deleteFile($imageOld);
				if(!$bw->input["{$this->tableName}Image"]) $bw->input["{$this->tableName}Image"] = 0;
			}
			
			$objUpdate = $this->model->createBasicObject ();
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
		if ($imageOld && $bw->input ['fileId']) {
			$vsFile->deleteFile ( $imageOld );
		}
		
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
		$lang = new languages();
	
		foreach ($lang->arrayLang as $value) {
			$vsFile->buildCacheFile ( $bw->input ['module'],$value->getFoldername() );;
		}
		
		return $this->output = $javascript . $this->getObjList ();
	}

	function getCategoryBox($message = "") {
		global $bw , $vsMenu;

		$data['message'] = $message;

		$option = array('listStyle' => "| - -",
						'id'		=> 'obj-category',
						'size'		=> 10,
		);
		$menu = new Menu();
		
		$menu = $this->model->getCategories();
		$data['html'] = $vsMenu->displaySelectBox($menu->getChildren(), $option);

		return $this->html->categoryList($data);
	}
	
	function loadDefault() {
		global $vsPrint,$vsSettings,$bw;
		
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		
		$vsPrint->addJavaScriptString ( 'init_tab', '
			$(document).ready(function(){
    			$("#page_tabs").tabs({
    				cache: false
    			});
  			});
		' );
		
		$this->output = $this->html->managerObjHtml();
		
	}
	
         function getListLangObject(){
            global $langObject,$vsLang;
            $langObject['itemList']         =$vsLang->getWords('global_Item_List',"Item List");
            $langObject['itemListAdd']      =$vsLang->getWords('global_list_add',"Add");
            $langObject['itemListHide']     =$vsLang->getWords('global_list_hide',"Hide");
            $langObject['itemListHome']     =$vsLang->getWords('global_list_Home',"Home");
            $langObject['itemListVisible']  =$vsLang->getWords('global_list_Visible',"Visible");
            $langObject['itemListDelete']   =$vsLang->getWords('global_list_Delete',"Delete");
            $langObject['itemListChangeCate']=$vsLang->getWords('global_list_ChangeCate',"Change Cate");
            $langObject['itemListInsertSearch']=$vsLang->getWords('global_list_InsertSearch',"Chuyển search");
            $langObject['itemListActive']    =$vsLang->getWords('global_list_Active',"Active");
            $langObject['itemListTitle']        =$vsLang->getWords('global_list_Title',"Title");
            $langObject['itemListIndex']        =$vsLang->getWords('global_list_Index',"Index");
            $langObject['itemListAction']       =$vsLang->getWords('global_list_Action',"Action");
            $langObject['itemListCurrentShow']  =$vsLang->getWords('global_list_Current_Show',"Current Show");
            $langObject['itemListNotShow']      =$vsLang->getWords('global_list_NotShow',"Not Show");
            $langObject['itemListHomeShow']     =$vsLang->getWords('global_list_HomeShow',"Home Show");
            $langObject['itemListConfirmDelete'] =$vsLang->getWords('global_list_ConfirmDelete',"Confirm Delete");
            $langObject['itemListChoiseCate'] =$vsLang->getWords('global_list_ChoiseCate',"Choise Cate");
            $langObject['itemListOption']     =$vsLang->getWords('global_list_Option',"Option");
    
            //langguague for obj
            $langObject['itemObjTitle'] = $langObject['itemListTitle'] ;
            $langObject['itemObjAuthor'] =$vsLang->getWords('global_obj_Author',"Author");
            $langObject['itemObjCode'] =$vsLang->getWords('global_obj_Code',"Code");
            $langObject['itemObjStatus'] =$vsLang->getWords('global_obj_Status',"Status");
            $langObject['itemObjDisplay'] =$vsLang->getWords('global_obj_Display',"Display");
            $langObject['itemObjHide'] =$vsLang->getWords('global_obj_Hide',"Hide");
            $langObject['itemObjIndex'] =$vsLang->getWords('global_obj_Index',"Index");
            $langObject['itemObjHome'] =$vsLang->getWords('global_obj_Home',"Home");
            $langObject['itemObjLink'] =$vsLang->getWords('global_obj_Link',"Link");
            $langObject['itemObjDeleteImage'] =$vsLang->getWords('global_obj_Delete_Image',"Delete Image");
            $langObject['itemObjFile'] =$vsLang->getWords('global_obj_File',"File");
            $langObject['itemObjType'] =$vsLang->getWords('global_obj_Type',"Type");
            $langObject['itemObjIntro'] =$vsLang->getWords('global_obj_Intro',"Intro");
            $langObject['itemObjContent'] =$vsLang->getWords('global_obj_Content',"Content");
            $langObject['itemObjAddress'] =$vsLang->getWords('global_obj_Address',"Address");
            $langObject['itemObjBack'] =$vsLang->getWords('global_obj_Back',"Back");
            $langObject['itemObjWebsite_Name'] =$vsLang->getWords('global_obj_Website_Name',"Website Name");
            $langObject['itemObjWebsite'] =$vsLang->getWords('global_obj_Website',"Website");
            $langObject['itemObjPosition'] =$vsLang->getWords('global_obj_Position',"Position");
            $langObject['itemObjPrice'] =$vsLang->getWords('global_obj_Price',"Price");
            //no define onfield
            $langObject['notItemObjTitle'] =$vsLang->getWords('global_not_Title',"Title not blank");
            //category
            $langObject['categoriesTitle'] =$vsLang->getWords('global_Categories_title',"Categories");
            $langObject['categoriesSelected'] =$vsLang->getWords('global_Categories_Selected',"Selected Categories");
            $langObject['categoriesNone'] =$vsLang->getWords('global_Categories_None',"None");
            $langObject['categoriesView'] =$vsLang->getWords('global_Categories_View',"View");
            $langObject['categoriesRSS'] =$vsLang->getWords('global_Categories_RSS',"RSS");
            //tab
            $langObject['tabVirtualModule'] =$vsLang->getWords('global_Tab_Virtual_Module',"Virtual Module");
            $langObject['tabSettings'] =$vsLang->getWords('global_Tab_Settings',"Settings");
            //form add new
            $langObject['itemFormAdd']      =$vsLang->getWords('global_form_add',"Add Item");
            $langObject['itemFormAddButton']      =$vsLang->getWords('global_form_add_bt',"Add");
            $langObject['itemFormEdit']         =$vsLang->getWords('global_list_edit',"Edit Item");
            $langObject['itemFormEditButton']      =$vsLang->getWords('global_form_edit_bt',"Edit");
            //add edit process
            $langObject['itemAddSuccess']      =$vsLang->getWords('global_add_success',"Add Success");
            $langObject['itemAddAnother']      =$vsLang->getWords('global_add_another',"Add Another");
            $langObject['itemEditSuccess']      =$vsLang->getWords('global_edit_success',"Edit Success");
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
}