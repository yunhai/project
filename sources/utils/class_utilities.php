<?php
class class_ultilities{
	function __construct(){
		global $vsStd, $vsSkin;

	}



	/* For Weather and Currency Only*/
	function getWeatherFromVNExpress($array = array()){
		global $vsStd, $DB;

		$query = "select count(*) as count from vsf_util_weather where weatherGetTime > ". (time() - 43200) ."";
		$DB->cur_query = $query;
		$DB->simple_exec();
		$record = $DB->fetch_row();


		if($record['count'] >= count($array)){
			$query = "select * from vsf_util_weather where weatherGetTime > ". (time() - 43200) ."";
			$DB->cur_query = $query;
			$DB->simple_exec();
			$record = $DB->fetch_row();
			$weather = array();
			while($record){
				$weather[$record['weatherCityCode']]['weatherCityCode'] = $record['weatherCityCode'];
				$weather[$record['weatherCityCode']]['weatherCity'] = $record['weatherCity'];
		  		$weather[$record['weatherCityCode']]['weatherTemp'] = $record['weatherTemp'];
		  		$weather[$record['weatherCityCode']]['weatherImage'] = $record['weatherImage'];
                                $weather[$record['weatherCityCode']]['weatherDes'] = $record['weatherDesc'];
				$record = $DB->fetch_row();
			}
			return $weather;
		}
		if(!$record['count']){
			$query = "TRUNCATE TABLE vsf_util_weather ";
			$DB->query($query);
		}

		$vsStd->requireFile(UTILS_PATH.'class_xml.php');
		$time = time();
		$return = array();
		foreach($array as $location){
			$return[$location['city']] = $this->mainWeatherFromVNExpress($location['city'], $time, $location['name']);
		}
		return $return;
	}

	function mainWeatherFromVNExpress($location='HCM', $time=0, $name=""){
		global $vsStd, $DB;
		$myXML = new class_xml();
		$xmlFile = "http://vnexpress.net/ListFile/Weather/{$location}.xml";

		$content = @file_get_contents($xmlFile);
		if($content){
		$myXML->xml_parse_document($content);
		$array = current($myXML->xml_array);

		$return['weatherCityCode'] = $location;
		$return['weatherCity'] = $name;
  		$return['weatherTemp'] = substr($array['AdImg1']['VALUE'],0,1). substr($array['AdImg2']['VALUE'],0,1);
  		$return['weatherImage'] = "http://vnexpress.net/Images/Weather/".trim($array['AdImg']['VALUE']);
		$return['weatherDesc'] = trim($array['Weather']['VALUE']);
		$return['weatherGetTime'] = $time;

		$DB->do_insert('util_weather',$return);


		return $return;
		}
	}

	function getCurrencyFormVietcombank($array= array(), $time=0){
		global $vsStd,$DB;

		$query = "select count(*) as count from vsf_util_exchange where exchangeGetTime > ". (time() - 43200) ."";
		$DB->cur_query = $query;
		$DB->simple_exec();
		$record = $DB->fetch_row();
              
		if($record['count'] >= count($array)){
			$query = "select * from vsf_util_exchange where exchangeGetTime > ". (time() - 43200) ."";
			$DB->cur_query = $query;
			$DB->simple_exec();
			$record = $DB->fetch_row();
			while($record){
				$exchange[$record['exchangeCode']]['exchangeCode'] = $record['exchangeCode'];
		  		$exchange[$record['exchangeCode']]['exchangeName'] = $record['exchangeName'];
		  		$exchange[$record['exchangeCode']]['exchangeBuy'] = $record['exchangeBuy'];
				$exchange[$record['exchangeCode']]['exchangeTranfer'] = $record['exchangeTranfer'];
				$exchange[$record['exchangeCode']]['exchangeSell'] = $record['exchangeSell'];

				$record = $DB->fetch_row();
			}
			return $exchange;
		}
  
		if(!$record['count']){
			$query = "TRUNCATE TABLE vsf_util_exchange ";
			$DB->query($query);
		}
//echo "asdad";exit;   
		$vsStd->requireFile(UTILS_PATH.'class_xml.php');
		
		$myXML = new class_xml();
		
		$xmlFile = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";

		$myXML->xml_parse_document(file_get_contents($xmlFile));
		$temp = current($myXML->xml_array);

  		foreach($temp['Exrate'] as $key=>$currency){
  			$return = array();
			$return['exchangeCode'] = $currency['ATTRIBUTES']['CurrencyCode'];
	  		$return['exchangeName'] = $currency['ATTRIBUTES']['CurrencyName'];
	  		$return['exchangeBuy'] = $currency['ATTRIBUTES']['Buy'];
			$return['exchangeTranfer'] = $currency['ATTRIBUTES']['Transfer'];
			$return['exchangeSell'] = $currency['ATTRIBUTES']['Sell'];
			$return['exchangeGetTime'] = $time;
			$DB->do_insert('util_exchange',$return);

			$exchange[$return['exchangeCode']] = $return;
  		}
		return $exchange;
	}

	function getCurrencyFormVietcombank2(){
		global $vsStd;
		$vsStd->requireFile(UTILS_PATH.'class_xml.php');

		$myXML = new class_xml();
		$xmlFile = "http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx";

		$myXML->xml_parse_document(file_get_contents($xmlFile));
		$array = current($myXML->xml_array);
		return $array;

	}

	function getCurrencyFromGoogleCode($option){
		$script = 'up_fromcur='.$option['from'].'&amp;up_tocur='.$option['to'].'&amp;up_minimsg1=0&amp;synd=open&amp;';
		$script.= 'w='.$option['width'].'&amp;h='.$option['height'].'&amp;title='.$option['title'].'&amp;lang=all&amp;country=ALL&amp;border=%23ffffff%7C3px%2C1px+solid+%23999999&amp;';
		return <<<EOF
				<script src="http://www.gmodules.com/ig/ifr?url=http://www.pixelmedia.nl/gmodules/ucc.xml&amp;{$script}output=js"></script>
EOF;
	}

	function getCurrencyFromThanhNien(){
		$htmlFile = './docs/thanhnien.currency.html';

		if(!file_exists($htmlFile)){
			if(fopen($htmlFile, "w")){
				$current = (file_get_contents("http://www.thanhnien.com.vn/_layouts/NgoaiTe.aspx"));
				file_put_contents($htmlFile, $current);
			}
			else return false;
		}

		$currencyContent = file_get_contents($htmlFile);

		$begin = strpos($currencyContent,'<div id="PgTable" class="pageview">');
		$end   = strpos($currencyContent,'<div id="PgChart" class="pageview" style="display:none;">');
		$currencyContent = substr($currencyContent, $begin, $end-$begin);

		return $this->html->currencyFromThanhNienHTML($currencyContent);
	}

	function getCurrencyFromVNExpress(){
		return $this->html->currencyFromVNExpressHTML();
	}




	function getGoldFormVNExpress(){
		return $this->html->goldFromVNExpressHTML();
	}

	function getGoldFormThanhNien(){
		$htmlFile = './docs/thanhnien.gold.html';

		if(!file_exists($htmlFile)){
			if(fopen($htmlFile, "w")){
				$current = (file_get_contents("http://www.thanhnien.com.vn/_layouts/giavang.aspx"));
				file_put_contents($htmlFile, $current);
			}
			else return false;
		}

		$currencyContent = file_get_contents($htmlFile);
		return $this->html->goldFromThanhNienHTML($currencyContent);

	}
	/* For Weather and Currency Only*/




}
?>