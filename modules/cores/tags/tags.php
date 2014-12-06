<?php 
require_once(CORE_PATH."tags/Tag.class.php");

class tags extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Tag';
		$this->tableName 		= 'tag';
		//$this->categoryField='catId';
		//$this->categoryName=$category?$category:"tags";
		$this->createBasicObject();		parent::__construct();

	}
function insertObject($object=null){
		if($object){
			$this->basicObject=$object;
		}
		$this->basicObject->setTrimText($this->strimText($this->basicObject->getTitle()));
		return parent::insertObject($this->basicObject);
	}
	function updateObject($object=null){
		if($object){
			$this->basicObject=$object;
		}
		$this->basicObject->setTrimText($this->strimText($this->basicObject->getTitle()));
		return parent::updateObject($this->basicObject);
	}
	function strimText($text){
		require_once UTILS_PATH.'TextCode.class.php';
		$text=preg_replace('/^\s+|\s+$/i', "", $text);
		$text=preg_replace('/\s+/i', " ", $text);
		$return =strtolower(VSFTextCode::removeAccent($text," "));
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
		$this->setOrder("`count`");
		$this->setLimit(array(0,$limit));
		return $this->getObjectsByCondition();
	}
	function getTagByContent($module,$contentId){
		$this->setTableName("tag,".SQL_PREFIX."tagcontent");
		$this->setCondition(SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and module='$module' and contentId='$contentId'");
		return $this->getObjectsByCondition();
		
		
	}
	function deleteObjectById($id){
		parent::deleteObjectById($id);
		if(!$id) $id=$this->basicObject->getId();
		VSFactory::createConnectionDB()->query("DELETE FROM ".SQL_PREFIX."tagcontent WHERE tagId ='$id'");
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
		$DB=VSFactory::createConnectionDB();
		$DB->query("DELETE FROM ".SQL_PREFIX."tagcontent WHERE module ='$module' and contentId='$contentId' ");
		foreach ($tagl as $value) {
			$this->basicObject=new Tag();
			$value=preg_replace('/^\s+|\s+$/i', "", $value);
			if(str_replace(" ", "", $value)){
				if(!$obj=$this->checkTag($value)){
					$this->basicObject->setTitle($value);
					$this->insertObject();
				}else{
					$this->basicObject=$obj;
				}
				$DB->query("INSERT INTO ".SQL_PREFIX."tagcontent (`tagId`, `module`, `contentId`) VALUES ('{$this->basicObject->getId()}', '$module', '$contentId')");
				VSFactory::createConnectionDB()->query("SELECT count(*) as vsf_count FROM ".SQL_PREFIX."tagcontent WHERE tagId ='{$this->basicObject->getId()}'");
				$row=VSFactory::createConnectionDB()->fetch_row();
				if($row['vsf_count']){
					$this->basicObject->setCount($row['vsf_count']);
					$this->updateObject();
				}
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
		$DB=VSFactory::createConnectionDB();
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
		$DB=VSFactory::createConnectionDB();
		$DB->query("select contentId from ".SQL_PREFIX."tag,".SQL_PREFIX."tagcontent
		where ".SQL_PREFIX."tag.id=".SQL_PREFIX."tagcontent.tagId  and ".SQL_PREFIX."tag.Id='$id'  and ".SQL_PREFIX."tagcontent.module='$module'");
		$result=array();
		while ($row=$DB->fetch_row()){
			$result[]=$row['contentId'];
		}
		if(count($result)) return implode(",", $result);
		else return 0;
	}



	
	/**
	*Enter description here ...
	*@var Tag
	**/
	var		$obj;
}
