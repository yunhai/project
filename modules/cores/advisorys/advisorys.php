<?php
require_once(CORE_PATH."advisorys/Advisory.class.php");
class advisorys extends VSFObject{
	
	function __construct(){
		global $DB ,$vsMenu;
		parent::__construct();
		$this->primaryField 	= 'advisoryId';
		$this->basicClassName 	= 'advisory';
		$this->tableName 	= 'advisory';
		$this->categoryField  	= 'advisoryCatId';
		$this->obj = $this->createBasicObject();
		$this->fields = $this->obj->convertToDB();
		$this->categories 	= array();
	
		$this->categories 	= $vsMenu->getCategoryGroup(strtolower($this->tableName)."s");
                if(!$DB->field_exists('advisoryCatId',$this->tableName))
                                $DB->sql_add_field($this->tableName,'advisoryCatId','int(5)');
                        if(!$DB->field_exists('advisoryIndex',$this->tableName))
                                $DB->sql_add_field($this->tableName,'advisoryIndex','int(5)');
                }
	
	
	function __destruct(){
	}


}
?>