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
require_once LIBS_PATH.'boards/VSAdminBoard.php';
class gallerys_admin  extends VSAdminBoard{
	
function auto_run(){
		global $bw;
		$this->tabs[]=array(
				'href'=>"{$bw->base_url}{$bw->input[0]}/{$bw->input[0]}_display_tab/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_{$bw->input[0]}",$bw->input[0]),
				'default'=>1,
				);
	
		if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_category_list', 0, $bw->input[0] )){
			$this->tabs[]=array(
				'href'=>"{$bw->base_url}menus/display-category-tab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_category","{$bw->input[0]} Category"),
				'default'=>1,
				);
			
		}		
		parent::auto_run();
	}
       /* function auto_run() {
		global $bw,$array_module_access;
               
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
function loadDefault() {
		global $vsPrint;
		$vsPrint->addJavaScriptString ( 'init_tab', '$(document).ready(function(){$("#page_tabs").tabs({fx: { opacity: "toggle" },cache: true});});' );
		$this->output = $this->html->managerObjHtml ();
	}
	function displayEditFileForm($model, $fileId){
		global $bw;
		$this->getFileById($fileId);
		$this->displayAddEditGalleryForm($model, 'edit', time(),"",$this->file,$bw->input[3]);

	}

	function displayGalleryAlbumList($cateId=0){
		global $bw;
		$option['cateId'] = $cateId;
		if($cateId)	$this->model->setCondition('galleryStatus>=0 and galleryCatId='.$cateId);
		else
		$this->model->setCondition('galleryStatus>=0');
		$size = VSFactory::getSettings()->getSystemKey("admin_{$bw->input[0]}_list_number",10);

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
		global $bw;
		$vsLang = VSFactory::getLangs();
		$vsRelation = VSFactory::getRelation();
		$array['albumTitle']?$this->model->basicObject->setTitle($array['albumTitle']):$this->model->basicObject->setTitle($vsLang->getWords('global_system_auto_album',"System Create Album")." [{$bw->input[2]}]");
		$array['albumCode']	?$this->model->basicObject->setCode($array['albumCode']):$this->model->basicObject->setCode($bw->input[2]);
		$this->model->basicObject->setCatId($this->model->getCategories()->getId());
		$this->model->basicObject->setStatus(-1);
		$vsRelation->setRelId($bw->input[3]);
		$vsRelation->setTableName("gallery_{$bw->input[2]}");
		$strId=$vsRelation->getObjectByRel();
		if($strId){
			$this->model->setCondition("galleryCode='{$this->model->basicObject->getCode()}' and galleryCatId in ({$this->model->getCategories()->getId()}) and galleryId in ({$strId})");
			$obj=$this->model->getOneObjectsByCondition();
		}
                
		if($obj) return ;
		$this->model->insertObject();
		$vsRelation->setObjectId($this->model->basicObject->getId());
		$vsRelation->setRelId($bw->input[3]);
		$vsRelation->setTableName("gallery_{$bw->input[2]}");
		$vsRelation->insertRel();
	}
	function displayGalleryTab(){
		global $bw;
		$vsLang = VSFactory::getLangs();
		if(!$bw->input[2]){
			$this->alertMessage($vsLang->getWords("global_none_model",'Bạn phải truyền tên model cần tạo Album'));
			return false;
		}
		if(!$bw->input[3]){
			$this->alertMessage($vsLang->getWords("global_none_id",'Bạn phải truyền Id của đối tượng cần tạo Album'));
			return false;
		}

		$this->createAlbum($bw->input);
		if(!$this->model->basicObject->getId()){
			$this->alertMessage($vsLang->getWords("global_error_system",'Có lỗi trong quá trình tạo Album'));
			return false;
		}

		return 	$this->displayFile($this->model->basicObject->getId());
	}

	function displayFileForm($formtype="add",$album){
		global $bw;
		if(is_numeric($album))
		$album= $this->model->getObjectById($album);
		$vsLang =  VSFactory::getLangs();
		if(!$album){
			$this->alertMessage($vsLang->getWords("global_none_album",'Bạn phải tạo Album trước khi sử dụng'));
			return false;
		}
		$form['type'] = $formtype;
		$form['albumId'] = $album->getId();
		$form ['formSubmit'] = $vsLang->getWords ( "file_type_{$formtype}_bt", ucwords ( $formtype ) );
		$form ['title'] = $vsLang->getWords ( "file_type_{$formtype}_title", ucwords ( $formtype ) . " File" );
		
		$vsFile = VSFactory::getFiles();
		
		if ($form ['type']=="edit") {
			$vsFile->getObjectById($bw->input[3]);
			$form['switchform'] = '<input type="button" class="ui-state-default ui-corner-all" value="Chuyển qua form thêm mới" name="switch" id="switch-add-file-bt" />';
		}
		return $this->output = $this->html->addEditFileForm($form,$vsFile->basicObject,$album);
	}

	function displayGalleryFileList($albumId=0){
		$this->model->getFileByAlbumId($albumId);
		return $this->output = $this->html->displayGalleryFileList($this->model->getArrayObj(),$albumId);
	}

	function addEditGalleryFile(){
		global $bw,$vsStd;
		$vsFile = VSFactory::getFiles();
		if($bw->input['oldFileId']){
			$vsStd->requireFile ( UTILS_PATH . "TextCode.class.php" );
			$objName =  $bw->input['fileTitle'];
			$vsFile->getObjectById($bw->input['oldFileId']);
			$pathOld = $vsFile->basicObject->getPathView();
			if($bw->input['fileImageId']) $vsFile->deleteFile($bw->input['oldFileId']);
			else{
				$vsFile->basicObject->convertToObject($bw->input);
				$vsFile->basicObject->setTitle($objName);
				$vsFile->updateObjectById($vsFile->basicObject);
			}
		}
		if($bw->input['fileImageId']){
			$vsRelation = VSFactory::getRelation();
			$vsRelation->setObjectId($bw->input['fileImageId']);
			$vsRelation->setRelId($bw->input['albumId']);
			$vsRelation->setTableName($this->model->getRelTableName());
			$vsRelation->insertRel();
		}
		print "<script>vsf.get('gallerys/add-form-file/{$bw->input['albumId']}','file-form')</script>";
		$this->displayGalleryFileList($bw->input['albumId']);
	}

	function displayDeleteFile(){
		global $bw;
		VSFactory::getFiles()->deleteFile($bw->input[2]);
		$vsRelation = VSFactory::getRelation();
		$vsRelation->setObjectId($bw->input[2]);
		$vsRelation->setTableName($this->model->getRelTableName());
		$vsRelation->delRelByObject();
		$this->displayGalleryFileList($bw->input[3]);
	}
	*/
}

?>