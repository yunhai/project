<?php
class skin_languages  extends skins_board {
	function MainPage($list) {
		global $bw;
		$this->vsLang = $vsLang = VSFactory::getLangs();
		$BWHTML .= <<<EOF
			<script type="text/javascript">
				function deleted(act,langid,value,id){
					jConfirm(
						'{$this->vsLang->getWords('lang_confirm','Confirm delete')} "'+value+'"?', 'Confirmation Dialog',
						function(r) {
							if(r)
								vsf.get('languages/'+act+'/'+langid+'/'+value,id);
					});
				}
			</script>
			<div id="page_tabs">
				<ul id="tabs_nav">
			        <foreach=" $list as $obj ">
			         	<li>
			         		<a href="{$bw->base_url}languages/viewLangWith/{$obj->getId()}/&ajax=1">
			         			<span>{$this->vsLang->getWords($obj->getName(), $obj->getName())}</span>
			         		</a>
			         	</li>
			        </foreach>
			        <li>
			        	<a href="{$bw->base_url}languages/displayLangForm/&ajax=1">
			        		<span>{$this->vsLang->getWords('tab_news_lang','Languages')}</span>
			        	</a>
			        </li>
			    </ul>
			</div>
EOF;
		return $BWHTML;	
	}
	
function LanguagesMain($show) {
global $bw;
$this->vsLang = $vsLang = VSFactory::getLangs();
$BWHTML = "";

$storein = $bw->vars['storelangtype']?"File":"Database";
$BWHTML = <<<EOF
<script type="text/javascript">
$(document).ready(function(){
	function deleted(act,langid,value,id)
	{			
		jConfirm('{$this->vsLang->getWords('lang_confirm','Confirm delete')} "'+value+'"?', 'Confirmation Dialog', function(r) {
    					if(r)	
							vsf.get('languages/'+act+'/'+langid+'/'+value,id);
					});
	}
	});
</script>
<div class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
    <div id="langmodule" class="left-cell">
    	{$show['form']}
    	
        <div class="clear"></div>
    </div>
    <div id="langlist" class="right-cell">
    	{$show['list']}
        <div class="clear"></div>
	</div>
    <div class="clear"></div>
    <div class="ui-state-error ui-corner-all" style="padding:10px 5px;">
        <p align="left">
            <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
            <strong>Alert:</strong> The system language is currently stored in <strong>{$storein}</strong>. 
    So if you make any change it will be saved to <strong>{$storein}</strong>.
        </p>
    </div>
</div>
EOF;
//--endhtml--//

return $BWHTML;
}
/*********
 * {CURRENT_LANG_ADD_ITEM}
        {CURRENT_LANG_ITEM}
 */

//======================================================
// LANGUAGE Lang ZONE
//======================================================
function addEditLangForm($form) {
	global $bw;
	$this->vsLang = $vsLang = VSFactory::getLangs();
$BWHTML = "";
$langua = $form['language'];
$BWHTML .= <<<EOF
	<form id="LANGFORM_1" nam='LANGFORM' method="post">
		<input type="hidden" name="FormType" value="{$form ['type']}" />
		<input type="hidden" name="langId" value="{$langua->getId()}" />
		<input type="hidden" name="oldFolder" value="{$langua->getFolderName()}" />
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
			<div >
		    	<span class="ui-dialog-title">{$form ['title']}</span>
		    </div>
			<div class="error">{$form ['message']}</div>
			<table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
			<tr>
		        <td>{$this->vsLang->getWords('lang_name','Language')}</td>
		        <td><input type="text" id="langName" name="langName" value="{$langua->getName()}" size="32"></td>
			</tr>
			<tr>
		        <td>{$this->vsLang->getWords('lang_folder','Folder')}</td>
		        <td><input type="text" id="langFolder" name="langFolder" value="{$langua->getFolderName()}" size="32"></td>
			</tr>
			<tr>
		        <td>{$this->vsLang->getWords('lang_Udefault','User Def')}</td>
		        <td>
		            <input class="checkbox" type="checkbox" name="userDefault" value="1" >
		            <label for="langDefault_first">Yes</label>
		           
		        </td>
			</tr>
			<tr>
		        <td>{$this->vsLang->getWords('lang_Adefault','Admin Def')}</td>
		        <td>
		            <input class="checkbox" type="checkbox"  name="adminDefault" value="1" />
		            <label for="langType_first">Yes</label>
		        </td>
			</tr>
			<tr>
		        <td>{$this->vsLang->getWords('lang_active','Active')}</td>
		        <td>
		            <input class="checkbox" type="radio" name="langStatus" value="1" >
		            <label for="langIsActive_first">Yes </label>
		            <input class="checkbox" type="radio" name="langStatus" value="0" >
		            <label for="langIsActive_last">No </label>
		        </td>
			</tr>
		    <tr>
		    	<td>{$this->vsLang->getWords('lang_symbol','Symbol')}</td>
		        <td class="ui-dialog-selectpanel">
			      	 <select size="5" multiple="multiple" id="langSymbol" name="langSymbol">
			      	 	<foreach="$form['flags'] as $flag">
							<option value="{$flag['value']}">{$flag['name']}</option>
						</foreach>
					</select>
		        </td>
		    </tr>
			<tr>
		        <td align="left" style="padding-left:70px;" colspan="2" class="ui-dialog-buttonpanel">
			        {$form['switchform']}
			        <input id="submit_langform" type="button" value="{$form['submit']}" onclick="submitForm()"/></td>
		        </td>
			</tr>
			</table>
		</div>
	</form>
	<script>
	
	$(document).ready(function(){
		vsf.radio('{$langua->getStatus()}', 'langStatus');
		vsf.select('{$langua->getSymbol()}', 'langSymbol');
		vsf.checkbox('{$langua->getUserDefault()}', 'userDefault');
		vsf.checkbox('{$langua->getAdminDefault()}', 'adminDefault');	
	});
	function submitForm() {
		if(!$('#langName').val()) {
			jAlert('{$this->vsLang->getWords('err_lang_name_blank','Please enter the language name!')}','{$bw->vars['global_websitename']} Dialog');
			$('#langName').addClass('ui-state-error ui-corner-all-inner');
			$('#langName').focus();
			return false;
		}
		if(!$('#langFolder').val()) {
			jAlert('{$this->vsLang->getWords('err_lang_folder_blank','Please enter the folder name!')}','{$bw->vars['global_websitename']} Dialog');
			$('#langFolder').addClass('ui-state-error ui-corner-all-inner');
			$('#langFolder').focus();
			return false;
		}
		vsf.submitForm($('#LANGFORM_1'),'languages/addEditLang/','langlist');
		vsf.get('languages/addLangForm/','langmodule');
		return false;
	}
	</script>
EOF;
return $BWHTML;
}
function getLangList($showval) {
	global $bw;
	$this->vsLang = $vsLang = VSFactory::getLangs();

$show="";
$BWHTML = "";
//--starthtml--//

$BWHTML .= <<<EOF
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
	<div >
    	<span class="ui-dialog-title">{$this->vsLang->getWords('lang_list','Current Language Packs In Use')}</span>
    </div>
	<div class="error">{$showval['mess']}</div>
	<table cellspacing="0" cellpadding="0" class="ui-dialog-content ui-widget-content" style="width:100%;">
    	<thead>
        	<tr>
                <th>{$this->vsLang->getWords('lang_symbol','Symbol')}</th>
                <th>{$this->vsLang->getWords('lang_name','Language')}</th>
                <th>{$this->vsLang->getWords('lang_active','Status')}</th>
                <th>{$this->vsLang->getWords('lang_folder','Folder name')}</th>
                <th>{$this->vsLang->getWords('lang_userdefault','Default User')}</th>
                <th>{$this->vsLang->getWords('lang_admindefault','Default Admin')}</th>
                <th>{$this->vsLang->getWords('lang_option','Option')}</th>
            </tr>
        </thead>
		<foreach="$showval['values'] as $show">			
			<tr class="{$show['format_class']}">
			    <td align="center"><img src="{$bw->vars['img_url']}/flags/{$show['langSymbol']}"></td>
			    <td align="center">
			    	<a href="javascript:vsf.get('languages/editLang/{$show['langId']}/','langmodule');" title='{$this->vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}' class="editObj">
					{$show['langName']}
					</a>
				</td>
			    <td align="center"><img src="{$bw->vars['img_url']}/{$show['imageactive']}.png" width="14" alt="{$show['imageactive']}" /></td>
			    <td align="center">{$show['langFolder']}</td>
			    <td align="center">{$show['userDefault']}</td>
			    <td align="center">{$show['adminDefault']}</td>
			    <td align="center">
					<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:deleted('deleteLang',{$show['langId']},'{$show['langName']}','langlist')" title='{$this->vsLang->getWords('newsItem_EditObjTitle',"Click here to delete this {$bw->input[0]}")}'>{$this->vsLang->getWords('global_del','Xóa')}</a>
			        {$show['defimg']}
			    </td>
		    </tr>
		    
		</foreach>
	</table>
</div>
EOF;
//--endhtml--//##
return $BWHTML;
}

function wordList($showall) {
	global $bw,  $vsUser;
	$this->vsLang = $vsLang = VSFactory::getLangs();
	$BWHTML = "";
	//--starthtml--//
$BWHTML .= <<<EOF
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
	<div >
    	<span class="ui-dialog-title">{$this->vsLang->getWords('lang_module_add_text',' Add module′s language text')}</span>
    </div>
    <div class="red">{$showall['message']}</div>
    <if="$showall ['moduleName']">
    <form action="javascript:vsf.submitForm($('#add_item_{$bw->input[2]}'),'languages/addWord','langlist_{$bw->input[2]}')" method="Post" id="add_item_{$bw->input[2]}">
     <input type="hidden" name="2" value="{$showall['langId']}">
    <input type="hidden" name="langtype" value="{$showall['mode']}">
    <input type="hidden" name="search" value="{$showall ['search']}"/>
    <input type="hidden" name="moduleName" value="{$showall ['moduleName']}"/>
    <table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0" style="width:100%;">
    	<thead>
        	<tr>
            	<th>{$this->vsLang->getWords('lang_module_text_key','Language key')}</th>
                <th>{$this->vsLang->getWords('lang_module_text_value','Language value')}</th>
                <th></th>
            </tr>
        </thead>

		<tr>
        	<td ><input type="text" name="wkey" value=""><br />
        	{$this->vsLang->getWords('root', 'Root', 1)}<input type="radio" name="root" />
        	</td>
			<td><textarea name="wdisplay" class="" cols="40" rows="1" ></textarea></td>
			<td class="ui-dialog-buttonpanel"><input class="button" type="submit" value="Add" name="submit"></td>
		</tr>
	</table>
	
    </form>
    </if>
    <div >
    	<span class="ui-dialog-title">{$this->vsLang->getWords('lang_module_text','Current module′s language text')} : [{$showall['moduleName']}]</span>
    </div>
    <form action="javascript:vsf.submitForm($('#frm_save_{$bw->input[2]}'),'languages/saveLangItem','langlist_{$bw->input[2]}')" id='frm_save_{$bw->input[2]}' method="Post">
    <input type="hidden" name="2" value="{$showall['langId']}">
    <input type="hidden" name="langtype" value="{$showall['mode']}">
    <input type="hidden" name="search" value="{$showall ['search']}"/>
	<table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0" style="width:100%;">
    	<thead>
        	<tr>
            	<th>{$this->vsLang->getWords('lang_module_text_key')}</th>
                <th>{$this->vsLang->getWords('lang_module_text_value')}</th>
                <th>{$this->vsLang->getWords('lang_option')}</th>
            </tr>
        </thead>
        <if="$showall['WORD_ITEM']">
            <foreach="$showall['WORD_ITEM'] as $module => $wordlist">
            	<foreach="$wordlist as $key => $word">
		<tr>
			<td ><p style="width:150px;overflow:auto">{$key}</p></td>
			<td>
			<textarea class="lang_keycode_input" name="word[$module][$key]" cols="50" rows="1">{$word}</textarea>
			</td>
			<td>				
				<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:deleted('deleteWord',{$showall['langId']},'{$key}/$module/{$showall['mode']}','langlist_{$showall['langId']}')" title='{$this->vsLang->getWords('newsItem_EditObjTitle',"Click here to delete this {$bw->input[0]}")}'>{$this->vsLang->getWords('global_del','Xóa')}</a>
			</td>
		</tr>
				</foreach>
            </foreach>
        </if>
        <tr>
        	<td colspan="2" class="ui-dialog-buttonpanel">
                <input class="button" type="Submit" name="Submit" value="Save" />
            </td>
        </tr>
		</form>
	</table>
</div>
<script>
$(".lang_keycode_input").keypress(function(event){
////autoresize
var str = $(this).val();
    var cols = $(this).attr("cols");

    var linecount = 0;
    var strs=str.split("{$this->DS}n");
    var count=strs.length;
    for(var i=0;i<count;i++){
    	linecount += Math.ceil( strs[i].length / cols )>0?Math.ceil( strs[i].length / cols ):1; // take into account long lines
    }
    $(this).attr("rows",linecount);
////
});
$(document).ready(function(){
	$(".lang_keycode_input").keypress();
});
$(".lang_keycode_input").keydown(function(event){

	if ( event.which == 13 && event.shiftKey ) {
		return;
		}
	if ( event.which == 13 && event.ctrlKey ||event.which == 9) {
		$(this).blur();
		event.preventDefault();
		var next=$(this).parents("tr").next();
		if(next.find(".lang_keycode_input").length>0) 
		next.find(".lang_keycode_input").focus().select();
		else{//alert( next.parents("form").find("input[type='submit']").val());
		 next.parents("form").find("input[type='submit']").focus();
		 }
		return;
	}
	if ( event.which == 13 ) {
		var space="<br/>";
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var text = $(this).val().substring(0,this.selectionStart)+space+$(this).val().substring(this.selectionStart,$(this).val().length);
				$(this).val(text);
				this.selectionStart=startPos+space.length;
				this.selectionEnd=startPos+space.length;	
					
				return false;
	}

	if ( event.which == 13 && event.altKey ) {
				var space="{$this->DS}{$this->DS}n";
				var startPos = this.selectionStart;
				var endPos = this.selectionEnd;
				var text = $(this).val().substring(0,this.selectionStart)+space+$(this).val().substring(this.selectionStart,$(this).val().length);
				$(this).val(text);
				this.selectionStart=startPos+space.length;
				this.selectionEnd=startPos+space.length;	
					
				return false;
		}
		
	
});

</script>
EOF;

//--endhtml--//

return $BWHTML;
}

function addLangItemForm($option=array()) {
global $bw ,$langtype;
$langtype=$langtype?$langtype:'user';
$this->vsLang = $vsLang = VSFactory::getLangs();

$BWHTML = "";
//--starthtml--//

$BWHTML .= <<<EOF
<script type="text/javascript"> 
$('#addlangitem_{$bw->input[2]}').submit(function() {

	if(!$('#moduleName_{$bw->input[2]}').val()) {
		alert('{$this->vsLang->getWords('err_lang_name_blank','Please enter the module name!')}');
		$('#moduleName').addClass('ui-state-error ui-corner-all-inner');
		$('#moduleName').focus();
		return false;
	}
	vsf.submitForm($(this),'languages/addLangItem','lang_item_list_{$bw->input[2]}');
	vsf.get('languages/additemform/{$bw->input[2]}/','langitemform_{$bw->input[2]}');
});
</script>
<div id="langitemform_{$bw->input[2]}">
	<form id="searchlangitem_{$bw->input[2]}" >
		<input type="hidden" name="langId" value="{$bw->input[2]}">
		<input type="hidden" name="langtype" value="{$langtype}">
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
			<div >
		    	<span class="ui-dialog-title">{$this->vsLang->getWords('lang_module_add',' Add module′s language file  ')}</span>
		    </div>
		    <table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
		    	<tr>
		        	<td>{$this->vsLang->getWords('lang_module','Module')}</td>
		            <td>
		            <select id="searchlangitem_{$bw->input[2]}_module" value="module">
		            <option value="0">All module</option>
		            <foreach="$option['lang_list'] as $modulename">
		            <option value="$modulename">$modulename</option>
		            </foreach>
		            
		            </select>
		            </td>
		        </tr>
		        <tr>
		        	<td>{$this->vsLang->getWords('lang_module_keyword','Module')}</td>
		            <td><input type="text" id="keywor_{$bw->input[2]}" name="keyword" value=" "></td>
		        </tr>
		        <tr>
		        	<td class="ui-dialog-buttonpanel" colspan="2"><input class="button" type="submit" name="submit" value="Search"></td>
		        </tr>
		    </table>
		   </div>
		   <script>
		   $("#searchlangitem_{$bw->input[2]}").submit(function(){
					vsf.get('languages/viewItem/{$bw->input[2]}/$langtype/'+$("#searchlangitem_{$bw->input[2]}_module").val()+'/'+$("#keywor_{$bw->input[2]}").val(),'langlist_{$bw->input[2]}');
					return false;
			});
		   
		   </script>
	</form>
	<form id="addlangitem_{$bw->input[2]}">
		<input type="hidden" name="langId" value="{$bw->input[2]}">
		<input type="hidden" name="langtype" value="{$langtype}">
		<div class="ui-dialog ui-widget ui-widget-content ui-corner-all">
			<div >
		    	<span class="ui-dialog-title">{$this->vsLang->getWords('lang_module_add',' Add module′s language file  ')}</span>
		    </div>
		    <table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0">
		    	<tr>
		        	<td>{$this->vsLang->getWords('lang_module','Module')}</td>
		            <td><input type="text" id="moduleName_{$bw->input[2]}" name="moduleName" value=" "></td>
		        </tr>
		        <tr>
		        	<td class="ui-dialog-buttonpanel" colspan="2"><input class="button" type="submit" name="submit" value="Add"></td>
		        </tr>
		    </table>
		   </div>
	</form>
</div>
EOF;
//--endhtml--//

return $BWHTML;
}

function langItem($showall) {
	global $bw;
	$this->vsLang = $vsLang = VSFactory::getLangs();

$BWHTML = "";

$BWHTML .= <<<EOF
<div class="ui-dialog ui-widget ui-widget-content ui-corner-all" id="lang_item_list_{$bw->input[2]}">
<div class="red">{$showall['message']}</div>
<table class="ui-dialog-content ui-widget-content" cellpadding="0" cellspacing="0" style="width:100%;">
	<thead>
    	<tr>
        	<th>{$this->vsLang->getWords('lang_itemm_list','Language Item List')}</th>
            <th>{$this->vsLang->getWords('lang_option','Option')}</th>
        </tr>
    </thead>
    <if="count($showall['VAR_LANG_ITEM'])">
    <foreach=" $showall['VAR_LANG_ITEM'] as $var">
		<tr class="{$var['format_class']}">
			<td>
				<a href="javascript:;" onclick="javascript:vsf.get('languages/viewItem/{$bw->input[2]}/{$var['langType']}/{$var['langModule']}/','langlist_{$bw->input[2]}')" title="{$this->vsLang->getWords('global_edit_title','Click here to edit')}" class="editObj">
					{$var['langModule']}
				</a>
			</td>
			<td>
				<a href="javascript:deleted('deleteItem','{$bw->input[2]}/{$var['langType']}','{$var['langModule']}','MODULE_FILE_LIST_{$bw->input[2]}')" title='{$this->vsLang->getWords('global_delete_title',"Click here to delete")}' class="ui-state-default ui-corner-all ui-state-focus">
					{$this->vsLang->getWords('global_delele','Delete')}
				</a>
			</td>
		</tr>
	</foreach>
	</if>
</table>
</div>
EOF;
//--endhtml--//

return $BWHTML;
}

