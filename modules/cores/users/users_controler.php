<?php
require_once(CORE_PATH.'users/users.php');

class users_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_users");
		parent::__construct($modelName,"skin_users","user");
		$this->model->categoryName="users";

	}

	
	
	
	
	
function getObjListExcel(){
		global $bw, $vsSettings;	
		if($bw->input['pageIndex']) $bw->input[2] = $bw->input['pageIndex'];
		$option['pageList']=$this->model->getObjectsByCondition();
require_once (CORE_PATH . "users/phpexel/PHPExcel.php");
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("http://luuquangvu.net/")
							 ->setLastModifiedBy("Luu Quang Vu")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Export Ecel")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Export Ecel");
$tmp=1;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tài Khoản')
            ->setCellValue('B1', 'Họ Tên')
            ->setCellValue('C1', 'Giới tính')
            ->setCellValue('D1', 'Email')
            ->setCellValue('E1', 'Địa chỉ')
            ->setCellValue('F1', 'Điện Thoại')
//            ->setCellValue('G1', 'Thời gian user có hiệu lực')	
//            ->setCellValue('H1', 'Thời gian user hết hiệu lực')
            ;	
$this->date=VSFactory::getDateTime();		
foreach($option['pageList'] as $key =>$value){
	
	if($value->getGender()==1){
		$gender="Nam";
	}
	else{
		$gender="Nữ";
	}
	$tmp++;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$tmp, $value->getName())
            ->setCellValue('B'.$tmp, $value->getTitle())
            ->setCellValue('C'.$tmp, $gender)
            ->setCellValue('D'.$tmp, $value->getEmail())
            ->setCellValue('E'.$tmp, $value->getAddress())
            ->setCellValue('F'.$tmp, $value->getPhone());
//            ->setCellValue('G'.$tmp, $this->date->getDate($value->getTimeStart(),'d/m/Y'))
//            ->setCellValue('G'.$tmp, $this->date->getDate($value->getTimeEnd(),'d/m/Y'))	;      
}
$objPHPExcel->getActiveSheet()->setTitle('Danh Sach Thanh Vien');
$objPHPExcel->setActiveSheetIndex(0);



// Redirect output to a client�s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Danh_Sach_Thanh_Vien.xls"');


header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

	  
}
	
	
	
	
	
	
	
	
	
	
	
function displaySearch(){
		global $bw;
//		if (VSFactory::getSettings()->getSystemKey ( $bw->input [0] . '_category_list', 0, $bw->input[0] ))
//			$option ['categoryList'] = $this->getCategoryBox ();
			//$option ['objList'] = $this->getObjList ();
        	$order="";
        	$from="vsf_".$this->tableName;
        	$where="1=1";
        	if($bw->input['search']['title']){
        		$where.=" and (`title` like '%{$bw->input['search']['title']}%' or `name` like '%{$bw->input['search']['title']}%')";
        	}
        	if($bw->input['search']['id']){
        		$where.=" and `id`='{$bw->input['search']['id']}' ";
        	}
        	if(isset($bw->input['search']['catId']))
        	if($bw->input['search']['catId']>0){
        		$category=VSFactory::getMenus()->getCategoryById($bw->input['search']['catId']);
        		if($category){
	        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
	        		$where.=" and `catId` in ({$idns})";
        		}
        	}else{
        		if($this->model->categoryName){
        			$category=VSFactory::getMenus()->getCategoryGroup($this->model->categoryName);
        			if($category){
		        		$idns=VSFactory::getMenus()->getChildrenIdInTree($category->getId());
		        		$where.=" and `catId` in ({$idns})";
        			}
        		}
        	}
        	if($bw->input['search']['status']!=-1&&$bw->input['search']['status']!==NULL){
	        		$where.=" and `status`='{$bw->input['search']['status']}'";
        		
        	}
        	$this->model->setCondition($where);
        	
        	$itemList=$this->model->getObjectsByCondition();
        	$vdata['search']=$bw->input['search'];
        	$option['vdata']=json_encode($vdata);
        	//if(!is_object($_GET['search'])) $_GET['search']=array();
        	$tmp['search']=$_GET['search'];
        	$bw->input['back']=urldecode( http_build_query($tmp	))."&pageIndex=".$bw->input['pageIndex'];
		return $this->output = $this->html->getListItemTable ($itemList, $option );
	}

	function addEditObjForm($objId = 0, $option = array()) {
		global  $vsStd, $bw, $vsPrint;
		$option['location']=VSFactory::getMenus()->getCategoryGroup('location')->getChildren();
		return parent::addEditObjForm($objId,$option);
	}
	function addEditObjProcess(){
		global $bw;
//		print  "<pre>";
//		print_r ($bw->input);
//		print  "<pre>";
//		exit();
		$day=explode("/",$bw->input['users']['birthday']);
		$bw->input['users']['day']=$day[0];
		$bw->input['users']['month']=$day[1];
		$bw->input['users']['year']=$day[2];
		return parent::addEditObjProcess();
	}

	function getHtml(){
		return $this->html;
	}



	function getOutput(){
		return $this->output;
	}



	function setHtml($html){
		$this->html=$html;
	}




	function setOutput($output){
		$this->output=$output;
	}



	
	/**
	*Skins for user ...
	*@var skin_users
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
