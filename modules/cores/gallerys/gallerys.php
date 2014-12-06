<?php

require_once (CORE_PATH . "gallerys/Gallery.class.php");
class gallerys extends VSFObject {
	protected $relTableName;
	function __construct() {
//		$DB = VSFactory::createConnectionDB ();
//		$vsMenu = VSFactory::getMenus ();
		parent::__construct ();
		$this->categoryField = "catId";
		$this->categoryName="gallerys";
		$this->primaryField = 'id';
		$this->basicClassName = 'Gallery';
		$this->tableName = 'gallery';
		$this->createBasicObject ();
		$this->relTableName = "gallery_file_rel";
		//$this->categories = $vsMenu->getCategoryGroup ( "gallerys" );
//		if (! $DB->field_exists ( 'passWord', $this->tableName ))
//			$DB->sql_add_field ( $this->tableName, 'passWord', 'varchar(32)' );
//		if (! $DB->field_exists ( 'image', $this->tableName ))
//			$DB->sql_add_field ( $this->tableName, 'image', 'int(10)' );
	}
	
	function getRelTableName() {
		return $this->relTableName;
	}
	
	function setRelTableName($relTableName) {
		$this->relTableName = $relTableName;
	}
	
	function getAlbumByCode($code = null,$limit=0) {
		if (! $code)
			return;
		$vsMenu = VSFactory::getMenus ();
		$strIds = $vsMenu->getChildrenIdInTree ( $this->getCategories () );
		$this->condition = "`code` ='{$code}'";
		$this->getOneObjectsByCondition ();
		
		return $this->getFileByAlbumId ( $this->basicObject->getId (),$limit );
	}
	
	function getFileByAlbumId($albumId,$limit=0) {
		$files=new files();
		$files->setCondition("`id` in (select `fileId` from vsf_{$this->relTableName} where galleryId='$albumId')");
		$files->setOrder("`index` desc");
		if($limit){
			$files->setLimit(array(0,$limit));
		}
		return $files->getObjectsByCondition();
	}
	function getAlbumPaging($code = null,$url,$index,$size) {
		if (! $code)
			return;
		$vsMenu = VSFactory::getMenus ();
		$strIds = $vsMenu->getChildrenIdInTree ( $this->getCategories () );
		$this->condition = "`code` ='{$code}'";
		$this->getOneObjectsByCondition ();
		
		return $this->getFilePaging ( $this->basicObject->getId (),$url,$index,$size );
	}
	function getFilePaging($albumId,$url,$index,$size) {
		$files=new files();
		$files->setCondition("`id` in (select `fileId` from vsf_{$this->relTableName} where galleryId='$albumId')");
		$files->setOrder("`index` desc");
		return $files->getPageList($url,$index,$size);
		
	}
	function addFileToAlbum($fileId,$albumId) {
		$query="
			INSERT INTO `vsf_{$this->getRelTableName()}` (`galleryId`, `fileId`) VALUES ('$albumId', '$fileId');
		";
		VSFactory::createConnectionDB()->query($query);
		return true;
	}
	
	function getAlbumById($albumId = 0, $tableName = "", $groupFile = 0) {
		if (intval ( $albumId ) or ! $tableName)
			return;
		$vsRelation = VSFactory::getRelation ();
		$vsRelation->setRelId ( $albumId );
		$vsRelation->setTableName ( $tableName );
		$strId = $vsRelation->getObjectByRel ();
		return $this->getFileByAlbumId ( $strId, $groupFile );
	}
	
	function __destruct() {
		unset ( $this );
	}
	/**
	 * @param $code code of albumn
	 * @param $module module referer name
	 * @param $obj Gallery return obj
	 */
	function createAlbum($code,$module='',&$obj=null){
		global $bw;
		if(!is_object($obj)) $obj=new Gallery();
		$obj->setCode($code);
		$obj->setModule($module);
		
		$obj->setModule($module);
		$vsLang = VSFactory::getLangs();
		$vsRelation = VSFactory::getRelation();
		$this->setCondition("`code`='$code'");
		$tmp=$this->getOneObjectsByCondition();
		if($tmp){
			return $obj=$tmp;
		}
		
		if(!$obj->getCatId()) $obj->setCatId($this->getCategories()->getId()); 
		if(!$obj->getStatus()) $obj->setStatus(-1);
		if(!$obj->getTitle()) $obj->setTitle($module);
		$this->insertObject($obj);
		return $obj;
	}
	function deleteAlbumByCode($code){
		$this->setCondition("`code`='$code'");
		$this->deleteObjectByCondition();
	}
	
	///overwride method
	function onDeleteObjectByCondition($condition){
		$files=new files();
		$files->setCondition("
			`id` in (
						select fileId from vsf_{$this->getRelTableName()}
						where galleryId in (
												select `id` from vsf_{$this->tableName}
												where $condition
											)
					) 
			
		");
		$filelist=$files->getObjectsByCondition();
		foreach ($filelist as $obj) {
			$files->deleteFile($obj->getId());
		}
		///xoa table rel
		VSFactory::createConnectionDB()->query("
			delete from vsf_{$this->getRelTableName()}
						where galleryId in (
												select `id` from vsf_{$this->tableName}
												where $condition
											)
		");
		
	}
}

