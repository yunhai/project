<?php
class skins_board {

	/**
	 *
	 * @return VSFLanguage
	 */
	function getLang() {
		return VSFactory::getLangs ();
	}

	/**
	 *
	 * @return settings
	 */
	function getSettings() {
		return VSFactory::getSettings ();
	}
	public $DS = "\\";

	function cut($string, $limit) {
		return VSFactory::getTextCode ()->cutString ( strip_tags ( $string ), $limit );
	}

	function dateTimeFormat($int, $format = "d/m/Y") {
		
		$int = $int?$int:time();
		
		return VSFactory::getDateTime ()->getDate ( $int, $format );
	}

	function numberFormat($number, $dec = 0) {
		return @number_format ( $number, $dec, ',', '.' );
	}

	function numberFormatPro($number, $dec = 0) {
		if (! $number)
			return "Call " . $this->getLang ()->getWords ( 'global_phone', '0903-567-789' );
		return @number_format ( $number, $dec ) . " " . $this->getLang ()->getWords ( 'unit', 'VN�' );
	}

	/**
	 *
	 * @return admins
	 */
	function getAdmin() {
		return VSFactory::getAdmins ();
		;
	}

	function urlEncode($str) {
		return urlencode ( $str );
	}

	function htmlspecialchars($str) {
		return htmlspecialchars ( $str );
	}

	/**
	 *
	 * @return users
	 */
	function getUser() {
		return VSFactory::getUsers ();
		;
	}

	function createEditor($content, $name, $width, $height, $toolbar = 'simple', $theme = 'advanced') {
		global $vsPrint, $vsStd;
		
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		$editor->setWidth ( $width );
		$editor->setHeight ( $height );
		$editor->setToolbar ( $toolbar );
		$editor->setTheme ( $theme );
		$editor->setInstanceName ( $name );
		$editor->setValue ( $content );
		
		return $editor->createHtml ();
	}

	static function titleSorter($a, $b) {
		if (is_object ( $a ) && is_object ( $b ))
			if ($a->getTitle () > $b->getTitle ())
				return 1;
		return 0;
	}
	
	function getSelectOption($obj,$selected=0,$method="getTitle"){
	
		if(!$obj) return;
	
		$html = "";
		foreach ($obj as $key => $value){
			$select = "";
			if($selected==$key) $select = "selected";
			$html .= "<option value='$key' $select>{$value->$method()}</option>";
		}
		return $html;
	
	}
	function get($var){
		return $var;
	}
	
}

?>