<?php

class VSFTextCode {
	var $convmap = array();
	
	function textcode() {
		$this->convmap = array(
			0xe1,0xe1,0x0,0xe1,0xc1,0xc1,0x0,0xc1,0xe0,0xe0,0x0,0xe0,
			0xc0,0xc0,0x0,0xc0,0x1ea3,0x1ea3,0x0,0x1ea3,0x1ea2,0x1ea2,0x0,0x1ea2,
			0xe3,0xe3,0x0,0xe3,0xc3,0xc3,0x0,0xc3,0x1ea1,0x1ea1,0x0,0x1ea1,
			0x1ea0,0x1ea0,0x0,0x1ea0,0x103,0x103,0x0,0x103,0x102,0x102,0x0,0x102,
			0x1eaf,0x1eaf,0x0,0x1eaf,0x1eae,0x1eae,0x0,0x1eae,0x1eb1,0x1eb1,0x0,0x1eb1,
			0x1eb0,0x1eb0,0x0,0x1eb0,0x1eb3,0x1eb3,0x0,0x1eb3,0x1eb2,0x1eb2,0x0,0x1eb2,
			0x1eb5,0x1eb5,0x0,0x1eb5,0x1eb4,0x1eb4,0x0,0x1eb4,0x1eb7,0x1eb7,0x0,0x1eb7,
			0x1eb6,0x1eb6,0x0,0x1eb6,0xe2,0xe2,0x0,0xe2,0xc2,0xc2,0x0,0xc2,
			0x1ea5,0x1ea5,0x0,0x1ea5,0x1ea4,0x1ea4,0x0,0x1ea4,0x1ea7,0x1ea7,0x0,0x1ea7,
			0x1ea6,0x1ea6,0x0,0x1ea6,0x1ea9,0x1ea9,0x0,0x1ea9,0x1ea8,0x1ea8,0x0,0x1ea8,
			0x1eab,0x1eab,0x0,0x1eab,0x1eaa,0x1eaa,0x0,0x1eaa,0x1ead,0x1ead,0x0,0x1ead,
			0x1eac,0x1eac,0x0,0x1eac,0xe9,0xe9,0x0,0xe9,0xc9,0xc9,0x0,0xc9,
			0xe8,0xe8,0x0,0xe8,0xc8,0xc8,0x0,0xc8,0x1ebb,0x1ebb,0x0,0x1ebb,
			0x1eba,0x1eba,0x0,0x1eba,0x1ebd,0x1ebd,0x0,0x1ebd,0x1ebc,0x1ebc,0x0,0x1ebc,
			0x1eb9,0x1eb9,0x0,0x1eb9,0x1eb8,0x1eb8,0x0,0x1eb8,0xea,0xea,0x0,0xea,
			0xca,0xca,0x0,0xca,0x1ebf,0x1ebf,0x0,0x1ebf,0x1ebe,0x1ebe,0x0,0x1ebe,
			0x1ec1,0x1ec1,0x0,0x1ec1,0x1ec0,0x1ec0,0x0,0x1ec0,0x1ec3,0x1ec3,0x0,0x1ec3,
			0x1ec2,0x1ec2,0x0,0x1ec2,0x1ec5,0x1ec5,0x0,0x1ec5,0x1ec4,0x1ec4,0x0,0x1ec4,
			0x1ec7,0x1ec7,0x0,0x1ec7,0x1ec6,0x1ec6,0x0,0x1ec6,0xed,0xed,0x0,0xed,
			0xcd,0xcd,0x0,0xcd,0xec,0xec,0x0,0xec,0xcc,0xcc,0x0,0xcc,
			0x1ec9,0x1ec9,0x0,0x1ec9,0x1ec8,0x1ec8,0x0,0x1ec8,0x128,0x128,0x0,0x128,
			0x129,0x129,0x0,0x129,0x1ecb,0x1ecb,0x0,0x1ecb,0x1eca,0x1eca,0x0,0x1eca,
			0xf3,0xf3,0x0,0xf3,0xd3,0xd3,0x0,0xd3,0xf2,0xf2,0x0,0xf2,
			0xd2,0xd2,0x0,0xd2,0x1ecf,0x1ecf,0x0,0x1ecf,0x1ece,0x1ece,0x0,0x1ece,
			0xf5,0xf5,0x0,0xf5,0xd5,0xd5,0x0,0xd5,0x1ecd,0x1ecd,0x0,0x1ecd,
			0x1ecc,0x1ecc,0x0,0x1ecc,0x1a1,0x1a1,0x0,0x1a1,0x1a0,0x1a0,0x0,0x1a0,
			0x1edb,0x1edb,0x0,0x1edb,0x1eda,0x1eda,0x0,0x1eda,0x1edd,0x1edd,0x0,0x1edd,
			0x1edc,0x1edc,0x0,0x1edc,0x1edf,0x1edf,0x0,0x1edf,0x1ede,0x1ede,0x0,0x1ede,
			0x1ee1,0x1ee1,0x0,0x1ee1,0x1ee0,0x1ee0,0x0,0x1ee0,0x1ee3,0x1ee3,0x0,0x1ee3,
			0x1ee2,0x1ee2,0x0,0x1ee2,0xf4,0xf4,0x0,0xf4,0xd4,0xd4,0x0,0xd4,
			0x1ed1,0x1ed1,0x0,0x1ed1,0x1ed0,0x1ed0,0x0,0x1ed0,0x1ed3,0x1ed3,0x0,0x1ed3,
			0x1ed2,0x1ed2,0x0,0x1ed2,0x1ed5,0x1ed5,0x0,0x1ed5,0x1ed4,0x1ed4,0x0,0x1ed4,
			0x1ed7,0x1ed7,0x0,0x1ed7,0x1ed6,0x1ed6,0x0,0x1ed6,0x1ed9,0x1ed9,0x0,0x1ed9,
			0x1ed8,0x1ed8,0x0,0x1ed8,0xfa,0xfa,0x0,0xfa,0xda,0xda,0x0,0xda,
			0xf9,0xf9,0x0,0xf9,0xd9,0xd9,0x0,0xd9,0x1ee7,0x1ee7,0x0,0x1ee7,
			0x1ee6,0x1ee6,0x0,0x1ee6,0x169,0x169,0x0,0x169,0x168,0x168,0x0,0x168,
			0x1ee5,0x1ee5,0x0,0x1ee5,0x1ee4,0x1ee4,0x0,0x1ee4,0x1b0,0x1b0,0x0,0x1b0,
			0x1af,0x1af,0x0,0x1af,0x1ee9,0x1ee9,0x0,0x1ee9,0x1ee8,0x1ee8,0x0,0x1ee8,
			0x1eeb,0x1eeb,0x0,0x1eeb,0x1eea,0x1eea,0x0,0x1eea,0x1eed,0x1eed,0x0,0x1eed,
			0x1eec,0x1eec,0x0,0x1eec,0x1eef,0x1eef,0x0,0x1eef,0x1eee,0x1eee,0x0,0x1eee,
			0x1ef1,0x1ef1,0x0,0x1ef1,0x1ef0,0x1ef0,0x0,0x1ef0,0xfd,0xfd,0x0,0xfd,
			0xdd,0xdd,0x0,0xdd,0x1ef3,0x1ef3,0x0,0x1ef3,0x1ef2,0x1ef2,0x0,0x1ef2,
			0x1ef7,0x1ef7,0x0,0x1ef7,0x1ef6,0x1ef6,0x0,0x1ef6,0x1ef9,0x1ef9,0x0,0x1ef9,
			0x1ef8,0x1ef8,0x0,0x1ef8,0x1ef5,0x1ef5,0x0,0x1ef5,0x1ef4,0x1ef4,0x0,0x1ef4,
			0x111,0x111,0x0,0x111,0x110,0x110,0x0,0x110,
		);
	}
	
