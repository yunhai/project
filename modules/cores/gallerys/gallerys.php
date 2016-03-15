<?php

require_once (CORE_PATH . "gallerys/Gallery.class.php");
class gallerys extends VSFObject{
	public $obj;
	protected $relTableName;
	function __construct() {
		global $DB,$vsMenu,$bw;
		parent::__construct ();
                $this->categoryField 	= "galleryCatId";
		$this->primaryField = 'galleryId';
		$this->basicClassName = 'Gallery';
		$this->tableName = 'gallery';
		$this->obj = $this->createBasicObject ();
		$this->relTableName 	= "rel_gallery_file";
		$this->categories = $vsMenu->getCategoryGroup($bw->input['module']);
		if(!$DB->field_exists('galleryPassWord',$this->tableName))
			$DB->sql_add_field($this->tableName,'galleryPassWord','varchar(32)');
		if(!$DB->field_exists('galleryImage',$this->tableName))
			$DB->sql_add_field($this->tableName,'galleryImage','int(10)');
	}

	function getRelTableName() {
		return $this->relTableName;
	}

	function setRelTableName($relTableName) {
		$this->relTableName = $relTableName;
	}

	function getAlbumByCode($code= null) {
            global $vsMenu;
		if(!$code) return;
		$strIds = $vsMenu->getChildrenIdInTree($this->getCategories());
		//$this->condition="galleryCatId in ({$strIds}) and galleryCode = '{$code}'";
		$this->condition="galleryCatId in ({$strIds}) and galleryCode = '{$code}'";
		$this->getOneObjectsByCondition();

		return $this->getFileByAlbumId($this->obj->getId());
	}

	function getFileByAlbumId($albumId,$groupFile=0){
		$this->vsRelation->setRelId($albumId);
		$this->vsRelation->setTableName($this->getRelTableName());
		$fileId = $this->vsRelation->getObjectByRel();
		if($fileId)	{
			$this->vsFile->setCondition("fileId in({$fileId})");
			$this->vsFile->setOrder("fileIndex ASC, fileId DESC");
			$this->vsFile->getObjectsByCondition();
			$arrayFile = $this->vsFile->getArrayObj();
		}
		if($groupFile){
			$groupFile=array();
			foreach ($this->vsRelation->arrval as $group)
			{
				if($arrayFile[$group['objectId']])
				$groupFile[$group['relId']][$group['objectId']]=$arrayFile[$group['objectId']];
			}
			return $this->arrayObj =$groupFile;
		}
		return $this->arrayObj =$arrayFile;
	}

	
	
	function getAlbumById($albumId=0,$tableName="",$groupFile=0){
		if(intval($albumId) or !$tableName) return;
		$this->vsRelation->setRelId($albumId);
		$this->vsRelation->setTableName($tableName);
		$strId=$this->vsRelation->getObjectByRel();
		return $this->getFileByAlbumId($strId,$groupFile);
	}
        
	function __destruct() {
		unset ( $this );
	}
        function getAlbumByCode1($code= null,$group=0) {
            global $vsMenu,$vsSettings,$bw,$DB;
     
          $strIds = $vsMenu->getChildrenIdInTree($this->getCategories());
          
//          $this->getFieldsString()==""?$this->setFieldsString("*"):$this->setFieldsString($this->getFieldsString().", vsf_file.*");
          $this->setFieldsString("galleryId, vsf_file.*");
          $this->setTableName("rel_gallery_file LEFT JOIN vsf_gallery ON galleryId = relId LEFT JOIN vsf_file ON objectId = fileId");
          $this->setOrder("fileIndex ASC,fileId DESC");
          
         
          if ($code)
          	$condi .=" galleryCode = '{$code}' and fileId is not NULL ";
          else $code = "common";
          if($vsSettings->getSystemKey("gallerys_use_categroup_".$code,0,$code))
          	$condi .= " and galleryCatId in ({$strIds}) and fileId is not NULL ";
          $this->getCondition() == "" ? $this->setCondition($condi): $this->setCondition($this->getCondition()." and ".$condi) ;

          $result = $this->getArrayByCondition();
   
          $count = 0;
          foreach ($result as $obj){
                    $file = new File();
                    $file->convertToObject($obj);
              if(!$group){
                    $this->arrayObj[$obj['fileId']] = $file;
                    $this->arrayObj;
              }else{
                    $this->arrayObj[$obj['galleryId']][$obj['fileId']] = $file;
              }
          }
  return $this->arrayObj;

 }
}

