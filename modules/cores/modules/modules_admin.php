<?php
/*
 +-----------------------------------------------------------------------------
 |   VIETSOL CMS version 1.0.0.0
 |	Author: BabyWolf
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 10/21/2007
 |	Finish Date: 10/21/2007
 |	Modified Start Date: 10/27/2007
 |	Modified Finish Date: 10/28/2007
 |	Module Description: This module is for management all modules in system.
 +-----------------------------------------------------------------------------
 */

if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}
require_once LIBS_PATH.'boards/VSAdminBoard.php';
class modules_admin extends VSAdminBoard{
	/**
	 * 
	 * @var skin_modules
	 */
	public $html = "";
	public $module;
	private $systemchoice = array ();
	
	/*-------------------------------------------------------------------------*/
	// construct
	/*-------------------------------------------------------------------------*/
	public function __construct() {
		global $vsTemplate;
		$this->module = new modules ();
		$this->html = $vsTemplate->load_template ( 'skin_modules' );
		$this->SetSystemChoice ();
	}
	function auto_run() {
		global $bw;
		//-------------------------------------------
		// What to do?
		//-------------------------------------------
		switch ($bw->input [1]) {
			
			case 'uninstall' :
				$this->uninstallModules ();
				break;
			
			case 'install' :
				$this->installModules ();
				break;
			
			case 'addForm' :
				$this->addModuleForm ();
				break;
			
			case 'edit' :
				$this->editModule ();
				break;
			
			case 'delete' :
				$this->deletedModule ();
				break;
				
			case 'exports' :
				$this->exportsModule ();
				break;
			case 'do_exports' :
				$this->doExportsModule ();
				break;
					
			case 'import_module' :
				
				$this->importModule ();
				break;			
			
			case 'addEdit' :
				$this->addEditModule ();
				break;
			
			case 'changeStatus' :
				$this->changeModuleStatus ();
				break;
			case 'display_obj_tab_modules' :
				$this->showModules ();
				break;
			//virtual module
			case 'virtual_module':
				$this->showVirtualModuleList();
				break;
				
				
				
			//something....
			case 'display_obj_tab_vmodules':
				$this->displayObjTabModules();
				break;
			case 'edit_obj_form_modules':
				$this->editObjectFormModules($bw->input[2]);
				break;
			case 'add_obj_form_modules':
				$this->addObjFormModules();
				break;
			case 'hide_checked_obj_modules':
				$this->hideCheckedObjModules();
				break;
			case 'delete_checked_obj_modules':
				$this->deleteCheckedObjModules();
				break;
			case 'submit_search_modules':
				$this->submitSearchModules();
				break;
				
			
				
			default :
				$this->tabs[]=array(
						'id'=>'modules',
						'href'=>"{$bw->base_url}{$bw->input[0]}/{$bw->input[0]}_display_tab/&ajax=1",
						'title'=>$this->getLang()->getWords("tab_{$bw->input[0]}",$bw->input[0]),
						'default'=>1,
						);
				$this->tabs[]=array(
						'id'=>'tab_settings',
						'href'=>"{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1",
						'title'=>$this->getLang()->getWords("tab_{$bw->input[0]}_ss",$bw->input[0].'Settings'),
						'default'=>0,
						);
				parent::auto_run();
				break;
		}
	}
	function showVirtualModuleList(){
		$this->module->setCondition("virtual>0");
		$option['module_list']=$this->module->getObjectsByCondition();
		
		return $this->output=$this->html->showModuleList($option);
	}
	
