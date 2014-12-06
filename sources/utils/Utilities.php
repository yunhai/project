<?php
class Utilities{

	/*
		Lấy thông tin thời tiết từ vnexpress.
		@param $location: địa điểm cần lấy thông tin thời tiết
		@return array.
	*/
	function getWeatherFromVNExpress($location='HCM'){
		global $vsStd;
		$vsStd->requireFile(UTILS_PATH.'class_xml.php');
			
		$myXML = new class_xml();
		$xmlFile = "http://vnexpress.net/ListFile/Weather/{$location}.xml";

		$myXML->xml_parse_document(file_get_contents($xmlFile));
		$array = current($myXML->xml_array);
			
		return $array;
	}



	function getCurrencyFormVietcombank(){
		global $vsStd;
		$vsStd->requireFile(UTILS_PATH.'class_xml.php');
			
		$myXML = new class_xml();
		$xmlFile = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";

		$myXML->xml_parse_document(file_get_contents($xmlFile));
		return current($myXML->xml_array);
	}


	/*
		Lấy thông tin vàng từ vnexpress.
		@return html.
	*/
	function getGoldFormVNExpress(){
		global $vsLang;
		return <<<EOF
				<script type='text/javascript' src='http://vnexpress.net/Service/Gold_Content.js'></script>
				<script type='text/javascript'>
					var goldDiv = "<div class='table_center'> <table width='100%' border='0'><tr>";
					goldDiv+= "<td class='col1'>SBJ</td>";
					goldDiv+= "<td class='col2'>" + vGoldSbjBuy + "</td>";
					goldDiv+= "<td class='col2'>" + vGoldSbjSell + "</td> </tr><tr>";
					
					goldDiv+= "<td class='col1'>SJC</td>";
					goldDiv+= "<td class='col2'>" + vGoldSjcBuy + "</td>";
					goldDiv+= "<td class='col2'>" + vGoldSjcSell + "</td></tr>";
					goldDiv+= "</table></div>";
					
					$('#fragment-10').append(goldDiv);
				</script>
EOF;
	}
	
	
	function getHTMLFromURL($url) {
		return file_get_contents("$url");
	}
	
	function getExchangeRage($moneyCode, $html, $i = 0) {
	
		$i_firstTableTag = stripos ( $html, '<table class="tbl-exch"' );	

		$i_moneyCode = stripos ( $html, $moneyCode, $i_firstTableTag );	

		$i_firstTDTag = stripos ( $html, '<td>', $i_moneyCode + $i );
		$i_secondTDTag = stripos ( $html, '<td>', $i_firstTDTag + $i );
		$i_thirdTDTag = stripos ( $html, '<td>', $i_secondTDTag + $i );
		
		$i_thirdTDCloseTag = stripos ( $html, '</td>', $i_thirdTDTag + $i );

		$rate = substr ( $html, $i_thirdTDTag + 4, $i_thirdTDCloseTag - $i_thirdTDTag );
		if($i==1)$rate = substr ( $html, $i_secondTDTag + 4, $i_thirdTDCloseTag - $i_thirdTDTag );
		$rate = str_replace("</td",'',$rate);
	
		return $rate;
		
	}
	
	function appendOption($moneyCode, $exchangeBuy, $exchangeSell,$exchangeSangpm, $i) {
		global $bw;
		$option = <<<EOF
			<li>
					<img src="{$bw->vars['img_url']}/lang_{$moneyCode}.jpg">
					<p>{$moneyCode}</p>
					<span>{$exchangeSell}</span>
					<div class="clear"></div>
			</li>
EOF;
		return $option;
	
	}
	
	function getTygiaEximbank(){
            global $vsStd,$vsTemplate,$vsLang;
            
		$time = time();
		$array = array('USD','EUR','GBP','AUD','SGD');
		$exchange = $this->getTigia();

                $rates .= <<<EOF
				<div class="tr_rate">
					<table class="chungkhoang">
                                        <thead>
                                            <tr>
                                                <th>{$vsLang->getWords("global_tt_machungkhoang","Mã")}</th>
                                                <th>{$vsLang->getWords("global_tt_muachungkhoang","Mua")}<th>
                                                <th>{$vsLang->getWords("global_tt_banchungkhoang","Bán")}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
EOF;

		foreach($exchange as $obj)
			$rates .= "<tr>
                                    <td>{$obj['exchangeCode']}</td>
                                    <td>{$obj['exchangeBuy']}<td>
                                    <td>{$obj['exchangeSell']}</td>
                                   </tr>";
				
                $rates .= <<<EOF
                            </tbody>
                            </table>
                        </div>
EOF;

		return $rates;
        }
		
	function getTigia() {
		
		$html = $this->getHTMLFromURL ( "http://www.eximbank.com.vn/WebsiteExRate1/exchange_tuoitre.aspx" );	
		
		if(!$html) return 'Đang cập nhật thông tin';
		$array = array('USD','EUR');
		$i = 0;
		
		$doc = new DOMDocument();
		@$doc->loadHTML($html);
		$nodes = $doc->getElementsByTagName('td');
		$nodeListLength =  $nodes->length;
		$result = array();
		
		 for ($i = 0; $i < $nodeListLength; $i ++){
			$node = $nodes->item($i);
			if(i%4 == 0){
				$j++;
			}
			 $arr[$j] = $node->nodeValue;
			$k++;
		}
		
		unset($arr[1]);unset($arr[2]);unset($arr[3]);
		unset($arr[4]);unset($arr[5]);unset($arr[6]);
		unset($arr[7]);
		
		$i=1;
		$j = 0;
		$p = 1;
		foreach($arr as $k=>$v){
			if($v){
				if($p%7 == 0){
					$j++;
					$i = 1;
				}
				$a[$j][$i] = $v;
				$i++;
				$p++;
			}
		}
		
		$array = $a;
		
		$item[1]['name'] 	= $array[0][1];
		$item[1]['real'] 	= $array[0][2];
		$item[1]['virtual'] = $array[0][4];
		$item[1]['sell'] 	= $array[0][6];
		
		unset($array[0]);
		$k=2;
		foreach($array as $its){
			$item[$k]['name'] = $its[2];
			$item[$k]['real'] = $its[3];
			$item[$k]['virtual'] = $its[5];
			$item[$k]['sell'] = $its[7];
			$k++;
		}
		unset($item[12]);

		return  $item;
	}
	
	function getWeather() {
		
		$html = $this->getHTMLFromURL ( 'www.vcb.com.vn' );	
		
		if(!$html) return 'Đang cập nhật thông tin';
		$array = array('USD','EUR');
		$i = 0;
		
		foreach ($array as $value) {
			$options .= $this->appendOption ( $value, $this->getExchangeRage ( $value, $html ), $this->getExchangeRage ( $value, $html,1 ), $this->getExchangeRage ( $value, $html,2 ),$i);
			if($i++ ==1)$i=0;
		}
		return  $options;
	}
	
}
?>