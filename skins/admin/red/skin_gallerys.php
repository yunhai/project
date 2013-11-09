<?php
/**
 * @author Sanh Nguyen
 * @version 1.0 RC
 */
class skin_gallerys extends skin_objectadmin{
    
function addOtionList($obj) {
		global $vsLang, $bw,$vsSettings,$tableName;
    	$BWHTML .= <<<EOF
                
   		<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" onclick="vsf.popupGet('gallerys/display-file/{$obj->getId()}','auto{$obj->getId()}')">
       	{$vsLang->getWords('global_album','Album')}
   		</a>
              
EOF;
            return $BWHTML;
        }
	
        
function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw,$vsSettings,$tableName;
		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST" enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="{$tableName}CatId" value="{$option['categoryId']}" />
				<input type="hidden" name="{$tableName}Id" value="{$objItem->getId()}" />
				<input type="hidden" name="pageInde" value="{$bw->input['pageInde']}" />
				<input type="hidden" name="pageCate" value="{$bw->input['pageCate']}" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
						<span class="ui-dialog-title">{$option['formTitle']}</span>
                                                 <p style="float:right; cursor:pointer;">
                                                <span class='ui-dialog-title' id='closeObj'>
                                                 {$vsLang->getWords('obj_back', 'Back')}
                                                </span>
                                            </p>
					</div>
					<table class="ui-dialog-content ui-widget-content" style="width:100%;">
						<if="$vsSettings->getSystemKey($bw->input[0].'_title',1, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj" width="75">{$vsLang->getWords('obj_title', 'Title')}:</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Title" value="{$objItem->getTitle()}" id="obj-title"/>
							</td>
						</tr>
						</if>
							
						<if="$vsSettings->getSystemKey($bw->input[0].'_author',0, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$vsLang->getWords('obj_Author', 'Author')}:
							</td>
							<td colspan="3">
								<input style="width:100%;" name="{$tableName}Author" value="{$objItem->getAuthor()}"/>
							</td>
						</tr>
						</if>