	/************ Export module ******************/
	function exportsModule(){
		global $bw,$INFO;
		
		$idmodule=$bw->input[2];
		//$option['id_module']=$bw->input[2];

		if($idmodule){
		VSFactory::createConnectionDB()->query("
				SELECT * FROM vsf_module WHERE id={$idmodule}
		");
		while($row=VSFactory::createConnectionDB()->fetch_row()){
			$option['module']=$row;  
		} 
		}
		$module=$option['module']['class'];

		$defin = array(
						'core'=>CORE_PATH.$module."/",
						'user'=>"./skins/user/finance/",
						'admin'=>"./skins/admin/red/"
						);
		foreach($defin as $key => $val){
			$option[$key]= array();
			foreach( scandir($val) as $k => $v){
				if(is_file($val.$v))
					$option[$key][$k] = $v;
			};
		}
		$result =mysql_list_tables($INFO['sql_database_0']);
		while ($rowdb = mysql_fetch_row($result)){
			 $option['table'][]=$rowdb[0];
		}

		return $this->output=$this->html->exportsModule($option);
	}
	
function doExportsModule(){
		global $bw,$INFO;
		
		$time=time();
		$root="./export_module";
		$name_module_root=$bw->input['namemodule'];
		$name_module=$bw->input['namemodule'];
		
		
		$tree=array(
					//'root' =>"./export_module",
					'root_module'=> "./export_module/".$name_module,
					'core1' =>"./export_module/".$name_module."/modules/",
					'core2' =>"./export_module/".$name_module."/modules/cores/",
					'core' =>"./export_module/".$name_module."/modules/cores/".$name_module,
					'skin1' =>"./export_module/".$name_module."/skins/",
					'skin2' =>"./export_module/".$name_module."/skins/user/",
					'skins' =>"./export_module/".$name_module."/skins/user/finance/",
					'admin1' =>"./export_module/".$name_module."/skins/admin/",
					'admin' =>"./export_module/".$name_module."/skins/admin/red/",
					'database' =>"./export_module/".$name_module."/database/"
		);
		$defin = array(
					'core'=>CORE_PATH.$name_module,
					'user'=>"./skins/user/finance/",
					'admin'=>"./skins/admin/red/"
		);
		
		if(!is_dir($root)){
			mkdir($root);
		}	
		
		if(!is_dir($root."/".$name_module)){
			foreach($tree as $key => $value){	
			mkdir($value);	
		}	
		}else{
			echo "Vui lòng kiểm tra lại! tên module đã tồn tại trong thư export_module";	
			return false;
		}
 		/******* tao file .sql vaf ghi dử liệu vào **************/

		if($bw->input['database']){
			foreach($bw->input['database'] as $key => $value){
				VSFactory::createConnectionDB()->query("
					SHOW CREATE TABLE $value
				");
		
				while($row=VSFactory::createConnectionDB()->fetch_row()){
							 $datdb[]=$row;
				}
				$wf = fopen ( $tree['database'].$value.".sql", "x+" );
				foreach($datdb as $index){
					file_put_contents($tree['database'].$value.".sql", $index['Create Table']);
					chmod($tree['database'].$value.".sql", 0777);
					//unlink($tree['database'].$value.".sql");
				}
				fclose($wf);
			}
		}
		

		/******* copy file core module********/
		if($bw->input['core']){
		foreach($bw->input['core'] as $value){
			copy($defin['core']."/".$value,$tree['core']."/".$value);	
		}};

		/******* copy file skin user********/
		if($bw->input['user']){
		foreach($bw->input['user'] as $value){
			copy($defin['user'].$value,$tree['skins'].$value);	
		}};
		/******* copy file skin admin********/
		if($bw->input['admin']){
		foreach($bw->input['admin'] as $value){
			copy($defin['admin'].$value,$tree['admin'].$value);	
		}};
		
		require_once CORE_PATH.'modules/recurseZip.php';
		
		$src='source/images';
		//Destination folder where we create Zip file.
		$dst='backup';
		$zip=new recurseZip();
		$zip->compress($tree['root_module'],$root);
		
		
		/********* delete thư mục sau khi Zip zong nhe ( dung de quy kiếm trên mạng )*********/
		$this->deleteDir($tree['root_module']);
		//$this->delete_folder($tree['root_module']);
		
		$option['download']=" {$bw->vars['board_url']}/export_module/{$name_module}.zip";
		
		$option['msg']="Bạn đã Export module thành công ";
		
		
		return $this->output=$this->html->exportsModule($option);
	}

function importModule(){
		global $bw,$INFO;
	
		require_once CORE_PATH.'files/files.php';
		$file=new files();
		
		$idfile=$bw->input['files']['fileimport']; 
		$file_upload=$file->getObjectById($idfile);
		$root="./import_module";
		if(!is_dir($root)){
			mkdir($root);
		}
		$zip = new ZipArchive;

		$res = $zip->open("./uploads"."/".$file_upload->getPath().$file_upload->getName().".".$file_upload->getType());
		
		if ($res === TRUE) {
		$zip->extractTo($root);
		$zip->close();
		}
		$dirname=$file_upload->getTitle();
		if(is_dir("./modules/cores/".$dirname)){
			
			return false;
		}
		/******** Chua optimate *************/
		$module_path=$root."/".$dirname;
		
		$array_dir=array(
			'user'=>"./skins/user/finance/",
			'admin'=>"./skins/admin/red/"
		);
		
		$this->all_copy($module_path."/skins/user/finance/",'./skins/user/finance/');
		$this->all_copy($module_path."./skins/admin/red/",'./skins/admin/red/');
		$dir_module="./modules/cores/".$dirname;
		if(!is_dir($dir_module)){
		mkdir($dir_module);	
		$this->all_copy($module_path."/modules/cores/".$dirname,"./modules/cores/".$dirname);
		}
		

		return $this->getListItemTable();
		
	}
	
public function deleteDir($dir) { 
		   if (substr($dir, strlen($dir)-1, 1) != '/') 
		       $dir .= '/'; 
	
		   if ($handle = opendir($dir)) 
		   { 
		       while ($obj = readdir($handle)) 
		       { 
		           if ($obj != '.' && $obj != '..') 
		           { 
		               if (is_dir($dir.$obj)) 
		               { 
		                   if (!$this->deleteDir($dir.$obj)) 
		                       return false; 
		               } 
		               elseif (is_file($dir.$obj)) 
		               { 
		                   if (!unlink($dir.$obj)) 
		                       return false; 
		               } 
		           } 
		       } 
		
		       closedir($handle); 
		
		       if (!@rmdir($dir)) 
		           return false; 
		       return true; 
		   } 
		   return false; 
		}	
	
/*public function delete_folder($tmp_path){
  if(!is_writeable($tmp_path) && is_dir($tmp_path)){chmod($tmp_path,0777);}
    $handle = opendir($tmp_path);
  while($tmp=readdir($handle)){
    if($tmp!='..' && $tmp!='.' && $tmp!=''){
         if(is_writeable($tmp_path.DS.$tmp) && is_file($tmp_path.DS.$tmp)){
                 unlink($tmp_path.DS.$tmp);
         }elseif(!is_writeable($tmp_path.DS.$tmp) && is_file($tmp_path.DS.$tmp)){
             chmod($tmp_path.DS.$tmp,0666);
             unlink($tmp_path.DS.$tmp);
         }
        
         if(is_writeable($tmp_path.DS.$tmp) && is_dir($tmp_path.DS.$tmp)){
                delete_folder($tmp_path.DS.$tmp);
         }elseif(!is_writeable($tmp_path.DS.$tmp) && is_dir($tmp_path.DS.$tmp)){
                chmod($tmp_path.DS.$tmp,0777);
                delete_folder($tmp_path.DS.$tmp);
         }
    }
  }
  closedir($handle);
  rmdir($tmp_path);
  if(!is_dir($tmp_path)){return true;}
  else{return false;}
}*/ 
	
	


function all_copy( $source, $target ) {
		
	if (is_dir($source) ) {
	    @mkdir( $target );
	    $d = dir( $source );
	    while ( FALSE !== ( $entry = $d->read() ) ) {
	        if ( $entry == '.' || $entry == '..' ) {
	            continue;
	        }
	        $Entry = $source . '/' . $entry; 
	        if ( is_dir( $Entry ) ) {
	            $this->all_copy( $Entry, $target . '/' . $entry );
	            continue;
	        }
	        copy( $Entry, $target . '/' . $entry );
	    }
	
	    $d->close();
	}else {
	    copy( $source, $target );
	}
}
	
		
	/**
	 * @return unknown
	 */
	public function getSystemchoice() {
		return $this->systemchoice;
	}
	
	
	
	
	
	function uninstallModules() {
		global $bw, $DB;
		
		$this->module->getObjectById ( $bw->input [2] );
		$classname = $this->module->basicObject->getClass () . "_install";
		$filepath = CORE_PATH . $this->module->basicObject->getClass () . "/" . $this->module->basicObject->getClass () . "_install.php";
		if (file_exists ( $filepath )) {
			require_once ($filepath);
			if (class_exists ( $classname )) {
				
				$module_install = new $classname ();
				
				if (method_exists ( $module_install, "Uninstall" )) {
					$module_install->Uninstall ( $bw->input [2] );
					$message = "You have successfully uninstalled modules [" . $this->module->basicObject->getClass () . "]";
					foreach ( $module_install->query as $value ) {
						$DB->query_id = mysql_query ( $value, $DB->connection_id );
						if (! $DB->query_id) {
							$message = mysql_error ();
							break;
						}
					}
				} else {
					$message = "The install method is not existed!";
				}
			} else {
				$message = "The install object is not existed!";
			}
		} else
			$message = "The install file is not existed!";
		
		$this->output = $this->getModuleList ( $message );
	}
	
	function installModules() {
		global $bw;
		$DB = VSFactory::createConnectionDB();
		$vsLang = VSFactory::getLangs();
		$this->module->basicObject->setClass ( $bw->input [2] );
		$classname = $this->module->basicObject->getClass () . "_install";
		$filepath = CORE_PATH . $this->module->basicObject->getClass () . "/" . $this->module->basicObject->getClass () . "_install.php";
		if (file_exists ( $filepath )) {
			require_once ($filepath);
			if (class_exists ( $classname )) {
				
				$module_install = new $classname ();
				
				if (method_exists ( $module_install, "Install" )) {
					$module_install->Install ();
					$message = sprintf ( $vsLang->getWords ( 'modules_install_success', "You have successfully installed modules [%s]" ), $this->module->basicObject->getClass () );
					foreach ( $module_install->query as $value ) {
						$DB->query_id = mysql_query ( $value, $DB->connection_id );
						if (! $DB->query_id) {
							$message = mysql_error ();
							break;
						}
					}
				} else {
					$message = $vsLang->getWords ( 'modules_install_method_not_exist', "The install method is not existed!" );
				}
			} else {
				$message = $vsLang->getWords ( 'modules_install_object_not_exist', "The install object is not existed!" );
			}
		} else
			$message = $vsLang->getWords ( 'modules_install_file_not_exist', "The install file is not existed!" );
		
		$this->output = $this->getModuleList ( $message );
	}
	
	function addModuleForm() {
		$this->output = $this->addEditForm ();
	}
	
	function editModule() {
		global $bw;
		$this->module->getObjectById ( $bw->input [2] );
		$this->output = $this->addEditForm ( 1 );
	}
	
	function deletedModule() {
		global $bw;
		
		$this->deleteModule ( $bw->input [2] );
		
		$this->output = $this->getModuleList ( $this->result ['message'] );
	}
	
	function addEditModule() {
		global $bw;
		
		if ($bw->input ['isAdmin'])
			$bw->input ['isAdmin'] = 1;
		if ($bw->input ['isUser'])
			$bw->input ['isUser'] = 1;
	
		$this->module->basicObject->convertToObject ( $bw->input );
		
		if ($bw->input ['FormType']) {
			$this->module->basicObject->setId ( $bw->input ['id'] );
			$this->module->updateObjectById ( $this->module->basicObject );
		} else {
			$this->module->validateModule ( true );
			if ($this->module->result ['status'])
				$this->module->insertObject ( $this->module->basicObject );
		}
		
		$this->output = $this->getModuleList ( $this->result ['message'] );
	}
	/**
	 * Function name: SetSystemChoice
	 * Author: BabyWolf
	 * Written date: 10/10/2007
	 * Modified date: 12/16/2007
	 * Description: Set system class list so that user can't modify its status.
	 *
	 * @return void
	 */
	function setSystemChoice() {
		$this->systemchoice = array ('modules' => 'modules', 'languages' => 'languages', 'home' => 'home', 'systemsetting' => 'systemsetting', 'generalsetting' => 'generalsetting', 'login' => 'login', 'logout' => 'logout' );
	}
	
	/**
	 * Function name: UpdateSkin
	 * Author: BabyWolf
	 * Written date: 12/30/2007
	 * Modified date:
	 * Description: Update Skin.
	 * Check if enable module already have skin, do nothing.
	 * If enable module don't have skin, create skin file for it.
	 *
	 * @param $modulename: name of enable module.
	 * @return void
	 */
	function updateSkin($modulename = "") {
		global $bw, $vsStd, $vsPrint;
		$DB = VSFactory::createConnectionDB();
		// init skin path for type of module
		if ($bw->input ['Type']) {
			$skinpath = "../skin_cache";
		} else {
			$skinpath = "./skin_cache";
		}
		
		$DB->simple_construct ( array ('select' => '*', 'from' => 'skin_sets' ) );
		$l = $DB->simple_exec ();
		
		while ( $skin = $DB->fetch_row ( $l ) ) {
			if (file_exists ( $skinpath . "/cacheid_" . $skin ['set_skin_set_id'] . "/skin_" . $modulename . ".php" ))
				break;
			
		// Build file content
			$content = "<?php\n\n";
			$content .= "class skin_" . $modulename . " {\n\n";
			$content .= "function " . ucfirst ( $modulename ) . "Main() {\n";
			$content .= "global \$bw;\n";
			$content .= "\$BWHTML = \"\";\n";
			$content .= "//--starthtml--//\n\n";
			$content .= "\$BWHTML .= <<<EOF\n";
			$content .= "<div class=\"maintitle\">{\$bw->lang['main_title']}</div>\n";
			$content .= "<div align=\"right\" class=\"normaltext\"><!--PAGE LINKS--></div>\n";
			$content .= "<!--PAGE CONTENT-->\n";
			$content .= "<div align=\"right\" class=\"normaltext\"><!--PAGE LINKS--></div>\n";
			$content .= "EOF;\n";
			$content .= "//--endhtml--//\n\n";
			$content .= "return \$BWHTML;\n";
			$content .= "}\n}\n?>";
			
			$wf = fopen ( $skinpath . "/cacheid_" . $skin ['set_skin_set_id'] . "/skin_" . $modulename . ".php", "w" );
			fwrite ( $wf, $content );
			fclose ( $wf );
		}
	}
	/**
	 * Function name: UpdateLanguage
	 * Author: BabyWolf
	 * Written date: 12/16/2007
	 * Modified date:
	 * Description: Update language.
	 * Check if enable module already have language, do nothing.
	 * If enable module don't have language, create language for it.
	 *
	 * @param $modulename: name of enable module.
	 * @return void
	 */
	function updateLanguage($modulename = "") {
		global $bw, $vsStd, $vsPrint;
		$DB = VSFactory::createConnectionDB();
		// init lang path for type of module
		if ($bw->input ['Type']) {
			$langtype = 1;
			$langpath = "../lang";
		} else {
			$langtype = 0;
			$langpath = "./lang";
		}
		
		$DB->simple_construct ( array ('select' => '*', 'from' => 'langs', 'where' => 'LangType=' . $langtype ) );
		$l = $DB->simple_exec ();
		
		while ( $lang = $DB->fetch_row ( $l ) ) {
			// if languages store in file, write file, else update database
			if ($bw->vars ['storelangtype'])
				$this->updateLangFile ( $lang, $langpath, $modulename );
			else
				$this->updateLangDB ( $lang ['LangID'], $modulename );
		}
	}
	
	/**
	 * Function name: UpdateLangFile
	 * Author: BabyWolf
	 * Written date: 12/16/2007
	 * Modified date:
	 * Description: Check if language of module is already exist in file. If not, create it.
	 *
	 * @param  integer 	$langid
	 * @param  string	$langpath
	 * @param  string	$modulename
	 * @return void
	 */
	function updateLangFile($lang = array(), $langpath = "", $modulename = "") {
		
		if (file_exists ( $langpath . "/" . $lang ['FolderName'] . "/" . $modulename . ".lang" ))
			return;
		
		// Build file content
		$content = "<?php\n";
		$content .= "\$lang = array(\n";
		$content .= "'pageTitle'	=> '" . $modulename . "',\n";
		$content .= "'main_title'	=> '" . $modulename . "',\n";
		$content .= ");\n";
		$content .= "?>";
		
		$wf = fopen ( $langpath . "/" . $lang ['FolderName'] . "/" . $modulename . ".lang", "w" );
		fwrite ( $wf, $content );
		fclose ( $wf );
	}
	
	/**
	 * Function name: UpdateLangDB
	 * Author: BabyWolf
	 * Written date: 12/16/2007
	 * Modified date:
	 * Description: Check if language of module is already exist in database. If not, create it.
	 *
	 * @param  integer $langid
	 * @param  string $modulename
	 * @return void
	 */
	function updateLangDB($langid = 1, $modulename = "") {
		global $bw, $vsStd, $vsPrint;
		$DB = VSFactory::createConnectionDB();
		$DB->simple_construct ( array ('select' => '*', 'from' => 'lang_items', 'where' => "Module='" . $modulename . "' AND LangID=" . $langid ) );
		$li = $DB->simple_exec ();
		
		if ($DB->fetch_row ( $li ))
			return;
		
		$langvalue = array ('pageTitle' => $modulename, 'main_title' => $modulename );
		$langitem = serialize ( $langvalue );
		$lang = array ('LangID' => $langid, 'Module' => $modulename, 'Value' => $langitem );
		$DB->do_insert ( 'lang_items', $lang );
	}
	
	function getModuleList($message = "") {
		$files = VSFactory::getFiles ()->readDir ( CORE_PATH, array ('.svn' ) );
		
		$this->module->getObjectsByCondition ( 'getClass' );
		$arrayModule =$this->module->getArrayObj ();
		$moduleListHTML = "";
		$count = 0;
		$files = array_reverse ( $files );
		foreach ( $files as $file ) {
			$count ++;
			$rowStyle = $count % 2 ? "odd" : "even";
			$installLink = "";
			$editLink = "";
			if (array_key_exists ( $file, $arrayModule )) {
				$moduleObject = $arrayModule [$file];
				$installLink = $this->html->uninstallLink ( $moduleObject );
				$editLink = $this->html->editLink ( $moduleObject );
			} else {
				$moduleObject = new Module ();
				$moduleObject->setTitle ( $file );
				$moduleObject->setClass ( $file );
				$installLink = $this->html->installLink ( $moduleObject );
			}
			
			if (! file_exists ( CORE_PATH . $file . "/" . $file . "_install.php" ))
				$installLink = "";
			
			$moduleListHTML .= $this->html->addModuleList ( $moduleObject, $editLink, $installLink, $rowStyle );
		}
		
		$modulehtml = $this->html->moduleList ( $message, $moduleListHTML );
		
		return $modulehtml;
	}
	
	function addEditForm($formtype = 0) {
		
		$formtitle = "Add More Module";
		if ($formtype)
			$formtitle = "Edit A Module";
		$addeditformhtml = $this->html->addEditModuleForm ( $formtitle, $formtype, $this->module->basicObject );
		
		return $addeditformhtml;
	}
	
	/**
	 * Function name: ShowModules
	 * Author: BabyWolf
	 * Written date: 10/10/2007
	 * Modified date: 12/16/2007
	 * Description: Show enabled/disabled module list.
	 *
	 * @return void
	 */
	function showModules() {
		$modulehtml = $this->getModuleList ();
		$addformhtml = $this->addEditForm ();
		$this->output = $this->html->modulesMain ( $addformhtml, $modulehtml );
	}
	
	function getVirtualModuleList() {
		$this->module->setCondition ( "virtual = 1" );
		$this->module->setOrder ( 'title' );
		$this->module->getObjectsByCondition ();
		
		return $this->module->getArrayObj ();
	}
	
	/*
	This code created by system
	add this code when using datepicker
	$vsPrint->addJavaScriptFile("jquery/ui.datepicker");
	$vsPrint->addCSSFile('ui.datepicker');
	*/
	//require_once CORE_PATH.$bw->input[0]."modules.php";
	function deleteCheckedObjModules(){
			global $bw;
			$this->vsLang=VSFactory::getLangs();
			$modules=new modules();
			if($bw->input['checkedObj']){
				
				$modules->setCondition($modules->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$modules->deleteObjectByCondition();
				$message=$this->vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabModules();
		}
	function hideCheckedObjModules(){
			global $bw;
			$this->vsLang=VSFactory::getLangs();
			$modules=new modules();
			if($bw->input['checkedObj']){
				$modules->setCondition($modules->getPrimaryField()." in ({$bw->input['checkedObj']}) ");
				$modules->updateObjectByCondition(array("status"=>"0"));
				$message=$this->vsLang->getWords('delete_success',"Delete success!");
			}
			return $this->displayObjTabModules();
		}
		function addObjFormModules(){
			global $bw;
			$this->vsLang=VSFactory::getLangs();
			$modules=new modules();
			
			if($bw->input['modules']['id']){
				$modules->getObjectById($bw->input['modules']['id']);
			}
			
			if($bw->input['modules']['isAdmin'])$bw->input['modules']['isAdmin']=1;
			else $bw->input['modules']['isAdmin']=0;
			
			
			if($bw->input['modules']['isUser'])$bw->input['modules']['isUser']=1;
			else $bw->input['modules']['isUser']=0;
			
			
			$modules->basicObject->convertToObject($bw->input['modules']);
			if($modules->basicObject->getId()){
				$modules->updateObject();
			}else{
				$modules->insertObject();
			}
			if(!$modules->result['status']) {
				$erro.=$this->vsLang->getWords("delete_tags_not_success", "Can not success:".$tags->result['developer']);
			}
			return $this->displayObjTabModules($error);
		}
     function editObjectFormModules($objId){
     	global $bw;
     	$modules=new modules();
     	$modules->getObjectById($objId);
     	$obj=$modules->basicObject;
		$option['parent_list']=	array(
				'pages'=>'pages',
				'products'=>'products'
		);
     	return $this->output=$this->html->addEditObjFormModules($obj, $option);
     }
	function displayObjTabModules($error=""){
	global $bw;
		$this->vsSettings=VSFactory::getSettings();
		$modules=new modules();
		$modules->setCondition("virtual>0");
		$option=$modules->getPageList("{$bw->input[0]}/display_obj_tab_vmodules",2,$this->vsSettings->getSystemKey($bw->input[0]."_limit_row_list",15),1,"obj_panel_modules");
		$option['error']=$error;
		return $this->output=$this->html->objListHtmlModules($option).$error;
	}
	function submitSearchModules(){
        	global $bw;
        	$select="*";
        	$order="";
        	$from="vsf_module";
        	$where="virtual>0";
//        	echo "<pre>";
//        	print_r($bw->input);
//        	echo "</pre>";
//        	exit;
        	if($bw->input['id']){
        		$where.=" and `id` ='{$bw->input['id']}'";
        	}else{
        		
//	        	if($bw->input['keyword']){
//	        		require_once UTILS_PATH . 'TextCode.class.php';
//					$condition=VSFTextCode::buildFullTextSearch($bw->input['keyword']);
//					$select.=",match(removedText) against ('$condition') as score";
//	        		$where.=" and match(removedText) against ('$condition') >0";
//	        		$order.="order by score desc";
//	        	}
//	        	if($bw->input['position']){
//	        		$where.=" and `id` in (select postId from vsf_postpositionrel where positionId='{$bw->input['position']}')";
//	        	}
//	        	if($bw->input['catId']){
//	        		$where.=" and `catId` ='{$bw->input['catId']}'";
//	        	}
//	        	if(isset($bw->input['publish'])){
//	        		if($bw->input['publish']!="all"){
//		        		$where.=" and `publish`='{$bw->input['publish']}'";
//	        		}
//	        		
//	        	}
//	        	if($bw->input['type']){
//	        		if($bw->input['type']!='0'){
//		        		$where.=" and `type`='{$bw->input['type']}'";
//	        		}
//	        		
//	        	}
        	}
        	$query="select $select from $from where $where $order limit 0,100";
        	$DB=VSFactory::createConnectionDB();
        	$DB->query($query);
        	$option=array();
        	$option['pageList']=array();
        	while($row=$DB->fetch_row()){
        		$module=new module();
        		$module->convertToObject($row);
        		$option['pageList'][$module->getId()]=$module;
        	}
        	return $this->output=$this->html->getResultSearchModules($option);
        }
	
	
	
}
?>