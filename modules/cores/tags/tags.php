<?php

require_once(CORE_PATH."tags/Tag.class.php");

class tags extends VSFObject {

/**
 * 
 * Enter description here ...
 * @var Tag
 */
	public $obj;

	function __construct(){
            global $vsMenu;
            parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Tag';
		$this->tableName 		= 'tag';
		$this->obj = $this->createBasicObject();
	}
	
	function __destruct(){
		unset($this);
	}
	function insertObject($object=null){
		
		
		if($object){
			$this->obj=$object;
		}
		$this->obj->setDateTime(time());
		$this->obj->setTrimText($this->strimText($this->obj->getText()));
		
		return parent::insertObject($this->obj);
	}
	function updateObject($object=null){
		if($object){
			$this->obj=$object;
		}
		$this->obj->setTrimText($this->strimText($this->obj->getText()));
		return parent::updateObject($this->obj);
	}
	function strimText($text){
		require_once UTILS_PATH.'TextCode.class.php';
		$text=preg_replace('/^\s+|\s+$/i', "", $text);
		$text=preg_replace('/\s+/i', " ", $text);
		$return =strtolower(VSFTextCode::removeAccent($text," "));
		//while($return[0]==" ") substr($return, 0,1);
		//while($return[strlen($return)-1]==" ") substr($return, 0,-1);
		return $return;
	}
	function checkTag($text){
		$obj=new Tag();
		$trimtext=$this->strimText($text);
		$this->setCondition("trimText ='$trimtext'");
		$obj=$this->getObjectsByCondition();
		
		if(is_array($obj)) return current($obj);
		return 0;
				
	}
	function getTopTags($limit=40){
		global $DB;
		$query="
		SELECT * FROM ( 
		select *,count(tagId) as count 
		from vsf_tag left join vsf_tagcontent 
		on vsf_tag.id=vsf_tagcontent.tagId 
		group by id 
		order by count 
		desc LIMIT 0,$limit 
		) AS T1 ORDER BY trimText
		";
		$DB->query($query);
		$result=array();
		while($row=$DB->fetch_row()){
			$t=new Tag();
			$t->convertToObject($row);
			$result[$t->getId()]=$t;
		}
		return $result;
	}
	function getTagByContent($module,$contentId){
		$this->setTableName("tag,".SQL_PREFIX."tagcontent");
		$this->setCondition(SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and module='$module' and contentId='$contentId'");
		return $this->getObjectsByCondition();
		
		
	}
	function deleteObjectById($id){
		parent::deleteObjectById($id);
		if(!$id) $id=$this->obj->getId();
		global $DB;
		$DB->query("DELETE FROM ".SQL_PREFIX."tagcontent WHERE tagId ='$id'");
	}
	/**
	 * 
	 * Enter description here ...
	 * @param $module string 
	 * @param $contentId int
	 * @param $taglist string
	 */
	function addTagForContentId($module,$contentId,$taglist){
		$tagl=explode(",", $taglist);
		global $DB;
		$DB->query("DELETE FROM ".SQL_PREFIX."tagcontent WHERE module ='$module' and contentId='$contentId' ");
		foreach ($tagl as $value) {
			$this->obj=new Tag();
			$value=preg_replace('/^\s+|\s+$/i', "", $value);
			if(str_replace(" ", "", $value)){
				if(!$obj=$this->checkTag($value)){
					$this->obj->setText($value);
					$this->insertObject();
				}else{
					$this->obj=$obj;
				}
				$DB->query("INSERT INTO ".SQL_PREFIX."tagcontent (`tagId`, `module`, `contentId`) VALUES ('{$this->obj->getId()}', '$module', '$contentId')");
			}
		}
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $modules
	 */
	function getTagsForModule($modules){
		$this->setTableName("tag,".SQL_PREFIX."tagcontent");
		$this->setCondition(SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and module='$modules' ");
		return $this->getObjectsByCondition();
	}
/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $modules
	 * @return list content id
	 */
	function getContentByTagName($module,$tag){
		$tag=$this->strimText($tag);
		global $DB;
		$DB->query("select contentId from ".SQL_PREFIX."tag,".SQL_PREFIX."tagcontent
		where ".SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and trimText='$tag' and ".SQL_PREFIX."tagcontent.module='$module'");
		$result=array();
		while ($row=$DB->fetch_row()){
			$result[]=$row['contentId'];
		}
		if(count($result)) return implode(",", $result);
		else return 0;
	}
/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $modules
	 * @return list content id
	 */
	function getContentByTagId($module,$id){
		global $DB;
		$DB->query("select contentId from ".SQL_PREFIX."tag,".SQL_PREFIX."tagcontent
		where ".SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and ".SQL_PREFIX."tag.Id='$id'  and ".SQL_PREFIX."tagcontent.module='$module'");
		$result=array();
		while ($row=$DB->fetch_row()){
			$result[]=$row['contentId'];
		}
		if(count($result)) return implode(",", $result);
		else return 0;
	}
}
?>