	function FileLangMainAjax($show) {
		global $bw;
		$this->vsLang = $vsLang = VSFactory::getLangs();
		$vsSettings = VSFactory::getSettings();
		$BWHTML = <<<EOF
			<div id="sa_content_{$bw->input[2]}">
			    <div id="langmodule_{$bw->input[2]}" class="left-cell">
			    	<div id="MODULE_FILE_FORM_{$bw->input[2]}">{$show['CURRENT_LANG_ADD_ITEM']}</div>
			    	<div id="MODULE_FILE_LIST_{$bw->input[2]}">{$show['CURRENT_LANG_ITEM']}</div>
			    	<div class="clear"></div>
			    </div>
			    <div id="langlist_{$bw->input[2]}" class="right-cell" style="margin-right:3px;">
			    	{$show['LANGUAGE_LIST']}
			        <div class="clear"></div>
				</div>
			    <div class="clear"></div>
			    <if=" $vsSettings->getSystemKey('display_alert', 0 , "languages", 1, 1) ">
			    <div class="ui-state-error ui-corner-all" style="padding:10px 5px;">
			        <p align="left">
			            <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
			            <strong>Alert:</strong> The system language is currently stored in <strong>{$storein}</strong>. 
			    		So if you make any change it will be saved to <strong>{$storein}</strong>.
			        </p>
			    </div>
			    </if>
			</div>
EOF;
		return $BWHTML;
	}

