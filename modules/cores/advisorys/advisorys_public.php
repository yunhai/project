<?php

class advisorys_public  extends ObjectPublic{
function __construct(){
            global $vsTemplate;
            parent::__construct('advisorys', CORE_PATH.'advisorys/', 'advisorys');
			$this->html = $vsTemplate->load_template('skin_advisorys');    
	}
    
	function auto_run() {
		global $bw;

		switch ($bw->input['action']) {
			case 'detail':
				$this->showDetail($bw->input[2]);
				break;

			case 'category':
				$this->showCategory($bw->input[2]);
				break;
           	case 'send':
				$this->sendadvisory();
				break;
        	case 'form':
             	$this->output = $this->html->advisoryForm ( );
              	break;
			case 'thanks':
				$this->thankadvisory();
				break;
			
			default:
				$this->showDefault();
				break;
		}
	}
	
function showDefault(){
		global $vsSettings,$vsMenu,$bw,$vsTemplate;
  
		$categories = $this->model->getCategories();
       	$strIds = $vsMenu->getChildrenIdInTree($categories);

       	$this->model->setFieldsString("{$this->tableName}Title, {$this->tableName}Image, {$this->tableName}Id, {$this->tableName}Intro,{$this->tableName}CatId,{$this->tableName}PostDate");
       	
		$this->model->setCondition("{$this->tableName}Status > 0 and {$this->tableName}CatId in ({$strIds})");
		$this->model->setOrder("{$this->tableName}Index ASC, {$this->tableName}Id DESC");
		$size  = $vsSettings->getSystemKey("{$bw->input[0]}_user_item_quality",10,$bw->input[0]);
		$option = $this->model->getPageList($bw->input['module'], 1, $size);			
    	
     	$option['cate'] = $categories;
        $this->model->getNavigator();
    	return $this->output = $this->html->showDefault($option);
		
	}
   
	function showDetail($objId){
		global $vsPrint, $vsLang, $bw,$vsMenu,$vsTemplate;              
		$query = explode('-',$objId);
		$objId = intval($query[count($query)-1]);
		if(!$objId) return $vsPrint->redirect_screen($vsLang->getWords('global_no_item','Không có dữ liệu theo yêu cầu!'));
		$obj=$this->model->getObjectById($objId);

		$this->model->convertFileObject(array($obj),$bw->input['module']);
		$cat=$this->model->vsMenu->getCategoryById($obj->getCatId());
		$this->model->getNavigator($obj->getCatId());
		
		$option['other'] =  $this->model->getOtherList($obj);
		$categories = $this->model->getCategories();
		$option['cate'] =  $vsLang->getWords('advisory_pagetitle', 'Tư vấn');
		$option['id'] = $obj->getId();	

		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();
		
		$this->output = $this->html->showDetail($obj,$option);
	}
	
	
	
	function sendadvisory(){
		global $bw,$vsLang,$vsSettings,$vsStd,$DB;

			$security = $bw->input ['advisorySecurity'];
			$vsStd->requireFile ( ROOT_PATH . "vscaptcha/VsCaptcha.php" );
			$image = new VsCaptcha();
			if (! $image->check ( $security )) {
				
				$this->model->obj->convertToObject($bw->input);
				$bw->input['message'] = $vsLang->getWords('thank_message','Security code doesnot match');
				
				if ($bw->input['skin']=='default'){
					$bw->input[1] = 1;
					return $this->showDefault();
				}
				if ($bw->input['skin']=='detail')
					return $this->showDetail($bw->input['id']);
				
			}
		
		$bw->input['advisoryPostDate'] = time();
		$bw->input['advisoryCatId'] = $bw->input['advisoryCat'] ? $bw->input['advisoryCat'] : $this->model->categories->getId();

		$this->model->obj->convertToObject($bw->input);
	
		$this->model->insertObject($this->model->obj);

		if($this->error) $this->sendadvisoryError();
		
		$url = $bw->input['module'];
		$this->thankadvisory($url);
	}
	
	function sentadvisoryByEmail($addon_profile){
		global $vsStd, $vsLang, $bw,$vsSettings;
		$vsStd->requireFile(LIBS_PATH."Email.class.php",true);
		$this->email = new Emailer();


		$message = "<strong>Name:</strong> {$this->model->obj->getName()}<br />
					<strong>Email:</strong> {$this->model->obj->getEmail()}<br />";
		//$message.= "<strong>Address:</strong>".$addon_profile[0]."<br /><strong>Phone:</strong>".$addon_profile[1]."<br />";
		$message.= "<strong>Message subject:</strong> {$this->model->obj->getTitle()}<br />
				    <strong>Message:</strong>".$this->model->obj->getContent();
		$this->email->setTo($vsSettings->getSystemKey("advisory_emailRecerver","admin@vietsol.net"));

		$this->email->setFrom($this->model->obj->getEmail());
		$this->email->setSubject($vsLang->getWords('advisorySubject', 'advisory'));
		$this->email->setMessage($message);

		$this->email->send_mail();
	}

	function thankadvisory($url){
		global $vsPrint, $vsLang,$bw;
		$text = $vsLang->getWords('advisory_redirectText','Câu hỏi của bạn đã được gửi');
		$this->output = $this->html->thankyou ( $text, $url );
	}

	function sendadvisoryError(){
		global $vsLang;
		$this->output = $vsLang->getWords('advisory_sendContentError','The following errors were found! Unknow!');
	}
}
?>