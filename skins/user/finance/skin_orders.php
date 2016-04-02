<?php
class skin_orders {

	function mainHtml($projectlist = "",$message="") {
		global $vsLang, $bw;
		$BWHTML .= <<<EOF
		{$projectlist}
EOF;
		return $BWHTML;
	}

function billName($option){
		global $bw, $vsLang, $vsUser, $vsMenu,$vsPrint,$vsTemplate,$vsSettings;

	    $this->bw = $bw;
                $vsPrint->addJavaScriptFile ("jquery.numeric",1);
                //$this->vsLang=$vsLang;
		$BWHTML .= <<<EOF

     	{$this->defineHead()}

     	<div class="giohang_form">
           <h3 style="text-transform:uppercase; padding:18px 0px 0px 0px;">{$vsLang->getWords("orders_infocart","thông tin giỏ hàng")}</h3>
  		<if="$option['orderItem']">
		<div class="table-responsive">
    	<table border="1" width="100%">
			<tr>
				<th class="col-xs-6">{$vsLang->getWords("orders_tensp","Tên sản phẩm")}</th>
             	<th class="col-xs-2">{$vsLang->getWords("orders_soluong","Số lượng")}</th>
               	<th class="col-xs-2">{$vsLang->getWords("orders_dongia","Đơn giá")}</th>
              	<th class="col-xs-2">{$vsLang->getWords("orders_thanhtien","Thành tiền")}</th>
            </tr>
          	<foreach="$option['orderItem'] as $obj">
          	<tr>
                <td>
                	<if=" !$this->bw->isMobile ">
						{$obj->createImageCache($obj->getImage(),42,44,4)}
					</if>
                    <p>{$obj->getTitle()}</p>
           		</td>
				<td>{$obj->getQuantity()}</td>
                <td>{$obj->getPrice()}</td>
                <td>{$obj->getTotals()}</td>
            </tr>
	   		</foreach>
          	</table>
			</div>
            <p class="total">
                     {$vsLang->getWords("orders_tongtien","Tổng thành tiền")} :
         		<span>{$option['total']}</span> {$vsLang->getWordsGlobal("global_unit","VNĐ")}</span>
         	</p>


       	<button id="back-id" class="xoa" type="button">{$vsLang->getWords("orders_back","Trở về")}</button>
       	<button id="cancel_sel" class="huy" type="button">{$vsLang->getWords("orders_Cancel_Order","Cancel Order")}</button>
     	<div class="clear"></div>
       	</if>


    	<div class="thongtinkh">
    		<h3 style='text-transform:uppercase; padding:18px 0px 0px 0px;'>{$vsLang->getWords('order_form','thông tin đặt hàng')}</h3>

     		<form id='user-form' class="register form-horizontal" name="user-form" method="POST" action="{$bw->base_url}orders/neworder/" enctype='multipart/form-data'>
				<input type='hidden' name='userId' value='{$vsUser->obj->getId()}'>



			<div class="form-group">
				<label class="col-sm-2 control-label">{$vsLang->getWords('order_fullname','Fullname')} <span class='required'>(*)</span>:</label>
				<div class="col-sm-6">
					<input type="text" name="orderName" class="obj_number form-control" id='order-fullname' value="{$bw->input['orderName']}"/>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">{$vsLang->getWords('order_phone','Phone')} <span class='required'>(*)</span>:</label>
	<div class="col-sm-6">
		<input type="text" name="orderPhone" class="obj_number form-control" id='order-phone' value="{$bw->input['orderPhone']}"/>
				</div>
	</div>

			                <div class="form-group">
			           		<label class="col-sm-2 control-label">{$vsLang->getWords('order_email','Email')}:</label>
							<div class="col-sm-6">
								<input type="text" name="orderEmail" class="obj_number form-control" id="order-email"  value="{$bw->input['orderEmail']}"/>
			            	</div>
							</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">{$vsLang->getWords('order_recipient_fullname','Tên người nhận')} <span class='required'>(*)</span>:</label>
					<div class="col-sm-6">
					  <input type="text" name="orderInfoU[fullname]" id="order-recipient-fullname" size="31" value="{$bw->input['orderInfoU']['fullname']}" class='form-control' />

					</div>
				</div>

            	<div class="form-group">
              	<label class="col-sm-2 control-label">{$vsLang->getWords('order_recipient_address','Địa chỉ người nhận')} <span class='required'>(*)</span>:</label>
				<div class="col-sm-6">
               	<input type="text" name="orderInfoU[address]" class="obj_number form-control" id="order-recipient-address"  value="{$bw->input['orderInfoU']['address']}"/>
				</div>
               	</div>

               	<div class="form-group">
               	<label class="col-sm-2 control-label">{$vsLang->getWords('order_recipient_phone','Điện thoại người nhận')} <span class='required'>(*)</span>:</label>
				<div class="col-sm-6">
               	<input  type="text" name="orderInfoU[phone]" class="numeric obj_number form-control" id="order-recipient-phone" size="11" value="{$bw->input['orderInfoU']['phone']}"/>
				</div>
              	</div>

              	<div class="form-group">
              	<label class="col-sm-2 control-label">{$vsLang->getWords("order_message","Nội dung")}</label>
				<div class="col-sm-6">
            	<textarea id="order-message" name="orderMessage" class='form-control'>{$bw->input['orderMessage']}</textarea>
				</div>
            	</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">{$vsLang->getWords("order_captcha","Mã bảo vệ")}:</label>
					<div class="col-sm-6">
					<input type="text" name="userSecurity" id="userSecurity" style="width:100px;float:left;" class/>
					<div style="margin-left:10px;">
						<a href="javascript:;" style="float:left;margin: 0 0 0 10px;">
							<img id="vscapcha" src="{$bw->vars['board_url']}/vscaptcha">
						</a>

						<a href="javascript:;" class="mamoi" id="reload_img">
							{$vsLang->getWords('user_security','Tạo mã mới')}
						</a>
					</div>
					<div class="clear-right" style="clear:both;"></div>
					</div>
				</div>
        <div class="clear"></div>
          <div class="bt_abc">
				<p style="color:red;margin-left: 100px;">{$bw->input['message']}</p>
				<div class="clear_left"></div>
              	<input type="submit" class="dathang_btn" id="bt_submit" value="{$vsLang->getWords('users_dathang','Đặt hàng')}">
               	<input type="reset" class="reset_btn" value="{$vsLang->getWords('user_reset','Làm lại')}"/></a>
               	<button id="back-id2" class="back" type="button">{$vsLang->getWords("orders_back","Trở về")}</button>
                </div>
              	<div class="clear"></div>
            </form>
            </div>
           </div>
           {$this->defineFoot()}




	<script language="javascript" type="text/javascript">
	$('#back-id').click(function(){
     		window.location.href="{$bw->vars['board_url']}/orders";
     		return false;
     });
     $('#back-id2').click(function(){
     		window.location.href="{$bw->vars['board_url']}/orders";
     		return false;
     });
     $('#cancel_sel').click(function(){
     		window.location.href="{$bw->vars['board_url']}/orders/deleteallcart/";
     		return false;
     });
	function checkMail(mail){
		var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if (!filter.test(mail))
			return false;
		return true;
	}
	$("#reload_img").click(function(){
    	$("#vscapcha").attr("src",$("#vscapcha").attr("src")+"?a");
       	$('#random').val('');
      	return false;
	});
	$("input.numeric").numeric();
	$('#user-form').submit(function()  {
		if(!$('#order-fullname').val()) {
			jAlert('{$vsLang->getWords('err_order_fullname_blank','Nhập vào tên người đặt!')}','{$bw->vars['global_websitename']} Dialog');
			$('#order-fullname').addClass('vs-error');
			$('#order-fullname').focus();
			return false;
		}

		if(!$('#order-phone').val()) {
			jAlert('{$vsLang->getWords('err_order_phone_blank','Nhập vào điện thoại người đặt!')}','{$bw->vars['global_websitename']} Dialog');
			$('#order-phone').addClass('vs-error');
			$('#order-phone').focus();
			return false;
		}

		if($('#order-email').val() && !checkMail($('#order-email').val())) {
						jAlert('{$vsLang->getWords('err_order_email_blank','Vui lòng nhập đúng loại email!')}','{$bw->vars['global_websitename']} Dialog');
						$('#order-email').addClass('vs-error');
						$('#order-email').focus();
						return false;
		}

    if(!$('#order-recipient-phone').val()) {
			jAlert('{$vsLang->getWords('err_order_recipient_phone_blank', 'Nhập vào điện thoại người nhận!')}','{$bw->vars['global_websitename']} Dialog');
			$('#order-recipient-phone').addClass('vs-error');
			$('#order-recipient-phone').focus();
			return false;
		}
// order_recipient_phone
		if(!$('#order-recipient-address').val()) {
			jAlert('{$vsLang->getWords('err_order_recipient_address_blank','Nhập vào địa chỉ người nhận!')}','{$bw->vars['global_websitename']} Dialog');
			$('#order-recipient-address').addClass('vs-error');
			$('#order-recipient-address').focus();
			return false;
		}
    if(!$('#order-recipient-phone').val()) {
			jAlert('{$vsLang->getWords('err_order_recipient_phone_blank','Nhập vào số điện thoại người nhận!')}','{$bw->vars['global_websitename']} Dialog');
			$('#order-recipient-phone').addClass('vs-error');
			$('#order-recipient-phone').focus();
			return false;
		}

		if(!$('#userSecurity').val()) {
			jAlert('{$vsLang->getWords('err_contact_security_blank','Vui lòng nhập mã bảo vệ!')}','{$bw->vars['global_websitename']} Dialog');
			$('#userSecurity').addClass('vs-error');
			$('#userSecurity').focus();
			return false;
		}
		//$('#user-form').submit()
	});

	$('#bt_cancel').click(function(){
		$( "form" )[ 1 ].reset()
	});
</script>
<!--<script>
	$(document).ready(function(){
		var the_USERFORM	= window.document.getElementById('user-form');
		vsf.jRadio('{$vsUser->obj->getGender()}','userGender');
		var date = "{$vsUser->obj->getBirthday()}";
			if(date){
				var list =date.split("/");
				vsf.jSelect(list[0],'obj_day');
				vsf.jSelect(list[1],'obj_month');
				vsf.jSelect(list[2],'obj_year');
			}
		});

</script>-->

EOF;
		return $BWHTML;

	}

function viewOrder($option){
        global $bw,$vsLang,$vsSettings;
      	$this->bw = $bw;
        $BWHTML .= <<<EOF

		{$this->defineHead()}

	 	<div class="giohang_form">
       		<div class="giohang_thongbao">
            <p>{$vsLang->getWords('orders_thanks','Cám ơn quý khách đặt hàng sản phẩm của chúng tôi.')}</p>
            <p>{$vsLang->getWords('orders_thanks2','Chúng tôi sẽ liên lạc với quý khách trong thời gian sớm nhất')}</p>
    		</div>
    		<p></p>
    		<br>
    		<h3 style="text-transform:uppercase;">{$vsLang->getWords("orders_infocart","thông tin giỏ hàng")}</h3>


				<div class="table-responsive">
	       	<table border="0" class="thongbao table table-bordered">
							<tr>
								<td style="color:#252525">{$vsLang->getWords('order_fullname','Fullname')}: </td>
									<td style="color:#5599bb">{$option['order']->getName()}</td>
							</tr>
							<tr>
								<td style="color:#252525">{$vsLang->getWords('order_phone','Phone')}: </td>
									<td style="color:#5599bb">{$option['order']->getPhone()}</td>
							</tr>
								<tr>
									<td style="color:#252525">{$vsLang->getWords('order_email','Email')}: </td>
										<td style="color:#5599bb">{$option['order']->getEmail()}</td>
								</tr>
	       				<tr>
                	<td style="color:#252525">{$vsLang->getWords('order_recipient_fullname','Tên người nhận')}: </td>
                  <td>{$option['order']->getU('fullname')}</td>
                </tr>
                <tr>
                	<td style="color:#252525">{$vsLang->getWords('order_recipient_phone','Điện thoại')}: </td>
                    <td>{$option['order']->getU("phone")}</td>
                </tr>
								<tr>
									<td style="color:#252525">{$vsLang->getWords('order_recipient_address','Địa chỉ')}:</td>
										<td>{$option['order']->getU('address')}</td>
								</tr>
                <tr>
                	<td style="color:#252525">{$vsLang->getWords("order_message","Nội dung")}: </td>
                    <td>{$option['order']->getMessage()}</td>
                </tr>
            </table>
					</div>

    		<if="$option['pageList']">
    		<table border="0" width="100%">
        	<tr>
             	<th class="giohang_col2">{$vsLang->getWords("orders_tensp","Tên sản phẩm")}</th>
              	<if="$vsSettings->getSystemKey("order_type",0, "orders", 0, 1)">
             	<th>{$vsLang->getWords("orders_loai","Loại")}</th>
              	</if>
             	<th class="giohang_col3">{$vsLang->getWords("orders_soluong","Số lượng")}</th>
               	<th class="giohang_col4">{$vsLang->getWords("orders_dongia","Đơn giá")}</th>
              	<th class="giohang_col5">{$vsLang->getWords("orders_thanhtien","Thành tiền")}</th>
            </tr>
          	<foreach="$option['pageList'] as $obj">
          	<tr>
                <td class="giohang_col2">
                	<if="!$this->bw->isMobile"><a href="{$obj->getUrl('products')}" title="{$obj->getTitle()}">{$obj->createImageCache($obj->getImage(),42,44,4)}</a></if>
                  <p>{$obj->getTitle()}</p>
           		</td>
              	<if="$vsSettings->getSystemKey("order_type", 0, "orders", 0, 1)">
             		<td><if="$obj->getType()">{$obj->getType()}<else />Cái</if></td>
             	</if>
				<td class="giohang_col3">{$obj->getQuantity()}</td>
                <td class="giohang_col4">{$obj->getPrice()}</td>
                <td class="giohang_col5">{$obj->getTotals()}</td>
            </tr>
	   		</foreach>
	   		</table>

            <p class="total">
                     {$vsLang->getWords("orders_tongtien","Tổng thành tiền")} :
         		<span>{$option['total']}</span> {$vsLang->getWordsGlobal("global_unit","VNĐ")}
         	</p>

	      	<else />
	        	<div style="font-size:20px;text-align:center">{$vsLang->getWords("no_products_order","Không tồn tại sản phẩm trong giỏ hàng")}</div>
	     	</if>

     		<p style="margin-top:15px;"><a href="{$bw->base_url}" class="tv_trangchu">{$vsLang->getWords('order_backhome','Trở về trang chủ')}</a></p>
     		<div class="phuongthuc_thanhtoan">
     		<p></p>
     			<!--<p><b>{$option['noidung']->getTitle()}</b></p>-->
                <p>{$option['noidung']->getIntro()}</p>



         	</div>
     		<div class="thongbao_thanhtoan">
     			<p>{$option['noidung']->getContent()}</p>
            </div>
     	 </div>
     	{$this->defineFoot()}

EOF;
		return $BWHTML;
	}

