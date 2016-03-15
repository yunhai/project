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

//	$dom = new DOMDocument(); // Represents an entire XML document (the root of the document tree)
//        $dom->encoding = 'utf-8';//set the document encoding
//        $dom->xmlVersion = '2.0';//set xml version
//        $dom->formatOutput = true;//Nicely formats output with indentation and extra space
//        $dom->xmlStandalone = false; //Whether or not the document is standalone
//
//        $pRSS = $dom->createElement('rss');
//        $pRSS->setAttribute('version', '2.0');
//        $dom->appendChild($pRSS);
//
//        $pChannel = $dom->createElement('channel');
//        $pRSS->appendChild($pChannel);
//        $pTitle = $dom->createElement('title', 'TalkPHP');
//$pLink  = $dom->createElement('link', 'http://www.talkphp.com');
//$pDesc  = $dom->createElement('description', 'Discuss PHP and other various web related topics in a knowledgeable and friendly community.');
//$pLang  = $dom->createElement('language', 'en');
//$pImage = $dom->createElement('image');
//
//// Here we simply append all the nodes we just created to the channel node
//$pChannel->appendChild($pTitle);
//$pChannel->appendChild($pLink);
//$pChannel->appendChild($pDesc);
//$pChannel->appendChild($pLang);
//$pChannel->appendChild($pImage);
//
//// Create three new elements that are needed to "describe" our image
//$pURL   = $dom->createElement('url', 'http://www.talkphp.com/images/misc/rss.jpg');
//$pTitle = $dom->createElement('title', 'TalkPHP');
//$pLink  = $dom->createElement('link', 'http://www.talkphp.com');
//
//// Append these new elements to the image element
//$pImage->appendChild($pURL);
//$pImage->appendChild($pTitle);
//$pImage->appendChild($pLink);
//
//        $root = $dom->createElement('root');//Creates the root element of the xml file
//
//        foreach($this->arrayObj as $value)
//        {
//            $item = $dom->createElement('items');//Creates the root element of the xml file
//
//            $node=$dom->createElement('title',$value->getTitle());//Create a child node
//            $item->appendChild($node);
//
//            $node=$dom->createElement('description',$value->getIntro());//Create a child node
//            $item->appendChild($node);
//
//            $node=$dom->createElement('pubDate',$value->getPostDate('SHORT'));//Create a child node
//            $item->appendChild($node);
//
//            $node=$dom->createElement('link',$value->getRssUrl($bw->input['module']));//Create a child node
//            $item->appendChild($node);
//
//
//            $root->appendChild($item);
//        }
//        $dom->appendChild($root);//append the root node

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
			$xml .= "\t</item>\n";
		}
		$xml .= "\n</channel>\n</rss>\n";
                if(!file_exists(ROOT_PATH."rss/"))
                {
                    mkdir(ROOT_PATH."rss/", 777);
                }
//		$xml = str_replace($reals, $alias, $xml);
                 $file_title = strtolower(VSFTextCode::removeAccent(str_replace("/", '-', trim($this->cate->title)),'-')). '-' . $this->cate->getId ().".rss";
		
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