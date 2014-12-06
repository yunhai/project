<?php
if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}
global $vsStd;
$vsStd->requireFile ( CORE_PATH . "languages/languages.php", true );
require_once LIBS_PATH.'boards/VSAdminBoard.php';
class languages_admin extends VSAdminBoard {
	public  $output = "";
	private $html = "";
	
	/*-------------------------------------------------------------------------*/
	// CONSTRUCT
	/*-------------------------------------------------------------------------*/
	
	function __construct() {
		global $vsTemplate;
		//parent::__construct ();
		// Get more words for this invocation!
		$this->html = $vsTemplate->load_template ( 'skin_languages' );
		$this->model=new languages();
	}
	/**
	 * @return unknown
	 */
	public function getHtml() {
		return $this->html;
	}
	
	/**
	 * @return unknown
	 */
	public function getOutput() {
		return $this->output;
	}
	
	/**
	 * @param unknown_type $html
	 */
	public function setHtml($html) {
		$this->html = $html;
	}
	
	/**
	 * @param unknown_type $output
	 */
	public function setOutput($output) {
		$this->output = $output;
	}
	
	function auto_run() {
		global $bw;
		
		//-------------------------------------------
		// What to do?
		//-------------------------------------------
		

		switch ($bw->input [1]) {
			// User langauge zone
			case 'languages_switch' :
				$this->switchUserLanguage ();
				break;
			
		}
	}
	function createDeleteFolder() {
	
	}
	
	function additemform() {
		//		global $bw, $vsTemplate;
		global $bw;
		
		$option['lang_list']=$this->getAllItemInLang();
		return $this->output = $this->html->addLangItemForm ($option);
	}
	
	function switchUserLanguage() {
		global $bw, $vsPrint;
		
		$languages = new languages();
		$languages->getObjectById($bw->input [2]);
		if($languages->basicObject->getId()){
			$_SESSION [APPLICATION_TYPE] ['language'] ['vsfcurrentLang'] = $languages->basicObject->convertToDB ();
		}
		
		$vsPrint->boink_it ( $_SERVER ['HTTP_REFERER'] );
	}
	
	function defaultLang() {
		global $bw;
		$this->language = $this->getLangByID ( $bw->input [2] );
		if ($this->result ['status']) {
			$this->language->setDefault ( 1 );
			$this->updateLang ();
		}
		$this->getLangsList ( $this->Langobj->result ['message'] );
	}
	
	function deleteLang() {
		global $bw;
		$this->deleteLanguges ( $bw->input [2] );
		$this->getLangsList ( $this->result ['message'] );
	}
	
	function getWordArray($langId,$mode,$module="",$filter="") {
		global $bw;
		$result=array();
		if ($module) {
			$this->language->setId ( $langId );
			$this->langtype = $mode;
			$this->language->setModule ( $module );
			$this->setItemFilePath ();
			require ($this->itempath);
			$result[$module]=$lang;
		} else{
			
			$listfile=$this->getAllItemInLang($langId,$mode);
			foreach ($listfile as $filename) {
				require ($this->language->getLangPath()."/".$mode."/".$filename.".lang");
				$result[$filename]=$lang;
				unset($lang);
				unset($userLang);
			}
			
		}
		if($filter){
			$filter=ltrim($filter," ");
			$filter=rtrim($filter," ");
		foreach ($result as $module => $words) {
			foreach ($words as $key => $value) {
				if(preg_match("/^key:(.*)/",$filter)){
					$search=preg_replace("/^key:(.*)/i","$1",$filter);echo $search;
					if(strpos(strtolower($key),strtolower($search))===FALSE){
						unset($result[$module][$key]);
					}
				}elseif(preg_match("/^value:(.*)/i",$filter)){
					$search=preg_replace("/^value:(.*)/","$1",$filter);
					if(strpos(strtolower($value),strtolower($search))===FALSE){
						unset($result[$module][$key]);
					}
				}elseif(strpos(strtolower($key),strtolower($filter))===FALSE&&strpos(strtolower($value),strtolower($filter))===FALSE){
					unset($result[$module][$key]);
				}
			}
		}
		}
		return $result;
	
	}
	
