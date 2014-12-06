<?php
require_once(CORE_PATH."settings/Setting.class.php");

class settings extends VSFObject {


	/**
	*Enter description here ...
	**/
	public	function __construct($category=''){
			$this->primaryField 	= 'id';
		$this->basicClassName 	= 'Setting';
		$this->tableName 		= 'setting';
		$this->categoryField='catId';
		$this->categoryName=$category?$category:"settings";
		$this->createBasicObject();		
		parent::__construct();
		//$this->categoryField 	= "catId";
		//$this->primaryField 	= 'settingId';
		//$this->basicClassName 	= 'Setting';
		//$this->tableName 		= 'setting';
		//$this->createBasicObject();
		$this->cache_path = "./cache/".APPLICATION_TYPE.".setting.php";

		$this->categories = VSFactory::getMenus()->getCategoryGroup("settings");

		if(VSFactory::getModules()->basicObject->getClass() !='settings') $this->importCache();

	}




	
	/**
	*Enter description here ...
	*@var Setting
	**/
	var		$obj;
function convertToCatId($module){
		if($module == VSFactory::getLangs()->getWords('group_global_module','global')) return 0;
		$module = strtolower($module);
		$categories = $this->categories->getChildren();
		foreach($categories as $child)
			if($child->getUrl() == $module)
				return $child->getId();

		$menus = new menus();
		$menus->basicObject->setLangId($_SESSION[APPLICATION_TYPE]['language']['currentLang']['langId']);
		$menus->basicObject->setAlt($module);
		$menus->basicObject->setTitle($module);
		$menus->basicObject->setParentId($this->categories->getId());
		$menus->basicObject->setIsLink(1);
		$menus->basicObject->setIsAdmin(-1);
		$menus->basicObject->setUrl($module);
		$menus->basicObject->setStatus(1);
		$menus->basicObject->setLevel($this->categories->getLevel()+1);
		$menus->basicObject->setType(1);
		$menus->insertObject();
		$this->categories->children[$menus->basicObject->getId()] = $menus->basicObject;
		return $menus->basicObject->getId();

	}
	/**
	 * 
	 * Enter description here ...
	 * @param $key
	 * @param $default
	 * @param $title
	 */
	function getKeyGroup($key,$title,$group,$value=1){
		global $bw;
		$type = 0;
		if($type){
			$type = 2;
			if(APPLICATION_TYPE == "admin") $type = 1;
		}
		
		return $this->getSystemKey($key,$value,$bw->input['module'],$type,1,$title,$group);
	}

/*
	type: 0: global, 1: chạy theo APPLICATION_TYPE
*/
	function getSystemKey($key, $val="", $module="", $type = 1, $root = 1,  $title = "",$group=""){
		global $bw;
		$catId = 0;
		$vsLang = VSFactory::getLangs();
		$key = strtolower($key);
		
		if(isset($bw->vars[$key])){
			if($group){
				
				if(isset($bw->vars['setting_group'][$key][$group])){
					 if($bw->vars[$key]) return $bw->vars['setting_group'][$key][$group];
				}else{
					$this->temp_arr_setting_group[$key][$group]=$bw->vars[$key];
					$this->builcachesetting = 1;
				}
			}
			return $bw->vars[$key];
		} 
		
		$bw->vars[$key] = $val;

		$module = $module ? $module : ($bw->input['module']?$bw->input['module']:$vsLang->getWords('group_global_module','global'));

		if($module != $vsLang->getWords('group_global_module','global'))
			$catId = $this->convertToCatId($module);

		$type = 0;
		if($type){
			$type = 2;
			if(APPLICATION_TYPE == "admin") $type = 1;
		}

//		$arra['intro'] 	= $intro;
		$arra['key']		= $key;
		$arra['value']	= $val;
		$arra['catId']	= $catId;
		$arra['title']	= $title?$title : ucwords(str_replace("_", " ", $key));
		$arra['index']	= 0;
		$arra['root']	= $root;
		$arra['module']	= $module;
		$arra['type']	= $type;
		$arra['title']=explode(" ", $arra['title']);
		if(strtolower($arra['title'][0])==strtolower($arra['title'][1])){
			unset($arra['title'][1]);
		}
		$arra['title']=implode(" ", $arra['title']);
		if($group){
				$this->temp_arr_setting_group[$key][$group]=$arra['value'];
			
		}
		
		$this->temp_arr_setting[] = $arra;
//		echo $key."<br/>";
		$this->builcachesetting = 1;
		unset($arra);

		return $bw->vars[$key];
	}

