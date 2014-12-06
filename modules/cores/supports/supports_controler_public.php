<?php
require_once CORE_PATH.'supports/supports.php';
class supports_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw;
		$this->model=new supports();
//		$this->html=$vsTemplate->load_template("skin_support");
		//parent::__construct($modelName,"skin_supports","support",$bw->input[0]);
		//$this->model->categoryName=$bw->input[0];
	}
function auto_run() {
	global $bw;
		
		switch ($bw->input['action']) {
			case $this->modelName.'supports_check_online':
				$this->checkOnline($bw->input['ids']);
				break;
			default:
				parent::auto_run();
				break;
		}
		
	}
	function checkOnline($ids){
		global $bw;
		$DB=VSFactory::createConnectionDB();
		$ids=explode(",", $ids);
		foreach ($ids as $index=>$value) {
			if(!intval($value)){
				unset($ids[$index]);
			}
		}
		$ids=implode($ids,",");
//		if($_SESSION['support'][$ids]){
//			$DB->close_db();
//			exit;
//		}
		
		$query="
		SELECT vsf_support.id as id,nickName,vsf_support.title as title,`type`,path,offImage,onImage FROM vsf_support LEFT JOIN vsf_supporttype ON vsf_support.type=vsf_supporttype.code
WHERE vsf_support.id IN ($ids)
		";
		$DB->query($query);
		
		$return=array();
		while($row=$DB->fetch_row()){
			
			if($row['type']=='yahoo'){
				if($this->CheckYahooOnline($row['nickName'])){
					$row['file']=$row['onImage'];
				}else{
					$row['file']=$row['offImage'];
				}
			}
			if($row['type']=='skype'){
				if($this->CheckSkyOnline($row['nickName'])){
					$row['file']=$row['onImage'];
				}else{
					$row['file']=$row['offImage'];
				}
			}
			///some type here.....
			
			//path partten
			$row['url']=str_replace(array("{title}","{nickname}","{nickName}"),array($row['title'],$row['nickName'],$row['nickName']),$row['path']);
			$return[]=$row;
			
		}
		$files=new files();
//		echo "<pre>";
//		print_r($return);
//		echo "<pre>";
//		exit;
		foreach ($return as $index=> $value) {
			if($value['file']){
				$files->getObjectById($value['file']);
				//echo $files->basicObject->getPathView(1);exit;
				$return[$index]['img']=$files->basicObject->getPathView();
				unset($return[$index]['file']);
			}
		}
		$_SESSION['support'][$ids]=json_encode($return);
			echo 	json_encode($return);
			$DB->close_db();
			exit;
		
	}
	function CheckYahooOnline($yahooid)
	{
		$pageurl = "http://mail.opi.yahoo.com/online?u=$yahooid&m=a&t=1";
		if (function_exists ( 'curl_init' ))
		{
			$ch = curl_init ();
			curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
			curl_setopt ( $ch, CURLOPT_URL, $pageurl );
			$status = curl_exec ( $ch );
			if ($status == "01")
			{
				$online = true;
			}
			else
			{
				$online = false;
			}
			curl_close ( $ch );
		}
		else
		{
			$y=$read="";
			$file = fopen ( $pageurl, "r" );
			$read = fread ( $file, 200 );
			$read = ereg_replace ( $yahooid, "", $read );
			if ($y = strstr ( $read, "00" ))
			{
				$online = false;
			}
			elseif (
			$y = strstr ( $read, "01" ))
			{
				$online = true;
			}
			fclose ( $file );
		}
		return $online;
	}
	
	function CheckSkyOnline($skyid)
	{
		$status = trim ( @file_get_contents ( "http://mystatus.skype.com/" . urlencode ( $skyid ) . ".num" ) );
		if ($status > 1)
		return 1;
		return 0;
	}
	/**
	 * 
	 * @var supports
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
	 * @var skin_supports
	 */
	public $html;
}

?>