	function updateModuleWord($valuearr = array(),$langId=1,$langtype='user',$module="global", $delete = 0) {
		global $bw;
		if(is_object($this->getLangById($langId)))
		$this->language=$this->getLangById($langId);
		$file_path=$this->language->getLangPath()."/".$langtype."/".$module.".lang";
		if(file_exists($file_path)){
		require $file_path;
		}else{
			$lang=$valuearr;
		}
		if($delete==1){
			foreach ($valuearr as $key => $value) {
				unset($lang[$key]);
			}
		}
		if($delete==2){
			foreach ($valuearr as $key => $value) {
				$lang[$key]=$value;
			}
		}
		elseif($delete==3){
			$lang=$valuearr;
		}else{
			foreach ($valuearr as $index=> $value) {
				$lang[$index]=$value;
			}
		}
//		echo str_replace("\n","\\n","\nabc");exit;
		//echo var_export ( $output, true );exit;
		$content = "<?php\n";
			$content .= "\$lang = ";
			$content .= var_export ( $lang, true );
			$content .= ";\n";
			
		$content .= "?>";
		if(file_exists($file_path)){
			@chmod ( $file_path, 0777 );
			if(!is_writeable($file_path)){
				echo $file_path." not writeable!";exit;
			}
		}
		$wf = fopen ($file_path, "w" );
		fwrite ( $wf, $content );
		fclose ( $wf );
		@chmod ( $file_path, 0644 );
	}
	
	function deleteWord() {
		global $bw;
		$valuearr [$bw->input [3]] = $bw->input [3];
		$langId=$bw->input[2];
		$mode=$bw->input[5];
		$module=$bw->input[4];
		$this->updateModuleWord ( $valuearr,$langId,$mode,$module, 1 );
		$this->viewItem ($langId,$mode,$module,$bw->input['search'], "The word key <b>[" . $bw->input [3] . "]</b> has been deleted." );
	}
	
	function addMoreWord() {
		global $bw;
		$langId=$bw->input[2];
		$mode=$bw->input['langtype'];
		$module=$bw->input['moduleName'];
		if($bw->input ['wkey']&&$bw->input ['wdisplay'] ){
		$valuearr = array ($bw->input ['wkey'] => $bw->input ['wdisplay'] );
		$this->updateModuleWord ( $valuearr,$langId,$mode,$module, 2 );
		}else{
			$message="Not insert null key";
		}
		$this->viewItem ($langId,$mode,$module,$bw->input['search'],$message?$message: "The word key <b>[" . $bw->input ['wkey'] . "]</b> has been added with value <b>[" . $bw->input ['wdisplay'] . "]." );
	}
	
	function saveLanguages() {
		global $bw;
		$InputArray = array ();
		$langId=$bw->input[2];
		$mode=$bw->input['langtype'];
		foreach ( $_REQUEST['word'] as $module => $langList ) {
			$this->updateModuleWord ( $langList,$langId,$mode,$module);
		}
		$modulename="";
		if(count($_REQUEST['word'])==1){
			foreach ( $_REQUEST['word'] as $module => $langList ){
				$modulename=$module;
			}
		}
		$this->viewItem ($langId,$mode,$modulename,$bw->input['search'], "All language  have been saved." );
	}
	
	function viewItem($langId,$mode,$module,$filter="",$message = "") {
		global $vsTemplate, $vsUser;
		
		$valuearr = $this->getWordArray ($langId,$mode,$module,$filter);
//		echo "<pre>";
//		print_r($show);
//		echo "</pre>";
//		exit;
//		$langitem ['moduleName'] = $_SESSION ['moduleName'];
		foreach ($valuearr as $module=>$word) {
			$show [$module]=array();
			foreach ($word as $key=> $value) {
				$show [$module][htmlspecialchars($key)] = htmlspecialchars($value);
			}
		}
		$showall ['WORD_ITEM'] = $show;
		$showall['langId']=$langId;
		$showall['mode']=$mode;
		unset ( $valuearr );
		$showall ['message'] = $message;
		$showall ['moduleName'] = $module;
		$showall ['search']=$filter;
//		echo "<pre>";
//		print_r($showall);
//		echo "</pre>";
//		exit;
		return $this->output = $this->html->wordList ( $showall );
	}
	
