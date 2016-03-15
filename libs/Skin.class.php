<?php
require_once CORE_PATH . "skins/skins.php";
class VSFSkin extends skins {
	public $wrapper = "";
	public $imageDir = "";
	public $cssDir = "";
	function __construct() {
		parent::__construct();
		$this->getDefaultSkin();
		$this->imageDir = $this->obj->getFolder() . "/images";
		$this->cssDir = $this->obj->getFolder() . "/css";
		$this->javaDir = $this->obj->getFolder() . "/javascripts/";
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
			<!-- Facebook Pixel Code -->
			<script>
			!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','//connect.facebook.net/en_US/fbevents.js');

			fbq('init', '1656754921241115');
			fbq('track', "PageView");</script>
			<noscript><img height="1" width="1" style="display:none"
			src="https://www.facebook.com/tr?id=1656754921241115&ev=PageView&noscript=1"
			/></noscript>
			<!-- End Facebook Pixel Code -->

			<title>{$this->TITLE}</title>
			<meta http-equiv="Content-Language" content="vi" />
			<meta name="viewport" content="width=device-width,initial-scale=1">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<META name="Language" content="Vietnamese">
			<META NAME="author" CONTENT="Nhien Solution">
			<META NAME="copyright" CONTENT="CRPAOA 2006">
			<META NAME="robots" CONTENT="FOLLOW,INDEX">
			<link rel="shortcut icon" href="{$this->SHORTCUT}" type="image/x-icon" />
			{$this->GENERATOR}
			{$this->CSS}
			{$this->JAVASCRIPT_TOP}
			</head>
			<body>
			{$this->BOARD}
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- http://hoatuoi360.vn/ -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-6307186514764531"
     data-ad-slot="9823952209"
     data-ad-format="auto"></ins>
<script>
		 (adsbygoogle = window.adsbygoogle || []).push({});
</script>
{$this->JAVASCRIPT_BOTTOM}
			</body>
			</html>
EOF;
		return $this->wrapper = $BWHTML;
	}
}
?>