                                                <if="$vsSettings->getSystemKey($bw->input[0].'_code',0, $bw->input[0])">
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$vsLang->getWords('obj_Code', 'Code')}:
							</td>
							<td colspan="3">
								<input style="width:40" name="{$tableName}Code" value="{$objItem->getCode()}"/>
							</td>
						</tr>
						</if>
						
						
						<tr class='smalltitle'>
							<td class="label_obj"  width="75">
								{$vsLang->getWords('obj_index', 'Index')}:
							</td>
							<td width="170" colspan="3">
								<input size="10" class="numeric" name="{$tableName}Index" value="{$objItem->getIndex()}" />
                                                                <span style="margin-right: 20px;margin-left:40px">{$vsLang->getWords('obj_Status', 'Status')}</span>
                                                                <label>{$vsLang->getWords('status_display','Display')}</label>

								<input name="{$tableName}Status" id="{$tableName}Status1" value='1' class='c_noneWidth' type="radio" checked />

								<label>{$vsLang->getWords('status_hidden','Hide')}</label>
								<input name="{$tableName}Status" id="{$tableName}Status0" value='0' class='c_noneWidth' type="radio" />


								<if=" $vsSettings->getSystemKey($bw->input[0].'_home',0, $bw->input[0]) ">
								<label>{$vsLang->getWords('status_2','Special')}</label>
								<input name="{$tableName}Status" id="{$tableName}Status2" value='2' class='c_noneWidth' type="radio" />
								</if>
							</td>
						</tr>
						
						<if="$vsSettings->getSystemKey($bw->input[0].'_image',1, $bw->input[0])">

						<tr class='smalltitle'>
							<td class="label_obj">
								{$vsLang->getWords('obj_image_file', "File")}:
							</td>
							<td>
								<input onclick="checkedLinkFile($('#link-file').val());" onclicktext="checkedLinkFile($('#link-file').val());" type="radio" id="link-file" name="link-file" value="file" checked="checked"/>
								<input size="27" type="file" name="{$tableName}IntroImage" id="{$tableName}IntroImage" /><br />
								 <!--{$vsSettings->getSystemKey($bw->input[0]."_image_timthumb_size","(size:100x100px)", $bw->input[0])}-->
							</td>
							<td colspan="2" rowspan="2">
								{$objItem->createImageCache($objItem->getImage(), 100, 50)}
								<br/>
								<if=" $objItem->getImage() && $vsSettings->getSystemKey($bw->input[0].'_image_delete',1, $bw->input[0]) ">
								<input type="checkbox" name="deleteImage" id="deleteImage" />
								<label for="deleteImage">{$vsLang->getWords('delete_image','Delete Image')}</lable>
								</if>
							</td>
						</tr>						
						</if>
						
						
						
						
						<tr>
							<td class="ui-dialog-buttonpanel" colspan="4" align="center">
								<input type="submit" name="submit" value="{$option['formSubmit']}" />
							</td>
						</tr>
					</table>
				</div>
			</form>
			<script language="javascript">
				$(window).ready(function() {
                                        $('#obj-category option').each(function(){
							$(this).removeAttr('selected');
						});
					$("input.numeric").numeric();
					checkedLinkFile();
					vsf.jRadio('{$objItem->getStatus()}','{$tableName}Status');
					vsf.jSelect('{$objItem->getCatId()}','obj-category');
				
				});
				
				$('#txtlink').change(function() {
					var img_html = '<img src="'+$(this).val()+'" style="width:100px; max-height:115px;" />'; 
					$('#td-obj-image').html(img_html);
				});
				
				$('#{$tableName}IntroImage').change(function() {
					var img_name = '<input type="hidden" id="image-name" name="image-name" value="'+$(this).val() +'"/>';
					$('#td-obj-image').html(img_name);
				});
				
				function checkedLinkFile(value){
					if(value=='link'){
						$("#txtlink").removeAttr('disabled');
						$("#{$tableName}IntroImage").attr('disabled', 'disabled');
					}else{
						$("#txtlink").attr('disabled', 'disabled');
						$("#{$tableName}IntroImage").removeAttr('disabled');
					}
				}
				
				$('#add-edit-obj-form').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId=0;
					var count=0;

					$("#obj-category  option").each(function () {
						count++;
                                                if($(this).attr('selected'))categoryId = $(this).val();
					});

					$('#obj-cat-id').val(categoryId);
					
					if(categoryId == 0 && count>1){
						error = "<li>{$vsLang->getWords('not_select_category', 'Please chose category')}</li>";
						flag  = false;
					}
					
					var title = $("#obj-title").val();
					if(title == 0 || title == ""){
						error += "<li>{$vsLang->getWords('null_title', 'Title cannot be blank')}</li>";
						flag  = false;
					}
					if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						vsf.alert(error);
						return false;
					}
					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel","{$bw->input[0]}");
					return false;
				});
                                $('#closeObj').click(function(){                                       
					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageInde={$bw->input['pageInde']}','obj-panel');
				});
			</script>