	/**
	 * This function is for add a language item to file or database
	 * @name AddLangItem
	 * @author BabyWolf
	 * @param String $bw->input['LangItemName'] posted from add form
	 * @param Int $bw->input['langId'] posted from add form
	 * @return The result message
	 */
	function addLangItem() {
		global $bw, $langtype;
		
		// Set language item object values
		$this->language->setValue ( array ('pageTitle' => $bw->input ['moduleName'], 'main_title' => $bw->input ['moduleName'] ) );
		$this->language->setId ( $bw->input ['langId'] );
		$this->language->setModule ( $bw->input ['moduleName'] );
		$bw->input [3] = $bw->input ['langtype'];
		$langtype = $bw->input ['langtype'];
		$this->langtype = $bw->input [3];
		
		if ($this->language->getModule () == "")
			$this->result ['message'] .= "Module can't be blank!<br>";
		elseif ($this->langtype == '')
			$this->result ['message'] .= "Folder Type lang is not define!<br>";
		else
			$this->writeItemToFile ();
		
		$this->getLangItemList ( $this->result ['message'] );
	}
	/**
	 * This function is for deleting an items in the list
	 * @name DeleteItem
	 * @author BabyWolf
	 * @param Int $bw->input['itemId'] got from address
	 * @return The message after process
	 */
	function deleteItem() {
		global $bw;
		
		$this->language->setId ( $bw->input [2] );
		$this->langtype = $bw->input [3];
		$this->language->setModule ( $bw->input [4] );
		$this->deleteItemFile ();
		$this->getLangItemList ( $this->result ['message'] );
	
		//		$this->viewLangModule ( $this->result ['message'] );
	

	}
	function viewLangModule($message = '') {
		global $bw, $vsTemplate;
		
		$_SESSION ['url_href'] = $bw->input ['vs'];
		$form ['CURRENT_LANG_ITEM'] = $this->getLangItemList ( $message );
		$option['lang_list']=$this->getAllItemInLang($bw->input[2],$bw->input[3]);
		
		$form ['CURRENT_LANG_ADD_ITEM'] = $this->html->addLangItemForm ($option);
		$this->output = $this->html->FileLangMainAjax ( $form );
	}
	/**
	 * This function is for get all items in a Lang
	 * @name GetLangItemList
	 * @author BabyWolf
	 * @param Int $bw->input['langId'] got from address
	 * @return html of item list in specified Lang
	 */
	function getLangItemList($message = "") {
		global $bw, $vsTemplate, $langtype;
		
		$bw->input [2] = $bw->input [2] ? $bw->input [2] : $this->language->getId ();
		$type = $bw->input [3] ? $bw->input [3] : 'user';
		// Then get all items it that Lang
		$items = $this->getAllItemInLang ( $bw->input [2], $type );
		
		if (! $this->result ['status']) {
			$message = $message . $this->result ['message'];
			$langhtml = $this->html->langItem ( $langitemhtml, $message );
			return $langhtml;
		}
		$format_class = 1;
		$count = 0;
		foreach ( $items as $key => $value ) {
			$values = $this->language->convertToView ();
			$values ['langModule'] = $value;
			$values ['langType'] = $type;
			$values ['format_class'] = $count % 2 ? 'even' : 'odd';
			//			$vsTemplate->assign_block_vars($values,"VAR_LANG_ITEM");
			$show [$count] = $values;
			$count ++;
		
		}
		$showall ['VAR_LANG_ITEM'] = $show;
		$showall ['type'] = $type;
		$langtype = $type;
		$showall ['message'] = $message;
		
		$this->output = $this->html->langItem ( $showall );
		return $this->output;
	
		//		$vsTemplate->assign_var('langtype',$type);
	//		$vsTemplate->assign_var('message',$message);
	//		$vsTemplate->assign_vars_form_string( $this->html->langItem(),'CURRENT_LANG_ITEM');
	}
	//==========================================
	// Lang ZONE
	//==========================================
	/**
	 * This function is for viewing the items in a Lang
	 * @name ViewLang
	 * @author BabyWolf
	 * @param Int $bw->input['langId'] got from address
	 * @return html of add form and item list
	 */
	function viewLangWith() {
		global $bw, $vsTemplate, $vsUser;
		$_SESSION ['url_href'] = $bw->input ['vs'];
//		echo "<pre>";
//		print_r($bw);
//		echo "</pre>";
//		exit;
		$show ['CURRENT_LANG_ITEM'] = $this->getLangItemList ();
		//if (VSFactory::getLangs()->checkRoot ()){
		$option['lang_list']=$this->getAllItemInLang($bw->input[2],$bw->input[3]?$bw->input[3]:'user');
			$show ['CURRENT_LANG_ADD_ITEM'] = $this->html->addLangItemForm ($option);
//}else
//			$show ['CURRENT_LANG_ADD_ITEM'] = '';
		
		$this->output = $this->html->FileLangMain ( $show );
	
	}
	
