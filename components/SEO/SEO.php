<?php
global $vsStd;
$vsStd->requireFile(COM_PATH."SEO/SEO.class.php");

class COM_SEO extends VSFObject{
	public $aliasurl = array();
        public $aliasurls = array();
	public $realurl	= array();
        
	public $obj;

	public $result 	= array();

	function __construct() {
		global $bw,$vsPrint;
		parent::__construct();
		$this->primaryField 	= 'seoId';
		$this->basicClassName 	= 'SEO';
		$this->tableName 		= 'seo';
		$this->obj = $this->createBasicObject();
$bw->input['vs'] = trim($bw->input['vs'],"/");
		$this->getAllSEOObject();
		if (APPLICATION_TYPE == 'user')
			if($this->realurls!="")
				$bw->input['vs'] = str_replace($bw->vars['board_url'].'/', "", strtr($bw->vars['board_url'].'/'.$bw->input['vs'],$this->realurls));
		if($this->obj->getId()){
			$vsPrint->pageTitle=$vsPrint->mainTitle=$this->obj->getTitle();
		}
			
	}

	function lastProcess() {
		global $bw, $vsPrint, $vsSkin,$vsSettings;
		
		if($this->obj->getTitle()!="") {
			$pageTitle = $this->obj->getTitle()." | ".$bw->vars['global_websitename'];
			$vsSkin->wrapper = str_replace("<title>".$vsPrint->pageTitle."</title>","<title>".$pageTitle."</title>", $vsSkin->wrapper);
			$vsSkin->wrapper = str_replace("</title>","</title><meta name='title' content='".$pageTitle."' />", $vsSkin->wrapper);		
		}
		else{
			$vsSkin->wrapper = str_replace("</title>","</title><meta name='title' content='".$vsPrint->pageTitle."' />", $vsSkin->wrapper);
		}
		
		if($this->obj->getKeyword()!="") {
			$pageKeyword = '<meta name="keywords" content="'.$this->obj->getKeyword().'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageKeyword, $vsSkin->wrapper);
		}
		elseif($vsSettings->getSystemKey("global_meta_keywords", '', "seo", 1, 1)){
			$pageKeyword = '<meta name="keywords" content="'.$vsSettings->getSystemKey("global_meta_keywords", '', "seo", 1, 1).'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageKeyword, $vsSkin->wrapper);
		}

		if($this->obj->getIntro()!="") {
			$pageDescription = '<meta name="description" content="'.$this->obj->getIntro().'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageDescription, $vsSkin->wrapper);
		}
		elseif($vsSettings->getSystemKey("global_meta_descriptions", '', "seo", 1, 1)) {
			$pageDescription = '<meta name="description" content="'.$vsSettings->getSystemKey("global_meta_descriptions", '', "seo", 1, 1).'" />';
			$vsSkin->wrapper = str_replace("</title>","</title>".$pageDescription, $vsSkin->wrapper);
		}

		if (APPLICATION_TYPE == 'user'){
//			if(!$vsSettings->getSystemKey("replace_details_alias_after_process", 0, "urlalias", 1, 1)){
//				$this->getGlobalSEOObject();			
//			}
           
			if(is_array($this->aliasurls)){
				$vsSkin->wrapper = strtr($vsSkin->wrapper,$this->aliasurls);
			}
		}
			
	}

	function validateSEOObject() {
		global $vsLang;
		$this->result['status'] = true;
		$this->result['message'] = "";

		if($this->obj->getAliasUrl() == "") {
			$this->result['status'] = false;
			$this->result['message'] .= $vsLang->getWords('seo_err_alias_url_blank',"Alias url can't be left blank!<br>");
		}

		if($this->obj->getRealUrl() == "") {
			$this->result['status'] = false;
			$this->result['message'] .= $vsLang->getWords('seo_err_real_url_blank',"Real url can't be left blank!<br>");
		}
	}

	function getAllSEOObject() {
		global $DB, $bw;
		$this->setOrder('seoAliasUrl');
		$this->setCondition(' seoStatus>0 ');
		$this->getObjectsByCondition('getAliasUrl');
		foreach($this->getArrayObj() as $seoObject){
			if($seoObject->getRealUrl()!=""){
			$this->aliasurl[$seoObject->getRealUrl()] = $seoObject->getAliasUrl();
                        $this->aliasurls[$bw->vars['board_url'].'/'.$seoObject->getRealUrl()] = $bw->vars['board_url'].'/'.$seoObject->getAliasUrl();
                        }
			if($seoObject->getAliasUrl()!=""){
				$this->realurl[$seoObject->getAliasUrl()] = $seoObject->getRealUrl();
				$this->realurls[$bw->vars['board_url'].'/'.$seoObject->getAliasUrl()] = $bw->vars['board_url'].'/'.$seoObject->getRealUrl();
			}			
		}	
               
                $temp = str_replace(".html", "", $bw->input['vs']);
                
		if(is_object($this->arrayObj[$temp]))
			$this->obj = $this->arrayObj[$temp];
		else 
		{
			$this->obj = new SEO();
		}
		return $this->getArrayObj();
	}
	function getAliasByUrl($url){
		global $DB;
		$this->setCondition(" seoRealUrl ='{$url}' and seoStatus>0 ");
		$obj=$this->getOneObjectsByCondition();
		if(is_object($obj)){
			return $obj->getAliasUrl();
		}else{
			return $url;
		}
		
	}
//	function getGlobalSEOObject() {
//		global $DB, $bw;
//		unset($this->aliasurl);
//		unset($this->realurl);
//		unset($this->arrayObj);
//		$this->setOrder('seoAliasUrl');
//		$this->setCondition(' seoStatus>0 and seoType =0 ');
//		$this->getObjectsByCondition('getAliasUrl');
//
//		foreach($this->getArrayObj() as $seoObject){
//			if($seoObject->getRealUrl()!=""){
//			$this->aliasurl[$seoObject->getRealUrl()] = $seoObject->getAliasUrl();
//                        $this->aliasurls[$bw->vars['board_url']."/".$seoObject->getRealUrl()] = $bw->vars['board_url']."/".$seoObject->getAliasUrl();
//                        }
//			if($seoObject->getAliasUrl()!="")
//			$this->realurl[$seoObject->getAliasUrl()] = $seoObject->getRealUrl();	
//                        }	
////		if(is_object($this->arrayObj[$bw->input['vs']]))
////			$this->obj = $this->arrayObj[$bw->input['vs']];
////		else 
////		{
////			$this->setCondition("seoAliasUrl = '{$bw->input['vs']}'");
////			$this->obj =$this->getOneObjectsByCondition ( 'getAliasUrl');
////			if(!is_object($this->obj)) {
////				$this->obj = new SEO();
////			}
////		}
//
//		return $this->getArrayObj();
//	}
	function movePage() {
		global $bw, $vsPrint;
		print 'dsadsa'.$bw->base_url.$this->aliasurl[$bw->input['vs']];exit;
		if(in_array($bw->input['vs'],$this->realurl)) {
			$vsPrint->boink_it($bw->base_url.$this->aliasurl[$bw->input['vs']]);
				
		}
	}
}