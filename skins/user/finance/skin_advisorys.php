<?php
class skin_objectpublic{

function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate;
	
	
		$BWHTML .= <<<EOF
		
   <div id="center">
	<div id="center_sub">   
    
    	<div id="sitebar">   
        	<h3 class="sitebar_title">{$vsLang->getWords("pageTitle","Giỏ hàng")}</h3>
    	{$vsTemplate->global_template->search}
        
        
        </div>
        <!-- STOP SITEBAR -->
        
        <div id="content">       
        	<h3 class="main_title"><span>{$vsLang->getWords("hoivatraloi","câu hỏi & trả lời")}</span></h3>
            <foreach="$option['pageList'] as $obj">
            <!-- STOP HOIDAP ITEM -->
            <div class="hoidap_item">
            	<h3><a href="{$obj->getUrl($bw->input['module'])}">{$obj->getTitle()}</a></h3>
                <p><strong>{$vsLang->getWords("cauhoi","Câu hỏi")}:</strong> {$obj->getIntro(100)}</p>
            </div>
            </foreach>    
            <!-- STOP HOIDAP ITEM -->
            <if="$option['paging']">
            <div class="page">
                	{$option['paging']}
                </div>
            </if>    
                
        </div>
        <!-- STOP CONTENT -->
        
        
	</div>

</div>
    	
		
EOF;
	}

	function showDetail($obj,$option){
		global $bw,$vsLang,$vsPrint,$vsTemplate;
		

		$BWHTML .= <<<EOF
<div id="center">
	<div id="center_sub">   
    
    	<div id="sitebar">   
        	<h3 class="sitebar_title">{$vsLang->getWords("pageTitle","Giỏ hàng")}</h3>
    	{$vsTemplate->global_template->search}
        
        
        </div>
        <!-- STOP SITEBAR -->
        
        <div id="content">       
        	<h3 class="main_title"><span>{$vsLang->getWords("hoivatraloi","câu hỏi & trả lời")}</span></h3>
            <h3 class="cauhoi">{$obj->getTitle()}</h3>
            <h3>{$vsLang->getWords("cauhoi","Câu hỏi")}: </h3>   
            {$obj->getIntro(1000)}
            <h3>{$vsLang->getWords("traloi","Trả lời")}: </h3>
            {$obj->getContent()}
             <if="$option['other']">
             <div class="other">
                
             	<h3 class="other_title"><span>{$vsLang->getWords("cauhoikhac","các câu hỏi khác")}</span></h3>
                <foreach="$option['other'] as $other">
                <a href="{$other->getUrl($bw->input['module'])}">{$other->getTitle()}</a>
                </foreach>
             </div>
             </if>
        </div>
        <!-- STOP CONTENT -->
        
        
	</div>

</div>	
		<script>var urlcate ='{$bw->base_url}{$bw->input['module']}/'</script>
	
EOF;
	}
	

