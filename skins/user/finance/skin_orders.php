<?php
class skin_orders {

	function cartSummary($option) {
		global $vsLang, $bw, $vsPrint, $vsTemplate;
		
        $vsPrint->addJavaScriptFile ("jquery.numeric",1);      
		$this->vsLang = $vsLang;
		$this->bw = $bw;
		$BWHTML = <<<EOF
                           
<h3 class="navigator">
      {$vsTemplate->global_template->navigator}
</h3>
<div id="content">
	<div id="content_sub">
    	<div class="content_center">
        	<div class="page_title">
	        	<h1>{$vsLang->getWords('shoppingcart', 'Shopping cart')}</h1>
            </div>
            <form action='{$bw->base_url}orders/updateitem' method='post'>
            	<foreach="$option['orderItem'] as $key1 => $value1">
            	<foreach="$value1 as $key2 => $value2">
                <div class="cart_item">
                    <div class="cart_img">
                    	<if="$option['products'][$key1]">
                    		{$option['products'][$key1]->createImageCache($option['products'][$key1]->getImage(), 70, 105, 1)}
                    	</if>
                    </div>
                    <div class="cart_name">
                        <p>{$value2->getTitle()}</p>
                        <a href="{$this->bw->base_url}orders/deleteitem/{$key1}/{$key2}" title="{$this->vsLang->getWords('remove_item', 'Remove item')}">{$this->vsLang->getWords('remove_item', 'Remove item')}</a>
                    </div>
                    <table border="0" width="100%">
                        <tr>
                            <td class="cart_col1">
                                <p>
                                	<strong>{$this->vsLang->getWords('width','Width')}:</strong>
                                	{$value2->infoarray['width']} mm
                                </p>
                                <p>
                                	<strong>{$this->vsLang->getWords('drop','Drop')}:</strong>
                                	{$value2->infoarray['drop']} mm
                                </p>
                                <p>
                                	<strong>{$this->vsLang->getWords('color','Color')}:</strong>
                                	<if=" $option['colors'][$value2->infoarray['color']] ">
                                		{$option['colors'][$value2->infoarray['color']]->getTitle()}
                                	</if>
                                </p>
                            </td>
                            <td class="cart_col2">
                                <h3>{$this->vsLang->getWords('type','Type')}</h3>
                                <p><if="$option['products'][$key1]">{$option['products'][$key1]->getType()}</if></p>
                            </td>
                            <td class="cart_col3">
                                <h3>{$this->vsLang->getWords('quantity','Quantity')}</h3>
                                <input class='numeric' type="text" value='{$value2->infoarray['quantity']}' name='quantity[{$key1}pandog{$key2}]' />
                            </td>
                            <td class="cart_col4">
                                <h3>{$this->vsLang->getWords('unitprice','unit price')}</h3>
                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getUnitprice(false)}</p>
                            </td>
                            <td class="cart_col5">
                                <h3>{$this->vsLang->getWords('subtotal','sub total')}</h3>
                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getPrice(false)}</p>
                            </td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                </div>
                </foreach>
                </foreach>
                <div class="cart_total">
                    <h3>{$this->vsLang->getWords('total','Total')}:  $ {$option['total']}</h3>
                </div>
                <div class="clear_right"></div>
                <a href="{$bw->base_url}orders/checkout" class="check_out">{$vsLang->getWords('checkout','Check out')}</a>
                <input type="submit" value="{$vsLang->getWords('updatecart','Update Cart')}" class="check_out" />
                
                <div class="clear_right"></div>
            </form>
        </div>
    </div>
</div>
<script type='text/javascript'>
	$("input.numeric").numeric();
