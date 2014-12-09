<?php
/**
 * Enter description here ...
 * @author tuyen
 *
 */
class VSFLanguage {

	function __construct() {
		global $vsStd;
		
		$flaglang = 0;
		// $vsLang = VSFactory::getLangs();
		$urls = explode ( '/', $_REQUEST ['vs'] );
		require_once CORE_PATH . 'languages/languages.php';
		$languages = new languages ();
		
		$languages->arrayLang = $languages->getObjectsByCondition ();
		
		if (APPLICATION_TYPE == 'user') {
			if (strlen ( $urls [0] ) > 0 && strlen ( $urls [0] ) < 3) {
				foreach ( $languages->arrayLang as $value )
					if ($value->getCode () == $urls [0]) {
						$this->currentLang = $value;
						$flaglang = 1;
						break;
					}
			}
			if ($flaglang == 0) {
				foreach ( $languages->arrayLang as $value )
					if ($value->getUserDefault () == 1) {
						$this->currentLang = $value;
						break;
					}
				if (! $this->currentLang) {
					$this->currentLang = current ( $languages->arrayLang );
				}
			}
			
			if (! is_array ( $_SESSION [APPLICATION_TYPE] )) {
				$_SESSION [APPLICATION_TYPE] = array ();
			}
			$_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] = $this->currentLang->convertToDB ();
		}
		
		if ($_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang']) {
			$this->currentLang = new Lang1 ();
			$this->currentLang->convertToObject ( $_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] );
		} else {
			$languages = new languages ();
			
			$languages->setCondition ( "userDefault=1" );
			
			$this->currentLang = $languages->getOneObjectsByCondition ();
			$_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] = $this->currentLang->convertToDB ();
		}
	}
	public $currentKeys = null;
	public $type = null;
	public $module = null;
	public $area = null;

	function getType() {
		if (! $this->type) {
			$this->type = APPLICATION_TYPE;
		}
		return $this->type;
	}

	function setType($type) {
		$this->type = $type;
	}

	function getModule() {
		return $this->module;
	}

	function setModule($module) {
		$this->module = $module;
	}

	function getArea() {
		if (! $this->area) {
			if (APPLICATION_TYPE == 'admin') {
				$languages = new languages ();
				// if(APPLICATION_TYPE=='user')
				$languages->setCondition ( "adminDefault='1'" );
				$obj = $languages->getOneObjectsByCondition ();
				if (is_object ( $obj ))
					$this->area = $obj->getCode ();
				else
					$this->area = $this->currentLang->getCode ();
			} else {
				$this->area = $this->currentLang->getCode ();
			}
		}
		return $this->area;
	}

	function setArea($area) {
		$this->area = $area;
	}

	function getWords($key = '', $value = '') {
		global $vsModule, $vsUser, $bw;
		
		$vs_nohtml = str_replace ( '.html', '', $_GET ['vs'] );
		$clean_url = explode ( "/", trim ( $vs_nohtml, "/" ) );
		
		$module = $clean_url [0] ? $clean_url [0] : "global";
		/*if($_REQUEST['test']){
			print_r($this->currentKeys);exit;
		}*/
		
		
		$fileName = explode ( "_", $key );
		if ($fileName [0] == 'global' || in_array($module, array('cn', 'en'))) $module = "global";
		
		if (! $this->currentKeys [$module]) {
			if(!file_exists ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/". $this->getArea ()  )){
				mkdir(CACHE_PATH . "langs/" . APPLICATION_TYPE . "/".$this->getArea (),true);
				chmod(CACHE_PATH . "langs/" . APPLICATION_TYPE . "/".$this->getArea (),0777);
			}
			if (file_exists ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea () . "/{$module}.php" )) {
				
				$this->loadCache ( $module );
			}
		}
		
		
		// $this->fwrite();
		if (isset ( $this->currentKeys [$module] [$key] ))
			return $this->currentKeys [$module] [$key];
		$this->change  =true;
		if (($string = $this->getWordFromDB ( $key )) === NULL) {
			
			$this->insertWords ( $key, $value,$module );
			return $this->currentKeys [$module] [$key] = $value;
		} else {
			return $this->currentKeys [$module] [$key] = $string;
		}
		
		
		return $value;
	}

	function loadCache($module) {
		if (file_exists ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea () . "/{$module}.php" )) {
			$langs = array ();
			require CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea () . "/{$module}.php";
			$this->currentKeys [$module] = $langs;
		}
	}

	function getWordFromDB($key) {
		global $bw;
		$DB = VSFactory::createConnectionDB ();
		
		$DB->query ( "
				select `key`,{$this->getArea()} as `value`
				from vsf_lang
				where `key`='{$key}'
		
		" );
		while ( $row = $DB->fetch_row () ) {
			return $row ['value'];
		}
		// $exp = var_export($this->currentKeys,true);
		// echo"$exp";exit();
		return NULL;
	}

	function exportToCache() {
		global $bw;
		foreach ( $this->currentKeys as $module => $value ) {
			$exp = var_export ( $value, true );
			// echo CACHE_PATH."langs/".APPLICATION_TYPE."/".$this->getArea();exit;
			if (! is_dir ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea () )) {
				mkdir ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea (), 0600, true );
			}
			$fp = fopen ( CACHE_PATH . "langs/" . APPLICATION_TYPE . "/" . $this->getArea () . "/{$module}.php", 'w' );
			fwrite ( $fp, '<?php $langs=' . $exp . '?>' );
			fclose ( $fp );
		}
	}

	function clearCache() {
		global $bw;
		$this->deleteDir ( CACHE_PATH . "langs/" );
	}

	private static function deleteDir($dirPath) {
		if (! is_dir ( $dirPath )) {
			return;
		}
		if (substr ( $dirPath, strlen ( $dirPath ) - 1, 1 ) != '/') {
			$dirPath .= '/';
		}
		$files = glob ( $dirPath . '*', GLOB_MARK );
		foreach ( $files as $file ) {
			if (is_dir ( $file )) {
				self::deleteDir ( $file );
			} else {
				unlink ( $file );
			}
		}
		rmdir ( $dirPath );
	}

	function insertWords($key, &$value = '',$module='') {
		if (! $value) {
			$value = ucwords ( strtolower ( str_replace ( array ('-', '_' ), ' ', $key ) ) );
		}
		
		$DB = VSFactory::createConnectionDB ();
		$value = mysql_real_escape_string ( $value );
		$key = mysql_real_escape_string ( $key );
		$DB->query ( "
			INSERT INTO `vsf_lang` 
				(`id`, `key`, `{$this->getArea()}`, `type`,`module`) 
			VALUES 
				(NULL, '$key', '{$value}',  '{$this->getType()}','{$module}');
		" );
	}

	function __destruct() {
	}
}
?>