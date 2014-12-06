<?php
require_once(CORE_PATH."skins/Skin.class.php");
class skins extends VSFObject {
	public $obj			= NULL;
	private $cache_path	=	"./cache/cache_skins.php";
	function __construct() {
		global $vsModule;
		parent::__construct ();
	
		$this->primaryField = 'skinId';
		$this->tableName = 'skin';
		$this->basicClassName = 'Skin';
		$this->createBasicObject();
		$this->cache_path="./cache/cache_skins.php";
		//$vsModule->basicObject->getClass(); 
		if($vsModule->basicObject->getClass()=='skins'){
			$this->getObjectsByCondition();
		}else{
			$this->createSkinCache();
		}
		
			
	}

	function __destruct() {
	}

	function createSkinCache(){
		//VSFactory::getSettings()->getSystemKey('use_cache_skin_wrapper', 1, 'global', 0, 1);exit;
		if( file_exists($this->cache_path) && VSFactory::getSettings()->getSystemKey('use_cache_skin_wrapper', 1, 'global', 0, 1)){
			$arraySkin = array();
			require_once ($this->cache_path);
			return $this->arrayObj = $arraySkin;
		}
		$this->writeCache();
	}
	
	function writeCache() {
		$this->condition = 'skinDefault=1';
		$this->getObjectsByCondition("getIsAdmin");
		$cache_content  = "<?php\n";
		$cache_content .= "\$arraySkin = ".var_export($this->arrayObj,true).";\n";
		$cache_content .= "?>";
		//echo file_exists($this->cache_path);
		$file = fopen($this->cache_path, "w");
		fwrite($file, $cache_content);
		fclose($file);
	}
	function getDefaultSkin() {
		$this->basicObject=$this->arrayObj[0];
		if (APPLICATION_TYPE == 'admin') {
			$this->basicObject=$this->arrayObj[1];
		}
		$this->basicObject->setFolder (SKIN_PATH . $this->basicObject->getFolder ());
	}

	function updateSkin() {
		// If the new skin is set to default, set all others to not default
		if ($this->basicObject->getDefault ()) {
			$this->fields = array ('skinDefault' => 0 );
			$this->setCondition("skinIsAdmin={$this->basicObject->getIsAdmin()}");
			$this->updateObjectByCondition ();
		}
		$objObj = clone ($this->basicObject);
		$this->getObjectById ( $this->basicObject->getId () );
		// If the name of folder have been changed, change it name
		if ($objObj->getFolder () != $this->basicObject->getFolder ()) {
			$objRootPath = "skins/user";
			$objNewPath = $objRootPath . "/" . $objObj->getFolder ();
			$objOldPath = $objRootPath . "/" . $this->basicObject->getFolder ();
			rename ( $objOldPath, $objNewPath );
		}
		$this->updateObjectById ($objObj);
		$this->writeCache();
	}

	function insertSkin($inheritId = 0) {
		global $vsStd;
		// If the new skin is set to default, set all others to not default
		if ($this->basicObject->getDefault ()) {
			$this->fields = array ('skinDefault' => 0 );
			$this->setCondition("skinIsAdmin={$this->basicObject->getIsAdmin()}");
			$this->updateObjectByCondition ();
		}
		// Starting insert database
		$this->insertObject ();
		$this->writeCache();
	}
}
?>