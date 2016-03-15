<?php
class skin_searchs extends skin_objectadmin{
function objListHtml($objItems = array(), $option = array()) {
		global $bw, $vsLang, $vsSettings, $vsSetting, $tableName, $vsUser;
		$BWHTML .= <<<EOF

			<div class="red">{$option['message']}</div>
			<form id="obj-list-form">
			<input type="hidden" name="checkedObj" id="checked-obj" value="" />
			<input type="hidden" name="categoryId" value="{$option['categoryId']}" id="categoryId" />
			<div class='ui-dialog ui-widget ui-widget-content ui-corner-all'>
                            <div class="ui-dialog-titlebar ui-widget-header ui-helper-clearfix ui-corner-all-inner">
                            <span class="ui-icon ui-icon-note"></span>
                            <span class="ui-dialog-title">{$vsLang->getWords('obj_objListHtmlTitle',"{$bw->input[0]} Item List")}</span>
                            </div>
					<table cellspacing="1" cellpadding="1" id='objListHtmlTable' width="100%">
						<thead>
						    <tr>
						        <th width="10"><input type="checkbox" onclick="vsf.checkAll()" onclicktext="vsf.checkAll()" name="all" /></th>
						        <th width="60">{$vsLang->getWords('obj_list_status', 'Active')}</th>
						        <th>{$vsLang->getWords('obj_list_title', 'Title')}</td>
						        <th width="30">{$vsLang->getWords('obj_list_update', 'Update')}</th>

						        <th width="40">{$vsLang->getWords('obj_list_action', 'Action')}</th>
						       
						    </tr>
						</thead>
						<tbody>
							<foreach="$objItems as $obj">
								<tr class="$vsf_class">
									<td align="center">
                                                                                <if="!$vsSettings->getSystemKey($bw->input[0].'_code',0) && $obj->getCode()">
                                                                                    <img src="{$bw->vars['img_url']}/disabled.png" />
                                                                                <else />
										<input type="checkbox" onclicktext="vsf.checkObject();" onclick="vsf.checkObject();" name="obj_{$obj->getId()}" value="{$obj->getId()}" class="myCheckbox" />
                                                                                </if>
									</td>
									<td style='text-align:center'>{$obj->getStatus('image')}</td>

									<td>
										
										{$obj->getTitle()}
										
									</td>
									<td>{$obj->getUpdate('SHORT')}</td>
									
									<td>
										{$obj->module}
									</td>
									
								</tr>
							</foreach>
						</tbody>
						<tfoot>
							<tr>
								<th colspan='5'>
									<div style='float:right;'>{$option['paging']}</div>
								</th>
							</tr>
                                                         <tr >
                                                      <th colspan='6' align="left">
                                                      <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/enable.png" /> {$vsLang->getWords('global_status_enable1', 'Current Show')}</span>
                                                      <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/disabled.png" /> {$vsLang->getWords('global_status_disabled1', 'Not Show')}</span>
                                                      
                                                            <span style="padding-left: 10px;line-height:16px;"><img src="{$bw->vars['img_url']}/home.png" /> {$vsLang->getWords('global_status_show_home', 'Home Show')}</span>
                                                      
                                                      </th>
                                                </tr>
						</tfoot>
					</table>
				</div>
			</form>
			<div class="clear" id="file"></div>
                        <div id='commentList'></div>
			
EOF;
	}
}
?>
