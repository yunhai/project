 <?php
/*
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: System
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 |	News Description: this file created by auto system
 +-----------------------------------------------------------------------------
 */
if(!defined( 'IN_VSF')){
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit();
}

require_once(CORE_PATH."tags/tags.php");
class tags_public{
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $html;
	/**
	 * 
	 * Enter description here ...
	 * @var tags
	 */
	protected $module;
	protected $output;
	
	function __construct(){
		global $vsTemplate, $bw, $vsModule;
		$this->html = $vsTemplate->load_template('skin_tags');
		$this->module = new tags();
	}

	function auto_run(){
		global $bw,$vsSettings;
        
                
		switch($bw->input['action']){
			#more_action#
			default:
					$this->loadDefault();
				break;
		}
	}

        

	function loadDefault(){
        global $vsPrint, $vsLang, $bw,$vsSettings, $vsTemplate, $vsStd, $vsMenu;
		 
        if($bw->input[1]){
			$ids=explode("-", $bw->input[1]);
			$id=intval($ids[count($ids)-1]);
			if(!$id) $vsPrint->boink_it($bw->vars['board_url'] ."/tags/");
			$this->module->getObjectById($id);
			if(!$this->module->obj->getId()){
				if(!$id) $vsPrint->boink_it($bw->vars['board_url'] ."/tags/");
			}
			$this->module->obj->setTitle($this->module->obj->getText());
			//$this->module->obj->createSeo();
			require_once(CORE_PATH."products/products.php");
        	$products=new products();
        	$products->setCondition("productId in ({$this->module->getContentByTagId("products",$id)}) and productStatus>0");
        	$option['product']=$products->getPageList($bw->base_url."tags/",1,50,0);
        	if($option['product'])
        		$this->module->convertFileObject($option['product']['pageList'],"products");
			require_once(CORE_PATH."news/news.php");
			$newes=new newses();
        	$newes->setCondition("newsId in ({$this->module->getContentByTagId("news",$id)})");
        	$option['news']=$newes->getPageList($bw->base_url."tags/",1,50,0);
        	if($option['news'])
        		$this->module->convertFileObject($option['news']['pageList'],"news");
        		
        	$option['obj']=$this->module->obj;
       		return $this->output=$this->html->listObject($option);
        }
		//$vsPrint->addCurentJavaScriptFile("jquery.tagsphere");
		//$vsPrint->addCurentJavaScriptFile("jquery.mousewheel.min");
		
        global $DB;
		$DB->query("
			SELECT * FROM
			(
				select *,count(tagId) as count from ".SQL_PREFIX."tag,".SQL_PREFIX."tagcontent
				where vsf_tag.id=vsf_tagcontent.tagId
				group by id
				order by count desc
				LIMIT 0,400
			) AS T1
			ORDER BY trimText
		");
		$option['tag_list']=array();
		$max=0;
		$min=0;
		while($row=$DB->fetch_row()){
			if($max<$row['count']) $max=$row['count'];
			if($min>$row['count']||$min==0) $min=$row['count'];
			$tag=new Tag();
			$tag->convertToObject($row);
			$tag->count=$row['count'];
			$option['tag_list'][$tag->getId()]=$tag;
		}
		if($max>$min)
		foreach ($option['tag_list'] as $tag){
		
			$tag->size=($tag->count-$min)/($max-$min)*20+10;
		}
		//ksort($option['tag_list']);
	
		$this->output = $this->html->loadDefault($option);
	}

	function loadDetail($pageId,$com=NULL){
		global $vsPrint, $vsLang, $bw,$vsMenu, $vsStd,$vsSettings;    
		          
        $this->output = $this->html->loadDetail($obj, $option);
	}
	

	function loadCategory($catId){
		global $vsPrint, $vsLang, $bw,$vsSettings,$vsTemplate,$vsStd,$vsMenu,$DB;
		
       	$this->output = $this->html->loadCategory($option);
	}

	
	

	function setOutput($out){
		return $this->output = $out;
	}

	function getOutput(){
		return $this->output;
	}
}
?>