EOF;
	}
	
	
	function displayGalleryAlbumList($albumList,$option){
		global $bw,$vsLang,$vsSettings;
		$count = 0;
		$message = $vsLang->getWords('gallery_deleteConfirm_NoItem', "You haven't choose any items!");
		$BWHTML .= <<<EOF
                        <input type="hidden" name="checkedObj" id="checked-obj" value="" />
			<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
			    <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
			        <span class="ui-icon ui-icon-triangle-1-e"></span>
			        <span class="ui-dialog-title">{$vsLang->getWords('gallery_listAlbum','Danh sÃ¡ch cÃ¡c album')}</span>
			    </div>
			    <if="$vsSettings->getSystemKey($bw->input[0].'_header',1)">
			    <ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-corner-all-inner ui-widget-header">
			    	<li class="ui-state-default ui-corner-top">
			    		<a onclick="addPage()" title="{$vsLang->getWords('gallery_addAlum','Add')}" id="addAlum" href="#">
							{$vsLang->getWords('gallery_addAlum','Add')}
						</a>
		    		</li>
		    		<li class="ui-state-default ui-corner-top">
			        	<a id="deleteAlbum" title="{$vsLang->getWords('gallery_deleteAlbum','Delete')}" href="#">
							{$vsLang->getWords('gallery_deleteAlbum','Delete')}
						</a>
					</li>
			        <li class="ui-state-default ui-corner-top">
			        	<a id="hideAlbum" title="{$vsLang->getWords('gallery_hideAlbum','Hide')}" href="#">
							{$vsLang->getWords('gallery_hideAlbum','Hide')}
						</a>
					</li>
			        <li class="ui-state-default ui-corner-top">
			        	<a id="displayAlbum" title="{$vsLang->getWords('gallery_unhideAlbum','Display')}" href="#">
							{$vsLang->getWords('gallery_unhideAlbum','Display')}
						</a>
					</li>
			    </ul>
				</if> 
				<table cellspacing="1" cellpadding="1" id='productListTable' width="100%">
					<thead>
					    <tr>
					        <th style='text-align:center;' width="15"><input type="checkbox" onclick="vsf.checkAll()"  name="all" /></th>
					        <th style='text-align:center;' width="20">{$vsLang->getWords('gallery_labelStatus', 'Hiá»‡n')}</th>
					        <th style='text-align:center;' >{$vsLang->getWords('gallery_labelTitle', 'TÃªn Album')}</td>
					        <th style='text-align:center;' width="15">{$vsLang->getWords('gallery_labelIndex', 'Thứ tự')}</th>
					        <th style='text-align:center;' width="110">{$vsLang->getWords('gallery_option', 'TÃ¹y chá»�n')}</th>
					    </tr>
					</thead>
					<tbody>
						<if="count($albumList)">
							<foreach="$albumList as $Album">
								<tr class="row{$vsf_class}">
									<td align="center" width="20">
										<input type="checkbox" onclick="vsf.checkObject();" name="obj_{$Album->getId()}" value="{$Album->getId()}" class="myCheckbox" />
									</td>
									<td style='text-align:center' width="20">{$Album->getStatus('image')}</td>
									
									<td>
									<a href="javascript:vsf.get('gallerys/edit-album-form/{$Album->getId()}/','gallery-panel')" title='{$vsLang->getWords('gallery_edit_album','Click here to edit this album')}' class="editObj">
											{$Album->getTitle()}
										</a>
									</td>
									
									<td>{$Album->getIndex()}</td>
									
									<td class="ui-dialog-buttonpanel" colspan="4" align="center">
										<a onclick="vsf.popupGet('gallerys/display-file/{$Album->getId()}','auto{$Album->getId()}')" class="ui-state-default ui-corner-all ui-state-focus" href="javascript:;" >
											{$vsLang->getWords('images','Images')}
										</a>
									</td>
								</tr>
							</foreach>
						</if>
					</tbody>
					
					<tfoot>
						<tr>
							<th colspan='7'>
								<div style='float:right;'>{$option['paging']}</div>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
			<script type="text/javascript">
				function addPage(){
					vsf.get('gallerys/add-album-form','gallery-panel');
				}
				$('#deleteAlbum').click(function(){
                                      if(vsf.checkValue())
					jConfirm(
						'{$vsLang->getWords("gallery_deleteConfirm","Are you sure to delete these Album information?")}', 
						'{$bw->vars['global_websitename']} Dialog', 
						function(r){
							if(r){
                                                                jsonStr = $('#checked-obj').val();
								vsf.get('gallerys/delete-album/{$option['cateId']}/'+jsonStr+'/','gallery-panel');
							}
						}
					);
				});
				$('#hideAlbum').click(function(){
                                      if(vsf.checkValue())
						vsf.get('gallerys/update-album-status/{$option['cateId']}/'+$('#checked-obj').val()+'/0/','gallery-panel');
				});
				
				$('#displayAlbum').click(function(){
                                      if(vsf.checkValue())
						vsf.get('gallerys/update-album-status/{$option['cateId']}/'+$('#checked-obj').val()+'/1/','gallery-panel');
				});
				
			</script>
EOF;
		return $BWHTML;
	}
	
	function displayFile($option){
		return $BWHTML .= <<<EOF
			<div id="dialog" title="Dialog Title">
				<div class='left-cell'><div id='file-form' >{$option['file-form']}</div></div>
				<div id="file-panel" >{$option['file-list']}</div>
			</div>	
EOF;
	}
	
	function addEditFileForm($form = array(), $file,$album) {
		global $bw, $vsLang, $vsSettings;
		$BWHTML = "";
		if(!$album->getCode())
			$album->setCode(common);
			
		$albumName = $album->getCode()."/Album-{$album->getId()}";
		if(!$file->getId())
			$file->setStatus(1);

		$BWHTML .= <<<EOF
		 <style>
                #file-uploadsạng{z-index:9998;}
                </style>
			<div class="ui-widget ui-widget-content ui-corner-all">
				<div class="ui-title  ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
				<span class="ui-dialog-title">
					<if="$album->getCode()=='videohome'">
						{$vsLang->getWords('video_upload_add_video',"Thêm video")}:
					<else />
						{$form['title']}
					</if>
				</span></div>
				<form name="form" method="post" id="form-add-edit-file" enctype="multipart/form-data">
					<input type="hidden" name="oldFileId" id="file-id" value="{$file->getId()}" />
					<input type="hidden" name="oldFileTitle" value="{$file->getTitle()}" />
					<input type="hidden" name="albumId" id="albumId" value="{$form['albumId']}" />
                    <if="$vsSettings->getSystemKey($album->getCode().'_file_limit',0,$album->getCode())">
                        <input type="hidden" name="fileLimit" id="fileLimit" value="{$vsSettings->getSystemKey($album->getCode().'_file_limit',0,$album->getCode())}" />
                    </if>
				<div class="red">{$form['message']}</div>
				<table cellpadding="0" cellspacing="0" border="0"
					class="ui-dialog-content ui-widget-content">
					<if="$vsSettings->getSystemKey($album->getCode().'_file_title',1,$album->getCode())">
					<tr>
						<td class="normalcell" width="100">
						<if="$album->getCode()=='videohome'">
						{$vsLang->getWords('video_upload_form_name',"Tên video")}:
						<else />
							{$vsLang->getWords('file_upload_form_name',"Filename")}:
						</if>
						</td>
						<td class="normalcell" width="300"><input type="text" value="{$file->getTitle()}" name="fileTitle" size="45" id="fileTitle" /></td>
						<td rowspan="2">{$file->show(50,50)}</td>
					</tr>
					</if>
					<if="$vsSettings->getSystemKey($album->getCode().'_file_url',0,$album->getCode())">
					<tr>
						<td class="normalcell" width="100">{$vsLang->getWords('file_url',"File Link")} </td>
						<td class="normalcell" width="300"><input type="text" value="{$file->getUrl()}" name="fileUrl" size="45" id="fileUrl" /></td>
					</tr>
					</if>
					<tr>
						<td class="normalcell">
						<if="$album->getCode()=='videohome'">
							{$vsLang->getWords('video_upload_form_source',"File video")}:
						<else />
							{$vsLang->getWords('file_upload_form_source',"Source")}:
						</if>
							
						</td>
						<td class="ui-dialog-buttonpanel"><input type="file" name="fileUpload" id="fileUpload" /></td>
					</tr>
					<if="$vsSettings->getSystemKey($album->getCode().'_file_intro', 0,$album->getCode())">
					<tr>
						<td class="normalcell" width="100">{$vsLang->getWords('file_url',"File	Intro")}:</td>
						<td class="normalcell" width="300"><textarea name="fileIntro">{$file->getIntro()}</textarea></td>
					</tr>
					</if>
					<if="$vsSettings->getSystemKey($album->getCode().'_file_index', 0, $album->getCode())">
					<tr>
						<td class="normalcell" width="100">{$vsLang->getWords('file_index',"File Index")}:</td>
						<td class="normalcell" width="300">
                         	<input type="text" id="fileIndex" size ="5" value="{$file->getIndex()}" name="fileIndex" />
                        </td>
					</tr>
					</if>
					
					<if="$vsSettings->getSystemKey($album->getCode().'_multiupload',0,$album->getCode())">
					<tr >
						<td class="normalcell">
							<span class="form_multi">{$vsLang->getWords('multiupload', "Multi Upload")}:</span>
						</td>
						<td class="ui-dialog-buttonpanel" >
							<input type="hidden" name='attfiles' id='files' value="" />

							<div id="file-uploader-pandog">
					        <noscript>
					            <p>Please enable JavaScript to use file uploader.</p>
					            <!-- or put a simple form for upload here -->
					        </noscript>
					    	</div>
					    </td>
					</tr>
					</if>
					<if="$vsSettings->getSystemKey($album->getCode().'_file_status',0,$album->getCode())">
					<tr>
						<td class="normalcell" width="100">{$vsLang->getWords('file_status',"File	Status")}:</td>
						<td class="normalcell" width="300"><input type="checkbox" value="1" name="fileStatus" /></td>
					</tr>
					</if>
					<if="$vsSettings->getSystemKey($album->getCode().'_file_size',0,$album->getCode())">
					<tr>
						<td class="normalcell" width="100">{$vsLang->getWords('file_size',"Kích thước")}:</td>
						<td class="normalcell" width="300">{$vsSettings->getSystemKey($album->getCode().'_size','741x256',$album->getCode())}</td>
					</tr>
					</if>
					<if="$album->getCode()=='image_promotions'">
					<tr>
						<td class="normalcell" width="100">Lưu ý:</td>
						<td class="normalcell" width="300">Chỉ up những hình ảnh có đuôi.png và nền trong suốt</td>
					</tr>
					</if>
					<tr>
						<td class="ui-dialog-buttonpanel" align="right" colspan="2">
							<input class="ui-state-default ui-corner-all" type="submit" name="submit" value="{$form ['formSubmit']}" /> {$form ['switchform']}
						</td>
					</tr>
				</table>
				</form>
			</div>
			<script type="text/javascript">
				$('#switch-add-file-bt').click( function() {
					vsf.get('gallerys/add-form-file/{$form['albumId']}','file-form');
				});
				
				$('#form-add-edit-file').submit(function() {
                	var fileLimit =$('#fileLimit').val();
					<if="!$file->getId()">
                    var fileUp = $('#fileUpload').val();
                    if(fileUp == 0 || fileUp == ""){
                    jAlert(
                          "{$vsLang->getWords('global_choise_file Up ',"Choise file upload")}",
                          "{$bw->vars['global_websitename']} Dialog"
                    );
                    
                    return false;
                    
                 }
                                      
                 if(!isNaN(fileLimit)){
                 	var count = 0;
                    $('.sangpm').each(function(){
						count++;
					});
                    if(count>=fileLimit){
                    	jAlert(
                        	"{$vsLang->getWords('global_Max_upload ',"Max Up load ")} "+fileLimit+" file",
                        	"{$bw->vars['global_websitename']} Dialog"
                        );
                        return false;
                     }
                    }
                    </if>
					vsf.uploadFile("form-add-edit-file", "gallerys", "add-edit-gallery-file", "file-panel", 'gallery/{$albumName}');
					return false;
				});
				$(window).ready(function() {
					vsf.jCheckbox('{$file->getStatus()}','fileStatus');
				});
			</script>
			<script>
   				var running = 0;
				var uploader = new qq.FileUploader({
			        element: document.getElementById('file-uploader-pandog'),
		        	action: "{$bw->base_url}files/upload/&ajax=1&fileModule={$bw->input['module']}&albumId={$album->getId()}&fileFolder=gallery/{$albumName}/",
                                onSubmit: function(id, fileName){
                                    running++;
                                },
		        	onComplete: function(id, fileName, responseJSON){
                                    running -- ;
                                    var file = responseJSON.fileId + "," +$('#files').val();
                                        $('#files').val(file);
                                     if(running==0){
                                        var fi =file.substr(0,file.lastIndexOf(','));

                                        vsf.get("gallerys/display-file-list/{$album->getId()}/",'file-panel');
                                        return false;
                                        }

                                    }

		    		});
   		 	</script> 
EOF;
		return $BWHTML;
	}
	
	function displayGalleryFileList($file,$albumId){
		global $vsLang, $bw;
		$BWHTML .= <<<EOF
			<div class="ui-widget ui-widget-content ui-corner-all" style="background:url('images/bg_dialog_cd.jpg') repeat scroll 0 0; border:1px solid #A8211D !important">
			<if="count($file)">
				<foreach="$file as $value">
				<div class="sangpm ui-dialog-content ui-widget-content" style="float: left; width: 100px; margin: 5px;" title="{$value->getTitle()}">
					{$value->show(100,100)}
					<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript: displayEditFile({$value->getId()},$albumId)" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to edit this {$bw->input[0]}")}'>{$vsLang->getWords('global_edit','Sá»­a')}</a>
					<a class="ui-state-default ui-corner-all ui-state-focus" href="javascript: removeFile({$value->getId()},$albumId,'{$value->getTitle()}')" title='{$vsLang->getWords('newsItem_EditObjTitle',"Click here to delete this {$bw->input[0]}")}'>{$vsLang->getWords('global_del','XÃ³a')}</a>
					
				</div>
				</foreach>
			<else />
				<div class="error">{$vsLang->getWords('gallery_file_empty',"Không có hình ảnh nào.")}</div>	
			</if>
			<div class="clear"></div>
        </div>
		<script>
			function displayEditFile(fileId, cateId){
				vsf.get('gallerys/edit-form-file/'+cateId + '/'+fileId+'/','file-form');	
			}
	
			function removeFile(fileId, cateId, fileName){
				vsf.get("gallerys/delete-file/" + fileId +'/'+ cateId +'/', 'file-panel');
			}		
		</script>
EOF;
		return $BWHTML;
	}	
	
}
?>