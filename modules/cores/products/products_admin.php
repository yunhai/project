<?php
class products_admin extends ObjectAdmin{
	function __construct(){
            global $vsTemplate,$vsPrint;
		parent::__construct('products', CORE_PATH.'products/', 'products');
		//$vsPrint->addJavaScriptFile("jquery/ui.datepicker");
		//$vsPrint->addCSSFile('ui.datepicker');
   		$this->html = $vsTemplate->load_template('skin_products');
                 
	}
        
function auto_run() {
		global $bw,$search_module,$vsSettings,$vsPrint;
		
	
		switch ($bw->input ['action']) {
			
			case 'visible-checked-obj' :
				$this->checkShowAll(1);
				break;
			
			case 'home-checked-obj' :
				$this->checkShowAll(2);
				break;
			
			case 'hide-checked-obj' :
				$this->checkShowAll(0);
				break;
			case 'hethang-checked-obj' :
				$this->checkShowAll(3);
				break;
			case 'khuyenmai-checked-obj' :
				$this->checkShowAll(4);
				break;
			case 'banchay-checked-obj' :
				$this->checkShowAll(5);
				break;
			case 'display-obj-tab' :
				$this->displayObjTab ();
				break;
			
			case 'display-obj-list' :
				$this->getObjList ( $bw->input [2], $this->model->result ['message'] );
				break;
			
			case 'add-edit-obj-form' :
				$this->addEditObjForm ( $bw->input [2] );
				break;
			
			case 'add-edit-obj-process' :
				$this->addEditObjProcess ();
				break;
			
			case 'change-objlist-bt' :
				$this->model->changeCateList ();
				$this->getObjList ();
				break;
			case 'insertSearch-objlist-bt' :
				$this->model->insertSearch ();	
				$this->getObjList ();
				break;
			case 'delete-obj' :
				$this->deleteObj($bw->input[2]);
				break;
			case 'display_list_news_comments':
				$this->displayListNewsComments($bw->input [2], $this->module->result ['message'] );
				break;
			case 'create_rss_file':
             	$this->createRSS($bw->input[2]);
              	break;
           	case 'updatedata':
             	$this->update();
              	break;
            case 'advance':
					$this->advance();
				break;
			case 'import':
					$this->import();
				break;
			case 'criteria':
					$this->criteria();
				break;
			case 'filter':
					$this->getFilterObj();
				break;
			case 'export':
					$this->export();
				break;
			default :
				$this->loadDefault ();
				break;
		}
	}
	
function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject,$vsFile;
		
