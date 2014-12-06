<?php

class VSFactory {
/**
	 * return a global menus object if reset = true return a new menus
	 * @author tuyenbui@vietsol.net
	 * @return cache
	 */
	static function getCacheVar() {
		static $cache=NULL;
		if ($cache===NULL) {
			require_once (LIBS_PATH . "cache.php");
			$cache = new cache ();
		}
		return $cache;
	}
	/**
	 * @return COM_SEO
	 * @author tuyenbui
	 */
	static function getSeo() {
		static $seo=NULL;
		if ($seo===NULL) {
			global $vsStd;
			require_once COM_PATH . 'SEO/SEO.php';
			$seo = new COM_SEO ();
		}
		return $seo;
	}
	/**
	 * @return VSFDateTime
	 * @author tuyenbui
	 */
	static function getDateTime() {
		static $dateTime;
		if (! $dateTime) {
			require_once LIBS_PATH . "DateTime.class.php";
			$dateTime = new VSFDateTime ();
		}
		return $dateTime;
	}
	/**
	 * @author tuyenbui@vietsol.net
	 * @return browserinfo
	 */
	static function getBrowserInfo() {
		static $obj;
		if (! $obj) {
			require_once LIBS_PATH . "Browserinfo.class.php";
			$obj = new browserinfo ();
		}
		return $obj;
	}
	/**
	 * @author tuyenbui@vietsol.net
	 * @return cookies
	 */
	static function getCookies() {
		static $obj = null;
		if (! $obj) {
			require_once LIBS_PATH . "Cookies.class.php";
			$obj = new cookies ();
		}
		return $obj;
	}
	/**
	 * return a global VSFRelationship object
	 * @author tuyenbui@vietsol.net
	 * @return VSFRelationship
	 */
	static function getRelation() {
		static $obj = null;
		if (! $obj) {
			require_once LIBS_PATH . "Relationships.php";
			$obj = new VSFRelationship ();
		}
		return $obj;
	}
	/**
	 * return a global user object
	 * @author tuyenbui@vietsol.net
	 * @return users
	 */
	static function getUsers($reset = false) {
		static $obj=NULL;
		if ($obj===NULL || $reset) {
			require_once CORE_PATH . "users/users.php";
			$obj = new users ();
		}
		return $obj;
	}
	/**
	 * return a global emailer object if reset = true return a new emailer
	 * @author tuyenbui@vietsol.net
	 * @return Emailer
	 */
	static public function getEmailer($reset = false) {
		static $obj;
		if (! $obj || $reset) {
			global $vsStd;
			require_once LIBS_PATH . "Email.class.php";
			$obj = new Emailer ( array ('html' => 1, 'charset' => 'utf-8', 'method' => 'smtp', 'smtp_host' => 'localhost', 'smtp_port' => 25, 'smtp_helo' => 'EHLO', 'wrap_brackets' => false ) );
		}
		return $obj;
	}
	/**
	 * return a global emailer object if reset = true return a new emailer
	 * @author tuyenbui@vietsol.net
	 * @return permissions
	 */
	static public function getPermission($reset = false) {
		static $obj;
		if (! $obj || $reset) {
			global $vsStd;
			require_once CORE_PATH . "admins/admins_perm.php";
			$obj = new admins_perm ();
		}
		return $obj;
	}
	
