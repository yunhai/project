<?php
class pcontacts_admin extends ObjectAdmin{
	public function __construct(){
            global $vsTemplate;
		parent::__construct('pcontacts', CORE_PATH.'pcontacts/', 'pcontacts');
                $this->html = $vsTemplate->load_template('skin_pcontacts');
	}
	function loadDefault() {
		global $vsPrint,$vsSettings,$bw;
		
		$script = '<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>';
		$vsPrint->addJavaScriptFile ( "tiny_mce/tiny_mce" );
		
		$vsPrint->addJavaScriptString ( 'init_tab', '
			$(document).ready(function(){
    			$("#page_tabs").tabs({
    				cache: false
    			});
  			});
		' );
		
		$this->output = $this->html->managerObjHtml().$script;
	}
	
function addEditObjForm($objId = 0, $option = array()) {
		global $vsLang, $vsStd, $bw, $vsPrint,$vsSettings,$search_module,$langObject;
		

		$recipient = array(
						1=>array('group'=>'','email'=>''),
						2=>array('group'=>'','email'=>''),
						3=>array('group'=>'','email'=>'')
					);
		$option['skey'] = $bw->input['module'];
		$obj = $this->model->createBasicObject ();
		$option ['formSubmit'] = $langObject['itemFormAddButton'];
		$option ['formTitle'] = $langObject['itemFormAdd'];
		if ($objId) {
			$option ['formSubmit'] = $langObject['itemFormEditButton'];
			$option ['formTitle'] = $langObject['itemFormEdit'];
			$obj = $this->model->getObjectById($objId, 1);
			foreach(unserialize($obj->getEmail()) as $key => $element){
				$recipient[$key] = $element;
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
		$editor->setValue ( $obj->getIntro () );
		$obj->setIntro ( $editor->createHtml () );
                }else
			$obj->setIntro ('<textarea name="'.$this->tableName.'Intro" style="width:100%;height:100px;">'. strip_tags($obj->getIntro()) .'</textarea>');
                   
		$editor = new tinyMCE ();
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
			}
		}
		$obj->setContent ( $editor->createHtml () );
		$obj->recipient = $recipient;
		return $this->output = $this->html->addEditObjForm ( $obj, $option );
	}
	
	function addEditObjProcess() {
		global $bw, $vsStd, $vsLang, $vsFile,$DB,$vsSettings,$search_module,$langObject;
	
		$bw->input ["{$this->tableName}Status"] = $bw->input ["{$this->tableName}Status"] ? $bw->input ["{$this->tableName}Status"] : 0;
                
		
		if (! $bw->input ["{$this->tableName}CatId"])
			$bw->input ["{$this->tableName}CatId"] = $this->model->getCategories ()->getId ();
                        
		if ($bw->input ['fileId'])
			$bw->input ["{$this->tableName}Image"] = $bw->input ['fileId'];
                elseif($bw->input['txtlink'])
			$bw->input["{$this->tableName}Image"]=$vsFile->copyFile($bw->input["txtlink"],$bw->input[0]);
		
		$receipt = array();
		foreach($bw->input['email'] as $key=>$email){
			if($email && $bw->input['group'][$key]){
				$receipt[$key]['group'] = $bw->input['group'][$key];
				$receipt[$key]['email'] = $email;
			}
		}
		$bw->input['pcontactEmail'] = serialize($receipt);
		// If there is Object Id passed, processing updating Object
		if ($bw->input ["{$this->tableName}Id"]) {
			$obj = $this->model->getObjectById ( $bw->input ["{$this->tableName}Id"] );
                        
			$imageOld = $obj->getImage ();
          	if($bw->input['deleteImage']){
				$imageOld = $obj->getImage();
				if($imageOld) $vsFile->deleteFile($imageOld);
				if(!$bw->input["{$this->tableName}Image"]) $bw->input["{$this->tableName}Image"] = 0;
			}
		
			if($vsSettings->getSystemKey('pcontacts_googleposition',0, $bw->input['module'])&&($bw->input ["{$this->tableName}Longitude"]==0 && $bw->input ["{$this->tableName}Latitude"]==0))  
				if(($bw->input["{$this->tableName}Address"]!= $obj->getAddress()) ){
				$vsStd->requireFile(UTILS_PATH."googleMap.class.php");
				$googleMap = new googleMap();
				$address = $bw->input["{$this->tableName}Address"];
				$googleMap->setAddress($address);
			
				$googleMap->getCoordinate();
				$bw->input ["{$this->tableName}Longitude"] = $googleMap->getLongitude();
				$bw->input ["{$this->tableName}Latitude"] = $googleMap->getLatitude();
			
				}	
				
			$objUpdate = $this->model->createBasicObject ();
			$objUpdate->convertToObject ( $bw->input );
                       
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
            if($vsSettings->getSystemKey('pcontacts_googleposition',0, $bw->input['module']))  
	            if($bw->input["{$this->tableName}Address"]){
					$vsStd->requireFile(UTILS_PATH."googleMap.class.php");
					$googleMap = new googleMap();
					$address = $bw->input["{$this->tableName}Address"];
					$googleMap->setAddress($address);
					
					$googleMap->getCoordinate();
					$bw->input ["{$this->tableName}Longitude"] = $googleMap->getLongitude();
					$bw->input ["{$this->tableName}Latitude"] = $googleMap->getLatitude();
				}		        
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
		if ($imageOld && $bw->input ['fileId']) {
			$vsFile->deleteFile ( $imageOld );
		}
		
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
	}
}
?>