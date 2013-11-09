 <?php
class news_public extends ObjectPublic{
	function __construct(){
		global $vsTemplate;
		parent::__construct( 'news', CORE_PATH.'news/', 'newses');
		$this->html = $vsTemplate->load_template('skin_news');
	}
	
	function showDefault(){
		global $bw, $vsCom, $vsPrint;
              
		$categories = $this->model->getCategories();
		$temp = $categories->getChildren();
		$subcat = current($temp);
		
		$url = $subcat->getCatUrl('news');
		$exac_url = strtr($url, $vsCom->SEO->aliasurls);

		$vsPrint->boink_it($exac_url);
	}
}
?>