	/**
	 * This function is for outputing add/edit Lang form
	 * @name AddEditPacakgeForm
	 * @author BabyWolf
	 * @param String $message the result message
	 * @param Bit $formtype control the type of form
	 * @param langpacakge_obj $this->language the object for editing
	 * @return html of add/edit Lang form
	 */
	function addEditLangForm($formtype = 'add', $message = "") {
		global $vsTemplate, $bw;
		$vsLang = VSFactory::getLangs();
		$form ['type'] = $formtype;
		$form ['message'] = $message;
		$form ['title'] = $vsLang->getWords ( 'creat_new_lang', ' Create Language set  ' );
		$form ['submit'] = $vsLang->getWords ( 'creat_new_lang_bt', 'Add' );
		if ($formtype == 'edit') {
			$this->language = $this->getLangById ( $bw->input [2] );
			$form ['submit'] = $vsLang->getWords ( 'edit_selected_lang_bt', 'Edit' );
			$form ['title'] = $vsLang->getWords ( 'edit_selected_lang', ' Edit Language set  ' );
			$form ['switchform'] = <<<EOF
				<input class="button" type="button" value="Switch to Add Form" name="switch" onclick="javascript:vsf.get('languages/addLangForm/','langmodule');" />
EOF;
			$form ['language'] = $this->language;
		}
		$flags = $this->getLanguageSymbol ();
		
		$form ['flags'] = $flags;
		if (! $form ['language'])
			$form ['language'] = new Lang ();
		
		return $this->output = $this->html->addEditLangForm ( $form );
	}
	
	/**
	 * This function is for process add/edit a Lang
	 * @name AddEditLang
	 * @author BabyWolf
	 * @param The parameters is posted from add/edit form
	 * @return Out put the result message
	 */
	function addEditLang() {
		global $bw;
		// Set posted parameters to Lang object
		$this->language->convertToObject ( $bw->input );
		// Check the form type,
		// if form type is 1 => edit
		// else form type is not 1 => add
		if ($bw->input ['FormType'] == 'edit') {
			$this->language->setId ( $bw->input ['langId'] ); // Get posted id to update
			if ($bw->input ['langFolder'] != $bw->input ['oldFolder']) {
				if ($this->makeLangfolder ( $bw->input ['langFolder'] )) {
					$this->deleteDirectory ( ROOT_PATH . "langs/" . $bw->input ['oldFolder'] );
				
				}
			}
			$this->updateLang ();
			$this->result ['message'] = "update folder[" . $bw->input ['langFolder'] . "]success";
		
		//			$this->updateLang ();
		} else {
			if ($bw->input ['langFolder'] && $this->makeLangfolder ( $bw->input ['langFolder'] )) {
				$this->insertLang ();
				$this->result ['message'] = "create folder[" . $bw->input ['langFolder'] . "]success";
			}
		}
		$this->getLangsList ( $this->result ['message'] );
	
	}
	
