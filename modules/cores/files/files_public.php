<?php
/*
 +-----------------------------------------------------------------------------
 |   VIET SOLUTION JSC  base on IPB Code version 2.0.0
 |	Author: BabyWolf
 |	Homepage: http://khkt.net
 |	If you use this code, please don't delete these comment line!
 |	Start Date: 21/09/2004
 |	Finish Date: 22/09/2004
 |	Modified Start Date: 07/02/2007
 |	Modified Finish Date: 10/02/2007
 +-----------------------------------------------------------------------------
 */

if ( ! defined( 'IN_VSF' ) )
{
	print "<h1>Incorrect access</h1>You cannot access this file directly. If you have recently upgraded, make sure you upgraded all the relevant files.";
	exit();
}
class files_public
{
	function __construct() {
		global $vsTemplate;
		$this->model = new files();
		$this->base_url = $bw->base_url;
		
	}
	/*-------------------------------------------------------------------------*/
	// INIT
	/*-------------------------------------------------------------------------*/
	public function getOutput() {
		return $this->output;
	}

	public function setOutput($output="") {
		$this->output = $output;
	}

	function auto_run()
	{
		global $bw;

		//-------------------------------------------
		// What to do?
		//-------------------------------------------
		switch($bw->input['action'])
		{
			case 'download':
				$this->download();
				break;
			case 'view':
				$this->viewfile($bw->input);
				break;
			case 'uploadfile':
				$this->model->uploadFile($bw->input['uploadName'],$bw->input['fileFolder']);
				break;
			default:
				$this->loadDefault();
				break;
		}
	}
	function viewfile($array) {
		global $bw;
		$fileId=$array[2];
		$width=$array['width'];
		$height=$array['height'];
		$divid=$array['divid'];
		$file=$this->model->getObjectById($fileId);
		if(is_object($file))
		{
			return $this->output = $file->show($width,$height,$divid);
		}

	}
	function download() {
		global $bw;

		$this->model->downloadFile($bw->input[2]);
		
		$returnHTML = $this->html->MainFile($this->result['message']);

		$this->setOutput($returnHTML);
	}
	function loadDefault(){
		return "dfsa";
	}
}
?>