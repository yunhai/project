<?php
class polls_public extends ObjectPublic{
	function __construct(){
            global $vsTemplate;
            parent::__construct('polls', CORE_PATH.'polls/', 'polls');
            $this->html = $vsTemplate->load_template('skin_polls');
	}
	function auto_run() {
		global $bw;

		switch ($bw->input['action']) {
			case 'view':
				$this->viewVote($bw->input[2]);
				break;
			case 'vote':
				$this->vote($bw->input[2]);
				break;
			default:{
				$this->loadDefault();
				break;
			}
		}
	}

	function vote($id){
		
		$this->model->getObjectById($id);
		$this->model->setCondition("pollId=".$this->model->obj->getId());
		$this->model->updateObjectByCondition(array("pollClick"=>$this->model->obj->getClick()+1));
		$this->viewVote($this->model->obj->getCatId());
		
	}
	
	function viewVote($catId){
		global $vsMenu;
		$cat=$vsMenu->getCategoryById($catId);
		$option['list'] = $this->model->getListWithCat($cat);
		$option['totalClick'] = $this->model->getTotalClick($cat->getId());
		
		return $this->output = $this->html->vote($cat ,$option);
	}
}
/*global $vsStd;
$vsStd->requireFile(CORE_PATH.'polls/polls.php');
class polls_public{

	protected $html;
	protected $module;
	protected $gallerys;
	protected $output;
	function __construct() {
		global $vsTemplate;
		$this->module = new polls();
		$this->html = $vsTemplate->load_template('skin_polls');
	}

	function auto_run() {
		global $bw;

		switch ($bw->input[1]) {
			case 'view':
				$this->viewVote($bw->input[2]);
				break;
			case 'vote':
				$this->vote($bw->input[2]);
				break;
			default:{
				$this->loadDefault();
				break;
			}
		}
	}

	function vote($id){
		
		$this->module->getObjectById($id);
		$this->module->setCondition("pollId=".$this->module->obj->getId());
		$this->module->updateObjectByCondition(array("pollClick"=>$this->module->obj->getClick()+1));
		$this->viewVote($this->module->obj->getCatId());
		
	}
	
	function viewVote($catId){
		$cat=$this->module->vsMenu->getCategoryById($catId);
		$option['list'] = $this->module->getListWithCat($cat);
		$option['totalClick'] = $this->module->getTotalClick($cat->getId());
		return $this->output = $this->html->vote($cat ,$option);
	}
	
	function viewOnhome(){
		global $bw,$vsSettings;
		$size = $vsSettings->getSystemKey("poll_view_home_num",6);
		$arrayObj	=	$this->module->getHotList($size);

		return  $this->output =$this->html->viewOnhome($arrayObj);
	}

	function loadDefault(){
		$hostObject=$this->module->getHotList();
		$htmlListCatPoll=$this->getListWithCat();
		return $this->output = $this->html->loadDefault($hostObject,$htmlListCatPoll);
	}

	function getOutput() {
		return $this->output;
	}

	function setOutput($output) {
		$this->output = $output;
	}
}*/
?>