	function makeLangfolder($name) {
		$linkname = ROOT_PATH . "langs/" . $name;
		if (! is_dir ( $linkname )) {
			mkdir ( $linkname, 0777, true );
			mkdir ( $linkname . "/admin", 0777, true );
			mkdir ( $linkname . "/user", 0777, true );
			return 1;
		} else {
			$this->result ['message'] .= " folder[" . $name . "] has been exits";
			return;
		}
	
	}
	
	function removeFolder($name) {
		$linkname = ROOT_PATH . "langs/" . $name;
		if (is_dir ( $linkname )) {
			Rmdir ( $linkname );
			return 1;
		}
	}
	function deleteDirectory($dir) {
		if (! file_exists ( $dir ))
			return true;
		if (! is_dir ( $dir ) || is_link ( $dir ))
			return unlink ( $dir );
		foreach ( scandir ( $dir ) as $item ) {
			if ($item == '.' || $item == '..')
				continue;
			if (! $this->deleteDirectory ( $dir . "/" . $item )) {
				chmod ( $dir . "/" . $item, 0777 );
				if (! $this->deleteDirectory ( $dir . "/" . $item ))
					return false;
			}
			;
		}
		return rmdir ( $dir );
	}
	
	/**
	 * This function is for get all Lang list
	 * @name GetLangLangsList
	 * @author BabyWolf
	 * @param String $message the message of result
	 * @return html of language Lang list
	 */
	function getLangsList($message = "") {
		global $vsTemplate, $bw;
		$showval = "";
		// Get all Langs
		$this->getAllLang ();
		// Init Lang object
		$count = 0; // Using for css of row
		$format_class = 1;
		foreach ( $this->arrayLang as $Lang ) {
			// Calculate even or odd row
			$values = $Lang->convertToView ();
			
			$values ['format_class'] = $count % 2 ? 'even' : 'odd';
			$values ['imageactive'] = $Lang->getStatus () ? "enabled" : "disabled";
			$values ['defimg'] = <<<EOF
			<img src="{$bw->vars['img_url']}/skin_visible.gif" border="0" alt="">
EOF;
			if ($values ['langDefault'])
				$values ['defimg'] = <<<EOF
			<a href="javascript:vsf.get('Languages/defaultLang/{$values['langId']}/','langlist');"><img src="{$bw->vars['img_url']}/skin_invisible.gif" border="0" alt=""></a>
EOF;
			$values ['langType'] = $values ['langType'] ? "User" : "Admin";
			$values ['langDefault'] = $values ['langDefault'] ? "Yes" : "No";
			//			$vsTemplate->assign_block_vars($values,'LANG_ITEM');
			$show [$count] = $values;
			$count ++;
		}
		$showval ['values'] = $show;
		
		$showval ['mess'] = $message;
		
		return $this->output = $this->html->getLangList ( $showval );
	}
	function loadDefault() {
		global $vsPrint, $vsTemplate;
		$vsPrint->addJavaScriptString ( 'init_tab', '
		var loadcategory=0;
		var loadproducts=0;
			$(document).ready(function(){
    			$("#page_tabs").tabs(
    				{
    					cache: false
    				}
    			);
  			});
		' );
		
		$list = $this->arrayLang;
		
		$this->output = $this->html->MainPage ( $list );
	}
	/**
	 * This function is show all language Lang and add Lang form
	 * @name ShowLanguages
	 * @author BabyWolf
	 * @return Out put module html
	 */
	function displayLanguagesForm() {
		$show ['form'] = $this->addEditLangForm ();
		$show ['list'] = $this->getLangsList ();
		
		return $this->output = $this->html->languagesMain ( $show );
	}
}
?>