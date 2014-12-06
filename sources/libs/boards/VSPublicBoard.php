<?php
class VSPublicBoard {
	protected  $tabs=array();
	function auto_run($module,$defaultModel="") {
		global $bw;
		//$cClass=$bw->input[0];
		if(!$bw->input [1]){
			$action=$defaultModel?$defaultModel:$module;
		}else{
			$action=$bw->input [1];
		}
		$expl=explode('_',$action);
		if(!file_exists(CORE_PATH.$module."/{$expl[0]}_controler_public.php")){
			$action=($defaultModel?$defaultModel:$module)."_".$action;
			$expl=explode('_',$action);
		}
		if($action){
			if(file_exists(CORE_PATH.$module."/{$expl[0]}_controler_public.php")){
				$cClass=$expl[0];
				$class=$cClass.'_controler_public';
				require_once CORE_PATH.$module."/$class.php";
				
				if(class_exists($class)){
					$controler=new $class($cClass);
					if(method_exists($controler,"auto_run")){
						$bw->input['action']=$action;
							$controler->auto_run();
							return $this->setOutput($controler->getOutput());
					}else die("$cClass::auto_run()  not exist!");
				}
			}else{
				die("controler  not exist!");
			}
		}
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
}

?>