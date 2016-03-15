<?php
class skin_partners extends skin_objectadmin{
    
function addEditObjForm($objItem, $option = array()) {
		global $vsLang, $bw,$vsSettings,$langObject;
                if($objItem->getPosition()) $pos = $objItem->getPosition();
                else $pos = 1;
		$BWHTML .= <<<EOF
			<div id="error-message" name="error-message"></div>
			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
				<input type="hidden" id="obj-cat-id" name="partnerCatId" value="{$objItem->getCatId()}" />
				<input type="hidden" id="pageCate" name="pageCate" value="{$bw->input['pageCate']}" />
				<input type="hidden" id="pageIndex" name="pageIndex" value="{$bw->input['pageIndex']}" />
				<input type="hidden" name="partnerId" value="{$objItem->getId()}" />
				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
					<span class="ui-dialog-title">{$option['formTitle']}</span>
                                         <p style="float:right; cursor:pointer;">
                                                <span class='ui-dialog-title' id='closeObj'>
                                                 {$langObject['itemObjBack']}
                                                </span>
                                            </p>
					</div>
					<table class="ui-dialog-content ui-widget-content" cellspacing="1" border="0" style="width:100%">
                                              
                                        <tr class="smalltitle">
                                                <td class="label_obj">{$langObject['itemObjWebsite_Name']}:</td>
                                                <td><input size="43" type="text" name="partnerTitle" value="{$objItem->getTitle()}" id="obj-title"/></td>
                                         <if="$vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])">       
                                                <td align='left' rowspan="3">
                                                <if="$objItem->getImage()">
                                                    {$objItem->createImageCache($objItem->getImage(),250, 150)}
                                                    <input name="oldImage" value="{$objItem->getImage()}" type="hidden" />
                                                    <p>{$langObject['itemObjDeleteImage']}<input type="checkbox" class="checkbox" name="partnerDeleteImage" /></p>
                                                <else />
                                                    {$objItem->createImageCache($objItem->getImage(), 250, 150,0,1, 1, 1)}
                                                </if>
                                                </td>
                                           </if>
										   <if="$bw->input['module']=='videos'">
                                            <if="$vsSettings->getSystemKey($bw->input[0].'_address',0, $bw->input[0])">   
                                                            <td align='left' rowspan="3">
                                           <iframe  id="videos_obj_code_img" style="" 
								width="200" height="200" src="http://www.youtube.com/embed/{$objItem->getAddress()}" frameborder="0" allowfullscreen></iframe>
                                                                </td>
                                                            </if>
											</if>					
                                                                
                                        </tr>
                                                    
                                        <if="$vsSettings->getSystemKey($bw->input[0].'_address',0, $bw->input[0])">
                                            <tr class="smalltitle">
                                                    <td class="label_obj">Link Youtube:</td>
                                                    <td><input size="43" type="text" name="partnerAddress" value="{$objItem->getAddress()}" id="videos_obj_code"/></td>
                                            </tr>
                                        </if>
                                       <if="$vsSettings->getSystemKey($bw->input[0].'_website',0, $bw->input[0])">   
                                            <tr class="smalltitle">
                                                    <td class="label_obj">{$langObject['itemObjWebsite']}:</td>
                                                    <td><input size="43" type="text" name="partnerWebsite" value="{$objItem->getWebsite()}" id="obj-website"/></td>
                                            </tr>
                                       </if> 
                                       <tr class="smalltitle">
                                           <td class="label_obj">{$langObject['itemObjIndex']}:</td>
                                            <td>
                                            <input size="43" type="text" name="partnerIndex" value="{$objItem->getIndex()}" id="obj-Index"/>
                                            </td>
                                        </tr>

                                        <tr class="smalltitle">
                                                <td class="label_obj">{$langObject['itemObjStatus']}:</td>
                                            <td>

                                               <input type="radio" value="1" name="partnerStatus" id="partnerStatus" class="radio" checked>
                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjDisplay']}</label>  

                                              <input type="radio" value="0" name="partnerStatus" id="partnerStatus" class="radio">
                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjHide']}</label>

                                               
                                            </td>
                                            </tr>
                                                                        <if="$bw->input['module']=='banner111'">
                                                                         <tr class="smalltitle">
                                            <td>{$vsLang->getWords('obj_Position', "Position")}</td>
                                            <td>
                                                <input type="radio" value="1" name="partnerPosition" class="radio">
                                                <label style="padding-right: 10px" for="left">{$vsLang->getWords('global_left', "Left")}</label>

                                                <input type="radio" value="2" name="partnerPosition" class="radio">
                                                <label style="padding-right: 10px" for="left">{$vsLang->getWords('global_right', "Right")}</label>
												
                                          

                                            </td>
                                        </tr>
                                                </if>
                            <if="$vsSettings->getSystemKey($bw->input[0].'_exptime',0,$bw->input[0])">
                            <tr class="smalltitle">
                                    <td>
                                            {$vsLang->getWords('obj_begtime', 'Begin Time')}
                                    </td>
                                    <td colspan="2">
                                        <input size="43" name="partnerBeginTime" value="{$objItem->getExpTime("SHORT")}" id="partnerBeginTime"/>
                                    </td>
                            </tr>
                            <tr class="smalltitle">
                                    <td>
                                            {$vsLang->getWords('obj_exptime', 'Expire Time')}
                                    </td>
                                   <td colspan="2">
                                        <input size="43" name="partnerExpTime" value="{$objItem->getBeginTime("SHORT")}" id="partnerExpTime"/>
                                    </td>
                            </tr>
                            </if>

                            <if="$vsSettings->getSystemKey($bw->input[0].'_price', 0, $bw->input[0])">
                            <tr class="smalltitle">
                                <td>
                                    {$langObject['itemObjPrice']}
                                </td>
                                <td colspan="2">
                                    <input  size="43" type="text" name="partnerPrice" value="{$objItem->getPrice()}" id="obj-price"/>
                                </td>
                            </tr>
                            </if>
                            <if="$vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])">
                            <tr class="smalltitle">
                                    <td class="label_obj">{$langObject['itemObjFile']}:</td>
                                    <td>
                                            <div style="padding:2px 5px;">
                                                    <input  size="29" type="file" name="partnerIntroImage" id="partnerIntroImage"/>
                                            </div>
                                    </td>
                                    <td colspan="2" align="center">{$vsLang->getWords('global_image_size', "Image size ")}
                                        ({$vsSettings->getSystemKey($bw->input[0].'_image_timthumb_size', 'Size: 500 x 300 px', $bw->input[0])})
                                    </td>
                            </tr>
                            </if>

                            <if="$vsSettings->getSystemKey($bw->input[0].'_intro', 0, $bw->input[0])">
                            <tr class="smalltitle">
                                    <td class="label_obj">{$langObject['itemObjIntro']}:</td>
                                    <td colspan="3">{$objItem->getIntro()}</td>
                            </tr>
                            </if>

                            <if="$vsSettings->getSystemKey($bw->input[0].'_content', 0, $bw->input[0])">
                            <tr class="smalltitle">
                                            <td colspan="4" class="label_obj">{$langObject['itemObjContent']}:</td>
                            </tr>
                            <tr class="smalltitle">
                                    <td colspan="4" align="center">{$objItem->getContent()}</td>
                            </tr>
                            </if>

                            <tr class="smalltitle">
                                    <td class="ui-dialog-buttonpanel" colspan="4" align="center">
                                            <input type="submit" name="submit" value="{$option['formSubmit']}" />
                                    </td>
                            </tr>
                            </table>
                    </div>
            </form>
                                            <script type="text/javascript">
function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    if (match&&match[7].length==11){
        return match[7];
    }else{
        return url;
    }
}
</script>              
			<script language="javascript">
              	$('#closeObj').click(function(){                  
					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageIndex={$bw->input['pageIndex']}','obj-panel');
				});
				function updateobjListHtml(categoryId){
					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj-panel');
				}
				function alertError(message){
					jAlert(
						message,
						'{$bw->vars['global_websitename']} Dialog'
					);
				}

//				$(window).ready(function() {
//                                        $("input.numeric").numeric();
//					vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
//					vsf.jRadio('{$pos}','partnerPosition');
//                                        vsf.jSelect('{$objItem->getCatId()}','obj-category');
//
//                                        $('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
//                                        $('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
//
//                                        if(!$("#obj-cat-id").val()) $("#obj-cat-id").val($("#idCategory").val());
//
//                                       
//				});
				
