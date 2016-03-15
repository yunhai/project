<?php
/**
 *
 * @author Sanh Nguyen
 * @version 1.0 RC
 */
if ( ! defined( 'IN_VSF' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}
require_once(CORE_PATH."gallerys/gallerys.php");
class gallerys_admin extends ObjectAdmin{

	function __construct() {
		global $vsStd, $vsTemplate,$vsPrint;
		
//		$vsPrint->addJavaScriptFile('thickbox');
//		$vsPrint->addGlobalCSSFile('thickbox');
                parent::__construct('gallerys', CORE_PATH.'gallerys/', 'gallerys');
		$this->html = $vsTemplate->load_template('skin_gallerys');
	}

	public function getOutput() {
		return $this->output;
	}
	
	public function getHtml() {
		return $this->html;
	}
	
        
        function auto_run() {
		global $bw,$array_module_access,$vsSettings;
		
		
               
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
			
			case 'delete-obj' :
				$this->deleteObj($bw->input[2]);
				break;
                            
                            //file addon
			case 'display-file':
					$this->displayFile($bw->input[2]);
				break;
			case 'display-file-list':
					$this->displayGalleryFileList($bw->input[2]);
				break;
			case 'add-edit-gallery-file':
					$this->addEditGalleryFile();
				break;
			case 'delete-file':
				$this->displayDeleteFile();
				break;
			case 'display-album-tab':
				$this->displayGalleryTab();
				break;
			case 'edit-form-file':
				$this->displayFileForm('edit',$bw->input[2]);
				break;
			case 'add-form-file':
				$this->displayFileForm('add',$bw->input[2]);
				break;
			default :
				$this->loadDefault ();
				break;
		}
	}

//	function addEditObjForm($objId = 0, $option = array()) {
//		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject,$vsFile;
//		
//                $option['skey'] = $bw->input['module'];
//		$obj = $this->model->createBasicObject ();
//		$option ['formSubmit'] = $langObject['itemFormAddButton'];
//		$option ['formTitle'] = $langObject['itemFormAdd'];
//		if ($objId) {
//                        
//			$option ['formSubmit'] = $langObject['itemFormEditButton'];
//			$option ['formTitle'] = $langObject['itemFormEdit'];
//			$obj = $this->model->getObjectById ( $objId ,1);
//		
//			if($obj->getImage())
//           		$file.=$obj->getImage().",";
//                        
//           	if($obj->getFileupload())
//             	$file.=$obj->getFileupload().",";
//          	$file = trim($file,",");
//          	if($file){
//            	$vsFile->setCondition("fileId in ({$file})");
//               	$option ['file'] =  $vsFile->getObjectsByCondition();
//        	}
//		} 
//              
//		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
//		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
//		$editor = new tinyMCE ();
//		if($vsSettings->getSystemKey($option['skey'].'_intro_editor', 1, $option['skey'])){
//		$editor->setWidth ( '100%' );
//		$editor->setHeight ( '150px' );
//		$editor->setToolbar ( 'simple' );
//		$editor->setTheme ( "advanced" );
//		$editor->setInstanceName ( "{$this->tableName}Intro" );
//		$editor->setValue ( $obj->getIntro () );
//		$obj->setIntro ( $editor->createHtml () );
//                }else
//			$obj->setIntro ('<textarea name="'.$this->tableName.'Intro" style="width:100%;height:100px;">'. strip_tags($obj->getIntro()) .'</textarea>');
//			
//		return $this->output = $this->html->addEditObjForm ( $obj, $option );
//	}
	
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
            if($bw->input['txtlink'] && !$bw->input["{$this->tableName}IntroImage"]){
            	$vsFile = new files();
				$bw->input["{$this->tableName}IntroImage"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
            }
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
	
	function displayEditFileForm($model, $fileId){
		global $bw;
		$this->getFileById($fileId);
		$this->displayAddEditGalleryForm($model, 'edit', time(),"",$this->file,$bw->input[3]);

	}

	function displayGalleryAlbumList($cateId=0){
		global $vsStd, $bw, $vsLang,$vsSettings;
		$option['cateId'] = $cateId;
		if($cateId)	$this->model->setCondition('galleryStatus>=0 and galleryCatId='.$cateId);
		else
		$this->model->setCondition('galleryStatus>=0');
		$size = $vsSettings->getSystemKey("admin_{$bw->input[0]}_list_number",10);

		$option=$this->model->getPageList("{$bw->input[0]}/display-gallery-album-list/{$cateId}/", 3,$size,1,'gallery-list');
		$album=$option['pageList'];
		return $this->output = $this->html->displayGalleryAlbumList($album,$option);
	}

	function deleteAlbum($albumId,$catId){
		$this->model->setCondition("galleryId in({$albumId})");
		$this->model->deleteObjectByCondition();
		$this->displayGalleryAlbumList($catId);
	}

	function updateAlbumStatus(){
		global $bw;

		$this->model->setCondition("galleryId in({$bw->input[3]})");
		$this->model->updateObjectByCondition(array("galleryStatus"=>$bw->input[4]));
		$bw->input[3] = 1;
		$this->displayGalleryAlbumList($bw->input[2]);

	}

	function displayFile($albumId=0){
		$option['file-form'] = $this->displayFileForm('add',$albumId);
		$option['file-list'] = $this->displayGalleryFileList($albumId);
		return $this->output = $this->html->displayFile($option);
	}
	function alertMessage($message='') {
		global $bw ;
		print "<script>
			vsf.alert('{$message}');
		</script>";	
	}
	function createAlbum($array=array()){
		global $vsLang,$bw,$DB,$vsMenu;
		
		$array['albumTitle']?$this->model->obj->setTitle($array['albumTitle']):$this->model->obj->setTitle($vsLang->getWords('global_system_auto_album',"System Create Album")." [{$bw->input[2]}]");
		$array['albumCode']	?$this->model->obj->setCode($array['albumCode']):$this->model->obj->setCode($bw->input[2]);
		if($array['albumCode']=="banner"){
			$vsMenu->obj->setLangId(1);
			$this->model->setCategories ( $vsMenu->getCategoryGroup("gallerys",array('key'=>1)));
			
			}
		$this->model->obj->setCatId($this->model->getCategories()->getId());
		$this->model->obj->setStatus(-1);
		$this->model->vsRelation->setRelId($bw->input[3]);
		$this->model->vsRelation->setTableName("gallery_{$bw->input[2]}");
		$strId=$this->model->vsRelation->getObjectByRel();
               
		if($strId){
			$this->model->setCondition("galleryCode='{$this->model->obj->getCode()}' and galleryCatId in ({$this->model->getCategories()->getId()}) and galleryId in ({$strId})");
			$obj=$this->model->getOneObjectsByCondition();
		}
                
		if($obj) return ;
		$this->model->insertObject();
		$this->model->vsRelation->setObjectId($this->model->obj->getId());
		$this->model->vsRelation->setRelId($bw->input[3]);
		$this->model->vsRelation->setTableName("gallery_{$bw->input[2]}");
		$this->model->vsRelation->insertRel();
	}
	function displayGalleryTab(){
		global $bw,$vsLang;
		if(!$bw->input[2]){
			$this->alertMessage($vsLang->getWords("global_none_model",'Bạn phải truyền tên model cần tạo Album'));
			return false;
		}
		if(!$bw->input[3]){
			$this->alertMessage($vsLang->getWords("global_none_id",'Bạn phải truyền Id của đối tượng cần tạo Album'));
			return false;
		}

		$this->createAlbum($bw->input);
		if(!$this->model->obj->getId()){
			$this->alertMessage($vsLang->getWords("global_error_system",'Có lỗi trong quá trình tạo Album'));
			return false;
		}

		return 	$this->displayFile($this->model->obj->getId());
	}

	function displayFileForm($formtype="add",$album){
		global $bw,$vsLang;
		if(is_numeric($album))
		$album= $this->model->getObjectById($album);
		if(!$album){
			$this->alertMessage($vsLang->getWords("global_none_album",'Bạn phải tạo Album trước khi sử dụng'));
			return false;
		}
		$form['type'] = $formtype;
		$form['albumId'] = $album->getId();
		$form ['formSubmit'] = $this->model->vsLang->getWords ( "file_type_{$formtype}_bt", ucwords ( $formtype ) );
		$form ['title'] = $this->model->vsLang->getWords ( "file_type_{$formtype}_title", ucwords ( $formtype ) . " File" );
		if ($form ['type']=="edit") {
			$this->model->vsFile->getObjectById($bw->input[3]);
			$form['switchform'] = '<input type="button" class="ui-state-default ui-corner-all" value="Chuyển qua form thêm mới" name="switch" id="switch-add-file-bt" />';
		}
		return $this->output = $this->html->addEditFileForm($form,$this->model->vsFile->obj,$album);
	}

	function displayGalleryFileList($albumId=0){
		$this->model->getFileByAlbumId($albumId);
		return $this->output = $this->html->displayGalleryFileList($this->model->getArrayObj(),$albumId);
	}

	function addEditGalleryFile(){
		global $bw,$vsStd;
		
		if($bw->input['oldFileId']){
			$vsStd->requireFile ( UTILS_PATH . "TextCode.class.php" );
			$objName =  $bw->input['fileTitle'];
			$this->model->vsFile->getObjectById($bw->input['oldFileId']);
			$pathOld = $this->model->vsFile->obj->getPathView();
			if($bw->input['fileId']) $this->model->vsFile->deleteFile($bw->input['oldFileId']);
			else{
				$this->model->vsFile->obj->convertToObject($bw->input);
				$this->model->vsFile->obj->setTitle($objName);
				$this->model->vsFile->updateObjectById($this->model->vsFile->obj);
			}
		}
		if($bw->input['fileId']){
			$this->model->vsRelation->setObjectId($bw->input['fileId']);
			$this->model->vsRelation->setRelId($bw->input['albumId']);
			$this->model->vsRelation->setTableName($this->model->getRelTableName());
			$this->model->vsRelation->insertRel();
		}
		print "<script>vsf.get('gallerys/add-form-file/{$bw->input['albumId']}','file-form')</script>";
		$this->displayGalleryFileList($bw->input['albumId']);
	}

	function displayDeleteFile(){
		global $bw;
		$this->model->vsFile->deleteFile($bw->input[2]);
		$this->model->vsRelation->setObjectId($bw->input[2]);
		$this->model->vsRelation->setTableName($this->model->getRelTableName());
		$this->model->vsRelation->delRelByObject();
		$this->displayGalleryFileList($bw->input[3]);
	}
}

?>