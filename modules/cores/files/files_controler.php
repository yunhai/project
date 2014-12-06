<?php
require_once(CORE_PATH.'files/files.php');

class files_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_files");
		parent::__construct($modelName,"skin_files","file");
		$this->model->categoryName="files";

	}

function auto_run(){
		global $bw;
		switch($bw->input[1]){
			case 'files_add-type' :
				$this->setOutput ( $this->addEditTypeForm () );
				break;
			
			case 'files_edit-type' :
				$this->editType ();
				break;
			
			case 'files_add-edit-type' :
				$this->addEditType ();
				break;
			
			case 'files_display-type' :
				$this->displayTypePage ();
				break;
			case 'files_delete-type' :
				$this->deleteObjectById ( $bw->input [2] );
				$this->output = $this->GetTypeList ( $this->result ['message'] );
				break;
			
			// Folder zone
			case 'files_getfolder' :
				$this->viewFolder ();
				break;
			
			case 'files_addfolder' :
				$this->addFolder ();
				break;
			
			case 'files_deletefolder' :
				$this->deleteFolder ();
				break;
			case 'files_delete_file' :
				$this->deleteFile ($bw->input[2]);
				break;
				
			// File zone
			case 'files_deletefile' :
				$this->doDeleteFile ();
				break;
			
			case 'files_addfile' :
				$this->output = $this->AddEditFileForm ();
				break;
			
			case 'files_editfile' :
				$this->editFile ();
				break;
			
			case 'files_addeditfile' :
				$this->addEditFile ();
				break;
			
			case 'files_getfilelist' :
				$this->viewFile ();
				break;
			case 'files_uploadfile' :
				$this->model->uploadFile($bw->input['uploadName'], $bw->input['fileFolder'], $bw->input['utype']);
				break;
			
			case 'files_displayfiles' :
				$this->displayFilePage ();
				break;
			
			case 'files_upload' :
				$this->upload ();
				break;
			case 'files_index_change' :
				$this->indexChange ();
				break;
			case 'files_propertis_change' :
				$this->filesPropertisChange ();
				break;
			default :
				return parent::auto_run();
				break;
				
		}
	}

