<?php
require_once (CORE_PATH . 'admins/admingroups.php');
class admingroups_controler extends VSControl_admin {

	function __construct($modelName) {
		global $vsTemplate, $bw; // $this->html=$vsTemplate->load_template("skin_admingroups");
		parent::__construct ( $modelName, "skin_admingroups", "admingroup" );
		$this->model->categoryName = "admingroups";
	}

	function addEditObjForm($objId = 0, $option = array()) {
		global $vsStd, $bw, $vsPrint;
		$admins = new admins ();
		// $option['permission_list_group']=$admins->getPermissionListGroup();
		$option ['permission_list'] = $admins->getPermisstionList ();
		$option ['myspermission'] = $this->model->getPermissionForGroup ( $objId );
		return parent::addEditObjForm ( $objId, $option );
	}

	function addEditObjProcess() {
		global $bw, $vsStd;
		if (! $bw->input [$this->modelName] ['default']) {
			$bw->input [$this->modelName] ['default'] = 0;
		}
		return parent::addEditObjProcess ();
	}

	/**
	 * (non-PHPdoc)
	 * 
	 * @see sources/libs/boards/VSControl_admin::afterProcess()
	 * @param
	 *        	admins
	 */
	function afterProcess($model) {
		global $bw;
		$own = VSFactory::getAdmins ()->basicObject->getName ();
		$DB = VSFactory::createConnectionDB ();
		if (count ( $bw->input ['permission'] )) {
			$DB->query ( "  DELETE FROM `vsf_admin_permission` WHERE `groupId` = '{$model->basicObject->getId()}' " );
			foreach ( $bw->input ['permission'] as $index => $value ) {
				$query = "
					INSERT INTO `vsf_admin_permission` (
					`groupId` ,
					`permission`,
					`grant`
					)
					VALUES (
					'{$model->basicObject->getId()}', '$value','{$own}'
					);
					
					";
				$DB->query ( $query );
			}
		}
	}

	function getHtml() {
		return $this->html;
	}

	function getOutput() {
		return $this->output;
	}

	function setHtml($html) {
		$this->html = $html;
	}

	function setOutput($output) {
		$this->output = $output;
	}
	
	/**
	 * Skins for admingroup .
	 * ..
	 * 
	 * @var skin_admingroups
	 *
	 */
	var $html;
	
	/**
	 * String code return to browser
	 */
	var $output;
}