		function FileLangMain($show){
			global $bw;
			$this->vsLang = $vsLang = VSFactory::getLangs();
		$vsSettings = VSFactory::getSettings();
			$BWHTML = "";

			$storein = $bw->vars['storelangtype']?"File":"Database";
			$BWHTML = <<<EOF
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
				    <div >
				        <span class="ui-icon ui-icon-note"></span>
				        <span class="ui-dialog-title">{$this->vsLang->getWords('language_file_title',"Language Files")}</span>
				    </div>
				    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">

				    	<li class="ui-state-default ui-corner-top" id="add-objlist-bt">
				    		<a href="#" title="{$this->vsLang->getWords('user',"User")}" onclick="javascript: vsf.get('languages/viewLangModule/{$bw->input[2]}/user/','sa_content_{$bw->input[2]}'); return false">
								{$this->vsLang->getWords('user',"User")}
							</a>
						</li>
						
				        <li class="ui-state-default ui-corner-top" id="hide-objlist-bt">
				        	<a href="#" title="{$this->vsLang->getWords('admin',"Admin")}" onclick="javascript: vsf.get('languages/viewLangModule/{$bw->input[2]}/admin/','sa_content_{$bw->input[2]}'); return false">
								{$this->vsLang->getWords('admin','Admin')}
							</a>
						</li>
				    </ul>
					<div id="sa_content_{$bw->input[2]}">
						    <div id="langmodule_{$bw->input[2]}" class="left-cell">
						    	<div id="MODULE_FILE_FORM_{$bw->input[2]}">{$show['CURRENT_LANG_ADD_ITEM']}</div>
						    	<div id="MODULE_FILE_LIST_{$bw->input[2]}">{$show['CURRENT_LANG_ITEM']}</div>
						    	<div class="clear"></div>
						    </div>
						    <div id="langlist_{$bw->input[2]}" class="right-cell">
						    	{$show['LANGUAGE_LIST']}
						        <div class="clear"></div>
							</div>
						    <div class="clear"></div>
						    
						    <if=" $vsSettings->getSystemKey('display_alert', 0 , "languages", 1, 1) ">
						    <div class="ui-state-error ui-corner-all" style="padding:10px 5px;">
						        <p align="left">
						            <span style="float: left; margin-right: 0.3em;" class="ui-icon ui-icon-alert"></span>
						            <strong>Alert:</strong> The system language is currently stored in <strong>{$storein}</strong>. 
						    		So if you make any change it will be saved to <strong>{$storein}</strong>.
						        </p>
						    </div>
						    </if>
						    
						</div>	
					</div>
EOF;
			return $BWHTML;
		}
	}
?>