</script>
EOF;
	return $BWHTML;
	}
	
	

	function checkOut($option){
		global $bw, $vsLang, $vsUser, $vsMenu,$vsPrint,$vsTemplate,$vsSettings;
            
		$this->vsLang = $vsLang;
                
		$vsPrint->addJavaScriptFile ("jquery.numeric",1);
		$BWHTML .= <<<EOF

<h3 class="navigator">
      {$vsTemplate->global_template->navigator}
</h3>
<div id="content">
	<div id="content_sub">
    	<div class="content_center">
        	<div class="page_title">
	        	<h1>{$vsLang->getWords('shoppingcart', 'Shopping cart')}</h1>
            </div>
            <div>
            	<foreach="$option['orderItem'] as $key1 => $value1">
            	<foreach="$value1 as $key2 => $value2">
                <div class="cart_item">
                    <div class="cart_img">
                    	<if="$option['products'][$key1]">
                    		{$option['products'][$key1]->createImageCache($option['products'][$key1]->getImage(), 70, 105, 1)}
                    	</if>
                    </div>
                    <div class="cart_name">
                        <p>{$value2->getTitle()}</p>
                    </div>
                    <table border="0" width="100%">
                        <tr>
                            <td class="cart_col1">
                                <p>
                                	<strong>{$this->vsLang->getWords('width','Width')}:</strong>
                                	{$value2->infoarray['width']} mm
                                </p>
                                <p>
                                	<strong>{$this->vsLang->getWords('drop','Drop')}:</strong>
                                	{$value2->infoarray['drop']} mm
                                </p>
                                <p>
                                	<strong>{$this->vsLang->getWords('color','Color')}:</strong>
                                	<if=" $option['colors'][$value2->infoarray['color']] ">
                                		{$option['colors'][$value2->infoarray['color']]->getTitle()}
                                	</if>
                                </p>
                            </td>
                            <td class="cart_col2">
                                <h3>{$this->vsLang->getWords('type','Type')}</h3>
                                <p><if="$option['products'][$key1]">{$option['products'][$key1]->getType()}</if></p>
                            </td>
                            <td class="cart_col3">
                                <h3>{$this->vsLang->getWords('quantity','Quantity')}</h3>
                                <p>{$value2->infoarray['quantity']}</p>
                            </td>
                            <td class="cart_col4">
                                <h3>{$this->vsLang->getWords('unitprice','unit price')}</h3>
                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getUnitprice(false)}</p>
                            </td>
                            <td class="cart_col5">
                                <h3>{$this->vsLang->getWords('subtotal','sub total')}</h3>
                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getPrice(false)}</p>
                            </td>
                        </tr>
                    </table>
                    <div class="clear"></div>
                </div>
                </foreach>
                </foreach>
                <div class="cart_total">
                    <h3>{$this->vsLang->getWords('total','Total')}:  $ {$option['total']}</h3>
                </div>
                <div class="clear_right"></div>
            </div>
            <div id="contact" style='margin-left: 90px;'>
            	<h1 style='color: #993300;font-size: 20px;'>{$vsLang->getWords('information','Your information')}</h1>
            	<form action="{$bw->base_url}orders/order" id='user-form' class="register" name="user-form" method="POST" >
                <label>{$vsLang->getWords('fullname','Fullname')}:</label>
                <input type="text" name="orderName" id="obj-FullName" size="31" value=""/>
                <div class="clear_left"></div>
                 
                <label>{$vsLang->getWords('email','Email')}:</label>
               	<input type="text" name="orderEmail" class="obj_number" id="obj-Email" value=""/>
                <div class="clear_left"></div>

				<label>{$vsLang->getWords('address','Address')}:</label>
               	<input type="text" name="orderAddress" class="obj_number" id="obj-Address"  value=""/>
               	<div class="clear_left"></div>
               	
               	<if=" $option['location'] ">
               	<label>{$vsLang->getWords('location','Location')}:</label>
               	<select name='orderLocation' id='orderLocation'  class='location'>
	               	<foreach=" $option['location'] as $l1">
		               	<optgroup label="{$l1->getTitle()}">
			               	<foreach=" $l1->getChildren() as $l2 ">
			               	<option value='{$l2->getId()}' />{$l2->getTitle()}</option>
			               	</foreach>
		               	</optgroup>
	               	</foreach>
	               	<option value='0'>{$vsLang->getWords('location_others','others')}</option>
               	</select>
               	<div class="clear_left"></div>
               	
               	<script type='text/javascript'>
               		var sjs = {$option['shippingjs']};
               		$('#orderLocation').change(function(){
               			if($(this).val() == 0 ){
               				var shipping = '{$vsLang->getWords('shipping_detail_none', 'We will email you shipping fee on your location.')}';
               			}
               			else{
               				var cur = $(this).val();
               				var shipping = '{$this->vsLang->getWords("unit","$")}'+ sjs[cur];
               			}
               			$('#shippingprice').html(shipping);
               			return true;
               		});
               		$(document).ready(function(){
               			var cur = $('#orderLocation').val();
               			
               			var shipping = '{$this->vsLang->getWords("unit","$")}' + sjs[cur];
               			$('#shippingprice').html(shipping);
               		})
               	</script>
               	
               	<label>{$vsLang->getWords('shipping','Shipping')}:</label>
               	<div id='shippingprice'>{$vsLang->getWords('shipping_detail_none', 'We will email you shipping fee on your location.')}</div>
               	<div class="clear_left"></div>
               	</if>
               	
               	<label>{$vsLang->getWords('phone','Phone')}:</label>
               	<input type="text" class="numeric" name="orderPhone" class="obj_number" id="obj-Phone" size="11" value=""/>
                <div class="clear_left"></div>

                <input type="submit" class="input_submit" id="bt_submit" value="{$vsLang->getWords('order','Order')}">
                <input type="reset"  class="input_reset" value="{$vsLang->getWords('reset','Reset')}"></a>
				<div class="clear_left"></div>
            </form>
            </div>
        </div>
    </div>
