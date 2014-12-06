<?php
require_once CORE_PATH.'pages/pages.php';
class pages_controler_public extends VSControl_public {
	function __construct($modelName){
		global $vsTemplate,$bw,$vsPrint,$vsSkin;
		if(file_exists(ROOT_PATH.$vsSkin->basicObject->getFolder()."/skin_".$bw->input[0].".php")){
			
		parent::__construct($modelName,"skin_".$bw->input[0],"page",$bw->input[0]);;
		}else{
		parent::__construct($modelName,"skin_pages","page",$bw->input[0]);
		}
		unset($_SESSION['active']);
	}
	
	/**
	 * 
	 * @var pages
	 */
	protected $model;
	
	function auto_run() {
		global $bw;
		
		switch ($bw->input ['action']) {
			case $this->modelName . '_detail' :
				$this->showDetail ( $bw->input [2] );
				break;
			
			case $this->modelName . '_category' :
				$this->showCategory ( $bw->input [2] );
				break;
			case $this->modelName . '_review' :
				$this->showReview ( $bw->input [2] );
				break;
			case $this->modelName . '_search' :
				$this->showSearch ();
				break;
			case $this->modelName.'_form_tuvan':
				$this->showFromTuvan();
				break;	
			case $this->modelName.'_addtshowbox':
				$this->showbox();
				break;	
			case $this->modelName.'_addmail':
				//echo 123; exit();
				$this->showAddmail();
			case $this->modelName.'_sendcontacts':
				//echo 123; exit();
				$this->showSendcontact();
			case $this->modelName.'_tags':
				//echo 123; exit();
				$this->showTag($bw->input[2]);
			break;	
			default :
			
			
				$this->showDefault ();
				//echo 123; exit();
				break;
		}
	}
	

