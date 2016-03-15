<?php
class skin_contacts extends skin_objectpublic{

	function contactForm() {
            global $vsLang, $bw, $vsSettings,$vsPrint,$vsTemplate;
            $vsPrint->addJavaScriptFile ("jquery.numeric",1);
            $vsPrint->addJavaScriptFile ("jquery.placeholder");
            $BWHTML .= <<<EOF

        <form name="formContact" class="form_contact" id="formContact"  method="POST" action="{$bw->base_url}contacts/send/" enctype="multipart/form-data">

            <input type="hidden" value="0" name="contactType"/>

            <if=" $vsSettings->getSystemKey("contact_form_name", 1, "contacts", 0, 1)">
                <input  required placeholder="{$vsLang->getWords('contact_full_name','Họ và tên')}" class="form-control" type="text" id="contactName" value="{$bw->input['contactName']}" name="contactName" title="{$vsLang->getWords('contact_full_name','Tên')}" />
            </if>

            <if=" $vsSettings->getSystemKey("contact_form_phone", 1, "contacts", 0, 1)">
                <input required placeholder="{$vsLang->getWords('contact_phone','Điện thoại')}" class="form-control" type="text" class="numeric" value="{$bw->input['contactPhone']}" id="contactPhone" name="contactPhone" title="{$vsLang->getWords('contact_phone','Điện thoại')}" />
            </if>

            <if=" $vsSettings->getSystemKey("contact_form_address", 1, "contacts", 0, 1)">
                <input required placeholder="{$vsLang->getWords('contact_address','Địa chỉ')}" class="form-control" id="contactAddress" value="{$bw->input['contactAddress']}" name="contactAddress" title="{$vsLang->getWords('contact_address','Địa chỉ')}"  type="email" />
            </if>

            <if=" $vsSettings->getSystemKey("contact_form_email", 1, "contacts", 0, 1)">
                <input required placeholder="{$vsLang->getWords('contact_email','Email')}" class="form-control" type="text" id="contactEmail" value="{$bw->input['contactEmail']}" name="contactEmail" title="{$vsLang->getWords('contact_email','Email')}" />
            </if>

            <if=" $vsSettings->getSystemKey("contact_form_title", 1, "contacts", 0, 1)">
                <input  required placeholder="{$vsLang->getWords('contact_title','Tiêu đề')}" class="form-control" class="col_left" type="text" id="contactTitle" value="{$bw->input['contactTitle']}" name="contactTitle"  title="{$vsLang->getWords('contact_title','Tiêu đề')}" />
            </if>

            <if="$vsSettings->getSystemKey("contact_form_content", 1, "contacts", 0, 1)">
                <textarea required placeholder="{$vsLang->getWords("contact_message","Nội dung")}" class="form-control" id="contactMessage" class="form_content" name="contactContent" >{$bw->input['contactContent']}</textarea>
            </if>

            
            <input required placeholder="{$vsLang->getWords("contact_captcha","Mã bảo vệ")}" class="form-control" type="text" name="contactSecurity" id="contactSecurity" style="width:100px;float:left;"/> 
            <div style="margin-left:10px;float:left;">
            <a href="javascript:;" style="float:left; padding-right:10px;">
                <img id="vscapcha" src="{$bw->vars['board_url']}/vscaptcha">
            </a>	

            <a href="javascript:;" class="mamoi" id="reload_img">
                    {$vsLang->getWords('contact_security','Tạo mã mới')}
            </a>
            </div> 
            <div class="clear_left"></div>
            <p style="color:red;margin-left: 75px;">{$bw->input['message']}</p>
            <div class="clear_left"></div>
            <input type="reset" class="input_reset btn btn-success" value="{$vsLang->getWords('contact_rs','Làm lại')}" style="width:45%">
            <input type="submit" value="{$vsLang->getWords('contact_sends','Gửi')}" class="input_submit btn btn-success" style="width:45%" />
            <div class="clear_left"></div>
    </form>
EOF;
		return $BWHTML;
	}

	function thankyou($text, $url){

		global $vsLang,$bw,$vsTemplate,$vsPrint;
		$BWHTML = <<<EOF
				<script type='text/javascript'>
					setTimeout('delayer()', 3000);
					function delayer(){
	    				window.location = "{$bw->base_url}$url.html";
					}
				</script>
	 <div id="center">
	<div id="center_sub">   
    
    	<div id="sitebar">   
        	<h3 class="sitebar_title">{$text}</h3>
    	{$vsTemplate->global_template->search}
        
        
        </div>
        <!-- STOP SITEBAR -->
        
        <div id="content">       
        	<h3 class="main_title"><span>{$vsLang->getWords("hoivatraloi","câu hỏi & trả lời")}</span></h3>
			
		<div class="primary">
     		<div class="container_contact">
           		<div class="address">
               		
                 	<p>{$vsLang->getWords('redirect_title','Chuyển trang...')}</p>
		 			<a style="color:#faaa20;" href='{$bw->base_url}{$url}'>({$vsLang->getWords('redirect_immediate','Click vào đây nếu không muốn chờ lâu')})</a>
            
              	</div><!--End address-->
            	
         	</div>
    	</div><!--end primary-->
	   	</div>
        <!-- STOP CONTENT -->
        
        
	</div>

</div>	
		
	
EOF;
		return $BWHTML;
	}


function showDefault($option=array()){
		global $bw, $vsLang, $vsSettings,$vsPrint,$vsTemplate;
		
		$BWHTML = <<<EOF
        
            <div class="main_item">
                <div class=" col-lg-3 col-md-4 col-sm-6 col-xs-12">
                    <div class="main_info">
                        <h3 class="lienhe_tt">{$option['contact']->getTitle()}</h3>
                        <p><p>{$option['contact']->getContent()}</p>
                        <h3 class="lienhe_tt">Form liên hệ </h3>
                        <div  id="contact">
                            {$this->contactForm()}
                             <div class="clear"></div> 
                        </div>
                    </div>
                    
                </div>
                <div class="primary1 col-lg-9 col-md-8 col-sm-6 col-xs-12">
                    <div class="map" id="map_canvas" ></div> 
                </div>
            </div>
<if="$option['contact'] && $option['contact']->getLongitude() && $option['contact']->getLatitude()">
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true&language=vi"></script>
                    <script  type="text/javascript">
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

EOF;
			return $BWHTML;
	}

	function loadRequireJavascript(){
		global $vsLang, $bw;
		$BWHTML = <<<EOF
			<script type='text/javascript'>
				fontend = {
					get:function(act, id) {
						var params = {
							ajax		:	1,
							vs			: 	act,
							identifyId 	:	document.getElementById('identifyCode').name
						};
						$.get(ajaxfile,params,function(data){
							document.getElementById('identifyCode').name = data;
							document.getElementById('identifyCode').src = '{$bw->base_url}contacts/createIdentifyCodeImage/'+data;
						});
					},

				submitForm:function(obj,act,id) {
						var params = {
							vs:act,
							ajax: 1
						};

						var count = 0;
						obj
						.find("input[type='radio']:checked, input[checked], input[type='text'], input[type='hidden'], input[type='password'], input[type='submit'], option[selected], textarea")
						.each(function() {
							params[ this.name || this.id || this.parentNode.name || this.parentNode.id ] = this.value;
						});
						$.post(ajaxfile,params,function(data){
							$("#"+id).html(data);
						});
					}
				}
			</script>
EOF;
		return $BWHTML;
	}


}
?>