	static function removeAccent($strAccent = "", $sepchar = "",$remove_special=true) {
		
		//Charachters must be in ASCII and certain ones aint allowed
		$text = html_entity_decode ( $strAccent );
		$specialchar = ", . ? : ! < > & * ^ % $ # @ ; ' ( ) { } [ ] + ~ = - 39 /";
		$specialchar .= "&acute; &grave; &circ; &tilde; &cedil; &ring; &uml; &amp; &quot;";
		$specialcharArr = explode ( " ", $specialchar );
		$text = str_replace ( $specialcharArr, " ", $text );
		$text = preg_replace ( "/(ä|à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $text );
		$text = str_replace ( "ç", "c", $text );
		$text = preg_replace ( "/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $text );
		$text = preg_replace ( "/(ì|í|î|ị|ỉ|ĩ)/", 'i', $text );
		$text = preg_replace ( "/(ö|ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $text );
		$text = preg_replace ( "/(ü|ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $text );
		$text = preg_replace ( "/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $text );
		$text = preg_replace ( "/(đ)/", 'd', $text );
		//CHU HOA
		$text = preg_replace ( "/(Ä|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $text );
		$text = str_replace ( "Ç", "C", $text );
		$text = preg_replace ( "/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $text );
		$text = preg_replace ( "/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $text );
		$text = preg_replace ( "/(Ö|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $text );
		$text = preg_replace ( "/(Ü|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $text );
		$text = preg_replace ( "/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $text );
		$text = preg_replace ( "/(Đ)/", 'D', $text );
		//Special string
		$text = preg_replace ( "/( |!|\"|#|$|%|\||')/", '-', $text );
		$text = preg_replace ( "/(̀|́|̉|$|>)/", '', $text );
		$text = preg_replace ( "'<[\/\!]*?[^<>]*?>'si", "", $text );
		
		$text = str_replace ( " / ", "-", $text );
		$text = str_replace ( "/", "-", $text );
		$text = str_replace ( " - ", "-", $text );
		$text = str_replace ( "_", "-", $text );
		$text = str_replace ( " ", "-", $text );
		$text = str_replace ( "ß", "ss", $text );
		$text = str_replace ( "&", "", $text );
		$text = str_replace ( "%", "", $text );
		$text = preg_replace ( "[^A-Za-z0-9-]", "", $text );
		
		$text = str_replace ( array("----","-–-", " -- ","--"), "-", $text );
		
		$text = trim ( $text, '-' );
		$text = str_replace ( "-", $sepchar, $text );
		$text = str_replace ( $sepchar . $sepchar, $sepchar, $text );
		
		
			
		return $text;
	}
	
	function uniToDecimal($str) {
		return mb_encode_numericentity($str, $this->convmap, "UTF-8");
	}
	
	function decimalToUni($str) {
		return mb_decode_numericentity($str, $this->convmap, "UTF-8");
	}
	
	function cutString($string = "", $num = 20){	
	   if(mb_strlen($string,"UTF-8") > $num)
	    {
	    	$result = mb_substr($string,0,$num+1,"UTF-8"); //cut string with limited number
	    	$position = mb_strrpos($result," ",null,"UTF-8"); //find position of last space
	    	if($position)
	    		$result = mb_substr($result,0,$position,"UTF-8"); //cut string again at last space if there are space in the result above    	
	    	$result .= ' ...';
	    }
	    else {
	    	$result = $string;    	
	    }    
	    return $result;
	}
	
	/*-------------------------------------------------------------------------*/
	//
	// Create a random 8 character password 
	//
	/*-------------------------------------------------------------------------*/
	
	function make_password()
	{
		$pass = "";
		$chars = array(
			"1","2","3","4","5","6","7","8","9","0",
			"a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J",
			"k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T",
			"u","U","v","V","w","W","x","X","y","Y","z","Z");
	
		$count = count($chars) - 1;
	
		srand((double)microtime()*1000000);

		for($i = 0; $i < 8; $i++)
		{
			$pass .= $chars[rand(0, $count)];
		}
	
		return($pass);
	}
	
	/*-------------------------------------------------------------------------*/
    // text_tidy:
    // Takes raw text from the DB and makes it all nice and pretty - which also
    // parses un-HTML'd characters. Use this with caution!         
    /*-------------------------------------------------------------------------*/
    
    function text_tidy($txt = "") {
    
    	$trans = get_html_translation_table(HTML_ENTITIES);
    	$trans = array_flip($trans);
    	
    	$txt = strtr( $txt, $trans );
    	
    	$txt = preg_replace( "/\s{2}/" , "&nbsp; "      , $txt );
    	$txt = preg_replace( "/\r/"    , "\n"           , $txt );
    	$txt = preg_replace( "/\t/"    , "&nbsp;&nbsp;" , $txt );
    	//$txt = preg_replace( "/\\n/"   , "&#92;n"       , $txt );
    	
    	return $txt;
    	
    }
	function htmlRemove($text, $htmlRemove = array()) {
		$tags = array ("<!DOCTYPE>", "<a>", "<abbr>", "<acronym>", "<address>", "<applet>", "<area>", "<b>", "<base>", "<basefont>", "<bdo>", "<big>", "<blockquote>", "<body>", "<br>", "<button>", "<caption>", "<center>", "<cite>", "<code>", "<col>", "<colgroup>", "<dd>", "<del>", "<dfn>", "<dir>", "<div>", "<dl>", "<dt>", "<em>", "<fieldset>", "<font>", "<form>", "<frame>", "<frameset>", "<h1>", "<h2>", "<h3>", "<h4>", "<h5>", "<h6>", "<head>", "<hr>", "<html>", "<i>", "<iframe>", "<img>", "<input>", "<ins>", "<isindex>", "<kbd>", "<label>", "<legend>", "<li>", "<link>", "<map>", "<menu>", "<meta>", "<noframes>", "<noscript>", "<object>", "<ol>", "<optgroup>", "<option>", "<p>", "<param>", "<pre>", "<q>", "<s>", "<samp>", "<script>", "<select>", "<small>", "<span>", "<strike>", "<strong>", "<style>", "<sub>", "<sup>", "<table>", "<tbody>", "<td>", "<textarea>", "<tfoot>", "<th>", "<thead>", "<title>", "<tr>", "<tt>", "<u>", "<ul>", "<var>", "<xmp>" );
		if (is_array ( $htmlRemove )) {
			foreach ( $htmlRemove as $value ) {
				$mix = array_search ( strtolower($value), $tags );
				if (! ($mix === FALSE)) {
					unset ( $tags [$mix] );
				}
			}
		
		}
		return strip_tags ( $text, implode ( "", $tags ) );
	}
	function FilterUrl($content) {
//	    return preg_replace_callback("/\<a href=['\"](.+?)[\"'].*\>(.+?)\<\/a\>/si", array("VSFTextCode",'my_nofollow_callback'), $content);
	    return preg_replace_callback("/<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>(.*)<\/a>/siU", array("VSFTextCode",'my_nofollow_callback'), $content);
	    
	}

        function removeTags( $text )
    {
    $text = preg_replace(
        array(
          // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu',
          // Add line breaks before and after blocks
            '@</?((address)|(blockquote)|(center)|(del))@iu',
            '@</?((div)|(h[1-9])|(ins)|(isindex)|(p)|(pre))@iu',
            '@</?((dir)|(dl)|(dt)|(dd)|(li)|(menu)|(ol)|(ul))@iu',
            '@</?((table)|(th)|(td)|(caption))@iu',
            '@</?((form)|(button)|(fieldset)|(legend)|(input))@iu',
            '@</?((label)|(select)|(optgroup)|(option)|(textarea))@iu',
            '@</?((frameset)|(frame)|(iframe))@iu',
        ),
        array(
            ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ',
            "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0", "\n\$0",
            "\n\$0", "\n\$0",
        ),
        $text );
    return strip_tags( $text );
}

	function my_nofollow_callback($matches) {
		static $linklist=NULL;
		//0 full link
		//1 quote
		//2 href
		//3 text link
		if($linklist===NULL){
			$linklist=array();
			$xmlDoc = new DOMDocument ();
			$xmlDoc->load ( UTILS_PATH . "domain_filter.xml" );
			$x = $xmlDoc->documentElement;
			foreach ($x->childNodes  as $value) {
				if($value->nodeName!="#text"){
					$linklist[]=array($value->nodeName,$value->nodeValue);
				} 
			}
		}
		foreach ($linklist as $item) {
			$link=$item[1];
			$index=$item[0];
			$link = preg_quote ( $link, '/' );
			$link = str_replace ( "\*", "(.*?)", $link );
			$tmp=$matches[2];
			if (preg_match ( '/' . $link . '/i', $tmp )) {
				if($index=="blacklink"){
					$matches[2]="http://*****";
					$rel[]="nofollow";
					$title="Black link! contact admin@vinabooking.vn";
				}
				if($index=="viplink"){
					$color="color:#ff0000 !important;";
					$rel[]="follow";
				}
				if($index=="followlink"){
					$rel[]="follow";
				}
			}
		}
		if(count($rel))
		$_rel=implode(",",$rel);
		else $_rel="nofollow"; 
		if(!$title)
		$title=strip_tags("Xem chi tiết {$matches[3]}");
		return "<a href='{$matches[2]}' style='$color' rel='$_rel' title='$title'  >{$matches[3]}</a>";
		
	}
	static function buildFullTextSearch($text){
//			require_once CORE_PATH.'hotels/searchkeys.php';
//			$searchKey = new searchkeys();
			$regexp=VSFTextCode::removeAccent($text,' ');
			//$regexp=$searchKey->buildSearchKey($regexp);
			$regexp=preg_replace("/\s+$/","",$regexp);
			$regexp=preg_replace("/^\s+/","",$regexp);
			$regexp=preg_replace("/\s+/"," ",$regexp);
			$arr=array();
			$arr=explode(" ",$regexp);
			$tmp="";
			if(count($arr)){
				$tmpkey=$arr[0];
					while(strlen($tmpkey)<4) $tmpkey.='0';
				$val="(>(>".$tmpkey." <".$arr[0]."*) ";
				$close=")";
				$tmp.=$tmpkey." ";
				for ($i=1;$i<count($arr);$i++) {
					$tmpkey=$arr[$i];
					while(strlen($tmpkey)<4) $tmpkey.='0';
					$tmp.=$tmpkey." ";
					$val.=" <(>(>".$tmpkey." <".$arr[$i]."*)";
					$close.=" )";
				}
			}
			return ">\"$tmp\" <".$val.$close ."IN BOOLEAN MODE";
	}
	static function strimText($text,$forfulltext=true) {
		//require_once UTILS_PATH . 'TextCode.class.php';
		
//		$text = preg_replace ( '/^\s+|\s+$/i', "", $text );
//		$text = preg_replace ( '/\s+/i', " ", $text );
		$text = strtolower ( VSFTextCode::removeAccent ( $text, " " ) );
		$text=explode(" ", $text);
		foreach ($text as $index => $value) {
			while (strlen($text[$index])<4) $text[$index].="0";
		}
		$text=implode(" ", $text);
		$text = strtolower ( VSFTextCode::removeAccent ( $text, " " ) );
		return $text;
	}
	function getIdBySlug($slug,$space="-",$extension="html"){
			if($extension)
			$slug=preg_replace("/\.{$extension}$/i","",rtrim( $slug));
			$query = explode ( $space, $slug );
			
			return intval ( $query [count ( $query ) - 1] );
	}
	
}