				$(document).ready(function() {
               		$('#obj-category option').each(function(){
							$(this).removeAttr('selected');
						});
					$("input.numeric").numeric();
					vsf.jRadio('{$pos}','partnerPosition');
					vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
					vsf.jSelect('{$objItem->getCatId()}','obj-category');
//					$('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
//               		$('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
				});

                                $('#obj-category').change(function() {
					var parentId = '';
					$("#obj-category option:selected").each(function () {
						parentId = $(this).val();
					});
					$('#obj-cat-id').val(parentId);
				});
				$('#add-edit-obj-form').submit(function(){
					var flag  = true;
					var error = "";
					var categoryId = 0;
					var count=0;
					
                 	
                 	$("#obj-category  option").each(function () {
						count++;
            			if($(this).attr('selected'))categoryId = $(this).val();
					});

					$('#obj-cat-id').val(categoryId);
					
					if(categoryId == 0 && count>1){
						error = "<li>{$langObject['itemListChoiseCate']}</li>";
						flag  = false;
					}
                 	
					var title = $("#obj-title").val();
					if(title == 0 || title == ""){
						error += "<li>{$langObject['notItemObjTitle']}</li>";
						flag  = false;
						$('#obj-title').addClass('ui-state-error ui-corner-all-inner');
					}

                   	if(!flag){
						error = "<ul class='ul-popu'>" + error + "</ul>";
						vsf.alert(error);
						return false;
					}
					$('#obj-cat-id').val($('#obj-category').val());
					$('#obj-category').removeClass('ui-state-error ui-corner-all-inner');
					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel", "{$bw->input[0]}");
					return false;
				});
                                