function filesPropertisChange(){
	
		global $bw;
		$id=intval($bw->input['id']);
		$result=array();

		$option['obj']=$this->model->getObjectById($id);
		if($bw->input['name']=='name'){
			
			$bw->input['value']=VSFactory::getTextCode()->removeAccent($bw->input['value'],"-");
			$this->model->setCondition("path ='{$option['obj']->getPath()}'");
			$option['obj_file']=$this->model->getObjectsByCondition();
			
//			foreach($option['obj_file'] as $key => $value){
//				if($value->getName()==$bw->input['value'] && $value->getId()!=$option['obj']->getId() )  {
//				$bw->input['value']=$bw->input['value']."_".++$number;
//				}
//			}
					
				function check_name($obj,$obj_file,$va){
					global $bw;
					$number=0;
					foreach($obj_file as $key => $value){
						if($value->getName()==$va && $value->getId()!=$obj->getId() )  {
							$bw->input['value']=$va."_".++$number;
						}
					}
					//check_name($obj,$obj_file,$bw->input['value']);	
				}
				check_name($option['obj'],$option['obj_file'],$bw->input['value']);
				
				echo "<pre>";
				print_r($bw->input['value']);
				echo "<pre>";
				exit();
				

		}
		
		$this->model->getObjectById($id);
		if(!$this->model->basicObject->getId()){
			$result['status']=0;
			$result['message']='File not found!';
			return $this->output=json_encode($result);
		}
		if(method_exists($this->model->basicObject, "set".ucfirst ($bw->input['name']))){
			$method="set".ucfirst ($bw->input['name']);
			$this->model->basicObject->$method($bw->input['value']);
			$this->model->updateObject();
			$result['status']=1;
			$result['message']='Update success!';
		}else{
			$result['status']=0;
			$result['message']='Properties not define';
			return $this->output=json_encode($result);
		}
		return $this->output=json_encode($result);
	}
	function indexChange(){
		global $bw;
		foreach ($bw->input['data'] as $index=>$value) {
			VSFactory::createConnectionDB()->query("
			UPDATE `vsf_file` SET `index` = '$value' WHERE `id` ='$index';
			");
		}
	}
	function upload() {
		global $bw;
		$result=array();
//		$result['success']
//		$result['index']
//		$result['intro']
//		$result['name']
//		$result['alt']
//		$result['objId']
//		$result['img']
//$result['path']
		$maxindex=0;
		if($bw->input['galleryId']){
        	require_once CORE_PATH.'gallerys/gallerys.php';
        	$gallerys=new gallerys();
        	$gallerys->getObjectById($bw->input['galleryId']);
        	if(!$gallerys->basicObject->getId()){
        		$result['message'].='Gallery not found!';
        		$result['success']=0;
        		return $this->output = json_encode($result);
        	}else{
        		$limit=VSFactory::getSettings()->getSystemKey($gallerys->basicObject->getModule()."_limit_files",0,'gallerys');
        		if($limit){
	        		VSFactory::createConnectionDB()->query("
			        		select count(fileId) as tbcount from vsf_{$gallerys->getRelTableName()}
			        		where galleryId='{$gallerys->basicObject->getId()}' 
	        		");
	        		$row=VSFactory::createConnectionDB()->fetch_row();
	        		if(intval($row['tbcount'])>=$limit){
	        			$result['success']=0;
        				$result['message'].=VSFactory::getLangs()->getWords('error_limit_file',sprintf("Lỗi: Vượt quá số lượng tập tin tải lên (tối đa %s tập tin)",$limit));
        				return $this->output = json_encode($result);
	        		}
        		}
        		
        		VSFactory::createConnectionDB()->query("
        		select max(`index`) as maxindex from vsf_file 
        		where `id` in 
        			(
		        		select fileId from vsf_{$gallerys->getRelTableName()}
		        		where galleryId='{$gallerys->basicObject->getId()}' 
        			)
        		");
        		$row=VSFactory::createConnectionDB()->fetch_row();
        		$maxindex=intval($row['maxindex'])+1;
        		$result['gallery']=$gallerys->basicObject->convertToDB();
        	}
        }
		$fileObj=new File();
		$fileObj->setIndex($maxindex);
		if (isset($_GET['qqfile'])) {
            //firefox
            if($this->model->uploadLocalToHost("php://input", $bw->input['fmodule'], $_GET['qqfile'], $fileObj)){
            	$result['success']=1;
            }else{
            	$result['message'].=$this->model->message;
            	$result['success']=0;
            }
        } elseif (isset($_FILES['qqfile'])) {
        	//IE
        	if($this->model->uploadLocalToHost($_FILES['qqfile']['tmp_name'], $bw->input['fmodule'], $_FILES['qqfile']['name'], $fileObj)){
        		$result['success']=1;
        	}else{
            	$result['message'].=$this->model->message;
            	$result['success']=0;
            }
        	
        }else{
        	$result['success']=0;
        	$result['message'].='Not detect file upload!';
        }
        $result['title']=$fileObj->getTitle();
        $result['alt']=$fileObj->getIntro();
        $result['index']=$fileObj->getIndex();
        $result['intro']=$fileObj->getIntro();
        $result['img']=$fileObj->getPathView(2);
        $result['path']=$fileObj->getPathView(0);
        $result['objId']=$fileObj->getId();
        if($gallerys&&$fileObj->getId()){
        	$gallerys->addFileToAlbum($fileObj->getId(), $gallerys->basicObject->getId());
        }
        /**
         * file to img
         * title->title
         * index->index
         * intro->alt
         * 
         */
		return $this->output = json_encode($result);
	}
	
	function viewFile() {
		
		$this->currentPath = $this->getPath ();
		$this->output = $this->GetFilesList ();
	}
	
	function getPath() {
		global $bw;
		
		$thisPath = "";
		for($i = 2; $i <= count ( explode ( "/", $bw->input ['vs'] ) ); $i ++)
			if ($bw->input [$i])
				$thisPath .= $bw->input [$i] . "/";
		return $thisPath;
	}
	
	function displayFilePage() {
		
		$createFormHTML = $this->html->FolderForm ();
		$folderListHTML = $this->getDirectoryList ();
		
		$output .= $this->html->FolderList ( $folderListHTML, $createFormHTML );
		
		$output .= $this->html->MainFiles ( $this->addEditFileForm (), $this->getFilesList () );
		
		$this->setOutput ( $output );
	}
	
	function loadDefault() {
		global $vsPrint;
		$vsPrint->addJavaScriptString ( 'init_tab', '$(document).ready(function(){$("#page_tabs").tabs({fx: { opacity: "toggle" },cache: true});});' );
		$this->output = $this->html->MainPage ();
	}
	
	//===================================================
	// TYPE ZONE
	//===================================================
	function editType() {
		global $bw;
		
		$this->type = $this->model->getObjectById ( $bw->input [2] );
		$this->output = $this->addEditTypeForm ( 'edit' );
	}
	
	function addEditType() {
		global $bw;
		
		$this->type->convertToObject ( $bw->input );
		
		if ($bw->input ['FormType'] == "edit") {
			$this->type->setId ( $bw->input ['fileTypeID'] );
			$this->updateObjectById ( $this->type );
		} else {
			$this->insertObject ( $this->type );
		}
		
		$this->output = $this->GetTypeList ( $this->result ['message'] );
	}
	
	function addEditTypeForm($formtype = 'add', $message = "") {
		$vsLang = VSFactory::getLangs ();
		$form ['message'] = $message;
		$form ['type'] = $formtype;
		$form ['formSubmit'] = $vsLang->getWords ( "file_type_{$formtype}_bt", ucwords ( $formtype ) );
		$form ['title'] = $vsLang->getWords ( "file_type_{$formtype}_title", ucwords ( $formtype ) . " File Type" );
		if ($form ['type'] == "edit") {
			$form ['switchform'] = <<<EOF
<input type="button" class="ui-state-default ui-corner-all" value="Chuyển qua form thêm mới" name="switch" onclick="vsf.get('files/add-type/','addeditform');" />
EOF;
		}
		$addEditFormHTML = $this->html->addEditTypeForm ( $form, $this->model->objType->type );
		
		return $addEditFormHTML;
	}
	
	function getTypeList($message = "") {
		$this->model->objType->getAllType ();
		// Get main html of mime list
		return $typeHTML = $this->html->TypeList ( $this->model->objType->arrayType, $message );
	}
	
	function displayTypePage() {
		
		$typeFormHTML = $this->addEditTypeForm ();
		$typeListHTML = $this->getTypeList ();
		
		$returnHTML = $this->html->MainType ( $typeFormHTML, $typeListHTML );
		
		$this->setOutput ( $returnHTML );
	}
	
	//===================================================
	// FOLDER ZONE
	//===================================================
	function viewFolder() {
		
		$thisPath = $this->getPath ();
		$this->output = $this->getDirectoryList ( $thisPath );
	}
	
	function deleteFolder() {
		$vsLang = VSFactory::getLangs ();
		$folderPath = $this->rootPath . $this->getPath ();
		if (file_exists ( $folderPath ) && @rmdir ( $folderPath ))
			$returnHTML = $this->html->showMessage ( $vsLang->getWords ( 'folder_delete_success', 'Delete folder successfully!' ) );
		else
			$returnHTML = $this->html->showMessage ( $vsLang->getWords ( 'folder_delete_fail', "Delete fail! Please check for permission or the folder have to be empty." ) );
		
		$parent_dir = substr ( $this->getPath (), 0, strrpos ( rtrim ( $this->getPath (), "/" ), "/" ) );
		
		$returnHTML .= $this->getDirectoryList ( $parent_dir );
		
		$this->setOutput ( $returnHTML );
	}
	
	function addFolder() {
		global $bw;
		$vsLang = VSFactory::getLangs ();
		$dirpath = $this->rootPath . $bw->input ['folderPath'] . $bw->input ['folderName'];
		
		if (! file_exists ( $dirpath )) {
			if (mkdir ( $dirpath ))
				$returnHTML = $this->html->showMessage ( $vsLang->getWords ( 'folder_create_success', "Created folder successfully!" ) );
			else
				$returnHTML = $this->html->showMessage ( $vsLang->getWords ( 'folder_create_fail', "Could not create folder, please check for permission!" ) );
		} else
			$returnHTML = $this->html->showMessage ( $vsLang->getWords ( 'folder_create_existed', "The folder you want to create have already existed!" ) );
		
		$returnHTML .= $this->getDirectoryList ( $bw->input ['folderPath'] );
		
		$this->setOutput ( $returnHTML );
	}
	
	function getDirectoryList($dir = "") {
		global $bw;
		$files = $this->model->readDir ( UPLOAD_PATH . $dir . "/", array ('.svn' ) );
		
		$filelist = "";
		if ($dir != "") {
			$thisfile ['name'] = "..";
			$thisfile ['path'] = substr ( $dir, 0, strrpos ( rtrim ( $dir, "/" ), "/" ) ) . "/";
			$thisfile ['icon'] = "up.png";
			$thisfile ['delete'] = "<br />";
			$filelist [] = $thisfile;
		}
		foreach ( $files as $key => $file ) {
			$thisfile ['name'] = $file;
			$thisfile ['path'] = $dir . $file . "/";
			$thisfile ['icon'] = "folder.png";
			$thisfile ['delete'] = "<a href=\"javascript:vsf.get('files/deletefolder/{$thisfile['path']}','folder-list')\"><img src='{$bw->vars['img_url']}/del.png' /></a><br />";
			$filelist [$key + 1] = $thisfile;
		}
		return $this->html->FolderLink ( $filelist );
	}
	
	//===================================================
	// FILES ZONE
	//===================================================
	
function deleteFile($id) {
		global $bw;
		$result = array ();
		$result ['status'] = 1;
		$this->model->deleteFile ( $id );
		VSFactory::createConnectionDB ()->query ( "
  delete from vsf_gallery_file_rel where 
  fileId not in (select id from vsf_file where id=vsf_gallery_file_rel.fileId)
  " );
		$this->output = json_encode ( $result );
	}
	function doDeleteFile() {
		global $bw;
		
		$this->model->deleteFile ( $bw->input [2] );
		
		$this->output = $this->getFilesList ( $this->result ['message'] );
	}
	
	function editFile() {
		global $bw;
		
		$this->model->basicObject->setId ( $bw->input [2] );
		$this->model->getObjectById ( $this->model->basicObject->getId () );
		$this->output = $this->AddEditFileForm ( 'edit' );
	}
	
	function addEditFile() {
		global $bw;
		if ($bw->input ['fileId']) {
			$arrayId = explode ( ',', $bw->input ['fileId'] );
			$count = 0;
			foreach ( $arrayId as $id ) {
				$bw->input ['fileId'] = $id;
				$this->model->getObjectById ( $bw->input ['fileId'] );
				if ($this->model->result ['status']) {
					$this->model->basicObject->convertToObject ( $bw->input );
					$this->model->updateObjectById ( $this->model->basicObject );
					if ($bw->input ['oldFileId'] && $count == 0) {
						$count ++;
						$this->model->deleteFile ( $id );
						$this->model->setCondition ( "fileId={$bw->input['fileId']}" );
						$this->model->updateObjectByCondition ( array ('fileId' => $id ) );
						$sql = "ALTER TABLE `" . SQL_PREFIX . $this->model->getTableName () . "` auto_increment = 1";
						$this->model->executeQuery ( $sql );
					}
				}
			}
		} else {
			$this->model->basicObject->convertToObject ( $bw->input );
			if ($bw->input ['oldFileId']) {
				$this->model->basicObject->setId ( $bw->input ['oldFileId'] );
				$this->model->updateObjectById ( $this->model->basicObject );
			} 

			else {
				print "
					<script>
						vsf.alert(" . VSFactory::getLangs ()->getWords ( 'global_file_upload_err_no_file', 'No file was uploaded!' ) . ");
					</script>
				";
			}
		}
		
		$this->model->currentPath = $this->model->basicObject->getPath ();
		unset ( $this->model->basicObject );
		
		$this->output = $this->GetFilesList ( $this->result ['message'] );
	}
	
	function getFilesList($message = "") {
		global $bw, $vsStd;
		require_once (UTILS_PATH . "TextCode.class.php");
		$textcode = new VSFTextCode ();
		
		if (! $this->model->currentPath)
			$this->model->currentPath = $this->getPath ();
		
		$this->model->setCondition ( "filePath='{$this->model->currentPath}'" );
		$this->model->setOrder ( 'fileId desc' );
		$end = $this->model->getNumberOfObject ();
		$size = VSFactory::getSettings()->getSystemKey ( "admin_file_list_number", 10 );
		$limit = array ();
		if ($end > $size) {
			// Build page link for product list
			$vsStd->requireFile ( LIBS_PATH . 'Pagination.class.php' );
			$pagination = new VSFPagination ();
			$pagination->ajax = 1;
			$pagination->callbackobjectId = 'area-panel';
			$pagination->url = "files/getfilelist/$this->model->currentPath/";
			$pagination->p_Size = $size;
			$pagination->p_TotalRow = $end;
			$pagination->SetCurrentPage ( 4 );
			$pagination->BuildPageLinks ();
			$limit = array ($pagination->p_StartRow, $pagination->p_Size );
		}
		$this->model->setLimit ( $limit );
		$this->model->getObjectsByCondition ();
		$option ['paging'] = $pagination->p_Links;
		$option ['mainTitle'] = VSFactory::getLangs ()->getWords ( 'discover_main_title', 'Discover Item List' );
		$option ['message'] = $message;
		
		return $this->html->fileList ( $this->model->getArrayObj (), $message );
	}
	
	function addEditFileForm($formtype = "add", $message = "") {
		$vsLang = VSFactory::getLangs ();
		$form ['message'] = $message;
		$form ['type'] = $formtype;
		$form ['formSubmit'] = $vsLang->getWords ( "file_type_{$formtype}_bt", ucwords ( $formtype ) );
		$form ['title'] = $vsLang->getWords ( "file_type_{$formtype}_title", ucwords ( $formtype ) . "Thêm một file mới" );
		if ($form ['type'])
			$form ['switchform'] = '<input type="button" class="ui-state-default ui-corner-all" value="Chuyển qua form thêm mới" name="switch" id="switch-add-file-bt" />';
		
		$form ['filepath'] = $this->model->basicObject->getPath ();
		
		$addeditformhtml = $this->html->addEditFileForm ( $form, $this->model->basicObject );
		
		return $addeditformhtml;
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
	*Skins for file ...
	*@var skin_files
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
