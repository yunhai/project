<?php
class VSSRss{
	public $cate = NULL;

	public $arrayObj = NULL;
        
        public $title = null;
        public $link  =null;
        public $copy = null;
        public $module = null;
	
	function buildRss(){
	global $vsMenu,$bw,$vsLang,$vsStd,$vsCom;
       
	$temp = $this->module?$this->module:$bw->input['module']	;

                $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		$xml .= "<rss version=\"2.0\">\n";
		$xml .= "<channel>\n";
		$xml .= "\t<title>{$this->cate->getTitle()} - {$bw->vars['global_websiteaddress']}</title>\n";
		$xml .= "\t<link>{$bw->vars['board_url']}/{$temp}</link>\n";
		$xml .= "\t<description>{$this->cate->getTitle()} - {$bw->vars['global_websiteaddress']}</description>\n";
		$xml .= "\t<copyright>{$bw->vars['global_websiteaddress']}</copyright>\n";
		$xml .= "\t<generator>http://{$bw->vars['global_websiteaddress']}:{$bw->vars['board_url']}/rss</generator>\n";
		if(count($this->arrayObj))
		foreach ( $this->arrayObj as $obj ) {
			$time = new DateTime($obj->getPostDate('RSS'));
			$xml .= "\t<item>\n";
			$xml .= "\t\t<title>".$obj->getTitle()."</title>\n";
			$xml .= "\t\t<description><![CDATA[".$obj->createImageCache($obj->file,0, 109).$obj->getIntro()."]]></description>\n";
			$xml .= "\t\t<pubDate>".$time->format(DateTime::RSS)."</pubDate>\n";
			$xml .= "\t\t<link>".$obj->getRssUrl($temp)."</link>\n";
                        $xml .= "\t\t<price>".$obj->getPrice("",1)."</Price>\n";
                        $xml .= "\t\t<hotPrice>".$obj->getHotPrice("",1)."</hotPrice>\n";
			$xml .= "\t</item>\n";
		}
		$xml .= "\n</channel>\n</rss>\n";
                if(!file_exists(ROOT_PATH."rss/"))
                {
                    mkdir(ROOT_PATH."rss/", 777);
                }
//		$xml = str_replace($reals, $alias, $xml);
                 $file_title = "products_{$vsLang->currentLang->getFoldername()}";strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->cate->title)),'-')). '-' . $this->cate->getId ().".rss";
		
		$wf = fopen ( ROOT_PATH."rss/".$file_title, "w" );
		file_put_contents(ROOT_PATH."rss/".$file_title, $xml);
		//fwrite ( $wf, $xml,strlen($xml) );
		fclose ( $wf );
		@chmod(ROOT_PATH."rss/".$file_title,0775);





//        if(!file_exists(ROOT_PATH."rss/"))
//        {
//            mkdir(ROOT_PATH."rss/", 777);
//        }
//       $filename = strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->cate->title)),'-')). '-' . $this->cate->getId ();
//        $dom->save(ROOT_PATH."rss/{$filename}.rss");//save the xml file
	}
	
//function text2utf8($text,$isutf8){
//	$text = str_replace('&nbsp;', " ",$text);
//	$text = str_replace('&', "&amp;",$text);
//	if($isutf8){
//		$text = str_replace('&apos;', "'", html_entity_decode($text, ENT_QUOTES));//html_entity_decode
//	}else{
//		//return utf8_html_entity_decode($text,null,'UTF-8');
//		$text = preg_replace("/([\x80-\xFF])/e","chr(0xC0|ord('\\1')>>6).chr(0x80|ord('\\1')&0x3F)",$text);
//		//$text=iconv("ISO-8859-1","UTF-8",$text);
//		$text = str_replace('&apos;', "'", html_entity_decode($text, ENT_QUOTES));//html_entity_decode
//	}
//		$text = str_replace('&amp;', "&",$text);
//	return $text;
//}


}