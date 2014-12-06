<?php

class Setting extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->htmlValue ) ? ($dbobj ['htmlValue'] = $this->htmlValue) : '';
		isset ( $this->value ) ? ($dbobj ['value'] = $this->value) : '';
		isset ( $this->inputType ) ? ($dbobj ['inputType'] = $this->inputType) : '';
		isset ( $this->key ) ? ($dbobj ['key'] = $this->key) : '';
		isset ( $this->root ) ? ($dbobj ['root'] = $this->root) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->flag ) ? ($dbobj ['flag'] = $this->flag) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['htmlValue'] ) ? $this->setHtmlValue ( $object ['htmlValue'] ) : '';
		isset ( $object ['value'] ) ? $this->setValue ( $object ['value'] ) : '';
		isset ( $object ['inputType'] ) ? $this->setInputType ( $object ['inputType'] ) : '';
		isset ( $object ['key'] ) ? $this->setKey ( $object ['key'] ) : '';
		isset ( $object ['root'] ) ? $this->setRoot ( $object ['root'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['flag'] ) ? $this->setFlag ( $object ['flag'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getCatId(){
		return $this->catId;
	}



	function getTitle(){
		return $this->title;
	}



	function getIntro(){
		return $this->intro;
	}



	function getValue(){
		return $this->value;
	}



	function getInputType(){
		return $this->inputType;
	}



	function getKey(){
		return $this->key;
	}



	function getRoot(){
		return $this->root;
	}



	function getType(){
		return $this->type;
	}



	function getModule(){
		return $this->module;
	}



	function getIndex(){
		return $this->index;
	}



	function setId($id){
		$this->id=$id;
	}




	function setCatId($catId){
		$this->catId=$catId;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setValue($value){
		$this->value=$value;
	}




	function setInputType($inputType){
		$this->inputType=$inputType;
	}




	function setKey($key){
		$this->key=$key;
	}




	function setRoot($root){
		$this->root=$root;
	}




	function setType($type){
		$this->type=$type;
	}




	function setModule($module){
		$this->module=$module;
	}




	function setIndex($index){
		$this->index=$index;
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
	
	function showHTMLForm($option=array()){
		$html=$this->htmlValue;
		$html=str_replace(
		array("{id}","{value}","editor",),
		array($this->id,$this->value,$this->createEditor($this->value, "value[{$this->id}]", "100%", "222px","")),
		$html);
		return $html;
		
	}


		var		$id;

		var		$catId;

		var		$title;

		var		$intro;
		
		var 	$htmlValue;

		var		$value;

		var		$inputType;

		var		$key;

		var		$root;

		var		$type;

		var		$module;

		var		$index;
		var		$flag;
	/**
	 * @return the $htmlValue
	 */
	/**
	 * @return the $flag
	 */
	public function getFlag() {
		return $this->flag;
	}

		/**
	 * @param field_type $flag
	 */
	public function setFlag($flag) {
		$this->flag = $flag;
	}

	public function getHtmlValue() {
		return $this->htmlValue;
	}

		/**
	 * @param field_type $htmlValue
	 */
	public function setHtmlValue($htmlValue) {
		$this->htmlValue = $htmlValue;
	}

	function validate() {
		return true;
		
	}
	
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','title','intro','htmlValue','value','inputType','key','root','type','module','index',);
}
