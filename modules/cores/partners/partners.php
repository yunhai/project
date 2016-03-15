<?php
require_once(CORE_PATH."partners/Partner.class.php");
class partners extends VSFObject {
	public $obj;
	protected $relTableName 	="";

	function __construct(){
            global $vsMenu,$bw;
            parent::__construct();
		$this->categoryField 	= "partnerCatId";
		$this->primaryField 	= 'partnerId';
		$this->basicClassName 	= 'Partner';
		$this->tableName 	= 'partner';
		$this->relTableName 	= "rel_partner_file";
		$this->obj = $this->createBasicObject();
		$this->categories = $vsMenu->getCategoryGroup($bw->input['module']);
	}

	/**
	 * @return the $relTableName
	 */
	public function getPartnersForUser($module="partners") {
            global $vsMenu;
                $categories = $vsMenu->getCategoryGroup($module);
                $ids=$vsMenu->getChildrenIdInTree($categories);
     
        $this->setFieldsString("partnerId,partnerTitle,partnerImage,partnerCatId,partnerWebsite");       
		$this->condition = "partnerStatus > 0 and partnerCatId in ( {$ids})";
		$this->setOrder("partnerIndex ASC");
                $list = $this->getObjectsByCondition();
                if($list)
                    $this->convertFileObject($list,$module);
               
		return $list;
	}
	
	public function getPartnersForPosition($pos,$module="partners") {
            global $vsMenu,$bw;
                $categories = $vsMenu->getCategoryGroup($module);
                $ids=$vsMenu->getChildrenIdInTree($categories);
     
        $this->setFieldsString("partnerId,partnerTitle,partnerImage,partnerCatId,partnerWebsite,partnerPosition");       
		$this->condition = "partnerStatus > 0 and partnerCatId in ( {$ids}) and partnerPosition = {$pos}";
		$this->setOrder("partnerIndex ASC");
                $list = $this->getObjectsByCondition();
                if($list)
                    $this->convertFileObject($list,$module);
               
		return $list;
	}
        
        public function getArrayPartners($moduleList=array()) {
            global $vsMenu;
            if(!is_array($moduleList) or !count($moduleList))return false;

            foreach($moduleList as $module){
                $temp = $vsMenu->getCategoryGroup($module);
                if($temp)
                    $id[$temp->getId()] = $module;
                
            }
            
                $ids=  implode(",", array_keys($id));
                
               
		$this->condition = "partnerStatus > 0 and partnerCatId in ( {$ids})";
		$this->setOrder("partnerIndex ASC");
		
		
		
                $list = $this->getObjectsByCondition('getCatId',1);
                
                if($list)
                    foreach($list as $key =>$val)
                    if($id[$key]){
                        
                        $this->convertFileObject($val,$id[$key]);
                        $return[$id[$key]] = $val;
                    }
            
		return $return;
	}
        
	public function getRelTableName() {
		return $this->relTableName;
	}

	/**
	 * @param $relTableName the $relTableName to set
	 */
	public function setRelTableName($relTableName) {
		$this->relTableName = $relTableName;
	}

	
	
	function __destruct(){
		unset($this);
	}

}
?>