<?php
require_once LIBS_PATH.'boards/addons/addon_public_board.php';
class addon_public extends addon_public_board{
function getMenuTop($option=array()){
		global   $bw;
		
		$option['menu']=VSFactory::getMenus()->getMenuByPosition('top');
         $option['list'] = VSFactory::getMenus()->getListGroup();      
		foreach ($option['menu'] as $menu) {
//			echo $bw->input['vs'].":".trim($menu->getUrl(),'/').":".strpos($bw->input['vs'], trim($menu->getUrl(),'/'))."<br>";
			if(@strpos($bw->input['vs'], trim($menu->getUrl(),'/')) ===0){
				$menu->active="active";
			}
			if($bw->vars['public_frontpage']== $bw->input['vs']&&$menu->getUrl()=='' ){
				$menu->active="active";
			}
			if(in_array($menu->getUrl(), array("abouts"))){
				$category=VSFactory::getMenus()->getCategoryGroup("abouts");
				$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
				if($ids){
					require_once CORE_PATH.'pages/pages.php';
					$pages=new pages();
					$pages->setCondition("catId in ($ids)");
					$pages->setOrder("`index`");
					$option['obj_list'][$menu->getId()]=$pages->getObjectsByCondition();
				}
			}
		}
                
             
		return $this->getHtml()->getMenuTop($option);
	}
	function getMenuBottom($option = array()) {
		global $bw;
		$option ['menu'] = VSFactory::getMenus ()->getMenuByPosition ( 'bottom' );
		foreach ( $option ['menu'] as $menu ) {
			if (@strpos ( $bw->input ['vs'], trim ( $menu->getUrl (), '/' ) ) === 0) {
				$menu->active = "active";
			}
			if ($bw->vars ['public_frontpage'] == $bw->input ['vs'] && $menu->getUrl () == '') {
				$menu->active = "active";
			}
		}
		return $this->getHtml ()->getMenuBottom ( $option );
	}
	function getSupport($option=array()){
		$DB=VSFactory::createConnectionDB();
		require_once CORE_PATH.'supports/supports.php';
		$supports=new supports();

	$query="
		SELECT vsf_support.index,  vsf_support.id as id,nickName,vsf_support.title as title,`type`,path,offImage,onImage FROM vsf_support LEFT JOIN vsf_supporttype ON vsf_support.type=vsf_supporttype.code
	WHERE vsf_support.status>0 ORDER BY  vsf_support.index DESC
		";
		$DB->query($query);
		
		$return=array();
		while($row=$DB->fetch_row()){
			$row['link']=str_replace(array("{title}","{nickname}","{nickName}"),array($row['title'],$row['nickName'],$row['nickName']),$row['path']);
			//$return[]=$row;
			$sup=new Support();
			$sup->convertToObject($row);
			$sup->link=$row['link'];
			$option[$row['type']][]=$sup;
		}
		
		
		
		return $this->getHtml()->getSupport($option);
	}
	
	

	
	function getBannerByCode($code){
		if (is_array ( $this->banner [$code] ))
			return $this->banner [$code];
		$ids = VSFactory::getMenus ()->getChildrenIdInTree ( VSFactory::getMenus ()->getCategoryGroup ( "banners" ) );
		
		require_once CORE_PATH . 'banners/banners.php';
		$banners = new banners ();
		$banners->setFieldsString ( "id,title,url,image,intro" );
		$banners->setCondition ( "`POSITION` IN (
					SELECT id FROM vsf_bannerpo
					WHERE `code`='$code'
				) and `status`>0 and catId in ($ids) " );
		$banners->setOrder ( "`index` desc" );
		//$option['logotop']=Object::getObjModule('slidebanners', 'slidebanners', '>0', '', ' ');
		$this->banner [$code] = $banners->getObjectsByCondition ();
		return $this->banner [$code];
	}
	function getBanner(){
			$option['logolefts']=Object::getObjModule('pages', 'slidebanners', '>0', '', ' ');
	  return $this->getHtml()->getBanner($option);
	}
	
	
	
function getSupports(){
	$DB=VSFactory::createConnectionDB();
		//require_once CORE_PATH.'supports/supports.php';
		//$supports=new supports();
		
		$option['support']=Object::getObjModule('supports', 'supports', '>0', '', ' ');
		
		

	  return $this->getHtml()->getSupports($option);
	}


function getContact($option){
		require_once CORE_PATH.'contacts/pcontacts.php';
		$pc=new pcontacts();
		$category=VSFactory::getMenus()->getCategoryGroup('contacts');
	
		$ids=VSFactory::getMenus()->getChildrenIdInTree($category);
		$pc->setCondition("status > 0 and catId in ({$ids})");
		//$pc->setOrder("`index`");
		$option['obj']=$pc->getOneObjectsByCondition();
//	echo "<pre>";
//	print_r($option['obj']);
//	echo "</pre>";
//	exit();
		return $this->getHtml()->getContact($option);

	}
function getAdvLeft(){
			$option['advleft']=Object::getObjModule('partners', 'advlefts', '>0', '', ' ');
			
			
			
			
	  return $this->getHtml()->getAdvLeft($option);
	}
function getAbouts(){
			$option['abouts']=Object::getObjModule('pages', 'abouts', '>0', '1', ' 1');
			$option['news']=Object::getObjModule('pages', 'news', '>0', '3', ' ');
			
			
			
			
	  return $this->getHtml()->getAbouts($option);
	}
function getWeblinks(){
			$option['weblinks']=Object::getObjModule('partners', 'weblinks', '>0', '', ' ');			
	  return $this->getHtml()->getWeblinks($option);
	}	
function getBannerTop(){
			$option['banner']=Object::getObjModule('partners', 'advtop', '>0', '', ' ');		
				
	  return $this->getHtml()->getBannerTop($option);
	}
function getBannerBottom(){
			$option['banner']=Object::getObjModule('partners', 'advbottom', '>0', '', ' ');		
				
	  return $this->getHtml()->getBannerBottom($option);
	}
function getTag($module){
		global $bw, $vsLang, $vsPrint,$DB;	
		require_once(CORE_PATH.'tags/tags.php');
		$tags = new tags();		
		$tags->setCondition("id IN (SELECT tagId FROM vsf_tagcontent WHERE module ='{$module}')");
		$option['list']=$tags->getObjectsByCondition();
		
	  return $this->getHtml()->getTag($option,$module);
	}		
}

?>