</div>


	<script language="javascript" type="text/javascript">
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
		$("input.numeric").numeric();
		$('#bt_submit').click(function(){
            if(!$('#obj-FullName').val()){
			jAlert('{$vsLang->getWords('err_contact_reserve_blank','Nhập vào tên người nhận!')}','{$bw->vars['global_websitename']} Dialog');
			$('#obj-FullName').addClass('vs-error');
			$('obj-FullName').focus();
			return false;
		}
		if(!$('#obj-Email').val()|| !checkMail($('#obj-Email').val())) {
						jAlert('{$vsLang->getWords('err_contact_email_blank','Vui lòng nhập đúng loại email!')}','{$bw->vars['global_websitename']} Dialog');
						$('#obj-Email').addClass('vs-error');
						$('#obj-Email').focus();
						return false;
		}
		if(!$('#obj-Address').val()) {
			jAlert('{$vsLang->getWords('err_contact_address_blank','Nhập vào địa chỉ!')}','{$bw->vars['global_websitename']} Dialog');
			$('#obj-Address').addClass('vs-error');
			$('#obj-Address').focus();
			return false;
		}
            if(!$('#obj-Phone').val()) {
			jAlert('{$vsLang->getWords('err_contact_phone_blank','Nhập vào số điện thoại!')}','{$bw->vars['global_websitename']} Dialog');
			$('#obj-Phone').addClass('vs-error');
			$('#obj-Phone').focus();
			return false;
			}
		$('#user-form').submit()
	});

	$('#bt_cancel').click(function(){
		$( "form" )[ 1 ].reset()
	});
</script>
EOF;
		return $BWHTML;
	}

	function viewOrder($option){
		global $bw,$vsLang,$vsSettings;
		$this->vsLang = $vsLang;
		$BWHTML .= <<<EOF
       		<h3 class="navigator">
      {$vsTemplate->global_template->navigator}
</h3>
<div id="content">
	<div id="content_sub">
    	<div class="content_center">
        	<div class="page_title">
	        	<h1>{$vsLang->getWords('shoppingcart', 'Shopping cart')}</h1>
            </div>
            <div>
            	<div class="vieworder">
            	<div class="camon">
            		<p>{$vsLang->getWords('orders_thank_message','Thank you! We will contact you as soon as possible.')}</p>
            		<p style="margin:5px 0 20px;">---------------------- *oOo* ----------------------</p>
         		</div>
         		<style>
         			h2{
         				margin-bottom: 10px;
         				color: #FFB800;
         			}
         		</style>
                <h3 style="color: #FFB800;font-size: 20px;margin-bottom: 5px;">{$vsLang->getWords('cart_information','Your information')}</h3>
                <div>
                	<strong>{$vsLang->getWords('fullname','Fullname')}</strong>: {$option['order']->getName()}<br />
                	<strong>{$vsLang->getWords('email','Email')}</strong>: {$option['order']->getEmail()}<br />
                	<strong>{$vsLang->getWords('address','Address')}</strong>: {$option['order']->getAddress()}<br />
                	<strong>{$vsLang->getWords('phone','Phone')}</strong>: {$option['order']->getPhone()}<br />
                	<p style="margin:5px 0 20px;">---------------------- *oOo* ----------------------</p>
                </div>
                <div class='cartinfo'>
                <h3 style="color: #FFB800;font-size: 20px;margin-bottom: 10px;">{$vsLang->getWords('order_detail','Order detail')}</h3>
            	<if="$option['orderItem']">
            		<foreach="$option['orderItem'] as $key1 => $value1">
	            	<foreach="$value1 as $key2 => $value2">
	                <div class="cart_item">
	                    <div class="cart_img">
	                    	<if="$option['products'][$key1]">
	                    		{$option['products'][$key1]->createImageCache($option['products'][$key1]->getImage(), 70, 105, 1)}
	                    	</if>
	                    </div>
	                    <div class="cart_name">
	                        <p>{$value2->getTitle()}</p>
	                    </div>
	                    <table border="0" width="100%">
	                        <tr>
	                            <td class="cart_col1">
	                                <p>
	                                	<strong>{$this->vsLang->getWords('width','Width')}:</strong>
	                                	{$value2->infoarray['width']} mm
	                                </p>
	                                <p>
	                                	<strong>{$this->vsLang->getWords('drop','Drop')}:</strong>
	                                	{$value2->infoarray['drop']} mm
	                                </p>
	                                <p>
	                                	<strong>{$this->vsLang->getWords('color','Color')}:</strong>
	                                	<if=" $option['colors'][$value2->infoarray['color']] ">
	                                		{$option['colors'][$value2->infoarray['color']]->getTitle()}
	                                	</if>
	                                </p>
	                            </td>
	                            <td class="cart_col2">
	                                <h3>{$this->vsLang->getWords('type','Type')}</h3>
	                                <p><if="$option['products'][$key1]">{$option['products'][$key1]->getType()}</if></p>
	                            </td>
	                            <td class="cart_col3">
	                                <h3>{$this->vsLang->getWords('quantity','Quantity')}</h3>
	                                <p>{$value2->infoarray['quantity']}</p>
	                            </td>
	                            <td class="cart_col4">
	                                <h3>{$this->vsLang->getWords('unitprice','unit price')}</h3>
	                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getUnitprice(false)}</p>
	                            </td>
	                            <td class="cart_col5">
	                                <h3>{$this->vsLang->getWords('subtotal','sub total')}</h3>
	                                <p>{$this->vsLang->getWords("unit","$")}{$value2->getPrice(false)}</p>
	                            </td>
	                        </tr>
	                    </table>
	                    <div class="clear"></div>
	                </div>
	                </foreach>
                	</foreach>
                <else />
                    <div style="font-size:20px;text-align:center">
                    	{$vsLang->getWords("no_product", "There isnot any item in your cart")}
                    </div>
                </if>
            </div>
            <p style="margin-top:15px;text-align:center;">
            	<a href="{$bw->base_url}" style="color:#00AEFE;font-weight:bold;text-transform:uppercase;">
                    {$vsLang->getWords('order_backtohome','Back to Home page')}
				</a>
			</p>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>
	$("input.numeric").numeric();
