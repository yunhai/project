<?php
require_once(CORE_PATH."skins/skins.php");
class VSFSkin extends skins {
	public $wrapper = "";
	public $imageDir = "";
	public $cssDir = "";
	function __construct() {
		parent::__construct ();
		$this->getDefaultSkin ();
		
		$this->imageDir = $this->basicObject->getFolder () . "/images";
		$this->cssDir = $this->basicObject->getFolder () . "/css";
		$this->javaDir = $this->basicObject->getFolder () . "/javascripts/";
		
	}

	function __destruct() {
	}
	function show() {
		if(APPLICATION_TYPE=='user'){
			require_once CORE_PATH.'adverts/adverts.php';
			$advert=new adverts();
			$request=ltrim($_SERVER['REQUEST_URI'],"/");
			$advert->url=$request;
			//'<advert code="global_banner" />'
	 		$this->wrapper=$advert->parseHtml($this->wrapper);
		}
		echo $this->wrapper;
	}
	function loadWrapper() {
		$BWHTML = "";
		$BWHTML .= <<<EOF
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
			<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi" lang="vi">
			<head>
			<title>{$this->TITLE}</title>
			<meta http-equiv="Content-Language" content="vi" />
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="Language" content="Vietnamese">
			<meta name="author" content="Viet Solution">
			<meta name="copyright" content="http://www.thegioitruyenhinh.vn 2011">
			<meta name="robots" content="FOLLOW,INDEX">
			<link href="https://plus.google.com/101560984096523656827" rel="publisher" />
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