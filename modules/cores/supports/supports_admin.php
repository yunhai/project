<?php
class supports_admin extends ObjectAdmin{
	function __construct(){
                global $vsTemplate, $vsPrint, $vsStd;
		parent::__construct('supports', CORE_PATH.'supports/', 'supports');
                $this->html = $vsTemplate->load_template('skin_supports');
	}
        function addEditObjForm($objId=0, $option=array()){
		global $vsLang, $vsStd,$bw,$vsMenu,$vsSettings;

		$obj = $this->model->createBasicObject();
		$option['formSubmit'] = $vsLang->getWords('obj_EditObjFormButton_Add', 'Add');
		$option['formTitle']  = $vsLang->getWords('obj_EditObjFormTitile_Add', "Add");
		$nickicons = $vsMenu->getCategoryGroup("nickicons")->getChildren();

		if(count($nickicons)){
			foreach ($nickicons as $icon){
				$icon->getIsDropdown()?$option['icon_online'][]=$icon:$option['icon_offline'][]=$icon;
			}
		}
		if($objId){
			$option['formSubmit'] = $vsLang->getWords('obj_EditObjFormButton_Edit', 'Edit');
			$option['formTitle']  = $vsLang->getWords('obj_EditObjFormTitile_Edit', "Edit {$bw->input[0]}");
			$obj = $this->model->getObjectById($objId);
			
		}
		else{
			if(count($option['icon_offline']))
				$obj->setImageOffline(current($option['icon_offline'])->getId());
			if(count($option['icon_online']))
				$obj->setImageOnline(current($option['icon_online'])->getId());
		}


		$vsStd->requireFile(JAVASCRIPT_PATH."/tiny_mce/tinyMCE.php");
		$editor = new tinyMCE();

		$editor->setWidth($vsSettings->getSystemKey($bw->input[0]."_intro_editor_width", '400px', $bw->input[0], 1, 1));
		$editor->setHeight($vsSettings->getSystemKey($bw->input[0]."_intro_editor_height", '150px', $bw->input[0], 1, 1));
		$editor->setToolbar($vsSettings->getSystemKey($bw->input[0]."_intro_editor_toolbar", 'narrow', $bw->input[0], 1, 1));
		$editor->setTheme($vsSettings->getSystemKey($bw->input[0]."_intro_editor_theme", "advanced", $bw->input[0], 1, 1));
		$editor->setInstanceName('supportIntro');
		$editor->setValue($obj->getIntro());
		$obj->setIntro($editor->createHtml());

		return $this->output = $this->html->addEditObjForm($obj, $option);
	}
}
?>