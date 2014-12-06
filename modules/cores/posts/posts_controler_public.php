<?php
require_once CORE_PATH.'posts/posts.php';
class posts_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw;
		parent::__construct($modelName,"skin_posts","post",$bw->input[0]);
		unset($_SESSION['active']);
	}
	
function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			
			default :
				parent::auto_run();
				break;
		}
	}
	
	/*
	 * Show default action 
	 */
	function showDefault(){
		global $bw,$vsTemplate;
		
		require_once CORE_PATH.'pages/pages.php';
		$page= new pages();
		
		$option['obj']=$page->getObjectById($bw->input[2]);
		
		
		$bw->input['ajax']=1;
		
		
        return $this->output = $this->getHtml()->showPopupBooking($option);
	}

	
	
	
	/**
	 * 
	 * @var posts
	 */
	protected $model;
	
	
    function getListLangObject(){
         	
    }
       /**
        * 
        * @param BasicObject
        */ 
    protected  function  onDeleteObject($obj){
    }
	public function getHtml() {
		return $this->html;
	}
	
	public function getOutput() {
		return $this->output;
	}
	
	public function setHtml($html) {
		$this->html = $html;
	}
	
	public function setOutput($output) {
		$this->output = $output;
	}
	/**
	 * 
	 * Enter description here ...
	 * @var skin_posts
	 */
	public $html;
}

?>