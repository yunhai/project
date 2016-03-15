<?php
class searchs_admin extends ObjectAdmin{
	function __construct(){
		global $vsTemplate;
		parent::__construct('searchs', CORE_PATH.'searchs/', 'searchs');
                $this->html = $vsTemplate->load_template('skin_searchs');
	}
        function getObjList($catId = '', $message = "") {
		global $bw, $vsSettings,$vsLang;
		$this->model->setCondition ( $this->model->getCategoryField () . ' in (' .$vsLang->currentLang->getId(). ')' );
		$size = $vsSettings->getSystemKey ( "admin_{$bw->input[0]}_list_number", 10 );
                $this->model->setOrder('searchUpdate DESC , searchId DESC');
		$option = $this->model->getPageList ( "{$bw->input[0]}/display-obj-list", 2, $size, 1, 'obj-panel' );
		return $this->output = $this->html->objListHtml ( $this->model->getArrayObj (), $option );
	}
}
?>