function advisoryForm($skin,$option) {
		global $vsLang, $bw, $vsTemplate,$vsPrint;
//		$vsPrint->addJavaScriptFile ("jquery.numeric",1);	

		$BWHTML .= <<<EOF

<div id="center">
	<div id="center_sub">   
    
    	<div id="sitebar">   
        	<h3 class="sitebar_title">{$vsLang->getWords("pageTitle","Giỏ hàng")}</h3>
                {$vsTemplate->global_template->search}
        </div>
        <!-- STOP SITEBAR -->
        
        <div id="content">       
        	<h3 class="main_title"><span>{$vsLang->getWords('advisorys_form','Gửi câu hỏi')}</span></h3>
            <div id="contact">
            	<p>{$vsLang->getWords("muondatcauhoi","Bạn muốn đặt câu hỏi cho chúng tôi, vui lòng điền đầy đủ vào form dưới đây. Chúng tôi sẽ trả lời sớm nhất cho bạn!!!")}</p>
                 
                  <form  style="border:none;margin-top:0px;" name="formContact" id="formContact" class="formcauhoi" method="POST" action="{$bw->base_url}advisorys/send/" enctype="multipart/form-data">
			
			<input  name="skin" type="hidden" value="$skin">
			<input  name="id" type="hidden" value="{$option['id']}">
			<label>{$vsLang->getWords('advisory_full_name','Họ tên')}</label>
            <input id="advisoryName" name="advisoryName" title="{$vsLang->getWords('advisory_full_name','Họ tên')}" value="{$bw->input['advisoryName']}">
            <div class="clear_left"></div>
            
           <!-- <label>{$vsLang->getWords('advisory_phone','Điện thoại')}</label>
            <input class="numeric"  maxlength="11" id="advisoryPhone" name="advisoryPhone" title="{$vsLang->getWords('advisory_phone','Điện thoại')}" value="{$bw->input['advisoryPhone']}">
            <div class="clear_left"></div> -->
            
            <label>{$vsLang->getWords('advisory_email','Email')}</label>
            <input id="advisoryEmail" name="advisoryEmail" title="{$vsLang->getWords('advisory_email','Email')}" value="{$bw->input['advisoryEmail']}">
            
			<div class="clear_left"></div>
            
            <label>{$vsLang->getWords('advisory_title','Câu hỏi')}  </label>
           	<input id="advisoryTitle" style="width:463px;" name="advisoryTitle" title="{$vsLang->getWords('advisory_title','Câu hỏi')}" value="{$bw->input['advisoryTitle']}">
           	<div class="clear_left"></div>
            
            <label>{$vsLang->getWords('advisory_message','Noi dung')} </label>
            <textarea id="advisoryMessage" name="advisoryIntro">{$bw->input['advisoryIntro']}</textarea>
            <div class="clear_left"></div>
            
            <label>{$vsLang->getWords("advisory_captcha","Mã bảo vệ")}:</label>
			<input type="text" name="advisorySecurity" id="advisorySecurity" style="width:100px"/> 
			<div style="margin-left:10px;float:left;">
            	<a href="javascript:;" style="float:left; padding-right:10px;">
                	<img id="vscapcha" src="{$bw->vars['board_url']}/vscaptcha">
               	</a>      	
			
		   	<a href="javascript:;" class="mamoi" id="reload_img">
				{$vsLang->getWords('advisory_security','Tạo mã mới')}
			</a>
			</div>
			
			<div class="clear_left"></div>
			<p style="color:red;margin-left: 97px;">{$bw->input['message']}</p>
            
     		<input type="submit" value="{$vsLang->getWords('button_send','Gửi')}" class="input_submit" />
     		<input type="reset" value="{$vsLang->getWords('button_reset','Làm lại')}" class="input_reset" />
          	
          	<div class="clear"></div>
		</form>
            </div>
        </div>
        <!-- STOP CONTENT -->
        
        
	</div>

</div>                
                
                
         

			<script type='text/javascript'>
				function checkMail(mail){
					var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
					if (!filter.test(mail)) return false;
					return true;
				}
				
				$("input.numeric").numeric();
				
				$("#reload_img").click(function(){
		                        $("#vscapcha").attr("src",$("#vscapcha").attr("src")+"?a");
		                        $('#random').val('');
		                        return false;
							});
							
				$('#formContact').submit(function(){
					if(!$('#advisoryName').val()) {
						jAlert('{$vsLang->getWords('err_advisory_name_blank','Vui lòng nhập họ tên!')}','{$bw->vars['global_websitename']} Dialog');
						$('#advisoryName').addClass('vs-error');
						$('#advisoryName').focus();
						return false;
					}
									
					/**if(!$('#advisoryPhone').val()) {
						jAlert('{$vsLang->getWords('err_advisory_phone_blank','Vui lòng nhập điện thọai!')}','{$bw->vars['global_websitename']} Dialog');
						$('#advisoryPhone').addClass('vs-error');
						$('#advisoryPhone').focus();
						return false;
					}	**/
					

					
					if(!$('#advisoryTitle').val()) {
						jAlert('{$vsLang->getWords('err_advisory_title_blank','Vui lòng nhập câu hỏi!')}','{$bw->vars['global_websitename']} Dialog');
						$('#advisoryTitle').addClass('vs-error');
						$('#advisoryTitle').focus();
						return false;
					}
					
					
					if($('#advisoryMessage').val().length < 15 ) {
						jAlert('{$vsLang->getWords('err_advisory_message_blank','Thông tin quá ngắn!')}','{$bw->vars['global_websitename']} Dialog');
						$('#advisoryMessage').addClass('vs-error');
						$('#advisoryMessage').focus();
						return false;
					}
					if(!$('#advisorySecurity').val()) {
						jAlert('{$vsLang->getWords('err_advisory_security_blank','Vui lòng nhập mã bảo vệ!')}','{$bw->vars['global_websitename']} Dialog');
						$('#advisorySecurity').addClass('vs-error');
						$('#advisorySecurity').focus();
						return false;
					}	
					$('#formContact').submit();
				});


			</script>
EOF;
		return $BWHTML;
	}
	
function thankyou($text, $url){
	global $vsLang,$bw,$vsTemplate,$vsPrint;
	$BWHTML = <<<EOF
	<script type='text/javascript'>
		setTimeout('delayer()', 3000);
		function delayer(){
    		window.location = "{$bw->base_url}$url/";
		}
	</script>
	 <div id="center">
	<div id="center_sub">   
    
    	<div id="sitebar">   
        	<h3 class="sitebar_title">{$vsLang->getWords("pageTitle","Giỏ hàng")}</h3>
    	{$vsTemplate->global_template->search}
        
        
        </div>
        <!-- STOP SITEBAR -->
        
        <div id="content">       
        	<h3 class="main_title"><span>{$vsLang->getWords("hoivatraloi","câu hỏi & trả lời")}</span></h3>
	
	
	<div class="sanpham">
   		
    	<div class="gioithieu detail">
 			<h1>{$text}</h1>
           	<p>{$vsLang->getWords('redirect_title','Chuyển trang...')}</p>
	      	<a style="color:#faaa20;" href='{$bw->base_url}{$url}'>({$vsLang->getWords('redirect_immediate','Click vào đây nếu không muốn chờ lâu')})</a>
	 	</div>	
	</div>
	
 </div>
        <!-- STOP CONTENT -->
        
        
	</div>

</div>	
	
EOF;
		return $BWHTML;
	}

}
?>