                $option['skey'] = $bw->input['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $langObject['itemFormAddButton'];
		$option ['formTitle'] = $langObject['itemFormAdd'];
		if ($objId) {
                        
			$option ['formSubmit'] = $langObject['itemFormEditButton'];
			$option ['formTitle'] = $langObject['itemFormEdit'];
			$obj = $this->model->getObjectById ( $objId ,1);
			
		
			///////////////////////////
			if($obj->getImage())
           		$file.=$obj->getImage().",";
                        
           	if($obj->getFileupload())
             	$file.=$obj->getFileupload().",";
          	$file = trim($file,",");
          	if($file){
            	$vsFile->setCondition("fileId in ({$file})");
               	$option ['file'] =  $vsFile->getObjectsByCondition();
        	}

        	
        	
        	
		} 
		
              
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		$vsStd->requireFile ( JAVASCRIPT_PATH . "/tiny_mce/tinyMCE.php" );
		$editor = new tinyMCE ();
		if($vsSettings->getSystemKey($option['skey'].'_intro_editor', 1, $option['skey'])){
			$editor->setWidth ( '100%' );
			$editor->setHeight ( '150px' );
			$editor->setToolbar ( 'simple' );
			$editor->setTheme ( "advanced" );
			$editor->setInstanceName ( "{$this->tableName}Intro" );
			if($obj->getIntro()){
				$editor->setValue($obj->getIntro());
			}else{
				$val=$vsSettings->getSystemKey($bw->input[0]."_introdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1);
				if(!is_numeric($val)){
					$editor->setValue($vsSettings->getSystemKey($bw->input[0]."_introdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1));
				}else
					 $editor->setValue($obj->getIntro());	
			}
			$obj->setIntro ( $editor->createHtml () );
		}else
			$obj->setIntro ('<textarea name="'.$this->tableName.'Intro" style="width:100%;height:100px;">'. strip_tags($obj->getIntro()) .'</textarea>');
                   
		$editor->setWidth ( '100%' );
		$editor->setHeight ( '350px' );
		$editor->setToolbar ( 'full' );
		$editor->setTheme ( "advanced" );
		$editor->setInstanceName ( "{$this->tableName}Content" );
		if($obj->getContent()){
			$editor->setValue($obj->getContent());
		}else{
			$val=$vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1);
			if(!is_numeric($val)){
				$editor->setValue($vsSettings->getSystemKey($bw->input[0]."_contentdefault{$vsLang->currentLang->getFoldername()}", 0, $bw->input[0], 1, 1));
			}else
				 $editor->setValue($obj->getContent());
				
		}
		$obj->setContent ( $editor->createHtml () );
			
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	
	
/****function addEditObjProcess() {
		global $bw, $vsStd, $vsLang, $vsFile,$DB,$vsSettings,$search_module,$langObject;

		$bw->input ["{$this->tableName}Promo"] = $bw->input ["{$this->tableName}HotPrice"] ? 1:0;		
		
		$bw->input ["{$this->tableName}Status"] = $bw->input ["{$this->tableName}Status"] ? $bw->input ["{$this->tableName}Status"] : 0;
                
		
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
                        
		if ($bw->input ['fileId']){
			$vsFile->setCondition("fileId in ({$bw->input ['fileId']})");
           	$list =  $vsFile->getObjectsByCondition();
           	if($list)
           		foreach($list as $obj){
                	$bw->input [$obj->getField()] = $obj->getId();
               	}
            if($bw->input['txtlink'])
				$bw->input["{$this->tableName}Image"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
		}
		    
		
		
		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
	
			$arrayI =  array("IntroImage"=>$obj->getImage (),
                             "Fileupload"=>$obj->getFileupload (),
                        );
            foreach($arrayI as $key => $val){
            	$vsFile= new files();            
				$imageOld = $val;
             	if($bw->input["delete".$key]){
					if($imageOld) $vsFile->deleteFile($imageOld);
                	if(!$bw->input["{$this->tableName}{$key}"]) $bw->input["{$this->tableName}{$key}"] = 0;
              	}
                if($imageOld && $bw->input[$this->tableName.$key])
                   		$vsFile->deleteFile($imageOld);
         	}         
			
			$objUpdate = $obj;

			
			
			
			
			
			//$objUpdate = $this->model->createBasicObject ();
			$objUpdate->convertToObject ( $bw->input );

			if($vsSettings->getSystemKey($bw->input[0].'_tags',0, $bw->input[0])){
			add tags process
			require_once CORE_PATH.'tags/tags.php';
			$tags=new tags();
			$tags->addTagForContentId($bw->input[0], $this->model->obj->getId(), $bw->input['tags_submit_list']);
			
			}

			$this->model->updateObjectById ( $objUpdate );
			if ($this->model->result ['status']) {
				$alert = $langObject['itemEditSuccess'];
				$javascript = <<<EOF
						<script type='text/javascript'>
							jAlert(
								"{$alert}",
								"{$bw->vars['global_websitename']} Dialog"
							);
						</script>
EOF;
			}
		} else {
            $bw->input["{$this->tableName}PostDate"] = time();
            
                     
			$this->model->obj->convertToObject ( $bw->input );
			
			$this->model->insertObject ( $this->model->obj );
			if ($this->model->result ['status']) {
				$confirmContent = $langObject['itemAddSuccess'] . '\n' . $langObject['itemAddAnother'] ." ?";
				$javascript = <<<EOF
					<script type='text/javascript'>
						jConfirm(
							"{$confirmContent}",
							'{$bw->vars['global_websitename']} Dialog',
							function(r){
								if(r){
									vsf.get("{$bw->input[0]}/add-edit-obj-form/&pageIndex={$bw->input['pageIndex']}&pageCate={$bw->input['pageCate']}",'obj-panel');
								}
							}
						);
					</script>
EOF;
			}
		}
		//if ($imageOld && $bw->input ['fileId']) {
			///$vsFile->deleteFile ( $imageOld );
		//}
		
        //convert to Search
		if (in_array($bw->input['module'], $search_module)){
                    if($bw->input['searchRecord']){
                        $vsStd->requireFile(CORE_PATH."searchs/searchs.php");
                        $search = new searchs();
                        $search->setCondition("searchRecord  = ".$bw->input['searchRecord']);
                        $search->updateObjectByCondition($this->model->obj->convertSearchDB());
                    }
                    elseif(isset ($bw->input['searchRecord'])){
                        $DB->do_insert("search",$this->model->obj->convertSearchDB());
                    }
		}
		      
        //end convert to Search
		$cat = $bw->input ['pageCate'] ? $bw->input ['pageCate'] : $bw->input ['pageCatId'];
		$vsFile->buildCacheFile ( $bw->input ['module'] );
		return $this->output = $javascript . $this->getObjList ();
	}**/
	function export(){
		global $bw, $vsMenu;
		
		if($bw->input['pandog']){
			$begin = $bw->input['begin'];
			$end = $bw->input['end'];
		
			$cond = '';
			if($begin){
				$cond = 'productPostDate > '.$begin;
				if($end) $cond = '('.$cond.' AND productPostDate < '.$end.')';
			}elseif($end){
				$cond = 'productPostDate < '.$end;
			}
			
			$this->module->setCondition($cond);
		}
		
		$fieldignorflag = true;
		foreach($bw->input['fields'] as $fkey=>$fvalue){
			
			$fields[$fkey] = $fkey;
		}
		
		//bat buoc phai co
		$fields['productId'] 		= 'productId';
		$fields['productTitle'] 	= 'productTitle';

		
		
		$fieldStr = implode(',', array_keys($fields));
		
		$this->model->setFieldsString($fieldStr);
		$items = $this->model->getObjectsByCondition();
	
		foreach($fields as $value){
			if($value == 'productCatId'){
				foreach($items as $key=>$obj){
					$cat = $vsMenu->arrayCategory[$obj->getCatId()];
					if($cat) $obj->setCatId($cat->getTitle());
				}
			}
			
			if($value == 'productIntro'){
				foreach($items as $key=>$obj){
					$content = strip_tags($obj->getIntro());
					$obj->setIntro($content);
				}
			}
			if($value == 'productContent'){
				foreach($items as $key=>$obj){
					$content = strip_tags($obj->getContent());
					$obj->setContent($content);
				}
			}
			
			
		}
		
		$fields = $this->sortHeader($fields);
		
		$this->writeToFile($items, $fields);
	}
	
	
	function writeToFile($items = array(), $header = array()){
		global $bw, $vsStd, $vsFile;
		
		$vsStd->requireFile(UTILS_PATH."excelwriter.inc.php");
		
		$time = time();
		$filename = "export_products_".gmdate('dmY', $time)."_".$time.".xls";
		$filepath = UPLOAD_PATH."exports/".$filename;
		$downloadpath = $bw->vars['board_url'].'/uploads/exports/'.$filename;
		$excel = new ExcelWriter($filepath);
		if($excel == false) echo $excel->error;
		chmod($filepath, 0755);
		
		global $vsLang;
		$theader =  $this->getAccess(true);
		
		foreach($header as $k=>$v){
			
			$eheader[$k] = $theader[$v];
		}
			
		$excel->writeLine($eheader, array('text-align'=>'center', 'color'=> 'red', "font-weight"=>"bold"));
        
		$array_aday=array(
							'getPostDate'	=> 'SHORT',
					);
       

		
		if($items){
			$style = array('text-align'=>'center');
			foreach($items as $obj){
				$data = array(); $i = 0;
				
				
				foreach($header as $key =>$value){
						$fn = str_replace('product', 'get', $value);
						
						$data[$i++] = $obj->$fn($array_aday[$fn]);
					
				}
			
				$excel->writeLine($data, $style);
			}
		}
		
		$excel->close();
		
		if (file_exists($filepath)) {
				header ( 'Content-Description: File Transfer' );
				header ( 'Content-Type: application/octet-stream' );
				header ( 'Content-Disposition: attachment; filename = '.$filename );
				header ( 'Content-Transfer-Encoding: binary' );
				header ( 'Expires: 0' );
				header ( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
				header ( 'Pragma: public' );
				header ( 'Content-Length: ' . $vsFile->formatbytes($filepath) );
				ob_clean ();
				flush ();
				readfile ( $downloadpath );
				exit();
			}
	}
	
	function sortHeader($header = array()){
		
		$order = array(
					'productId'		=> 0,
					'productCatId'		=> 1, 
					'productTitle'		=> 2,
					'productPrice'		=> 3,
            		'productHotPrice'		=> 4,
            		'productImage'		=> 5,
            		
            		'productIntro'		=> 6, 
            		
            		'productContent'	=> 7,
            		
            		'productStatus'	=> 8, 
            		'productIndex'		=> 9,
            		'productPostDate'	=> 10,
				);
		
		$return = array(); $i = 100;
		foreach($header as $key=>$value){
			if(key_exists($value, $order))
				$return[$order[$key]] = $value;
			else $return[$i++] = $value;
		}
		
		ksort($return);
		
		return $return;
	}
	
	function import(){
		global $bw,$vsFile,$vsLang, $vsStd;
		
		if(!$bw->input['fileDocumentId']) return $this->output = $vsLang->getWords('error_import_file', '"Không thể import dữ liệu"');
		
		$idFile = $bw->input['fileDocumentId'];
		$file = $vsFile->getObjectById($bw->input['fileDocumentId']);
		
		$arrayTerm = $this->getDTExcel($file);
		
		$data = $this->convertToData($arrayTerm);

		$message = 'Đã xảy ra lỗi trong quá trình import';
		if($data){
			foreach($data['main'] as $key=>$single){
				$id = 0;
				$this->module->singleInsert($single, &$id);
				$idArray[$key] = $id;
			}
			if($idArray){
				
				
				foreach($data['sub'] as $key1=>$value1){
						foreach($value1 as $key2=>$value2){
							if($data['sub'][$key1][$key2]){
								$data['sub'][$key1][$key2]['productId'] = $idArray[$key1];
							}else{
								unset($data['sub'][$key1][$key2]);
							}
						}
					$this->module->multiInsert($data['sub'][$key1]);
				}
			}

			$message = 'import thành công!';
		}
		
		$this->output = $message;
//		$vsFile->deleteFile($idFile);
	}
	function advance(){
		$option['objList'] = $this->getFilterList();
		$this->output = $this->html->advanceTab($option);
	}
	
	function getFilterList(){
		global $bw;
		
		$option['field'] = $this->getProductFields();
		return $this->output = $this->html->filterList($option);
	}
	
	function getProductFields(){
		global $DB, $vsLang;
		
		$DB->query("SHOW COLUMNS FROM vsf_product");
		$access = $this->getAccess();
		
		$field = array();
		$row = $DB->fetch_row();
                
		while($row){
			if(key_exists($row['Field'], $access))
				$field[$row['Field']] = $access[$row['Field']];
			
			$row = $DB->fetch_row();
		}

		
		return $field;
	}
	
	function getAccess(){
            global $vsLang;
            $access = array(
					'productId'			=> $vsLang->getWords('export_productId','Mã'),
					'productCatId'		=> $vsLang->getWords('export_productCatId','Danh mục'), 
					'productTitle'		=> $vsLang->getWords('export_productTitle','Tiêu đề'), 
					'productPrice'		=> $vsLang->getWords('export_productPrice','Giá'),
            		'productCode'		=> $vsLang->getWords('obj_macode', 'Mã sản phẩm'),
            		'productImage'		=> $vsLang->getWords('obj_hinh', 'Hình'),
            		'productHotPrice'	=> $vsLang->getWords('obj_giakhuyenmai', 'Giá khuyến mãi'),
            		'productIntro'		=> $vsLang->getWords('export_intro', 'Mô tả'), 
            		'productContent'	=> $vsLang->getWords('export_content', 'Nội dung'),
            		'productStatus'		=> $vsLang->getWords('export_status', 'Trạng thái'), 
            		'productIndex'		=> $vsLang->getWords('export_index', 'STT'),
            		'productPostDate'	=> $vsLang->getWords('export_postdate', 'Ngày đăng'),
				);
            return $access;
        }
	function getProductCatId($name, $type){
		global $vsMenu;
	  	$temp = $vsMenu->getCategoryGroup($type);
	  
	  	if($temp){
	   		$cats = $temp->getChildren();
	   		foreach($cats as $key => $value){
	    		if(trim(strtolower($name)) == trim(strtolower($value->getTitle()))) return $key;
	    		foreach($value->getChildren() as $key1 => $value1){
	     			if(trim(strtolower($name)) == trim(strtolower($value1->getTitle()))){
	      			return $key1;
	     			}
	    		}
	    	if(trim(strtolower(VSFTextCode::removeAccent($value->getTitle()))) == 'loai bat dong san khac') $otherId = $key;
	   		}
	  	}
	  	return $otherId;
	}
 	
	function update(){
		global $bw,$vsFile,$vsLang, $vsStd;
		
		if(!$bw->input['fileDocumentId']) return $this->output = $vsLang->getWords('error_import_file', '"Không th? import d? li?u"');
		
		$idFile = $bw->input['fileDocumentId'];
		$file = $vsFile->getObjectById($bw->input['fileDocumentId']);
		
		
		$arrayTerm = $this->getDTExcel($file);
	
		$data = $this->update_convertToData($arrayTerm);

		$message = 'Ðã x?y ra l?i trong quá trình import';
		if($data){
			$flag = false;
			
			foreach($data['main'] as $key=>$single){
				if(is_numeric($key)){
					$this->module->obj = new Product();
					$this->module->obj->convertToObject($single);
	
					$this->module->updateObjectById();
					$idArray[$key] = $key;
					$flag = true;
				}
			}
			
			
			if($flag)
				$message = $vsLang->getWords('product_update_data_ok', 'c?p nh?t d? li?u thành công!');
		}
		$this->output = $message;
//		$vsFile->deleteFile($idFile);
	}
	
	
	function getDTExcel($file="", $sheet = 0){
		
		if($file->getPathView(false)){
			require_once(UTILS_PATH."excel_reader2_patch_applied.php");
			
			$data = new Spreadsheet_Excel_Reader($file->getPathView(false), true, "UTF-8");
			$temp = $data->getRawExcelData($sheet);
			
			return $temp;
		}
		return array();
	}
	
	
	function update_convertToData($rawdata = array()){
		global $vsSettings, $vsStd;
		
		$i = 1;
		while($i < 2) unset($rawdata[$i++]);
		
		
		$data = array();
		$datetime = new VSFDateTime();
		
		$prices = $this->module->getUnits();
//		$vsStd->requireFile(CORE_PATH.'roads/roads.php');
//		$roads = new roads();

		foreach($rawdata as $keyraw=>$value ){
			if(!$value[1]) continue;
			$key = $value[1];
			$data[$key]['productId'] = $value[1];
			$data[$key]['productCatId'] = $this->getProductCatId($value[2], 'products');//
			$data[$key]['productTitle'] = $value[3];
			$data[$key]['productPrice'] = $value[4];
			
			$data[$key]['productIntro'] = $value[5];
			$data[$key]['productContent'] = $value[6];

			$data[$key]['productStatus'] = $value[7];
			$data[$key]['productIndex'] = $value[8];
			
			$datetimeArray  	= explode("/", $value[9]);
			$datetime->day 		= $datetimeArray[0];
			$datetime->month 	= $datetimeArray[1];
			$datetime->year 	= $datetimeArray[2];
			$data[$key]['productPostDate'] = $datetime->TimeToInt();
			
			
//			$arrayinfo = array(
//				'userFullName' 	=> $value[43],
//				'userAddress' 	=> $value[44],
//				'userPhone' 	=> $value[45],
//				'userChusohuu'  => $value[46],
//				'userCMND'  	=> $value[47],
//				'userNgaycap' 	=> $value[48],
//				'userNoicap'  	=> $value[49],
//				'userEmail'  	=> $value[50],
//			);
//			$data[$key]['userInfo'] = serialize($arrayinfo);
//			$data[$key]['productRoadId'] = $roads->convertToRoadId($value[12]);
//////
			//$utils[$key] = $this->update_convertToUtils($key, $value);
		}
		
		$return['main'] = $data;
		
		
		return $return;
	}
}

?>