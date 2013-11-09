<?php
class skin_contacts extends skin_objectpublic{

	function contactForm() {
		global $vsLang, $bw, $vsSettings,$vsPrint;
		$vsPrint->addJavaScriptFile ("jquery.numeric",1);	

		$BWHTML .= <<<EOF
        <form name="formContact" id="formContact" class="contact_form" method="POST" action="{$bw->base_url}contacts/send" enctype="multipart/form-data">
			<input type="hidden" name="targetpage" value="{$bw->input['targetpage']}" />
         	<input type="hidden" value="{$bw->input['contactType']}" name="contactType"/>
			
			<if=" $vsSettings->getSystemKey("contact_form_name", 1, "contacts", 0, 1)">
			<label>{$vsLang->getWords('contact_fullname','Họ tên')}:</label>
            <input type="text" id="contactName" name="contactName" value="{$bw->input['contactName']}" title="{$vsLang->getWords('contact_fullname','Họ tên')}" />
            <div class='clear'></div>
            </if>
            
            <if=" $vsSettings->getSystemKey("contact_form_address", 1, "contacts", 0, 1)">
            <label>{$vsLang->getWords('contact_address','Địa chỉ')}:</label>
            <input id="contactAddress" name="contactAddress" value="{$bw->input['contactAddress']}" title="{$vsLang->getWords('contact_address','Địa chỉ')}"  type="text" />
			<div class='clear'></div>
            </if>
			
            <if=" $vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 0, 1)">
            <label>{$vsLang->getWords('contact_phone','Điện thoại')}:</label>
            <input type="text" class="numeric"  value="{$bw->input['contactPhone']}" id="contactPhone" name="contactPhone" maxlength="11" title="{$vsLang->getWords('contact_phone','Điện thoại')}" />
            <div class='clear'></div>
			</if>
			
			<if=" $vsSettings->getSystemKey("contact_form_email", 1, "contacts", 0, 1)">
            <label>{$vsLang->getWords('contact_email','Email')}:</label>
			<input type="text" id="contactEmail" value="{$bw->input['contactEmail']}" name="contactEmail" title="{$vsLang->getWords('contact_email','Email')}" />
			<div class='clear'></div>
            </if>
            
            <if=" $vsSettings->getSystemKey("contact_form_title", 1, "contacts", 0, 1)">
            <label>{$vsLang->getWords('contact_title','Tiêu đề')}:</label>
            <input type="text" class='col_left' id="contactTitle" name="contactTitle" value="{$bw->input['contactTitle']}" title="{$vsLang->getWords('contact_title','Tiêu đề')}" />
            <div class='clear'></div>
            </if>
            
            <if="$vsSettings->getSystemKey("contact_form_file", 0, "contacts", 0, 1)">
            <label>File:</label>
            <input type="file" class="file_input" size="72" id="contactFile" name="contactFile"  />
			<div class="clear"></div>
            </if>
               
            <if="$vsSettings->getSystemKey("contact_form_content", 1, "contacts", 0, 1)">
         	<label>{$vsLang->getWords("contact_message","Nội dung")}</label>
            <textarea id="contactMessage" name="contactContent">{$bw->input['contactContent']}</textarea>
            </if>
     
            <if="$vsSettings->getSystemKey("contact_form_capchar", 0, "contacts", 0, 1)">
            <label>{$vsLang->getWords("contact_captcha","Mã bảo vệ")}:</label>
			<input type="text" name="contactSecurity" id="contactSecurity" style="width:100px"/> 
			<div style="margin-left:10px;float:left;">
            	<a href="javascript:;" style="float:left; padding-right:10px;">
                	<img id="vscapcha" src="{$bw->vars['board_url']}/vscaptcha">
               	</a>      	
		   		<a href="javascript:;" class="mamoi" id="reload_img">
					{$vsLang->getWords('contact_security','Tạo mã mới')}
				</a>
			</div>
			<div class="clear"></div>
			</if>
			<div class="clear"></div>
			<label>&nbsp;</label>
			<input type="submit" value="{$vsLang->getWords('contact_sends','Gửi')}" class="btn" />
			<input type="reset" value="{$vsLang->getWords('contact_reset','Làm lại')}" class="btn" />
			<div class="clear"></div>
		</form>
		
			<script type='text/javascript'>
				$("#reload_img").click(function(){
                          $("#vscapcha").attr("src",$("#vscapcha").attr("src")+"?a");
                          $('#random').val('');
                          return false;
       			});
       
				function checkMail(mail){
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!filter.test(mail)) return false;
					return true;
				}
				