	function showDefault($option=array()){
	//echo 123; exit();
	
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		
                //if(in_array($bw->input['module'], array('abouts','maps','helps')))return $this->showDefault1 ();
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$option['cate_list']=VSFactory::getMenus()->getCategoryGroup($bw->input[0])->getChildren();
		$_SESSION['active']=0;
		if(!$category || $bw->input[1]){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index` desc,id desc");
		$tmp=$this->model->getPageList($bw->input[0],1,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_public_limit',30));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum($category);
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
       	$option['cate'] = $category->getChildren();
      
        if($option['pageList'] and in_array($bw->input[0],array('introduce','resumes','companylinking'))){
         	$obj=current($option['pageList']);
         	$vsPrint->boink_it($obj->getUrl($bw->input[0]));
         } 
         $option['idcate']=0;      
         if($bw->input['cate']){
         	 $option['idcate']=$bw->input['cate'];
         }  
         $i=1;     
         foreach ($option['pageList'] as $value){
         	if($i<=9){
         		$value->count='0'.$i;
         		
         	}
         	else{
         		$value->count=$i;
         	}
         	$i++;
         }       
        return $this->output = $this->getHtml()->showDefault($option);
	}

	function showCategory($catId){
		global $bw,$vsPrint;
		if($bw->input[0]=='projects'){
		$idcate = $this->getIdFromUrl($catId);	
		$category2=VSFactory::getMenus()->getCategoryById($idcate);
		
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$option['cate_list']=VSFactory::getMenus()->getCategoryGroup($bw->input[0])->getChildren();
		
		if(!$category2){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ($ids)");
		$this->model->setOrder("`index` desc,id desc");
		$tmp=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_public_limit',12));
		$option=array_merge($tmp,$option);
		$option['breakcrum']=$this->createBreakCrum(VSFactory::getMenus()->getCategoryById($idcate) );
		$option['title']=VSFactory::getLangs()->getWords($bw->input[0]);
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
       	$option['cate'] = $category->getChildren();
      
        if($option['pageList'] and in_array($bw->input[0],array('introduce','resumes','companylinking'))){
         	$obj=current($option['pageList']);
         	$vsPrint->boink_it($obj->getUrl($bw->input[0]));
         } 
         $option['idcate']=$category2->getId();;      
          
         $i=1;     
         foreach ($option['pageList'] as $value){
         	if($i<=9){
         		$value->count='0'.$i;
         		
         	}
         	else{
         		$value->count=$i;
         	}
         	$i++;
         }       
		 return $this->output = $this->getHtml()->showDefault($option);
		}
		else{
        $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$idcate = $this->getIdFromUrl($catId);		
		$category=VSFactory::getMenus()->getCategoryById($idcate);
		if(!$category){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$_SESSION['active']=$category->getId();
		
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status>0 and catId in ({$idcate})");
		
		$this->model->setOrder("`index` desc,id desc");
		$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));

		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
        
        $option['breakcrum']=$this->createBreakCrum(VSFactory::getMenus()->getCategoryById($idcate) );
        $option['obj']=$category;
     	if($option['pageList'] and in_array($bw->input[0],array('proservicer'))){
         	$obj=current($option['pageList']);
         	$vsPrint->boink_it($obj->getUrl($bw->input[0]));
         } 
        $option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		foreach ($option['cate'] as $value) {
      		if($value->getId()==$category->getId()){
      			$value->active="active";
      		}
      		else{
      			$value->active="";
      		}
      	}
      
		return $this->output = $this->getHtml()->showDefault($option);
		}
	}
function showTag($tagId){
		global $bw,$vsPrint;
		require_once(CORE_PATH.'tags/tags.php');
		$tags = new tags();	
		$idtag = $this->getIdFromUrl($tagId);
		$id = $tags->getContentByTagId($bw->input['module'],$idtag);	
        $category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("status >0 and catId in ({$ids}) and id in ({$id})");	
		//$this->model->setOrder("`index` desc,id desc");		
		$option=$this->model->getPageList($bw->input[0]."/".$bw->input[1]."/".$bw->input[2],3,VSFactory::getSettings()->getSystemKey($bw->input[0].'_paging_limit',12));

		$option['title']=$category->getTitle();
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];       
        $option['breakcrum']=$this->createBreakCrum(null);
       // $option['obj']=$category;
		$_SESSION['active']['tag']=$idtag;
        $option['cate'] = VSFactory::getMenus ()->getCategoryGroup ( $bw->input [0] )->getChildren();
		// echo 124; exit();
		
      
		return $this->output = $this->getHtml()->showDefault($option);
	}
	function showDetail($objId,$option=array()){
		global $vsPrint, $bw,$vsTemplate,$vsStd,$DB;
		$category=VSFactory::getMenus()->getCategoryGroup($bw->input[0]);
		$obj=$this->model->getObjectById($this->getIdFromUrl($objId));
		if(!$obj->getId()||$obj->getStatus()<=0){
			$vsPrint->boink_it($bw->base_url."404.html");
		}
		$obj->createSeo();
		$option['breakcrum']=$this->createBreakCrum($obj);
		$option['other']=$this->model->getOtherList($obj);
		$option['cate'] = $category->getChildren();
		$option['cate_obj']=VSFactory::getMenus()->getCategoryById($obj->getCatId());
		foreach ($option['cate'] as $value) {
      		if($value->getId()==$obj->getCatId()){
      			$value->active="active";
      		}
      		else{
      			$value->active="";
      		}
      	}
		$obj->createSeo();
	
			
		require_once CORE_PATH.'gallerys/gallerys.php';
		$galerys=new gallerys();
       	$option['files_list']=$galerys->getAlbumByCode($bw->input[0]."_".$obj->getId());
		$option['title']=$option['cate_obj']->getTitle();
       	
		if($bw->input['assessments']['submit']){
			
		$option['assessments']=$bw->input['assessments'];
		
		
       		require_once (CORE_PATH."assessments/assessments.php");	
			$assessments = new assessments();
			
       		//$bw->input['assessments']['title']=$bw->input['assessments']['name'];
			$bw->input['assessments']['postdate']=time();
			$bw->input['assessments']['status']=0;
			$assessments->basicObject->convertToObject($bw->input['assessments']);		
/*			print  "<pre>";
			print_r ($assessments);
			print  "<pre>";
			exit();	*/
			$assessments->insertObject();
			$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
			$this->email = new Emailer ();
			$this->email->setTo(VSFactory::getSettings ()->getSystemKey ("email_assessments", "vuongnguyen@vietsol.net", "configs"));
			//$this->email->addBCC($contacts->basicObject->getEmail());
			$time=VSFactory::getDateTime()->getDate(time(),"d/m/y h:i");
			$this->email->setFrom ('alert@gmail.com');
			$this->email->setSubject ("ý kiến của khách hàng - {$time}" );
			$content="
				<h1 class='titile_contacts'>ý kiến của khách hàng</h1>
				<p> Họ tên    			: {$bw->input['assessments']['name']}<p>
				<p>	Điện thoại			: {$bw->input['assessments']['phone']}<p>
				<p>	Địa chỉ   			: {$bw->input['assessments']['address']}<p>
				<p>	Email    			: {$bw->input['assessments']['email']}<p>
				<p>	Tên sản phẩm		: {$bw->input['assessments']['title']}<p>
				<p>	Đánh giá  			: {$bw->input['assessments']['assessment']}<p>
				<p>	Mức giá bạn hy vọng  : {$bw->input['assessments']['content']}<p>
			
			";
			$this->email->setBody ($content);
			$this->email->sendMail ();
//			print  "<pre>";
//			print_r ($this->email);
//			print  "<pre>";
//			exit();
			$option['error'] = VSFactory::getLangs()->getWords('thanks_proposals')."!";
			
			
		}
		
		require_once(CORE_PATH.'tags/tags.php');
		$tags = new tags();		
		$tags->setCondition("id IN (SELECT tagId FROM vsf_tagcontent WHERE module ='{$bw->input[0]}' and contentId={$obj->getId()})");
		$option['list']=$tags->getObjectsByCondition();
		
	
		$this->output = $this->getHtml()->showDetail($obj,$option);
	}
	
function showSearch() {
		global $bw, $vsTemplate, $vsStd, $vsPrint;
		
		$option['breakcrum']=$this->createBreakCrum(null);
		$category = VSFactory::getMenus ()->getCategoryGroup ($bw->input [0]);
		//echo 123; exit();
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( $category->getId());
//		echo "<pre>";
//		print_r($ids);
//		echo "</pre>";
//		exit();
		if($bw->input[2])
			$bw->input['keyword']=$bw->input[2];
		if($bw->input['keyword']){
			$condition.=" status >0  and  title like '%".mysql_real_escape_string($bw->input['keyword'])."%'";	
		}
		
		$this->model->setCondition($condition);
		$this->model->setOrder("`index`,id desc");
		$option['pageList']=$this->model->getObjectsByCondition();
//		print  "<pre>";
//		print_r ($condition);
//		print  "<pre>";
//		exit();
		require_once CORE_PATH.'entrepreneurs/entrepreneurs.php';
		$entrepreneurs =new entrepreneurs() ;
		$entrepreneurs->setCondition($condition);
		$option['entrepreneurs']=$entrepreneurs->getObjectsByCondition();
		if($bw->input['keyword'])
		$option['title']=VSFactory::getLangs()->getWords('products_search_keyword','Từ khóa: ')."<i>".$bw->input['keyword']."</i>";
		else $option['title']=VSFactory::getLangs()->getWords('products_search_result','Kết quả tìm kiếm');
		$vsPrint->mainTitle=$vsPrint->pageTitle=$option['title'];
		
		return $this->output = $this->getHtml()->showSearch($option);
	}
		
function showbox($option=array()){			
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$bw->input['ajax']=1;

		$arrayObj=array();
		$oldIds = $bw->input[2];
		$this->model->setCondition("status>0 and id ={$oldIds}");
		$obj=$this->model->getOneObjectsByCondition();
		require_once CORE_PATH.'gallerys/gallerys.php';
		$gallerys=new gallerys();
		$option['galary']=$gallerys->getAlbumByCode($bw->input['module'].'_'.$oldIds);
//		print  "<pre>";
//		print_r ($obj);
//		print  "<pre>";
//		exit();
		return $this->output =$this->getHtml()->showbox($option,$obj);
		

	}	
function showAddmail($option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		$bw->input['ajax']=1;
		$category=VSFactory::getMenus()->getCategoryGroup('emails');
	
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$this->model->setCondition("catId in ({$ids}) and title='{$bw->input['objId']}'");
		$this->model->setOrder("`index`,id desc");
		$option['mail']=$this->model->getOneObjectsByCondition();
	
		if($option['mail']){
			$option['mess']="Địa chỉ mail đã đăng ký";
		}
		else{
			$bw->input['emails']['catId']=$ids;
			$bw->input['emails']['title']=$bw->input['objId'];
			$bw->input['emails']['postDate']=time();
			$bw->input['emails']['status']=1;
			$this->model->basicObject->convertToObject($bw->input['emails']);
//			print  "<pre>";
//			print_r ($this->model);
//			print  "<pre>";
//			exit();
			$this->model->insertObject();
			
			$option['mess']="Đăng ký Thành công";
		
		}
		
		echo $this->getHtml()->showAddmail($option);die;
	}
function checkmail($email){
	if (strlen($email) == 0) return false;
            if (eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) return true;
            return false;
}	
function showSendcontact($option=array()){
		global $bw,$vsTemplate,$vsStd,$vsPrint;
		
		$vsLang = VSFactory::getLangs();
		$this->vsLang = VSFactory::getLangs();
		
	
		
		
//	echo 123; exit();
		require_once CORE_PATH.'contacts/contacts.php';
		$contacts=new contacts();
		
		$contacts->basicObject->setTitle($bw->input['name_contacts']);
	   	$contacts->basicObject->setName($bw->input['name_contacts']);	  
	   	$contacts->basicObject->setEmail($bw->input['email_contacts']);
	   	$contacts->basicObject->setContent($bw->input['message_contacts']);
	   	$contacts->insertObject();
	   	
	   	$vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
		$this->email = new Emailer ();
		$option['mess']=$this->vsLang->getWords("mess_oki","Gởi Nội dung liên hệ thành công!!");
		$option['reset']="		
		 <script type='text/javascript'>
		$(document).ready(function() {
			document.getElementById('main-contact-form').reset();
		});
		</script> ";
 
		
		echo $this->getHtml()->showSendcontact($option);
		
		
		$this->email->setTo(VSFactory::getSettings ()->getSystemKey ( "email_admin", "vuongnguyen0712@gmail.com", "configs" ));				
		$time=VSFactory::getDateTime()->getDate(time(),"d/m/y h:i");
		$this->email->setFrom ('alert@gmail.com');
		$this->email->setSubject ($this->vsLang->getWords("title_email_sender","ý kiến của khách hàng")." - {$time}" );
		
		$content="
					<h1 class='titile_contacts'>".$this->vsLang->getWords("title_email_sender","ý kiến của khách hàng")."</h1>
					
					<p> Họ tên    	: {$bw->input['name_contacts']}<p>					
					<p>	Email    	: {$bw->input['email_contacts']}<p>					
					<p>	Nội dung	: {$bw->input['message_contacts']}<p>
					
				
				";
		$this->email->setBody ($content);
		$this->email->sendMail ();
		
		  print  "<pre>";
         print_r ($this->email);
         print  "<pre>";
         exit(); 
		
		die;
// //	   	print  "<pre>";
// //	   	print_r ($this->email);
// //	   	print  "<pre>";
// //	   	exit();
	}
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
	 * @var skin_pages
	 */
	public $html;
}

?>