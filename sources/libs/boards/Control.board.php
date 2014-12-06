<?php
class VSControl {
	protected $output;
	function  auto_run() {
		return;
	}
	function setOutput($out) {
			return $this->output = $out;
		}
		
		function getOutput() {
			return $this->output;
		}
	function exitDenyAccess($error=''){
		return $this->output=$error?$error:VSFactory::getLangs()->getWords('exitDenyAccess','Access denied!');
	}
	/**
	 * @return skins_board
	 */
	public function getHtml() {
		return $this->html;
	}

	/**
	 * @param $html string file name
	 */
	public function setHtml($html) {
		$this->html = $html;
	}
	function getIdFromUrl($url,$sep="-"){
		$url=str_replace(".html", "", $url);
		$url=explode($sep, $url);
		return intval($url[count($url)-1]);
	}
	function lastModifyChange(){
		if(!LAST_MODIFY_FILE) return false;
		$fp = fopen(LAST_MODIFY_FILE, 'w');
		fwrite($fp, 'modified');
		fclose($fp);
	}
}
?>