	function addSetting(){
		if($this->builcachesetting == 2){
			$this->buildCache("admin");
			$this->buildCache("user");

			return true;
		}
		if(is_array($this->temp_arr_setting)){
			foreach($this->temp_arr_setting as $arra){
				$this->basicObject->convertToObject($arra);
				if($this->basicObject->getValue()===0||$this->basicObject->getValue()===1){
					$this->basicObject->setHtmlValue(
					" 	<label><input id='el_{id}_1' type='radio' value='1' name='value[{id}]' />Yes</label>
						<label><input id='el_{id}_0' type='radio' value='0' name='value[{id}]' />No</label>
						<script> $('#el_{id}_{value}').attr('checked','checked'); </script> "
					);
					}
				$this->insertObject();
				$this->basicObject->__destruct();
			}
			
		}
		if(is_array($this->temp_arr_setting_group)){
			foreach($this->temp_arr_setting_group as $key=>$arr ){
				foreach ($arr as $group =>$value) {
					$value=mysql_real_escape_string($value);
					$key=mysql_real_escape_string($key);
					$group=mysql_real_escape_string($group);
					VSFactory::createConnectionDB()->query("delete  from vsf_setting_group where `key`='{$key}' and `group`='$group'");
					VSFactory::createConnectionDB()->query("
					INSERT INTO `vsf_setting_group` (
					`group` ,
					`key` ,
					`value`
					)
					VALUES (
					'{$group}', '{$key}', '{$value}'
					);
					");
				}
			}
		}
		$this->buildCache();
		$this->getSystemKey('public_menu_cache', 1, 'global', 0, 1);
	}

	function buildCache($mode=APPLICATION_TYPE) {
		global $bw;
		$type = ($mode=="user")? 2 : 1;
		$condition = "type=0 OR type=".$type;
		$this->setCondition($condition);
		
		$array = $this->getArrayByCondition();

		$vars = array();
		foreach($array as $element){
			$vars[strtolower($element['key'])] = $element['value'];
//			$vars[$element['key']] = $element['value'];
		}
		VSFactory::createConnectionDB()->query(
		"SELECT g.* FROM vsf_setting_group AS g LEFT JOIN vsf_setting AS s ON g.`key`=s.`key`
			WHERE TYPE=0 OR TYPE=2"
			);
			while($row=VSFactory::createConnectionDB()->fetch_row()){
				$vars['setting_group'][$row['key']][$row['group']]=$row['value'];
			}
		$cachepath = "./cache/".$mode.".setting.php";
//echo "<pre>";
//		print_r($cachepath);
//		echo "</pre>";
//		exit;
		$bw->vars = array_merge($bw->vars, $vars);
		$cache_content  = "<?php\n";
		$cache_content .= "\$arraySetting = ".var_export($vars,true).";\n";
		$cache_content .= "?>";
		$file = fopen($cachepath, "w");
		fwrite($file, $cache_content);
		fclose($file);
		unset($vars);
	}

	function importCache(){
		global $bw;

		if(file_exists($this->cache_path) && SETTINGS_CACHE){
			require_once ($this->cache_path);
			if(count($arraySetting))
				 $bw->vars = array_merge($bw->vars, $arraySetting);
				if (APPLICATION_TYPE == "admin") {
					$groups=VSFactory::getAdmins()->basicObject->getGroupList();
					if(count($groups)){
						$bw->vars['admin_frontpage']= current($groups)->getHomePath()?current($groups)->getHomePath():$bw->vars['admin_frontpage'];	
					}
				}
				unset($arraySetting);
				return $bw->vars;
		}
		$this->buildCache();
	}

	function deleteByModule($module = ""){
		if(!$module) return false;
		$this->condition = "module in (".$module.")";
		$this->deleteObjectByCondition();

		VSFactory::getSettings()->builcachesetting = 2;
		return $this->result['status'];
	}

	function deleteByCatId($catId = ""){
		if(!$catId) return false;
		$this->condition = "catId in (".$catId.")";
		$this->deleteObjectByCondition();


		VSFactory::getSettings()->builcachesetting = 2;
		return $this->result['status'];
	}

	function deleteObjInCategory($catId = 0){
		$this->condition = "catId IN (".$catId.")";
		if(!$this->deleteObjectByCondition()) return false;

		return true;
	}
}