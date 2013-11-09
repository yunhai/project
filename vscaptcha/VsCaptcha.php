<?php

class VsCaptcha {
	function check($text){
		if(!isset($_SESSION['vscaptcha_vscaptcaha'])||!$text) return false;
		$rtext=strtoupper(str_replace(array(" "), "", $text));
		$captcha=strtoupper(str_replace(array(" "), "", $_SESSION['vscaptcha_vscaptcaha']));
		if($captcha!=$rtext){
			unset($_SESSION['vscaptcha_vscaptcaha']);
			return false;
		}
		unset($_SESSION['vscaptcha_vscaptcaha']);
		return true;
	}
}

?>