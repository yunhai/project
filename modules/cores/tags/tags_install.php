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

class tags_install {
	public $query = "";
	public $version = "3.3.4.1";
	public $build = "628";

	function Install(){

		$this->query[] = "
			INSERT INTO `".SQL_PREFIX."module`(`moduleTitle`,`moduleVersion`,`moduleIsAdmin`,`moduleIsUser`,`moduleIntro`,`moduleClass`) values 
			('Page Manager','".$this->version."',1,1,'This module had create auto by system for management all tags for VS Framework.','tags');
		";
		$this->query[] = "
			CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."tag` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `text` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
			  `trimText` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
			  `dateTime` int(11) NOT NULL,
			  PRIMARY KEY (`id`),
			  UNIQUE KEY `trimText` (`trimText`)
			) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
		
		";
		$this->query[] = "
			CREATE TABLE IF NOT EXISTS `".SQL_PREFIX."tagcontent` (
			  `tagId` int(11) NOT NULL,
			  `module` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
			  `contentId` int(11) NOT NULL
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
		
		";
	}

	function Uninstall($moduleId) {
		$this->query[] = "DELETE FROM `".SQL_PREFIX."module` WHERE `moduleId`=".$moduleId;
	}
}
?>