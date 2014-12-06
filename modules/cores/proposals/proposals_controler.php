<?php
require_once(CORE_PATH.'proposals/proposals.php');

class proposals_controler extends VSControl_admin {

		function __construct($modelName){
			global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_proposals");
		parent::__construct($modelName,"skin_proposals","proposal");
		$this->model->categoryName="proposals";

	}

	function auto_run() {
		global $bw;
		
		switch ($bw->input [1]) {
			case $this->modelName."_popup":
				$this->popup();
				break;	
			case $this->modelName."_export_excel":
				$this->Export_excel();
				break;	

			default :
				parent::auto_run();
				break;
		}
	}


function Export_excel(){
		//
		$bw->input['ajax']=1;
		require_once ROOT_PATH.'phpexel/PHPExcel.php';
		$objPHPExcel = new PHPExcel();

		
		$option['proposals']=Object::getObjModule('proposals', 'proposals', '> -1');
	//echo 123; exit();
		$backkup=serialize($option['proposals']);
		$file_back="backup_export_ngay_".VSFactory::getDateTime()->getDate(time(),'d_m_Y_H_i_s').".txt";
		$file = UPLOAD_PATH."backup_database_proposals/{$file_back}";
		file_put_contents($file, $backkup);	

		$this->menu=VSFactory::getMenus();
			
		//$objPHPExcel->getActiveSheet()->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		
	

		$objPHPExcel->setActiveSheetIndex(0)
		        ->setCellValue('A1','id')
		        ->setCellValue('B1','Họ tên')
		        ->setCellValue('C1','Địa chỉ')
		        ->setCellValue('D1','Điện thoại')
		        ->setCellValue('E1','Email')
		        ->setCellValue('F1','Mã sản phẩm')
		        ->setCellValue('G1','Màu')
		        ->setCellValue('H1','Nội dung')
		        
		        ;

		$i=2;       
		foreach ($option['proposals'] as $key => $value) {
			
			$option['color'][$key]=VSFactory::getMenus()->getCategoryById($value->getColor());
			
			$objPHPExcel->setActiveSheetIndex(0)
		        ->setCellValue('A'.$i, $value->getId())
		        ->setCellValue('B'.$i, $value->getTitle())
		        ->setCellValue('C'.$i, $value->getAddress())
		        ->setCellValue('D'.$i, $value->getPhone())
		        ->setCellValue('E'.$i, $value->getEmail())
		        ->setCellValue('F'.$i, $value->getCode())
		        ->setCellValue('G'.$i, $option['color'][$key]->getTitle())
		        ->setCellValue('H'.$i, $value->getContent())
		       
		        ;


		         $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->getFill()
		        ->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,
		        'startcolor' => array('rgb' => 'F28A8C')
		        ));

			$i++;
		}

		$i=$i+4;
		$info="File này dung để chỉnh sửa offline \n 
		Vui lòng sửa dụng file mới nhất bằng cách export trong hệ thống quản trị \n 
		Chú file này không dùng để thêm dử liệu mới mà chỉ để chỉnh sửa sản phẩm có sản trên hệ thống \n 
		Không được phép chỉnh sửa côt A(id) \n 
		";
		$objPHPExcel->setActiveSheetIndex(0)
		        ->setCellValue('A'.$i,$info);

		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':J'.$i); 
		$j=$i+1;   
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':A'.$j); 
		$j=$i+1;   
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':J'.$j);  
		$j=$i+1;   
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':A'.$j); 
		$j=$i+1;   
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$i.':J'.$j);      

		/*for ($i=1;$i<=10;$i++)
		{
		$objPHPExcel->setActiveSheetIndex(0)
		        ->setCellValue('A'.$i, $i)
		        ->setCellValue('B'.$i, 'sản phẩm '.$i);
		}*/

		//$objPHPExcel->setActiveSheetIndex(0)
		      //  ->setCellValue('A12', 'Created by Nguyen Van Teo - Nhất Nghệ');


		// Rename sheet
		$objPHPExcel->getActiveSheet()->setTitle('danh sach san pham');
		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);

		// Redirect output to a client’s web browser (Excel5)

		$file_name="Export_excel_San_pham_".VSFactory::getDateTime()->getDate(time(),'d_m_Y_H_i_s').".xls";
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename='.$file_name.'');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit; 



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
	*Skins for proposal ...
	*@var skin_proposals
	**/
	var		$html;

	
	/**
	*String code return to browser
	**/
	var		$output;
}
