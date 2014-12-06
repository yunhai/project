<?php
/*
 +-----------------------------------------------------------------------------
 |   VIET SOLUTION SJC  base on IPB Code version 3.0.0
 |	Author: tongnguyen
 |	Start Date: 5/04/2009
 |	Finish Date: 11/04/2009
 |	moduleName Description: This module is for management all languages in system.
 +-----------------------------------------------------------------------------
 */
require_once CORE_PATH.'languages/Language.class.php';
class languages extends VSFObject{
	function __construct(){
		parent::__construct ();
		$this->primaryField = 'id';
		$this->basicClassName = 'Lang1';
		$this->tableName = 'langs';
		$this->createBasicObject ();
	}
}
?>