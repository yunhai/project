<?php 
require_once(CORE_PATH."modules/Module.class.php");

class modules extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Module';
		$this->tableName 		= 'module';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"modules";
		$this->createBasicObject();	
		$this->fields = $this->basicObject->convertToDB();
		parent::__construct();

	}
function getEnabledModule($moduleType="admin") {
		if($moduleType=="admin") {
			$this->condition = "isAdmin=1";
		}
		elseif($moduleType=="User") {
			$this->condition = "isUser=1";
		}
		$this->getAllModules();
	}

	function getModuleByClass($class="") {
		$vsLang = VSFactory::getLangs();
		$this->basicObject->setClass($class);
		$this->result['message'] = $vsLang->getWords('module_get_class_success',"Get action successfully!");
		$this->condition = "class='".$class."'";
		$this->getOneObjectsByCondition();
		if(!$this->result['status']) {
			$this->result['message'] = $vsLang->getWords('module_get_class_fail',"There is no item with specified action!");
		}

	}

	function validateModule($checkexist = false) {
		if($checkexist) {
			$this->getModuleByClass($this->basicObject->getClass());
			if($this->result['status']) {
				$this->result['status'] = false;
				$this->result['message'] .= VSFactory::getLangs()->getWords('err_module_existed',"This module is already existed!<br>");
			}
			else $this->result['status'] = true;
		}
		else {
			$this->condition = "(moduleName='".$this->basicObject->getTitle()."' OR moduleClass='".$this->basicObject->getClass()."') AND moduleId !=".$this->basicObject->getId();
			$list = $this->getObjectsByCondition();
			if($this->result['status']) {
				$this->result['status'] = false;
				$this->result['message']  = "This module is duplicated with another module!<br>";
			}
		}
	}

	function getAllModules() {
		$DB= VSFactory::createConnectionDB();
		$this->result['status'] = true;
		$this->result['message'] = VSFactory::getLangs()->getWords('get_all_success',"Get all modules success!");
			
		$DB->simple_construct(array('select'	=> '*',
										'from'		=> $this->tableName,
										'where'		=> $this->condition
		)
		);
		$DB->simple_exec();
		$module = $DB->fetch_row();
		while($module) {
			$oModule = new Module();
			$oModule->convertToObject($module);
			$this->arrayModule[$oModule->getClass()] = $oModule;
			$module = $DB->fetch_row();
		}
	}

	function getModuleById($id=0) {
		$DB= VSFactory::createConnectionDB();

		$id = intval($id);
		$this->result['status'] = true;

		$DB->simple_construct(array('select'	=> '*',
									'from'		=> $this->tableName,
									'where'		=> 'id='.$id
		)
		);
		$DB->simple_exec();
		$module = $DB->fetch_row();
		if($module) {
			$this->basicObject->convertToObject($module);
		}
		else {
			$this->result['status'] = false;
			$this->result['message'] = VSFactory::getLangs()->getWords('module_get_id_fail',"There is no item with specified ID!");
		}
	}
	
	function getModuleByIds($ids = 0){
		$lisname= "";
		if($ids){
			$this->setCondition("id in ({$ids})");
			$list =  $this->getObjectsByCondition();
	
			if(count($list))
				foreach($list as $obj)
					$lisname .= $obj->getClass().",";
		}
		
		return rtrim($lisname,',');
	}

	function getVirtualModuleList(){
		$this->setCondition("class = 'virtual'");
		$this->getObjectsByCondition();
	}




	
	/**
	*Enter description here ...
	*@var Module
	**/
	var		$obj;
}
