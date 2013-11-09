<?php
require_once(CORE_PATH."skins/skins.php");
class VSFSkin extends skins {
	public $wrapper = "";
	public $imageDir = "";
	public $cssDir = "";
	function __construct() {
		parent::__construct ();
		$this->getDefaultSkin ();
		$this->imageDir = $this->obj->getFolder () . "/images";
		$this->cssDir = $this->obj->getFolder () . "/css";
		$this->javaDir = $this->obj->getFolder () . "/javascripts/";
	}

	function __destruct() {
	}
	function show() {
		echo $this->wrapper;
	}
	function loadWrapper() {
		global $bw, $vsLang;
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">
			<head>
			<title>{$this->TITLE}</title>
			<meta http-equiv="Content-Language" content="vi" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<META name="Language" content="Vietnamese">
			<META NAME="author" CONTENT="Viet Solution">
			<META NAME="copyright" CONTENT="CRPAOA 2006">
			<META NAME="robots" CONTENT="FOLLOW,INDEX">
			<link rel="shortcut icon" href="{$this->SHORTCUT}" type="image/x-icon" />
			
			{$this->GENERATOR}
			{$this->CSS}
			{$this->JAVASCRIPT_TOP}
			</head>
			<body>
			{$this->BOARD}

			</body> 
			

			</html>
			{$this->JAVASCRIPT_BOTTOM }
EOF;
			return $this->wrapper = $BWHTML;
	}
}
?>