				$("input.numeric").numeric();
				
				$('#formContact').submit(function(){
					
					<if=" $vsSettings->getSystemKey("contact_form_name", 1, "contacts", 1, 1)">
					if(!$('#contactName').val()) {
						jAlert('{$vsLang->getWords('err_contact_name_blank','Vui lòng nhập họ tên!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactName').addClass('vs-error');
						$('#contactName').focus();
						return false;
					}
					</if>
					
					<if=" $vsSettings->getSystemKey("contact_form_address", 1, "contacts", 1, 1)">
					if(!$('#contactAddress').val()) {
						jAlert('{$vsLang->getWords('err_contact_address_blank','Vui lòng nhập địa chỉ!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactAddress').addClass('vs-error');
						$('#contactAddress').focus();
						return false;
					}
					</if>
					
					<if=" $vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 1, 1)">
					if(!$('#contactPhone').val()) {
						jAlert('{$vsLang->getWords('err_contact_phone_blank','Vui lòng nhập số điện thoại!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactPhone').addClass('vs-error');
						$('#contactPhone').focus();
						return false;
					}
					</if>
					
					
					if(!$('#contactEmail').val()|| !checkMail($('#contactEmail').val())) {
						jAlert('{$vsLang->getWords('err_contact_email_blank','Vui lòng nhập đúng loại email!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactEmail').addClass('vs-error');
						$('#contactEmail').focus();
						return false;
					}
					
					
					
					<if=" $vsSettings->getSystemKey("contact_form_title", 1, "contacts", 1, 1)">
					if(!$('#contactTitle').val()) {
						jAlert('{$vsLang->getWords('err_contact_title_blank','Vui lòng nhập câu hỏi!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactTitle').addClass('vs-error');
						$('#contactTitle').focus();
						return false;
					}
					</if>

					if($('#contactMessage').val().length < 15) {
						jAlert('{$vsLang->getWords('err_contact_message_blank','Thông tin quá ngắn!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactMessage').addClass('vs-error');
						$('#contactMessage').focus();
						return false;
					}
                                        

					<if=" $vsSettings->getSystemKey("contact_form_capchar", 0, "contacts", 1, 1)">
					if(!$('#contactSecurity').val()) {
						jAlert('{$vsLang->getWords('err_contact_phone_security','Vui lòng nhập mã bảo vệ!')}','{$bw->vars['global_websitename']} Dialog');
						$('#contactSecurity').addClass('vs-error');
						$('#contactSecurity').focus();
						return false;
					}
					</if>
					
					$('#formContact').submit();
					return false;
				});
			</script>
EOF;
		return $BWHTML;
	}

	function thankyou($url, $option){
		global $vsLang,$bw,$vsTemplate,$vsPrint;
		
		$BWHTML .= <<<EOF
		<script type='text/javascript'>
			setTimeout('delayer()', 3000);
			function delayer(){
	    		window.location = "{$url}";
			}
		</script>
		
		<div class='row' id='contact-main-content'>
			<div class="span6 well">
		        <h3 class="center_title detail_title">
		        	<a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
					</a>
				</h3>
				
				<div class='thankyou'>
		        	<p>{$vsLang->getWords('contacts_redirectText', 'Thank you! Your message have been sent.')}</p>
		        	
		        	<p>{$vsLang->getWords('redirect_title','Chuyển trang...')}</p>
		        	<a href='{$url}'>
		        		({$vsLang->getWords('redirect_immediate','Click vào đây nếu không muốn chờ lâu')})
		        	</a>
	        	</div>
			</div>
			
        	{$this->displayMap($option)}
		</div>
            
EOF;
		return $BWHTML;
	}
        
	function showDefault($option= array()){
		global $bw, $vsLang, $vsSettings,$vsLang;
             
		$bw->input['contactType'] = 0;
		$this->index = 1;
		$this->total = count($option['plist']);
		
		$BWHTML = <<<EOF
		<div class='row' id='contact-main-content'>
			<div class="span6 well">
		        <h3 class="center_title detail_title">
		        	<a href="{$bw->base_url}{$bw->input[0]}" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}
					</a>
				</h3>
				
				<p class="note">{$vsLang->getWords('contact_note','Xin vui lòng liên hệ với chúng tôi theo các số điện thoại trên hoặc bằng cách điền thông tin vào mẫu sau:')}</p>
				{$this->contactForm()}
			</div>
			
			{$this->displayMap($option)}
		</div>
		
		
EOF;
			return $BWHTML;
	}
	
	function displayMap($option){
		global $bw, $vsLang, $vsSettings,$vsLang;
		 
		$this->index = 1;
		$this->total = count($option['plist']);
		
		$BWHTML = <<<EOF
			<div class="span5 well">
				<h3 class="center_title detail_title">
		        	<a href="{$bw->base_url}{$bw->input[0]}#contact-main-content" title='{$vsLang->getWords($bw->input[0]."_title", $bw->input[0])}'>
						{$vsLang->getWords($bw->input[0]."_map_title", 'Bản đồ')}
					</a>
				</h3>
				<div id="contact-map-list">
					<foreach=" $option['plist'] as $obj ">
		           		<a class="{$obj->active}" href="{$bw->base_url}contacts/{$obj->getCleanTitle()}-{$obj->getId()}#contact-main-content" title='{$obj->getTitle()}'>
							{$obj->getTitle()} 
						</a>
						<if=" $this->index++ < $this->total ">
							 |
						</if>
	                </foreach>
	                <div class='clear'></div>
	           </div>
	           
		        <div class="map">
		        	<div style='margin-bottom: 20px; border-bottom: 1px dashed #444;'>{$option['contact']->getIntro()}</div>
	           		
	           		<div id='map_canvas'></div>
				</div>
			</div>
		</div>
	        			
	        			
        	<if=" $option['contact'] ">
	    	<if=" $option['contact']->getLongitude() && $option['contact']->getLatitude() ">
	    		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
	    		<script  type="text/javascript">
	    		//key=AIzaSyD2heuHJ0KdL8IPCyE3OYQrARjSjCeVGMI&
				    function init() {
				    	var myHtml = "<h4>{$option['contact']->getTitle()}</h4><p>{$option['contact']->getAddress()}</p>";
	
				    	
				      	var map = new google.maps.Map(
				      					document.getElementById("map_canvas"),
				      					{scaleControl: true}
				      				);
				      	map.setCenter(new google.maps.LatLng({$option['contact']->getLatitude()},{$option['contact']->getLongitude()}));
				      	map.setZoom(15);
				      	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
		
				      	var marker = new google.maps.Marker({
				      						map: map,
				      						position:map.getCenter()
										});
		
						var infowindow = new google.maps.InfoWindow({
											'pixelOffset': new google.maps.Size(0,15)
										});
				      	infowindow.setContent(myHtml);
				      	infowindow.open(map, marker);
				    }
				      			
				      			
			    	$(document).ready(function(){
						init();
					});
				</script>
			</if>
			</if>		
EOF;
	}
}