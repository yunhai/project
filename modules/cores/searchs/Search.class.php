<?php
class Search extends BasicObject {
	public $module = NULL;

	function __construct() {
		parent::__construct ();
	}

	function __destruct() {
		parent::__destruct ();
		
	}
	public function convertToDB() {
		$dbobj = parent::convertToDB('search');
		isset ( $this->price)       ? ($dbobj ['searchPrice']	 = $this->price) : '';
                return $dbobj;
	}

	function convertToObject($object) {
		global $vsMenu,$tableName;
                parent::convertToObject($object,'search');
                isset ( $object ["{$tableName}Price"] )      ? $this->price = $object ["{$tableName}Price"]             : '';
                isset ( $object ["{$tableName}Module"] )      ? $this->module = $object ["{$tableName}Module"]             : '';
                isset ( $object ["{$tableName}Record"] )      ? $this->record = $object ["{$tableName}Record"]             : "";
                isset ( $object ["{$tableName}Update"] )      ? $this->update = $object ["{$tableName}Update"]             : "";
	}

        function getUrl($module=null) {
		global $bw;
		
		return $bw->vars['board_url'] . "/{$this->module}/detail/".strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->title)),'-')). '-' . $this->getId () . '/';
	}
        function getUpdate($format = NULl, $standard = false){
		if($format && $this->update) {
			$datetime= new VSFDateTime();
			return $datetime->getDate($this->update, $format, $standard);
		}
		return $this->update;
	}
public function getPrice($number=true) {
		global $vsLang;
		if (APPLICATION_TYPE=='user' && $number){
			if ($this->price>0){
				return number_format ( $this->price,0,"","." );
			}
			return $vsLang->getWords('callprice','Call');
		}
		return $this->price;
	}

        
	
        public function setPrice($price) {
		$this->price = $price;
	}
	public function getRecord() {
		return $this->record;
	}
}