<?php

class emails_admin extends ObjectAdmin{
	function __construct(){
            global $vsTemplate;
		parent::__construct('emails', CORE_PATH.'emails/', 'emails');
                $this->html = $vsTemplate->load_template('skin_emails');
	}
        
//        function displayObjTab() {
//		global $vsLang, $vsStd,$bw;
//               $bw->vars[$bw->input[0].'_category_list']=1;
//		$option ['objList'] = $this->getObjList ();
//		$option ['categoryList'] = $this->addEditObjForm();
//		return $this->output = $this->html->displayObjTab ( $option );
//	}
}

?>