	static function log($content = "") {
		global $vsUser, $vsf;
		$fp = fopen ( CACHE_PATH . ".log", 'a+' );
		fwrite ( $fp, $vsf->getDateTime ()->getDate ( time (), "LONG" ) . ":" . $vsUser->obj->getName () . ":" . $content . "\n" );
		fclose ( $fp );
	}
	/**
	 * return a global emailer object if reset = true return a new emailer
	 * @author tuyenbui@vietsol.net
	 * @return caches
	 */
	static function getCache() {
		static $obj;
		if (! $obj) {
			require_once CORE_PATH . "caches/caches.php";
			$obj = new caches ();
		}
		return $obj;
	}
	/**
	 * return a global emailer object if reset = true return a new emailer
	 * @author tuyenbui@vietsol.net
	 * @return cachelinks
	 */
	static function getCacheLink() {
		static $obj;
		if (! $obj) {
			require_once CORE_PATH . "caches/caches.php";
			$obj = new cachelinks ();
		}
		return $obj;
	}
	/**
	 * return a global emailer object if reset = true return a new emailer
	 * @author tuyenbui@vietsol.net
	 * @return admins
	 */
	static function getAdmins() {
		static $obj=NULL;
		if ($obj===NULL) {
			
			require_once CORE_PATH . "admins/admins.php";
			$obj = new admins ();
			$obj->basicObject->convertToObject ( $_SESSION ['admin'] ['obj'] );
			if (is_array ( $_SESSION ['admin'] ['vsgroups'] ))
				foreach ( $_SESSION ['admin'] ['vsgroups'] as $groupId ) {
					$obj->basicObject->addGroup ( $obj->admingroups->getGroupById ( $groupId ) );
				}
				
//			VSFactory::getPermission ()->loadModulePerssionUser ( $obj->obj );
		}
		return $obj;
	}
	/**
	 * return a global database object if reset = true return a new database
	 * @author quangvu@vietsol.net
	 * @return db_driver
	 */
	static function createConnectionDB($db_id = 0, $reset = false) {
		global $INFO;
		static $db_array = array ();
		if (!isset($db_array [$db_id]) || $reset) {
			$INFO ['sql_driver'] [$db_id] = ! $INFO ['sql_driver'] [$db_id] ? 'mysql' : strtolower ( $INFO ['sql_driver'] [$db_id] );
			// Getting database driver
			require_once (UTILS_PATH . 'class_db_' . $INFO ['sql_driver'] [$db_id] . ".php");
			$db_array [$db_id] = new db_driver ();
			// Configure DB Object
			
			$db_array [$db_id]->obj ['sql_database'] = $INFO ['sql_database_'.$db_id] ;
			$db_array [$db_id]->obj ['sql_user'] = $INFO ['sql_user_'.$db_id];
			$db_array [$db_id]->obj ['sql_pass'] = $INFO ['sql_pass_'.$db_id] ;
			$db_array [$db_id]->obj ['sql_host'] = $INFO ['sql_host_'.$db_id] ;
			$db_array [$db_id]->obj ['sql_tbl_prefix'] = $INFO ['sql_tbl_prefix'.$db_id] ;
			$db_array [$db_id]->obj ['use_shutdown'] = USE_SHUTDOWN;
			//--------------------------------
			// on/off secutity  
			//--------------------------------
			$db_array [$db_id]->require = 0;
			$db_array [$db_id]->return_die = 0;
			//--------------------------------
			// Get a DB connection
			//--------------------------------
			$db_array [$db_id]->connect ();
		}
		
//		define ( 'SQL_PREFIX', $db_array [$db_id]->obj ['sql_tbl_prefix'] );
//		define ( 'SQL_DRIVER', $INFO ['sql_driver_0'] );
		
		return $db_array [$db_id];
	}
	/**
	 * return a global menus object if reset = true return a new menus
	 * @author quangvu@vietsol.net
	 * @return menus
	 */
	static function getMenus() {
		static $vsMenu=NULL;
		if ($vsMenu ===NULL) {
			require_once (CORE_PATH . "menus/menus.php");
			$vsMenu = new menus ();
		}
		return $vsMenu;
	}
	
	/**
	 * return a global langs object if reset = true return a new langs
	 * @author quangvu@vietsol.net
	 * @return VSFLanguage
	 */
	static function getLangs() {
		static $vsLang=NULL;
		if ($vsLang ===NULL) {
			require_once LIBS_PATH . "Language.class.php";
			$vsLang = new VSFLanguage ();
		}
		return $vsLang;
	}
	
	/**
	 * return a global files object if reset = true return a new files
	 * @author quangvu@vietsol.net
	 * @return files
	 */
	static function getFiles($reset = false) {
		static $vsFile;
		if (! $vsFile || $reset) {
			require_once (CORE_PATH . "files/files.php");
			$vsFile = new files ();
		}
		return $vsFile;
	}
	
	/**
	 * return a global modules object if reset = true return a new modules
	 * @author quangvu@vietsol.net
	 * @return modules
	 */
	static function getModules($reset = false) {
		static $vsModule;
		if (! $vsModule || $reset) {
			require_once (CORE_PATH . "modules/modules.php");
			$vsModule = new modules ();
		}
		return $vsModule;
	}
	
	/**
	 * return a global settings object if reset = true return a new settings
	 * @author quangvu@vietsol.net
	 * @return settings
	 */
	static function getSettings() {
		static $vsSettings=NULL;
		if ($vsSettings ===NULL) {
			require_once (CORE_PATH . 'settings/settings.php');
			$vsSettings = new settings ();
		}
		return $vsSettings;
	}
	/**
	 * @author quangvu@vietsol.net
	 * @return VSFTextCode
	 */
	static function getTextCode(){
		require_once (UTILS_PATH . "TextCode.class.php");
		static $textcode;
		if($textcode===NULL){
			$textcode=new VSFTextCode();
		}
		return $textcode;
	}
/**
	 * @author quangvu@vietsol.net
	 * @return PostParser
	 */
	static function getPostParser(){
		static $postparser=NULL;
		if($postparser===NULL){
			require_once (UTILS_PATH . "PostParser.class.php");
			$postparser=new PostParser();
		}
		return $postparser;
	}
	
	static function getObjModule($root="pages",$module="",$status,$limit,$type){
		require_once CORE_PATH.$root."/".$root.'.php';
		
		$pages=new $root();
		$category=VSFactory::getMenus()->getCategoryGroup($module);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$pages->setCondition("status>{$status} and catId in ($ids)");
		$pages->setOrder("`index` DESC,id desc");
		if($limit)
		$pages->setLimit(array(0,$limit));
		if($type==1)
		return $pages->getOneObjectsByCondition();	
		if($type==2)
		return $pages->getObjectsByCondition();
	}
	static function getFacebook($reset = false) {
		
		global $bw;
		static $obj=NULL;
		if ($obj===NULL || $reset) {
			require_once (ROOT_PATH."plugins/facebook/facebook.php");
		
		 $obj = new Facebook(array(
			 'appId'  => '823003417709837',
			 'secret' =>'bae28669d0c2e4310052dc2c2821d11f',
		   ));
		}
		return $obj;
	}
	
}
?>