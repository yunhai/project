 <?php
class payment_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct('pages', CORE_PATH.'pages/', 'pages');
	}



function showDefault(){

		global $vsSettings,$vsMenu,$bw,$vsTemplate,$vsCom,$vsPrint;

    $code = 'payment';
    $obj = $this->model->getObjByCode($code, 'payment');
    $obj = current($obj);

		$this->model->getNavigator($obj->getCatId());

		$vsPrint->mainTitle = $vsPrint->pageTitle = $obj->getTitle();

		return $this->output = $this->html->showDetail($obj, $option);
	}
}
?>