	function cartSummary($option) {
		global $vsLang, $bw,$vsUser,$vsPrint,$vsSettings;
		$this->bw = $bw;
        $vsPrint->addJavaScriptFile ("jquery.numeric",1);
		$count= count($_SESSION [$_SESSION [APPLICATION_TYPE]['language']['currentLang']['langFolder']] ['cart'] ['item'])?count($_SESSION [$_SESSION [APPLICATION_TYPE]['language']['currentLang']['langFolder']] ['cart'] ['item']):'0';
		$BWHTML = <<<EOF
     	{$this->defineHead()}


    	<div id="cart" class="giohang_form">
    	<h3 style="padding:18px 0px 0px 0px;">Hiện tại giỏ hàng của bạn có {$count} sản phẩm!</h3>
		<div class="table-responsive">
    	<form id="addEditForm" name="addEditForm" method="post"  action="{$bw->base_url}orders/updatecart/" enctype='multipart/form-data'>
            <table id="grvSanPham" border="0" cellpadding="8" cellspacing="0" rules="all" class='table table-bordered'>
            <tbody>
            <tr>
           		<th class="col-xs-1"><input type="checkbox" name="checkall" id="checkboxall" title="checkall"/></th>
             	<th class="col-xs-6">{$vsLang->getWords("orders_tensp","Tên sản phẩm")}</th>
             	<th class="col-xs-1">{$vsLang->getWords("orders_soluong","Số lượng")}</th>
               	<th class="col-xs-2">{$vsLang->getWords("orders_dongia","Đơn giá")}</th>
              	<th class="col-xs-2">{$vsLang->getWords("orders_thanhtien","Thành tiền")}</th>
            </tr>
            <foreach="$option['orderItem'] as $key => $val">
         	<tr>
        		<td><input type="checkbox" value="{$key}" name="checkall"/></td>
                <td>
					<if=" !$this->bw->isMobile ">
                	{$val->createImageCache($val->getImage(),42,44,4)}
					</if>
                    <span id="grvSanPham_ctl0{$vsf_count}_lblTenSanPham">{$val->getTitle()}</span>
           		</td>

				<td>
                 	<input name="cart[{$key}]" value="{$val->getQuantity ()}" id="grvSanPham_ctl0{$vsf_count}_txtSoLuong" tabindex="3" onkeyup="TinhTong(this);" onblur="TinhTong(this);" type="text" class="numeric quantity">
          		</td>
                <td>
                     <input type="hidden" value="{$val->getPrice()}" id="grvSanPham_ctl0{$vsf_count}_txtDonGia" class='unit-price'>
                     {$val->getPrice()}
                </td>
                <td>

					<span id="grvSanPham_ctl0{$vsf_count}_txtThanhTien"  class="thanhtien sub-total">{$val->getTotals()}</span>
                    <span id="grvSanPham_ctl0{$vsf_count}_lblThanhTien" style="display: none;">NaN</span>
                </td>
            </tr>
            </foreach>
            </table>
            </div>
         	<p class="total" id="Label1">
                {$vsLang->getWords("orders_tongtien","Tổng thành tiền")} :
         		<span id="lblTong">{$option['total']}</span> {$vsLang->getWordsGlobal("global_unit","VNĐ")}
         	</p>


       		<button id="delete_sel" class="xoa" type="button">{$vsLang->getWords("orders_Delete_selected","Xóa")}</button>
			<button id="cancel_sel" class="huy" type="button">{$vsLang->getWords("orders_Cancel_Order","Hủy Bỏ")}</button>
       		<button id="orders_sel" class="thanhtoan" type="button">{$vsLang->getWords("orders_Order","Đặt hàng")}</button>
			<button id="cont_sel" class="muatiep" type="button">{$vsLang->getWords("orders_Cont","Mua tiếp")}</button>

         	<!--<button id="update_sel" class="capnhat" >{$vsLang->getWords("orders_Updated","Updated")}</button>-->


            <div class="clear"></div>
            </tbody>
		</form>
        </div>
       	{$this->defineFoot()}
        <!-- STOP CONTENT CENTER -->

    <script>

		var flag = false;
      var price = [];
      <if="!$option['orderItem']">
      $('#delete_sel').css({display:"none"});
      $('#cancel_sel').css({display:"none"});
      $('#orders_sel').css({display:"none"});

      </if>
      <if="$option['opt']">
          <foreach="$option['opt'] as $key => $val">
               price[$key]=[];
                        price[$key][0] = '{$option['orderItem'][$key]->getPrice()}';
                         <foreach="$val as $k => $v">
                            price[$key][$k] = '{$v->getPrice()}';
                         </foreach>
          </foreach>
      </if>
      $("input.numeric").numeric();
     function  changevalue(inp,vale,ind){
              if(price[inp][vale]){
                    $('#grvSanPham_ctl0'+ind+'_txtDonGia').val(price[inp][vale]);
                    $('#grvSanPham_ctl0'+ind+'_txtSoLuong').blur();
             }
         }

     $('#delete_sel').click(function(){
	     var value = getCheck();
	   	if(value){
	   		window.location.href="{$bw->vars['board_url']}/orders/deletecart/"+value+".html";
	   	}
                        return false;
     });
     $('#update_sel').click(function(){
    		 $('#addEditForm').submit();
     });
     $('#cancel_sel').click(function(){
     		window.location.href="{$bw->vars['board_url']}/orders/deleteallcart.html";
     		return false;
     });
     $('#orders_sel').click(function(){
     		var str ="<input type='hidden' name='actionUpdate' value='bill'>";
     		$('#addEditForm').append(str);
     		$('#addEditForm').submit();
     		//window.location.href="{$bw->vars['board_url']}/orders/billName.html";
     		//return false;

     });
     $('#cont_sel').click(function(){
     		var str ="<input type='hidden' name='actionUpdate' value='cont'>";
     		$('#addEditForm').append(str);
     		$('#addEditForm').submit();
     });
      $(document).ready(function(){

	      $("#checkboxall").click(function() {
	      var checked_status = this.checked;
		      $("input[name=checkall]").each(function()
		      {
		      this.checked = checked_status;
		      });
	      });
	    <foreach="$option['orderItem'] as $key => $val">
		$('#grvSanPham_ctl0{$vsf_count}_txtSoLuong').blur();
		</foreach>
		flag = true;
      });

    function getCheck() {
		var checkedString = '';
		$("input[name=checkall]").each(function(){
			if(this.checked) checkedString += $(this).val()+',';
		});
		checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
		if(checkedString =='') {
			jAlert(
				"{$vsLang->getWords('delete_obj_confirm_noitem', "You haven't choose any items !")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		return checkedString;
	}
    </script>
    <script>


    function formatCurrency(num) {
			return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");;
		}
     function TinhTong(mObject)
        {
            var object_ = mObject.id;

            // Khai báo và gán giá trị các cột dữ liệu
            var m2= object_.replace('txtSoLuong','txtThanhTien');
            var m3 = object_.replace('txtSoLuong','txtDonGia');
            var mNhap = object_.replace('txtSoLuong','txtNhap');
            var lblTT = object_.replace('txtSoLuong','lblThanhTien');

            var m4 = document.getElementById(m2);
            var m5 = document.getElementById(m3.replace(/\$|\,/g,''));
            var SoLuong;

            if(mObject.value.length>0)
            {
                 SoLuong = mObject.value.replace(/\$|\,/g,'');
            }
            var DonGia =m5.value.replace(/\$|\,/g,'');
            // Tính ThanhTien =DonGia*SoLuong
            var ThanhTien= parseFloat(SoLuong)* parseFloat(DonGia);
            document.getElementById(lblTT).innerHTML=formatCurrency(ThanhTien);
            if(isNaN(m3))
            {
                document.getElementById(m2).innerHTML = formatCurrency(ThanhTien);
            }
            // Tính tổng số tiền
            var test="";
            var tongtien =0;
            var z="";
            for(x=1;x<20;x++)
            {
                if(x<10)
                {
                    test ="grvSanPham_ctl0"+x+"_lblThanhTien";
                    if(document.getElementById(test) !=null)
                    {
                        z = document.getElementById(test).innerHTML.toString().replace(/\$|\,/g,'');
                        if(isNaN(z) || z ==''){z = '0';}
                        tongtien =tongtien+ parseFloat(z);
                    }
                }
                else
                {
                    test ="grvSanPham_ctl"+x+"_lblThanhTien";
                    if(document.getElementById(test) !=null)
                    {
                        z = document.getElementById(test).innerHTML.toString().replace(/\$|\,/g,'');
                        if(isNaN(z) || z ==''){z = '0';}
                        z = '0';
                        tongtien =tongtien+ parseFloat(z);
                    }
                }
            }
            document.getElementById('lblTong').innerHTML =formatCurrency(tongtien);

        }

    </script>

EOF;

	//--endhtml--//

	return $BWHTML;
	}

function defineHead(){
    global $vsPrint,$vsTemplate;
	$BWHTML .= <<<EOF
	<div class="primary">
     <h3 class="title_cate">Giỏ Hàng</h3>



EOF;
		return $BWHTML;
        }
function defineFoot(){
            $BWHTML .= <<<EOF
        </div>

EOF;
		return $BWHTML;
        }

	function orderLoading($message){
		global $vsLang,$bw,$vsPrint;
		$dir = $_SERVER['HTTP_REFERER']?$_SERVER['HTTP_REFERER']:$bw->base_url."orders/";
		$BWHTML .= <<<EOF
		  <div style='margin-top: 10px; font-weight:bold;'>{$message}</div>
			<script>
                        <if="$message">
                           $(document).ready(function()
                            {
                                jAlert(
                                                "{$message}",
                                                "{$bw->vars['global_websitename']} Dialog"
                                        );
                            });
                        </if>

                        setTimeout('relead()',2000)

                        function relead(){
                                document.location.href = "{$dir}";
                        }
			</script>
EOF;
		return $BWHTML;
	}

	function htmlThanhToan($page,$acc){
		$BWHTML .= <<<EOF
		<h3 class="main_title">{$page->getTitle()}</h3>
            <div class="gioithieu">
            <p>{$page->getContent()}</p>
            <div class="link_bank">
            	<foreach="$acc as $ac">
        		<a href="{$ac->getWebsite()}" title="{$ac->getTitle()}" target="_blank">{$ac->createImageCache($ac->file,182,67)}</a>
      			</foreach>
                <div class="clear_left"></div>
            </div>
			</div>
EOF;
	return $BWHTML;
	}

	function viewSendEmail($option){
        global $bw,$vsLang;

        $BWHTML .= <<<EOF
        <style>
        body{background-color:#F3E1A6;font-family:Arial;font-size:12px;line-height:18px;color:#8A3512;}
        .order_title{font-weight:bold; text-transform: uppercase;color:red;line-height:20px;height:20px;}
		.ordermail{width:728px;}
        table{border:1px solid #fff;width:100%;}
        table .textwhile{background:#5c1e05;font-weight:bold;text-align: center;color:#fff;text-transform: uppercase;line-height:28px;}
        table td{font-size:14px;height:25px;padding:5px;}
        table .label_cart_total,table .text_total{font-weight:bold;text-align: right;}
		.text_left{text-align: center;}
		.text_right{text-align: right;}
        </style>
       <div class="ordermail">
		<h3 class="order_title">{$vsLang->getWords('global_xacnhandonhang','Xác nhận đơn hàng')}</h3>
		<p>{$vsLang->getWords('global_noidungxacnhan','Bạn đã mua thành công sản phẩm của chúng tôi.')}</p>
		<table border="0" class="thongbao">
			<tr align="left">
					<th>{$vsLang->getWords('order_name','Họ tên người đặt hàng')}:</th>
					<td>{$option['order']->getName()}</td>
			</tr>
			<tr align="left">
							<th>{$vsLang->getWords('order_phone','Điện thoại người đặt hàng')}:</th>
							<td>{$option['order']->getPhone()}</td>
			</tr>
			<tr align="left">
							<th >{$vsLang->getWords('order_email','Email người đặt hàng')}:</th>
							<td>{$option['order']->getEmail()}</td>
			</tr>

			<tr align="left">
				<th>{$vsLang->getWords('order_receipt_name','Họ tên người nhận')}:</th>
							<td>{$option['order']->getU('fullname')}</td>
			</tr>
			<tr align="left">
							<th>{$vsLang->getWords('order_receipt_address','Địa chỉ người nhận')}:</th>
							<td>{$option['order']->getU('address')}</td>
			</tr>
				<tr align="left">
							<th>{$vsLang->getWords('order_receipt_phone','Điện thoại người nhận')}:</th>
							<td>{$option['order']->getU('phone')}</td>
				</tr>
                <tr>
                	<th>{$vsLang->getWords("user_message","Nội dung")}: </td>
                    <td>{$option['order']->getMessage()}</td>
                </tr>

            </table>
            <p></p>
     	<table border="1" cellspacing="0" cellpadding="8">
            <tr class="textwhile">
            	<th class="col3">{$vsLang->getWords("orders_stt","STT")}</th>
             	<th class="col4">{$vsLang->getWords("orders_tensp","Tên sản phẩm")}</th>
               	<th class="col5">{$vsLang->getWords("orders_soluong","Số lượng")}</th>
            	<th class="col6">{$vsLang->getWords("orders_dongia","Đơn giá")}</th>
              	<th class="col7">{$vsLang->getWords("orders_thanhtien","Thành tiền")}</th>
          	</tr>
         	<foreach="$option['pageList'] as $obj">
            <tr>
                  <td class="col3" width="30px">{$obj->stt}</td>
                  <td class="col4">
        			{$obj->createImageCache($obj->getImage(),42,44,4)}
            		<p>{$obj->getTitle()}</p>
            		<p><if="$obj->getType()!='-'">({$obj->getType()})</if></p>
            	  </td>
                  <td class="col5">{$obj->getQuantity()}</td>
                  <td class="col7">{$obj->getPrice()}</td>
                  <td class="col7">{$obj->getTotals()}</td>
            </tr>
          	</foreach>
              <tr>
               	<td colspan="4">
                   	<p style="font-weight:bold; color:#f57e20">{$vsLang->getWords("orders_Total","Total")}:({$vsLang->getWordsGlobal("global_unit","VNĐ")})</p>
              	</td>
                 <td class="text_total text_right">
                  	<b>{$option['total']}</b>
                 </td>
              </tr>
        </table>
		</div>
EOF;
		return $BWHTML;
	}

	function viewMyOrder($option){
        global $bw,$vsLang,$vsSettings,$vsPrint;

        $BWHTML .= <<<EOF

            {$this->defineHead()}
            <div class="giohang">


                <h3>{$vsLang->getWords('global_mycart','Đơn hàng của tôi')}</h3>


            	<if="$option">
            	<table border="1" width="100%">
                	<tr>
                		<th class="col3">
                    	<input type="checkbox" name="checkall" id="checkboxall" title="checkall"/></th>
                        <th class="col4">{$vsLang->getWords("orders_Product_Name","Product Name")}</th>
                        <th class="col5">{$vsLang->getWords("orders_Price","Price")}</th>
                        <if="$vsSettings->getSystemKey("order_type", 0, "orders", 0, 1)">
                        <th>{$vsLang->getWords("orders_Type","Type")}</th>
                        </if>
                        <th class="col6">{$vsLang->getWords("orders","Quantity")}</th>
                        <th class="col7">{$vsLang->getWords("orders_Total_amount","Total amount")}</th>
                        <th class="col7">{$vsLang->getWords("orders_Status","Trạng thái")}</th>
                    </tr>

                            <foreach="$option['pageList'] as $key =>$obj">
                                <tr>
                                	<td class="col3"><input type="checkbox" value="{$key}" name="checkall" style="width:25px" <if="$obj->getStatus()==1">DISABLED</if>/></td>
                                    <td class="col4">
            							{$obj->createImageCache($obj->getImage(),42,44,4)}
            							<p>{$obj->getTitle()}</p>
            							<p><if="$obj->getType()!='-'">({$obj->getType()})</if></p>
            						</td>
                                    <td class="col5">{$obj->getPrice()}</td>
                                    <if="$vsSettings->getSystemKey("order_type", 0, "orders", 0, 1)">
                                    <td class="text_right "><if="$obj->getType()">{$obj->getType()}<else />Cái</if></td>
                                    </if>
                                    <td class="col6" style="text-align: center;">{$obj->getQuantity()}</td>
                                    <td class="col7">{$obj->getTotals() }</td>
                                    <td class="col7">{$obj->getMyStatus() }</td>
                                </tr>
	                    </foreach>

                    <tr>
                    	<td colspan="5" align="right" style="text-align:left;padding-left:10px;">
                            <button id="delete_sel" class="btn_xoa" type="button">{$vsLang->getWords("orders_Delete_selected","Delete selected")}</button>
                        </td>
                    </tr>
                </table>

                <else />
                    <div style="font-size:20px;text-align:center">{$vsLang->getWords("no_products_order","Không tồn tại sản phẩm trong giỏ hàng")}</div>
                 </if>
                 <if="$option['paging']">
                <div class="page">{$option['paging']}</div>
                </if>
            </div>


            <p style="margin-top:25px;text-align:center;"><a href="{$bw->base_url}" style="color:#1f357e;font-weight:bold;text-transform:uppercase;">{$vsLang->getWords('order_backhome','Trở về trang chủ')}</a></p>
	<script>

	function getCheck() {
		var checkedString = '';
		$("input[name=checkall]").each(function(){
			if(this.checked) checkedString += $(this).val()+',';
		});
		checkedString = checkedString.substr(0,checkedString.lastIndexOf(','));
		if(checkedString =='') {
			jAlert(
				"{$vsLang->getWords('delete_obj_confirm_noitem', "You haven't choose any items !")}",
				"{$bw->vars['global_websitename']} Dialog"
			);
			return false;
		}
		return checkedString;
	}
     $('#delete_sel').click(function(){
	     var value = getCheck();
	   	if(value){
	   		window.location.href="{$bw->vars['board_url']}/orders/deletemycart/"+value+".html";
	   	}
                        return false;
     });
     </script>
            {$this->defineFoot()}

EOF;
		return $BWHTML;
	}

}
?>
