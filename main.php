<?php  
// Handle all error of application
try {
  
	// Initialize configuration
	$INFO = array ();
	require ROOT_PATH . "conf_global.php";
	// Starting debug
	$Debug = new Debug ( );
	$Debug->startTimer ();
	// Setting database driver
	$INFO ['sql_driver'] = ! $INFO ['sql_driver'] ? 'mysql' : strtolower ( $INFO ['sql_driver'] );
	// Getting database driver
	require (UTILS_PATH . 'class_db_' . $INFO ['sql_driver'] . ".php");
	$DB = new db_driver ( );
	// Configure DB Object
	$DB->obj ['sql_database'] = $INFO ['sql_database'];
	$DB->obj ['sql_user'] = $INFO ['sql_user'];
	$DB->obj ['sql_pass'] = $INFO ['sql_pass'];
	$DB->obj ['sql_host'] = $INFO ['sql_host'];
	$DB->obj ['sql_tbl_prefix'] = $INFO ['sql_tbl_prefix'];
	$DB->obj ['use_shutdown'] = USE_SHUTDOWN;
	//--------------------------------
	// on/off secutity  
	//--------------------------------
	$DB->require = 0;
	$DB->return_die = 0;
	 
	//--------------------------------
	// Get a DB connection
	//--------------------------------
      
	$DB->connect ();
        
	session_start();	
	//--------------------------------
	// Make CONSTANT
	//--------------------------------
    
	define ( 'SQL_PREFIX', $DB->obj ['sql_tbl_prefix'] );
	define ( 'SQL_DRIVER', $INFO ['sql_driver'] );
        
	$bw = new infos ( );
	// Getting core library
       
	require_once LIBS_PATH . "Component.class.php";
	require_once LIBS_PATH . "Functions.class.php";
	require_once LIBS_PATH . "Session.class.php";
	$vsStd 	= new VSFFunction ();
	
	require_once LIBS_PATH . "Language.class.php";
	$vsLang = new VSFLanguage();
	require_once LIBS_PATH . "Object.class.php";
	require_once LIBS_PATH . "boards/BasicObject.board.php";
	require_once LIBS_PATH . "Skin.class.php";
	require_once UTILS_PATH . "TemplateEngine.class.php";
	require_once LIBS_PATH . "Relationships.php";
	
//	$vsStd->AuthorizeInstall(false,true);
	require_once LIBS_PATH . "Display.class.php";
	
	require_once LIBS_PATH . "Path.class.php";
	require_once( UTILS_PATH . "PostParser.class.php" );
	require_once LIBS_PATH . "DateTime.class.php";
	
	require_once(UTILS_PATH."TextCode.class.php");
	require_once(CORE_PATH."files/files.php");
	require_once LIBS_PATH . "Counter.class.php";
	$vsCounter = new VSSCounter();
	  
	if(APPLICATION_TYPE=="admin"){
        $vsStd->requireFile(LIBS_PATH."boards/Object.admin.php");
		$vsStd->requireFile(CORE_PATH."admins/admins.php");
		$vsUser = new admins();
	}
	else{
   		$vsStd->requireFile(LIBS_PATH."boards/Object.public.php");
		$vsStd->requireFile(CORE_PATH."users/users.php");
		$vsUser = new users();
	}

	// Starting session
	$vsSess = new VSFSession();
	$vsStd->requireFile(CORE_PATH . "modules/modules.php");
	$vsModule = new modules();
	$vsRelation = new VSFRelationship();
	//---------------------------------------
	// Initialize user language default value
	//---------------------------------------
	$vsPrint = new VSFDisplay ();
	$vsFile=new files();
	$bw->input = $vsStd->parse_incoming ();
	
	 
	if($bw->input['vs']=="admin")
		$vsPrint->boink_it($bw->vars['board_url']."/admin.php");
	//===========================================================================
	// Get system menu
	//===========================================================================
	require_once (CORE_PATH . "menus/menus.php");
	$vsMenu = new menus();
	
	
	$vsStd->requireFile(CORE_PATH.'settings/settings.php');
	$vsSettings = new settings();
	
	$vsCom = new VSFComponent();

	
	$vsSkin = new VSFSkin();
	
	$vsTemplate = new VSFTemplate($vsSkin->obj->getFolder(),1);
	
	$vsPath = new VSFPath();
	
	global $search_module;
 	if($vsSettings->getSystemKey('searchs_function', 1, 'global'))
		$search_module = array("products", "news", "abouts", "recruitments", "services");
		
	$vsStd->requireFile(CORE_PATH.'languages/languages.php');
	$languages = new languages();
	$DB->obj ['debug'] = ($bw->vars ['sql_debug'] == 1) ? $_GET ['debug'] : 0;
	
	$vsPath->setupBaseUrl();
		
	$bw->vars ['img_url'] = $bw->vars ['board_url']."/".$vsSkin->obj->getFolder()."/images";
	$bw->vars ['cur_scripts'] = $bw->vars ['board_url']."/".$vsSkin->obj->getFolder()."/javascripts";
	//--------------------------------
	//  Upload dir?
	//--------------------------------
	$bw->vars ['upload_dir'] = (isset($bw->vars ['upload_dir']) && $bw->vars ['upload_dir']) ? $bw->vars ['upload_dir'] : ROOT_PATH . 'uploads';
	$bw->vars ['upload_url'] = (isset($bw->vars ['upload_url']) && $bw->vars['upload_url']) ? $bw->vars ['upload_url'] : $bw->vars['board_url'].'/uploads';
       
	
	if (USE_SHUTDOWN and $bw->input ['act'] != 'task') {
		chdir(ROOT_PATH);
		$ROOT_PATH = getcwd();
		register_shutdown_function(array(&$vsStd,'my_deconstructor'));
	}

	$vsModule->getModuleByClass(strtolower($bw->input['module']));

	if(APPLICATION_TYPE=="admin") {
		if(!$vsModule->result['status']||!$vsModule->obj->getAdmin()){
			$vsModule->obj->setClass($bw->vars['admin_frontpage']);
                        $bw->input[0] = $bw->input['module']=$bw->vars['admin_frontpage'];
                }
		$vsUser->authorizeAdmin();
		$thread = "admin";
	}
	else {
		if(!$vsModule->result['status']||!$vsModule->obj->getUser()){
			$vsModule->obj->setClass($bw->vars['public_frontpage']);
			$bw->input[0] = $bw->input['module']=$bw->vars['public_frontpage'];
		}
		$thread = "public";
	}
	
	// Update language for new display
	$vsLang->setCurrentArea($vsModule->obj->getClass());
	$runmeFilePath = $vsModule->obj->getClass() . "/" . $vsModule->obj->getClass() . "_".$thread.".php";
	if(file_exists(EXTEND_PATH. $runmeFilePath))
		$runmeFilePath=EXTEND_PATH. $runmeFilePath;
	elseif(file_exists(CORE_PATH. $runmeFilePath))
		$runmeFilePath=CORE_PATH. $runmeFilePath;
	elseif($vsModule->obj->getVirtual())
	{
		$vsModule->obj->setClass($vsModule->obj->getVirtual());
		$runmeFilePath = CORE_PATH.$vsModule->obj->getVirtual() . "/" . $vsModule->obj->getVirtual() . "_".$thread.".php";
		
		if(!file_exists($runmeFilePath))                    
		{	
                    $modu = $vsModule->obj->getParent()?$vsModule->obj->getParent():'pages';
                    $vsModule->obj->setClass($modu);
                    $runmeFilePath = CORE_PATH.$vsModule->obj->getClass() . "/" . $vsModule->obj->getClass() . "_".$thread.".php";
                    if(!file_exists($runmeFilePath)) {echo "no parent ".  $modu." in framwork " ;  exit();}      
                   
                    if(APPLICATION_TYPE=="admin"){
                            $vsLang->setCurrentArea($modu);
                    }
                          
		}
	}
	else throw new Exception(sprintf($vsLang->getWords('global_file_not_exist', 'The file <b>%s</b> does not exist!'),$runmeFilePath));
	$vsStd->requireFile($runmeFilePath);
	
	$runme_class = $vsModule->obj->getClass()."_".$thread;
    
	if(!class_exists($runme_class)) throw new Exception(sprintf($vsLang->getWords('global_class_not_exist', 'The class <b>%s</b> does not exist in the file <b>%s</b>!'),$runme_class,$runmeFilePath));
	$runme = new $runme_class();
       
	// Check permission before running
	$vsUser->result['status'] = true;

	$vsPrint->mainTitle = $vsLang->getWords('main_title',mb_strtoupper($vsModule->obj->getClass(),"UTF-8"));
	$vsPrint->pageTitle = $vsLang->getWords('pageTitle',mb_strtoupper($vsModule->obj->getClass(),"UTF-8"));
	
	
	$vsStd->requireFile(LIBS_PATH . 'Addon.class.php');
	$addon = new Addon();
	
	$vsStd->requireFile($vsSkin->obj->getFolder()."/GlobalLoad.php");

	if($vsUser->result['status']) {
		$runme->auto_run();
	}else {
		$runme->setOutput($vsTemplate->global_template->PermissionDenied($vsUser->result['message']));
	}
}
catch (Exception $e) {
	//===========================================================================
	// Load default css/javascript
	//===========================================================================
	if(is_object($vsPrint)) {
		require_once($vsSkin->obj->getFolder()."/GlobalLoad.php");
		
		require_once(LIBS_PATH."ErrorHandler.class.php");
		$runme = new ErrorHander();
		$currentErrorHTML = $vsTemplate->global_template->displayFatalError($e->getMessage(), $e->getLine(), $e->getFile(), $e->getTraceAsString());
		$runme->setOutput($currentErrorHTML); 
	}
	else {
		$message= "<div >
			Error: {$e->getMessage()}<br />
			Line: {$e->getLine()}<br />
			File: {$e->getFile()}<br />
			Trace: <pre>{$e->getTraceAsString()}</pre><br />
			</div>";
		if($bw->input['json']){
			print "{error: '" . $message . "'}";
		}else{
			echo $message;
		}
			
		exit();
	}
}

if(isset($bw->input['ajax']) && $bw->input['debug']!=1) {
	print $runme->getOutput();
	$vsPrint->lastestProject();
	exit();
}

	
$vsPrint->addOutput($runme->getOutput());

$vsPrint->doOutput();
function fatal_error($message = "", $help = "") {
	echo ("$message<br><br>$help");
	exit ();
}
?>