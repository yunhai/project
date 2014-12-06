 <?php
/*
 +-----------------------------------------------------------------------------
 |   VSF version 5.0
 |	Author: System
 |	Homepage: http://www.vietsol.net
 |	If you use this code, please don't delete these comment lines!
 |	Start Date: 
 |	Finish Date: 
 |	Modified Start Date: 
 |	Modified Finish Date: 
 |	News Description: this file created by auto system
 +-----------------------------------------------------------------------------
 */
if(!defined( 'IN_VSF')){
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit();
}

require_once(CORE_PATH."modules/nguoibiengiois.php");
class modules_public extends VSControl{
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $html;
	/**
	 * 
	 * Enter description here ...
	 * @var unknown_type
	 */
	protected $module;
	protected $output;
	
	function __construct(){
		global $vsTemplate, $bw, $vsModule;
		$this->html = $vsTemplate->load_template('skin_pages');
		$this->module = new nguoibiengiois();
	}

	function auto_run(){
		global $bw;
        
                
		switch($bw->input['action']){
			case 'detail':
					$this->loadDetail($bw->input[2]);
				break;
				
			case 'category':
					$this->loadCategory($bw->input[2]);
				break;
			default:
					$this->loadDefault();
				break;
		}
	}

        

	function loadDefault(){
		$this->output = $this->html->loadDefault($option);
	}

	function loadDetail($pageId,$com=NULL){
        $this->output = $this->html->loadDetail($obj, $option);
	}
	

	function loadCategory($catId){
       	$this->output = $this->html->loadCategory($option);
	}

	
	

	function setOutput($out){
		return $this->output = $out;
	}

	function getOutput(){
		return $this->output;
	}
}
?>