</script>
EOF;
		return $BWHTML;
	}

  
	function orderLoading($message){
		global $vsLang, $bw;

		$BWHTML .= <<<EOF
			<script>
				<if="$message">
					$(document).ready(function(){
						jAlert(
							"{$message}",
							"{$bw->vars['global_websitename']} Dialog"
						);
					});
				</if>
				setTimeout('relead()',2000)
				function relead(){
					document.location.href = "{$bw->base_url}/products";
				}
			</script>
EOF;
		return $BWHTML;
	}

	function viewSendEmail($option){
        global $bw,$vsLang;
       
        $this->vsLang = $vsLang;
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
     	<table border="1" cellspacing="0" cellpadding="8">
            <tr class="textwhile">
              	<th>{$vsLang->getWords("orders_product_name","Product Name")}</th>
              	<th>{$vsLang->getWords("orders_product_detail","Product Detail")}</th>
              	<th>{$vsLang->getWords("orders_type","Type")}</th>
               	<th>{$vsLang->getWords("orders_quantity","Quantity")}</th>
              	<th>{$vsLang->getWords("orders_unitprice","Unit Price")}</th> 
              	<th>{$vsLang->getWords("orders_Total_amount","Total amount")}</th>
          	</tr>
          			<foreach="$option['orderItem'] as $key1 => $value1">
	            	<foreach="$value1 as $key2 => $value2">
	                        <tr>
	                        	<td>{$value2->getTitle()}</td>
	                            <td class="text_left">
	                                <p>
	                                	{$value2->infoarray['width']} mm
	                                </p>
	                                <p>
	                                	{$value2->infoarray['drop']} mm
	                                </p>
	                                <p>
	                                	<if=" $option['colors'][$value2->infoarray['color']] ">
	                                		{$option['colors'][$value2->infoarray['color']]->getTitle()}
	                                	</if>
	                                </p>
	                            </td>
	                            <td class="text_left">
	                                <if="$option['products'][$key1]">{$option['products'][$key1]->getType()}</if>
	                            </td>
	                            <td class="text_left">
	                            	{$value2->infoarray['quantity']}
	                            </td>
	                            <td class="text_left">
									{$this->vsLang->getWords("unit","$")}{$value2->getUnitprice(false)}
	                            </td>
	                            <td class="text_total1">
									{$this->vsLang->getWords("unit","$")}{$value2->getPrice(false)}
	                            </td>
	                        </tr>
	                </foreach>
                	</foreach>
                </tr>
              	<tr>
	               	<td colspan="5">
	                   	<p class="label_cart_total">{$vsLang->getWords("orders_Total","Total")}</p>    
	              	</td>
	              	<td class="text_total text_right">
	                  	<b>{$vsLang->getWords("unit","$")}{$option['total']}</b>
					</td>
				</tr>
        </table>
		</div>
EOF;
		return $BWHTML;
	}

}
?>