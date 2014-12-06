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

class Lang1 {
	protected $name 			= null; // name of language package
	protected $admindefault 	= null; // 0 for admin and 1 for user
	protected $userdefault 	= null; // 0 for not default, 1 for default
	protected $code 	= null; // folder name of language when store language in files
	protected $status 		= null; // 0 is instatus, 1 is status
	protected $symbol 		= null; // the symbol of language, e.g: vietnamese flag for vietnamese language
	protected $id 	= null;


	function __construct(){
		// Set path of Lang
	}

	function __destruct(){
		unset($this->itemId);
		unset($this->status);
		unset($this->code);
		unset($this->userdefault);
		unset($this->admindefault);
		unset($this->name);
		unset($this->userDefault);
		unset($this->id);
		unset($this->module);
		unset($this->value);
	}
	public function getPrimary() {
		return 'id';
	}
	/**
	 * @return unknown
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @return unknown
	 */
	public function getUserDefault() {
		return $this->userdefault;
	}

	/**
	 * @return unknown
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @return unknown
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @return unknown
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @return unknown
	 */
	public function getSymbol() {
		return $this->symbol;
	}

	/**
	 * @return unknown
	 */
	public function getAdminDefault() {
		return $this->admindefault;
	}

	/**
	 * @return unknown
	 */
	public function getValue() {
		return $this->value;
	}


	/**
	 * @param unknown_type $status
	 */
	public function setStatus($Status) {
		$this->status = $Status;
	}

	/**
	 * @param unknown_type $default
	 */
	public function setUserDefault($default) {
		$this->userdefault = intval($default);
	}

	/**
	 * @param unknown_type $code
	 */
	public function setCode($code) {
		$this->code = $code;
	}

	/**
	 * @param unknown_type $id
	 */
	public function setId($id) {
		$this->id = intval($id);
	}


	/**
	 * @param unknown_type $name
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @param unknown_type $symbol
	 */
	public function setSymbol($symbol) {
		$this->symbol = $symbol;
	}

	/**
	 * @param unknown_type $type
	 */
	public function setAdminDefault($adminDefault) {
		$this->admindefault = intval($adminDefault);
	}


	public function convertToDB() {
		isset($this->id)        	? ($dbobj['id'] 		= $this->id) 			: '';
		isset($this->name)        	? ($dbobj['name'] 		= $this->name) 			: '';
		isset($this->userdefault)   ? ($dbobj['userDefault'] 	= $this->userdefault) 	: '';
		isset($this->admindefault)  ? ($dbobj['adminDefault'] 	= $this->admindefault) 	: '';
		isset($this->code )   ? ($dbobj['code'] 	= $this->code) 	: '';
		isset($this->status)     	? ($dbobj['status'] 	= $this->status) 		: '';
		isset($this->symbol )      	? ($dbobj['symbol'] 	= $this->symbol) 		: '';

		return $dbobj;
	}
	/**
	 * change new from database object to Module object
	 * @param array $dbobj Database object
	 * @return void
	 *
	 */
	public function convertToObject($object=array(),$time_method = "SHORT") {
		isset($object['id'])		? $this->setId($object['id'])							:'';
		isset($object['name'])		? $this->setName($object['name'])						:'';
		isset($object['userDefault'])	? $this->setUserDefault($object['userDefault'])				:'';
		isset($object['adminDefault'])	? $this->setAdminDefault($object['adminDefault'])			:'';
		isset($object['code'])	? $this->setCode($object['code'])				:'';
		isset($object['status'])	? $this->setStatus($object['status'])					:'';
		isset($object['symbol'])	? $this->setSymbol($object['symbol'])					:'';
	}
	/**
	 * change object to template use
	 * @param array $dbobj Database object
	 * @return void
	 *
	 */
	public function convertToView() {
		isset($this->id)   			? ($template['id'] = $this->getId() ) 					: '';
		isset($this->name)        	? ($template['name'] = $this->getName()) 				: '';
		isset($this->userdefault)   ? ($template['userDefault'] = $this->getUserDefault()) 		: '';
		isset($this->admindefault)  ? ($template['adminDefault'] = $this->getAdminDefault()) 	: '';
		isset($this->code )   ? ($template['code'] = $this->getCode()) 		: '';
		isset($this->status)     	? ($template['status'] = $this->getStatus()) 			: '';
		isset($this->symbol )       ? ($template['symbol'] = $this->getSymbol()) 			: '';
		return $template;
	}

}
?>