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
				$this->getObjList ( str_replace("-", "", $bw->input [2]), $this->model->result ['message'] );
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
		global $vsLang,$bw,$DB;
		$bw->input[2] = str_replace("-", "", $bw->input[2]);
		$array['albumTitle']?$this->model->obj->setTitle($array['albumTitle']):$this->model->obj->setTitle($vsLang->getWords('global_system_auto_album',"System Create Album")." [{$bw->input[2]}]");
		$array['albumCode']	?$this->model->obj->setCode($array['albumCode']):$this->model->obj->setCode($bw->input[2]);
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

		return $this->displayFile($this->model->obj->getId());
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
			$form['switchform'] = '<input type="button" class="ui-state-default ui-corner-all" value="Add" name="switch" id="switch-add-file-bt" />';
		}
		return $this->output = $this->html->addEditFileForm($form, $this->model->vsFile->obj, $album);
	}

	function displayGalleryFileList($albumId=0){
		$this->model->getFileByAlbumId($albumId);
		return $this->output = $this->html->displayGalleryFileList($this->model->getArrayObj(),$albumId);
	}

	function addEditGalleryFile(){
		global $bw,$vsStd;
		
		if($bw->input['oldFileId']){
			$vsStd->requireFile ( UTILS_PATH . "TextCode.class.php");
			$this->model->vsFile->getObjectById($bw->input['oldFileId']);
			
			if($bw->input['fileId']) $this->model->vsFile->deleteFile($bw->input['oldFileId']);
			else{
				$bw->input['fileTitle'] = $bw->input['fileTitle']?$bw->input['fileTitle']:$bw->input['oldFileTitle'];
				$bw->input['fileTitle'] = $bw->input['fileTitle']?$bw->input['fileTitle']:'no name';
				$this->model->vsFile->obj->convertToObject($bw->input);
				$this->model->vsFile->updateObjectById();
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