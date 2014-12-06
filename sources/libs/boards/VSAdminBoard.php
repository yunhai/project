<?php


class VSAdminBoard{
	protected  $tabs=array();

	function auto_run() {
		global $bw,$vsModule;
		if(!VSFactory::getAdmins()->basicObject->checkPermission($bw->input[0].'_access_module')&&file_exists(CORE_PATH.$vsModule->basicObject->getClass()."/{$vsModule->basicObject->getClass()}_admin_permission.php")){
			return $this->exitDenyAccess();
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
				$vsPrint->addJavaScriptString ( 'init_tab', "
					//dã copy qua vs.fwadmin.js
				");
		
				$this->output=
			<<<EOF
		<div id="page_tabs" class="ui-tabs">
		<ul id="tabs_nav" class="ui-tabs-nav">
EOF;
		$i=1;
		foreach ($this->tabs as $tab) {
			$i++;
			$this->output.=
			'<li class="'.($tab['default']?'ui-state-default':'').' ui-corner-top">
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
		return $this->output;
	}
	function getLang(){
		return VSFactory::getLangs();
	}
	public $output;
	/**
	 * @return the $output
	 */
	public function getOutput() {
		return $this->output;
	}

	/**
	 * @param field_type $output
	 */
	public function setOutput($output) {
		$this->output = $output;
	}
	function exitDenyAccess(){
		throw  new Exception( "Access denied!", "001100");
	}
}

?>