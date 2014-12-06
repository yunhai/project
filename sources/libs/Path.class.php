<?php
class VSFPath {
	private $paramIndex = 0;
	private $alias = array ();
	private $realurl = array ();
	private $seo = array ();

	function __construct() {
		global $bw;
		static $i = 0;
		$i ++;
		$flaglang = 0;
		$vsLang = VSFactory::getLangs ();
		if (! $vsLang->currentLang || $i == 1) {
			$urls = explode ( '/', $bw->input ['vs'] );
			require_once CORE_PATH . 'languages/languages.php';
			$languages = new languages ();
			$languages->arrayLang = $languages->getObjectsByCondition ();
			
			if (APPLICATION_TYPE == 'user') {
				if (strlen ( $urls [0] ) > 0 && strlen ( $urls [0] ) < 3) {
					foreach ( $languages->arrayLang as $value )
						if ($value->getCode () == $urls [0]) {
							$vsLang->currentLang = $value;
							$flaglang = 1;
							break;
						}
				}
				
				if ($flaglang == 0) {
					foreach ( $languages->arrayLang as $value )
						if ($value->getUserDefault () == 1) {
							$vsLang->currentLang = $value;
							break;
						}
					if (! $vsLang->currentLang) {
						$vsLang->currentLang = current ( $languages->arrayLang );
					}
				}
				// $this->currentLang->convertToObject($_SESSION[APPLICATION_TYPE]['language']['vsfcurrentLang']);
				$_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] = $vsLang->currentLang->convertToDB ();
				// $vsLang->loadWords();
			}
			if (APPLICATION_TYPE != 'install')
				if (! $vsLang->currentLang->getUserDefault () && APPLICATION_TYPE == 'user') {
					$bw->input ['vs'] = rtrim ( $bw->input ['vs'], "/" ) . "/";
					$bw->input ['vs'] = str_replace ( $vsLang->currentLang->getCode () . "/", '', $bw->input ['vs'] );
				}
		}
		
		$this->initPath ();
		$vs_nohtml = str_replace ( '.html', '', $bw->input ['vs'] );
		$clean_url = explode ( "/", trim ( $vs_nohtml, "/" ) );
		
		$bw->input = array_merge ( $clean_url, $bw->input );
		
		$bw->input ['module'] = $bw->input [0];
		$bw->input ['action'] = $bw->input [1];
		
		$this->setupBaseUrl ();
	}

	function initPath() {
		global $bw;
		if (! $bw->input ['vs'] || ! isset ( $bw->input ['vs'] )) {
			
			switch (APPLICATION_TYPE) {
				
				case 'admin' :
					$bw->input ['vs'] = $bw->vars ['admin_frontpage'];
					break;
				
				case 'user' :
					$bw->input ['vs'] = $bw->vars ['public_frontpage'];
					break;
			}
		}
	}

	function setupBaseUrl() {
		global $bw;
		
		$vsLang = VSFactory::getLangs ();
		if (APPLICATION_TYPE == 'admin')
			$bw->base_url = $bw->vars ['board_url'] . '/admin.' . $bw->vars ['php_ext'] . '?vs=';
		else {
			if ($bw->vars ['public_cleanurl']) {
				$bw->base_url = $bw->vars ['board_url'] . '/';
				if (! $vsLang->currentLang->getUserDefault ())
					$bw->base_url = $bw->vars ['board_url'] . '/' . $vsLang->currentLang->getCode () . '/';
			} else {
				$language = $vsLang->currentLang->getCode () . "/";
				$bw->base_url = $bw->vars ['board_url'] . '/' . 'index.' . $bw->vars ['php_ext'] . '?vs=';
				if (! $vsLang->currentLang->getUserDefault ())
					$bw->base_url = $bw->vars ['board_url'] . '/' . 'index.' . $bw->vars ['php_ext'] . '?vs=' . $vsLang->currentLang->getCode () . '/';
			}
			if (APPLICATION_TYPE == 'install')
				$bw->base_url = $bw->vars ['board_url'] . '/installer/index.' . $bw->vars ['php_ext'] . '?vs=';
		}
	}
}
?>