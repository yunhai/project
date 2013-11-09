<?php
/*
 +-----------------------------------------------------------------------------
 |   VIET SOLUTION SJC  base on IPB Code version 3.3.4.1
 |	Author: tongnguyen
 |	Start Date: 19/05/2009
 |	Finish Date: 20/05/2009
 |	moduleName Description: This module is for management all component in system.
 +-----------------------------------------------------------------------------
 */

class subcribes_install {
	public $query = "";
	public $version = "3.3.4.1";
	public $build = "628";
	public $tableName = "subcribe";
	public $moduleTitle = "subcribes";
	function Install() {
		$this->query[] = "DROP TABLE IF EXISTS`".SQL_PREFIX."{$this->tableName}`";
		$this->query[] = "
			CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."{$this->tableName}` (
			  `subId` int(10) NOT NULL AUTO_INCREMENT,
			  `subUser` int(10) NOT NULL,
			  `subEmail` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `subContent` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
			  `subProfile` text NOT NULL,
			  `subStatus` tinyint(1) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`subId`)
			) ENGINE=MyISAM AUTO_INCREMENT=1 ;
		";
		$this->query[] = "
			INSERT INTO `".SQL_PREFIX."module`(`moduleTitle`,`moduleVersion`,`moduleIsAdmin`,`moduleIsUser`,`moduleIntro`,`moduleClass`) VALUES 
			('{$this->moduleTitle} manager','".$this->version."',1,1,'This is a system module for management all {$this->moduleTitle}  for VS Framework.','{$this->moduleTitle}');
		";
	}

	function Uninstall($moduleId) {
		$this->query[] = "DROP TABLE `".SQL_PREFIX."{$this->tableName}`";
		$this->query[] = "DELETE FROM `".SQL_PREFIX."module` WHERE `moduleClass`='{$this->moduleTitle}'";
	}
}
?>