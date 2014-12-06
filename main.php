<?php
// Handle all error of application $vsLang
try {
	session_start ();
	
	// Initialize configuration
	global $INFO;
	$INFO = array ();
	require ROOT_PATH . "conf_global.php";
	// Starting debug
	$Debug = new Debug ();
	$Debug->startTimer ();
	
	require_once LIBS_PATH . 'Factory.class.php';
	require_once LIBS_PATH.'plugin.php';
	require_once LIBS_PATH.'boards/Control.board.php';
	//Connection Database
	
	$DB = VSFactory::createConnectionDB();
	$DB->obj ['debug'] = ($INFO ['sql_debug'] == 1) ? $_GET ['debug'] : 0;
	//--------------------------------
	// Make CONSTANT
	//--------------------------------
	
	$bw = new infos ();
	
	require_once LIBS_PATH . "Component.class.php";
	
	require_once LIBS_PATH . "Functions.class.php";
	require_once LIBS_PATH . "Session.class.php";
	$vsStd = new VSFFunction ();
	
	//$vsLang = VSFactory::getLangs();
	
	require_once LIBS_PATH . "Object.class.php";
	require_once LIBS_PATH . "boards/BasicObject.board.php";
	
	require_once LIBS_PATH . "Skin.class.php";
	require_once LIBS_PATH . "VSTemplate.class.php";
	require_once LIBS_PATH . "Display.class.php";
	
	require_once LIBS_PATH . "Path.class.php";
	
	$vsStd->requireFile(LIBS_PATH."boards/Control.board.php");
	$vsStd->requireFile(LIBS_PATH."boards/skins/skins_board.php");
	
	if (APPLICATION_TYPE == "admin") {
		require_once LIBS_PATH.'boards/skins/skin_board_admin.php';
		require_once LIBS_PATH.'boards/Control_admin.board.php';
		$vsStd->requireFile ( CORE_PATH . "admins/admins.php" );
		
	} else {
		require_once LIBS_PATH.'boards/skins/skin_board_public.php';
		require_once LIBS_PATH.'boards/skins/skin_board_public.php';
		require_once LIBS_PATH.'boards/Control_public.board.php';
		$vsStd->requireFile ( CORE_PATH . "users/users.php" );	
		$vsUser = VSFactory::getUsers();
	}
	// Starting session
	$vsSess = new VSFSession ();
	$vsModule = VSFactory::getModules();
	
	//$vsRelation = new VSFRelationship ();
	//---------------------------------------
	// Initialize user language default value
	//---------------------------------------
	
	$vsFile =  VSFactory::getFiles();
	$bw->input = $vsStd->parse_incoming ();
	$vsPrint = new VSFDisplay ();
	if ($bw->input ['vs'] == "admin")
		$vsPrint->boink_it ( $bw->vars ['board_url'] . "/admin.php" );
	
	//===========================================================================
	// Get system menu
	//===========================================================================
	//$vsMenu = VSFactory::getMenus();
	$vsCom = new VSFComponent ();
	$vsSkin = new VSFSkin ();
	$vsTemplate = new VSTemplate ( $vsSkin->basicObject->getFolder (), 1);
	
	
	$vsPath = new VSFPath ();
		
	$vsPath->setupBaseUrl ();

	$bw->vars ['img_url'] = $bw->vars ['board_url'] . "/" . $vsSkin->basicObject->getFolder () . "/images";
	$bw->vars ['cur_scripts'] = $bw->vars ['board_url'] . "/" . $vsSkin->basicObject->getFolder () . "/javascripts";
	//--------------------------------
	//  Upload dir?
	//--------------------------------
	$bw->vars ['upload_dir'] = (isset ( $bw->vars ['upload_dir'] ) && $bw->vars ['upload_dir']) ? $bw->vars ['upload_dir'] : ROOT_PATH . 'uploads';
	$bw->vars ['upload_url'] = (isset ( $bw->vars ['upload_url'] ) && $bw->vars ['upload_url']) ? $bw->vars ['upload_url'] : $bw->vars ['board_url'] . '/uploads';
	
	if (USE_SHUTDOWN and $bw->input ['act'] != 'task') {
		chdir ( ROOT_PATH );
		$ROOT_PATH = getcwd ();
		register_shutdown_function ( array (&$vsStd, 'my_deconstructor' ) );
	}
	
	$vsModule->getModuleByClass ( strtolower ( $bw->input ['module'] ) );
	
	if (APPLICATION_TYPE == "admin") {
		
		if (! $vsModule->result ['status'] || ! $vsModule->basicObject->getAdmin ()){
			$vsModule->basicObject->setClass ( $bw->vars ['admin_frontpage'] );
			$bw->input['module']=$bw->input[0]=$bw->vars ['admin_frontpage'];
		}
	// Check the admin session
		VSFactory::getAdmins()->authorizeAdmin ();
		
		
		$thread = "admin";
	} else {
		if (! $vsModule->result ['status'] || ! $vsModule->basicObject->getUser ()){
			$vsModule->getModuleByClass ( $bw->vars ['public_frontpage'] );
		}
		$thread = "public";
		
	}
	
		// Update language for new display
	//$vsLang->setCurrentArea ($vsModule->basicObject->getClass ()  );
	$runmeFilePath = $vsModule->basicObject->getClass () . "/" . $vsModule->basicObject->getClass () . "_" . $thread . ".php";
	
	if (file_exists ( EXTEND_PATH . $runmeFilePath )){
		$runmeFilePath = EXTEND_PATH . $runmeFilePath;
	}elseif (file_exists ( CORE_PATH . $runmeFilePath )){
		$runmeFilePath = CORE_PATH . $runmeFilePath;
	}elseif ($vsModule->basicObject->getVirtual ()) {
		$vsModule->basicObject->setClass ( $vsModule->basicObject->getVirtual () );
		$runmeFilePath = CORE_PATH . $vsModule->basicObject->getVirtual () . "/" . $vsModule->basicObject->getVirtual () . "_" . $thread . ".php";
		
		if (! file_exists ( $runmeFilePath )) {
			
					 $modu = $vsModule->basicObject->getParent()?$vsModule->basicObject->getParent():'pages';
                    $vsModule->basicObject->setClass($modu);
                    $runmeFilePath = CORE_PATH.$vsModule->basicObject->getClass() . "/" . $vsModule->basicObject->getClass() . "_".$thread.".php";
		if (! file_exists ( $runmeFilePath )) {
			
					 $modu = $vsModule->basicObject->getParent()?$vsModule->basicObject->getParent():'pages';
                    $vsModule->basicObject->setClass($modu);
                    $runmeFilePath = CORE_PATH.$vsModule->basicObject->getClass() . "/" . $vsModule->basicObject->getClass() . "_".$thread.".php";
                    if(!file_exists($runmeFilePath)) {echo "no parent ".  $modu." in framwork " ;  exit();}      
                    
		}
		}
	} else
		throw new Exception ( sprintf ( VSFactory::getLangs()->getWords ( 'global_file_not_exist', 'The file <b>%s</b> does not exist!' ), $runmeFilePath ) );
		$vsStd->requireFile ( $runmeFilePath );
		
	$runme_class = $vsModule->basicObject->getClass () . "_" . $thread;
	
	if (! class_exists ( $runme_class ))
		throw new Exception ( sprintf ( "The class <b>%s</b> does not exist in the file <b>%s</b>!", $runme_class, $runmeFilePath ) );
	$runme = new $runme_class ();
	// Check permission before running
	
	$vsUser->result ['status'] = true;
	
	$vsPrint->mainTitle = VSFactory::getLangs()->getWords ( 'main_title', mb_strtoupper ( $vsModule->basicObject->getClass (), "UTF-8" ) );
	$vsPrint->pageTitle = VSFactory::getLangs()->getWords ( 'pageTitle', mb_strtoupper ( $vsModule->basicObject->getClass (), "UTF-8" ) );
	
	$vsStd->requireFile ( $vsSkin->basicObject->getFolder () . "/GlobalLoad.php" );
	if ($vsUser->result ['status']){
		$runme->auto_run ();
	}else {
		$runme->setOutput ( $vsTemplate->getGlobal()->PermissionDenied ( $vsUser->result ['message'] ) );
	}
} catch ( Exception $e ) {
	//===========================================================================
	// Load default css/javascript
	//===========================================================================
	if (is_object ( $vsPrint )) {
		require_once ($vsSkin->basicObject->getFolder () . "/GlobalLoad.php");
		
		require_once (LIBS_PATH . "ErrorHandler.class.php");
		$runme = new ErrorHander ();
		$currentErrorHTML = $vsTemplate->getGlobal()->displayFatalError ( $e->getMessage (), $e->getLine (), $e->getFile (), $e->getTraceAsString () );
		$runme->setOutput ( $currentErrorHTML );
	} else {
		$message = "<div >
			Error: {$e->getMessage()}<br />
			Line: {$e->getLine()}<br />
			File: {$e->getFile()}<br />
			Trace: <pre>{$e->getTraceAsString()}</pre><br />
			</div>";
		if ($bw->input ['json']) {
			print "{error: '" . $message . "'}";
		} else {
			echo $message;
		}
		
		exit ();
	}
}

if (isset ( $bw->input ['ajax'] ) && $bw->input ['debug'] != 1) {
	print $runme->getOutput ();
	//if (! $bw->show_callback&&!$bw->input ['json'])
		///print $vsTemplate->getGlobal()->importantAjaxCallBack ();
	$vsPrint->lastestProject ();
	
	$vsPrint->_finish();
}
if (isset ( $bw->input ['iframe'] ) && $bw->input ['debug'] != 1) {
	$vsPrint->addOutput ( $runme->getOutput () );
$vsPrint->doOutputContent ();
$vsPrint->_finish();
}

$vsPrint->addOutput ( $runme->getOutput () );
$vsPrint->doOutput ();///hàm này gần 100ms
function fatal_error($message = "", $help = "") {
	global $vsPrint;
	echo ("$message<br><br>$help");
	$vsPrint->_finish();
	exit ();
}
?>