			</script>
                        <script>
						//$(document).mousedown(refreshImage);
						$("#videos_obj_code").keyup(refreshImage);
						function refreshImage(){
                                                $("#videos_obj_code").val(youtube_parser($("#videos_obj_code").val()));
							$("#videos_obj_code_img").attr("src","http://www.youtube.com/embed/"+$("#videos_obj_code").val()).show();
						}
						</script>
EOF;
	}
//function addEditObjForm($objItem, $option = array()) {
//		global $vsLang, $bw,$vsSettings,$langObject;
//      	if($objItem->getPosition()) $pos = $objItem->getPosition();
//       	else $pos = 1;
//       
//		$BWHTML .= <<<EOF
//			<div id="error-message" name="error-message"></div>
//			<form id='add-edit-obj-form' name="add-edit-obj-form" method="POST"  enctype='multipart/form-data'>
//				<input type="hidden" id="obj-cat-id" name="partnerCatId" value="{$objItem->getCatId()}" />
//				<input type="hidden" id="pageCate" name="pageCate" value="{$bw->input['pageCate']}" />
//				<input type="hidden" id="pageIndex" name="pageIndex" value="{$bw->input['pageIndex']}" />
//				<input type="hidden" name="partnerId" value="{$objItem->getId()}" />
//				<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
//					<div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
//					<span class="ui-dialog-title">{$option['formTitle']}</span>
//                                         <p style="float:right; cursor:pointer;">
//                                                <span class='ui-dialog-title' id='closeObj'>
//                                                 {$langObject['itemObjBack']}
//                                                </span>
//                                            </p>
//					</div>
//					<table class="ui-dialog-content ui-widget-content" cellspacing="1" border="0" style="width:100%">
//
//                                        <tr class="smalltitle">
//                                                <td class="label_obj">{$langObject['itemObjWebsite_Name']}:</td>
//                                                <td><input size="43" type="text" name="partnerTitle" value="{$objItem->getTitle()}" id="obj-title"/></td>
//                                         	<if="$vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])">       
//                                                <td align='left' rowspan="4">
//                                                <if="$objItem->getImage()">
//                                                    {$objItem->createImageCache($objItem->getImage(),250, 150)}
//                                                    <input name="oldImage" value="{$objItem->getImage()}" type="hidden" />
//                                                    <p>{$langObject['itemObjDeleteImage']}<input type="checkbox" class="checkbox" name="partnerDeleteImage" /></p>
//                                                    
//                                                <else />
//                                                    {$objItem->createImageCache($objItem->getImage(), 250, 150,1,0)}
//                                                </if>
//                                                </td>
//                                           </if>
//                                        </tr>
//                                        <if="$vsSettings->getSystemKey($bw->input[0].'_address',0, $bw->input[0])">
//                                            <tr class="smalltitle">
//                                                    <td class="label_obj">{$langObject['itemObjAddress']}:</td>
//                                                    <td><input size="43" type="text" name="partnerAddress" value="{$objItem->getAddress()}" id="obj-address"/></td>
//                                            </tr>
//                                        </if>
//                                       <if="$vsSettings->getSystemKey($bw->input[0].'_website',0, $bw->input[0])">
//                                      	<tr class="smalltitle">
//                                                    <td class="label_obj">{$langObject['itemObjWebsite']}:</td>
//                                                    <td><input size="43" type="text" name="partnerWebsite" value="{$objItem->getWebsite()}" id="obj-website"/></td>
//                                      	</tr>
//                                      	</if>
//                                    	<if="$vsSettings->getSystemKey($bw->input[0].'_position',0, $bw->input[0])">
//                                       	<tr class="smalltitle">
//									    <td>{$vsLang->getWords('obj_Position', "Position")}</td>
//									    <td>
//									    	<input type="radio" value="1" name="partnerPosition" class="radio">
//									        <label style="padding-right: 10px" for="left">{$vsLang->getWords('global_position_left', "Trái")}</label>
//			
//			                               	<input type="radio" value="2" name="partnerPosition" class="radio">
//									        <label style="padding-right: 10px" for="left">{$vsLang->getWords('global_position_right', "Phải")}</label>
//									        <!--<input type="radio" value="3" name="partnerPosition" class="radio">
//									        <label style="padding-right: 10px" for="left">{$vsLang->getWords('global_position_video', "Video")}</label>-->
//									    </td>
//										</tr>
//                                        </if>
//                                       <tr class="smalltitle">
//                                           <td class="label_obj">{$langObject['itemObjIndex']}:</td>
//                                            <td>
//                                            <input size="43" type="text" name="partnerIndex" value="{$objItem->getIndex()}" id="obj-Index"/>
//                                            </td>
//                                        </tr>
//
//                                        <tr class="smalltitle">
//                                                <td class="label_obj">{$langObject['itemObjStatus']}:</td>
//                                            <td>
//
//                                               <input type="radio" value="1" name="partnerStatus" id="partnerStatus" class="radio" checked>
//                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjDisplay']}</label>  
//
//                                              <input type="radio" value="0" name="partnerStatus" id="partnerStatus" class="radio">
//                                                                        <label style="padding-right: 10px" for="left">{$langObject['itemObjHide']}</label>
//
//                                               
//                                            </td>
//                                            </tr>
//                            <if="$vsSettings->getSystemKey($bw->input[0].'_exptime',0,$bw->input[0])">
//                            <tr class="smalltitle">
//                                    <td>
//                                            {$vsLang->getWords('obj_begtime', 'Begin Time')}
//                                    </td>
//                                    <td colspan="2">
//                                        <input size="43" name="partnerBeginTime" value="{$objItem->getExpTime("SHORT")}" id="partnerBeginTime"/>
//                                    </td>
//                            </tr>
//                            <tr class="smalltitle">
//                                    <td>
//                                            {$vsLang->getWords('obj_exptime', 'Expire Time')}
//                                    </td>
//                                   <td colspan="2">
//                                        <input size="43" name="partnerExpTime" value="{$objItem->getBeginTime("SHORT")}" id="partnerExpTime"/>
//                                    </td>
//                            </tr>
//                            </if>
//
//                            <if="$vsSettings->getSystemKey($bw->input[0].'_price', 0, $bw->input[0])">
//                            <tr class="smalltitle">
//                                <td>
//                                    {$langObject['itemObjPrice']}
//                                </td>
//                                <td colspan="2">
//                                    <input  size="43" type="text" name="partnerPrice" value="{$objItem->getPrice()}" id="obj-price"/>
//                                </td>
//                            </tr>
//                            </if>
//                            <if="$vsSettings->getSystemKey($bw->input[0].'_image', 1, $bw->input[0])">
//                            <tr class="smalltitle">
//                                    <td class="label_obj">{$langObject['itemObjFile']}:</td>
//                                    <td>
//                                            <div style="padding:2px 5px;">
//                                                    <input  size="29" type="file" name="partnerIntroImage" id="partnerIntroImage"/>
//                                            </div>
//                                    </td>
//                                   <td></td>
//                            </tr>
//                            
//<tr class="smalltitle">
//                                    <td class="label_obj">{$vsLang->getWords('global_image_size', "Image size ")}:</td>
//                                    <td colspan="3">({$vsSettings->getSystemKey($bw->input[0].'_image_width', 250, $bw->input[0])} x {$vsSettings->getSystemKey($bw->input[0].'_image_height', 150, $bw->input[0])})</td>
//                            </tr>
//                                    </if>
//                            <if="$vsSettings->getSystemKey($bw->input[0].'_intro', 0, $bw->input[0])">
//                            <tr class="smalltitle">
//                                    <td class="label_obj">{$langObject['itemObjIntro']}:</td>
//                                    <td colspan="3">{$objItem->getIntro()}</td>
//                            </tr>
//                            </if>
//
//                            <if="$vsSettings->getSystemKey($bw->input[0].'_content', 0, $bw->input[0])">
//                            <tr class="smalltitle">
//                                            <td colspan="4" class="label_obj">{$langObject['itemObjContent']}:</td>
//                            </tr>
//                            <tr class="smalltitle">
//                                    <td colspan="4" align="center">{$objItem->getContent()}</td>
//                            </tr>
//                            </if>
//
//                            <tr class="smalltitle">
//                                    <td class="ui-dialog-buttonpanel" colspan="4" align="center">
//                                            <input type="submit" name="submit" value="{$option['formSubmit']}" />
//                                    </td>
//                            </tr>
//                            </table>
//                    </div>
//            </form>
//			<script language="javascript">
//              	$('#closeObj').click(function(){                  
//					vsf.get('{$bw->input[0]}/display-obj-list/{$bw->input['pageCate']}/&pageIndex={$bw->input['pageIndex']}','obj-panel');
//				});
//				function updateobjListHtml(categoryId){
//					vsf.get('{$bw->input[0]}/display-obj-list/'+categoryId+'/','obj-panel');
//				}
//				function alertError(message){
//					jAlert(
//						message,
//						'{$bw->vars['global_websitename']} Dialog'
//					);
//				}
//
////				$(window).ready(function() {
////                                        $("input.numeric").numeric();
////					vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
////					vsf.jRadio('{$pos}','partnerPosition');
////                                        vsf.jSelect('{$objItem->getCatId()}','obj-category');
////
////                                        $('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
////                                        $('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
////
////                                        if(!$("#obj-cat-id").val()) $("#obj-cat-id").val($("#idCategory").val());
////
////                                       
////				});
//				
//				$(document).ready(function() {
//               		$('#obj-category option').each(function(){
//							$(this).removeAttr('selected');
//						});
//					$("input.numeric").numeric();
//					vsf.jRadio('{$pos}','partnerPosition');
//					vsf.jRadio('{$objItem->getStatus()}','partnerStatus');
//					vsf.jSelect('{$objItem->getCatId()}','obj-category');
////					$('#partnerExpTime').datepicker({dateFormat: 'dd/mm/yy'});
////               		$('#partnerBeginTime').datepicker({dateFormat: 'dd/mm/yy'});
//				});
//
//                                $('#obj-category').change(function() {
//					var parentId = '';
//					$("#obj-category option:selected").each(function () {
//						parentId = $(this).val();
//					});
//					$('#obj-cat-id').val(parentId);
//				});
//				$('#add-edit-obj-form').submit(function(){
//					var flag  = true;
//					var error = "";
//					var categoryId = 0;
//					var count=0;
//					
//                 	
//                 	$("#obj-category  option").each(function () {
//						count++;
//            			if($(this).attr('selected'))categoryId = $(this).val();
//					});
//
//					$('#obj-cat-id').val(categoryId);
//					
//					if(categoryId == 0 && count>1){
//						error = "<li>{$langObject['itemListChoiseCate']}</li>";
//						flag  = false;
//					}
//                 	
//					var title = $("#obj-title").val();
//					if(title == 0 || title == ""){
//						error += "<li>{$langObject['notItemObjTitle']}</li>";
//						flag  = false;
//						$('#obj-title').addClass('ui-state-error ui-corner-all-inner');
//					}
//
//                   	if(!flag){
//						error = "<ul class='ul-popu'>" + error + "</ul>";
//						vsf.alert(error);
//						return false;
//					}
//					$('#obj-cat-id').val($('#obj-category').val());
//					$('#obj-category').removeClass('ui-state-error ui-corner-all-inner');
//					vsf.uploadFile("add-edit-obj-form", "{$bw->input[0]}", "add-edit-obj-process", "obj-panel", "{$bw->input[0]}");
//					return false;
//				});
//                                
//			</script>
//EOF;
//	}
}
?>