<?php
global $vsStd;
$vsStd->requireFile(CORE_PATH."seos/Seo.class.php");

class COM_SEO extends VSFObject{
	public $aliasurl = array();
	public $realurl	= array();
	public $obj;

	public $result 	= array();

	function __construct() {
		global $bw,$vsPrint;
		parent::__construct();
		$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Seo';
		$this->tableName 		= 'seo';
		$this->createBasicObject();

		$this->getAllSEOObject();
		if($this->realurl!="")
			$bw->input['vs'] = str_replace($bw->vars['board_url'].'/', "", strtr($bw->vars['board_url'].'/'.$bw->input['vs'],$this->realurl));
		if($this->basicObject->getId()){
			$vsPrint->pageTitle=$vsPrint->mainTitle=$this->basicObject->getTitle();
		}
	}

	function lastProcess() {
		global $bw, $vsPrint, $vsSkin;
		
		$pageIndex = $bw->input['vs_page_index']?'-'.$bw->input['vs_page_index']:'';
		
		if($this->basicObject->getTitle()!="") {
			$pageTitle = $this->basicObject->getTitle()." ".$bw->input['vs_page_index']." | ".VSFactory::getSettings()->getSystemKey('global_websiteaddress','','global');
			$vsSkin->wrapper = str_replace("<title>".$vsPrint->pageTitle."</title>","<title>".$pageTitle."</title>", $vsSkin->wrapper);
			$vsSkin->wrapper = str_replace("</title>","</title><meta name='title' content='".$pageTitle."' />", $vsSkin->wrapper);		
		}
		else{
			
			$vsSkin->wrapper = str_replace("</title>","</title><meta name='title' content='".$vsPrint->pageTitle." ".$bw->input['vs_page_index']."' />", $vsSkin->wrapper);
		}
		
		if($this->basicObject->getKeyword()!="") {
			$pageKeyword = '<meta name="keywords" content="'.$this->basicObject->getKeyword().$pageIndex.'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageKeyword, $vsSkin->wrapper);
		}
		elseif(VSFactory::getSettings()->getSystemKey("global_meta_keywords", '', "seos", 1, 1)){
			$pageKeyword = '<meta name="keywords" content="'.VSFactory::getSettings()->getSystemKey("global_meta_keywords", '', "seo", 1, 1).$pageIndex.'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageKeyword, $vsSkin->wrapper);
		}

		if($this->basicObject->getIntro()!="") {
			$pageDescription = '<meta name="description" content="'.$this->basicObject->getIntro()." ".$bw->input['vs_page_index'].'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageDescription, $vsSkin->wrapper);
		}
		elseif(VSFactory::getSettings()->getSystemKey("global_meta_descriptions", '', "seos", 1, 1)) {
		
			$pageDescription = '<meta name="description" content="'.VSFactory::getSettings()->getSystemKey("global_meta_descriptions", '', "seo", 1, 1).$pageIndex.'" />';
			
				$vsSkin->wrapper = str_replace("</title>","</title>".$pageDescription, $vsSkin->wrapper);
			
		}

		if (APPLICATION_TYPE == 'user'){
//			if(!VSFactory::getSettings()->getSystemKey("replace_details_alias_after_process", 0, "urlalias", 1, 1)){
//				$this->getGlobalSEOObject();			
//			}
			if(is_array($this->aliasurl)){
				$vsSkin->wrapper = strtr($vsSkin->wrapper,$this->aliasurl);
			}
		}
			
	}

	function validateSEOObject() {
		return;
		$vsLang = VSFactory::getLangs();
		$this->result['status'] = true;
		$this->result['message'] = "";

		if($this->basicObject->getAliasUrl() == "") {
			$this->result['status'] = false;
			$this->result['message'] .= $vsLang->getWords('seo_err_alias_url_blank',"Alias url can't be left blank!<br>");
		}

		if($this->basicObject->getRealUrl() == "") {
			$this->result['status'] = false;
			$this->result['message'] .= $vsLang->getWords('seo_err_real_url_blank',"Real url can't be left blank!<br>");
		}
	}

	function getAllSEOObject() {
		global $bw;
		$this->setOrder('`aliasUrl`');
		$this->setCondition(' `status`>0 ');
		$this->getObjectsByCondition('getAliasUrl');
		foreach($this->getArrayObj() as $seoObject){
			if($seoObject->getRealUrl()!=""){
			$this->aliasurl[$bw->vars['board_url'].'/'.$seoObject->getRealUrl()] = $bw->vars['board_url'].'/'.$seoObject->getAliasUrl();
			}
			if($seoObject->getAliasUrl()!="")
			$this->realurl[$bw->vars['board_url'].'/'.$seoObject->getAliasUrl()] = $bw->vars['board_url'].'/'.$seoObject->getRealUrl();	
		}	
		if(is_object($this->arrayObj[$bw->input['vs']]))
			$this->basicObject = $this->arrayObj[$bw->input['vs']];
		else 
		{
			$this->basicObject = new SEO();
		}
		return $this->getArrayObj();
	}
	function getAliasByUrl($url){
		$this->setCondition(" realUrl ='{$url}' and `status`>0 ");
		$obj=$this->getOneObjectsByCondition();
		if(is_object($obj)){
			return $obj->getAliasUrl();
		}else{
			return $url;
		}
		
	}
	function getGlobalSEOObject() {
		global $bw;
		unset($this->aliasurl);
		unset($this->realurl);
		unset($this->arrayObj);
		$this->setOrder('aliasUrl');
		$this->setCondition(' `status`>0 and `type` =0 ');
		$this->getObjectsByCondition('getAliasUrl');

		foreach($this->getArrayObj() as $seoObject){
			if($seoObject->getRealUrl()!="")
			$this->aliasurl[$seoObject->getRealUrl()] = $seoObject->getAliasUrl();
			if($seoObject->getAliasUrl()!="")
			$this->realurl[$seoObject->getAliasUrl()] = $seoObject->getRealUrl();			}	
		if(is_object($this->arrayObj[$bw->input['vs']]))
			$this->basicObject = $this->arrayObj[$bw->input['vs']];
		else 
		{
			$this->setCondition("aliasUrl = '{$bw->input['vs']}'");
			$this->basicObject =$this->getOneObjectsByCondition ( 'getAliasUrl');
			if(!is_object($this->basicObject)) {
				$this->basicObject = new SEO();
			}
		}

		return $this->getArrayObj();
	}
	function movePage() {
		return;
		global $bw, $vsPrint;
		print 'dsadsa'.$bw->base_url.$this->aliasurl[$bw->input['vs']];exit;
		if(in_array($bw->input['vs'],$this->realurl)) {
			$vsPrint->boink_it($bw->base_url.$this->aliasurl[$bw->input['vs']]);
				
		}
	}
}