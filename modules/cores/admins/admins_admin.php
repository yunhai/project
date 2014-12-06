<?php
require_once(LIBS_PATH.'boards/VSAdminBoard.php');

class admins_admin extends VSAdminBoard {
var $fillter=array("dologin","login","logout","forgot_password");

	/**
	*auto run function
	*System IDE create
	**/
	public	function auto_run(){
		global $bw,$vsModule;	
			if($bw->input[0]=='admins' && in_array($bw->input['action'], $this->fillter) ){
				$bw->input[1]="admins_".$bw->input['action'];
				require_once CORE_PATH."admins/admins_controler.php";
				$controler=new admins_controler("admins");
				$controler->auto_run();
				return $this->setOutput($controler->getOutput());
			}
		if(VSFactory::getAdmins()->basicObject->checkPermission('admins_account_manager')){
			$this->tabs[]=array(
					'id'=>'admins',
					'href'=>"{$bw->base_url}admins/admins_display_tab/&ajax=1",
					'title'=>$this->getLang()->getWords("tab_admin",'Tài khoản'),
					'default'=>0,
			);
		}
		$this->tabs[]=array(
				'id'=>'chang_password',
				'href'=>"{$bw->base_url}admins/admins_info_form/&ajax=1",
				'title'=>$this->getLang()->getWords("tab_admin_changpassword",'Thay đổi mật khẩu'),
				'default'=>0,
		);
		if(VSFactory::getSettings()->getSystemKey($bw->input[0]."_admins_group_tab",1,$bw->input[0])){
			$this->tabs[]=array(
					'id'=>'group_manager',
					'href'=>"{$bw->base_url}admins/admingroups_display_tab/&ajax=1",
					'title'=>$this->getLang()->getWords("tab_admingroup",'Quản lý nhóm'),
					'default'=>0,
			);
		}
		
		if(VSFactory::getSettings()->getSystemKey ( $bw->input[0]. '_settings_tab', 1, $bw->input[0] )){
			$this->tabs[]=array(
				'id'=>'settings',
				'href'=>"{$bw->base_url}settings/moduleObjTab/{$bw->input[0]}/&ajax=1",
				'title'=>$this->getLang()->getWords("{$bw->input[0]}_ss","Cấu hình {$bw->input[0]}"),
				'default'=>0,
				);
		}
		//$cClass=$bw->input[0];
		if($bw->input [1]){
			$expl=explode('_',$bw->input [1]);
			if(file_exists(CORE_PATH.$vsModule->basicObject->getClass()."/{$expl[0]}_controler.php")){
				
				$cClass=$expl[0];
				$class=$cClass.'_controler';
				require_once CORE_PATH.$vsModule->basicObject->getClass()."/$class.php";
				
				if(class_exists($class)){
					$controler=new $class($cClass);
					if(method_exists($controler,"auto_run")){
							$controler->auto_run();
							return $this->setOutput($controler->getOutput());
					}else die("$cClass::auto_run()  not exist!");
				}
			}
			
		}
				global $vsPrint;
	if(!($bw->input[0]=='admins' && in_array($bw->input['action'], $this->fillter)) ){
				$vsPrint->addJavaScriptString ( 'init_tab', "
					$(document).ready(function(){
		    			$(\"#page_tabs\").tabs({
		    				cache: false
		    			});
		    			$(\"#page_tabs\").bind(\"tabsselect\", function(event, ui) { 
		    			  if(window.location.hash.indexOf(ui.tab.hash)!=0)
					      window.location.hash = ui.tab.hash;
					    });
					    $.address.externalChange(function(event){
						    var name = window.location.hash != \"\" ? window.location.hash.split(\"#\")[1] : \"\";
						    var  arr=name.split('/');
						    var request='';
						    var callbackid;
						    if(arr.length<=1) {
						    	if(name.length==0) {
						    		var retab=($(\"#page_tabs\").find('li.ui-state-default a') ||
						    			$(\"#page_tabs\").find('li:first a')).attr('href');
						    		 arr[0]=retab;
						    		
						    	}
						    	
						    	$(\"#page_tabs\").tabs( \"select\" , arr[0] );
						    	arr[0]='#'+arr[0].replace(/^\#/,'');
								var mde=$(arr[0]).find(\"input[name='modelName']\").val();
								if(typeof(mde)=='undefined') return;
								var mod=$(arr[0]).find(\"input[name='moduleName']\").val();
						    	request=mod+'/'+mde+'_display_tab';
						    	callbackid=$(arr[0]).find('.vs_panel').attr('id');
						    	
						    }else{
						    	$(\"#page_tabs\").tabs( \"select\" , arr[0] );
							   if(typeof($('#'+arr[0]).find('.vs_panel')[0])=='undefined'){
								    $( \"#page_tabs\").bind( \"tabsload\", function(event, ui) {
									     	callbackid=$('#'+arr[0]).find('.vs_panel').attr('id');
										    arr[0]=null;
										    //alert(arr.join('/'));
										    if(callbackid!='undefined'){
										    	request=arr.join('/');
										    	requestData(request,callbackid);
										    	
										    }
									});
									
							    }else{
							    		callbackid=$('#'+arr[0]).find('.vs_panel').attr('id');
									    arr[0]=null;
									    if(callbackid!='undefined'){
									    	request=arr.join('/');
									 	}
							    }
						    }
						    
						    requestData(request,callbackid);
						     
						    
						});
		  			});
		  			function requestData(url,callback){
		  				if(typeof(callback)!='undefined'){
		  				if($(\"#\"+callback).length>0){
		  					$(\"#\"+callback).children().remove();		
						}
							    if(typeof(noimage)==\"undefine\" || !noimage && callback!='')
									$(\"#\"+callback).html('<img src=\"'+imgurl+'loader.gif\"/>');
							    $.ajax({
									url: baseUrl+url,
									data:'ajax=1',
									success: function(data) {
										$('#'+callback).html(data);
									}
								});
						}
		  			}
				");
				
		
				$this->output=
			<<<EOF
		<div id="page_tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all-top">
		<ul id="tabs_nav" class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all-inner">
EOF;
	$i=1;
		foreach ($this->tabs as $tab) {
			$i++;
			$this->output.=
			'<li class="'.($tab['default']?'ui-state-default':'').' ui-corner-top ">
		        	<a '.($tab['id']?'title="'.$tab['id'].'"':'').' href="'.$tab['href'].'">'.$tab['title'].'</a>
		    </li>';
		}
		
			$this->output.=
			<<<EOF
		</ul>
		<div class="clear"></div>
		</div>
		<div id="temp"></div>
EOF;
	}
		return $this->output;
	}



}
