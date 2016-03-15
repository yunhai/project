<?php
require_once LIBS_PATH . "boards/Object.board.php";
class VSFObject extends Object{
/*
 	Những hàm kế thừa từ Object:
	1. createBasicObject
	2. getNumberOfObject
	3. getObjectById($id)
	4. getOneObjectsByCondition
	5. getObjectsByCondition($method='getId',$group=0)
	6. insertObject
	7. deleteObjectByCondition
	8. deleteObjectById($id)
	9. updateObjectByCondition(fields)
*/
	function __construct() {
		parent::__construct();
	}


        function getSearchStrings() {
		global $DB,$vsLang;
                $this->fieldsString = $this->tableName.'Id, '.$this->tableName.'Title';
		$this->resetResult();
		$this->createMessageSuccess($this->vsLang->getWords('count_table_success', "count table successfully!"));
		$query = array(	'select'=> $this->fieldsString,
                                'from'	=> $this->tableName,
                                'where'	=> $this->condition
		);

		$DB->simple_construct($query);
		$this->resetQuery();
		$array=array();
		if(!$DB->simple_exec()) {
			$this->createMessageError($this->vsLang->getWords('count_table_condition_fail',"There is no item in table!"));
			return $array;
		}

                while($row = mysql_fetch_array($DB->query_id))
                        $result[] = $row;

                $arrayStrings = null;
                if(count($result))
                   for($i=0; $i<count($result); $i++){
                        $arrayStrings['id'][$i] = $result[$i][$this->tableName.'Id'];
                        $arrayStrings['title'][$i] = $result[$i][$this->tableName.'Title'];
                   }
                  if($arrayStrings){
                  $arrayStrings['id']=implode(',', $arrayStrings['id']);
                  $arrayStrings['title']=implode(',', $arrayStrings['title']);
                  }

                  return $arrayStrings;
	}


	function countTable() {
		global $DB,$vsLang;
		$this->resetResult();
		$this->fieldsString="count({$this->primaryField}) as total";
		$this->createMessageSuccess($this->vsLang->getWords('count_table_success', "count table successfully!"));
		$query = array(	'select'=> $this->fieldsString,
					 	'from'	=> $this->tableName,
					   	'where'	=> $this->condition
		);
		$totalfeild=1;
		if($this->groupby)
		{
			$query['select'] = "{$this->groupby},$this->fieldsString";
			$query['groupby'] = $this->groupby;
			$totalfeild= count(explode(',',$this->groupby));
		}
		$DB->simple_construct($query);
		$this->resetQuery();
		$array=array();
		if(!$DB->simple_exec()) {
			$this->createMessageError($this->vsLang->getWords('count_table_condition_fail',"There is no item in table!"));
			return $array;
		}
		$result=mysql_fetch_row($DB->query_id);
		if(!is_array($result))
		{
			$this->createMessageError($this->vsLang->getWords('count_table_condition_fail',"There is no item in table!"));
			return array();
		}
		try{
			while($result) {
				$eval ="\$array";

				for($i=0; $i<$totalfeild; $i++)
					$eval =$eval."[$result[$i]]";

				eval($eval."=$result[$totalfeild] ;");
				$result=mysql_fetch_row($DB->query_id);
			}
		}catch(Exception $e){
			$this->createMessageError($this->vsLang->getWords('count_table_condition_fail',"There is no item in table!"));
			Throw new Exception($e);
		}
		return $array;
	}


	function getPageList($url="", $objIndex=3, $size=10, $ajax = 0, $callack=""){
		global $vsStd,$bw,$DB;
		$vsStd->requireFile(LIBS_PATH."/Pagination.class.php");
	
		$total = $this->getNumberOfObject();
		if($size < $total){
			$pagination = new VSFPagination();
			$pagination->ajax				= $ajax;
			$pagination->callbackobjectId 	= $callack;
			$pagination->url 				= $ajax?ltrim($url,'/')."/":$bw->base_url.(trim($url,'/')."/");

			$pagination->p_Size 			= $size;
			$pagination->p_TotalRow 		= $total;
			$pagination->SetCurrentPage($objIndex);
			$pagination->BuildPageLinks();
			$this->setLimit(array($pagination->p_StartRow,$pagination->p_Size));
		}
		$option['paging'] = $pagination->p_Links;

		$option['pageList'] = $this->getObjectsByCondition();
		$option['total'] = $total;
		return $option;
	}


	function reportError(){
		if($this->result['message'])
			print '<script type="text/javascript">window.parent.alertError("'.$this->result['message'].'");</script>';
	}


	function getBasicObject() {
		return $this->basicObject;
	}

	function getBasicClassName() {
		return $this->basicClassName;
	}


	function setBasicObject($basicObject) {
		$this->basicObject = $basicObject;
	}


	function setBasicClassName($basicClassName) {
		$this->basicClassName = $basicClassName;
	}


	function setPrimaryField($primaryField) {
		$this->primaryField = $primaryField;
	}


	function setTableName($tableName) {
		$this->tableName = $tableName;
	}


	function getPrimaryField() {
		return $this->primaryField;
	}


	function getTableName() {
		return $this->tableName;
	}


	function setFieldsString($fieldsString) {
		$this->fieldsString  = $fieldsString ? $fieldsString : "*";
	}


	function getFieldsString() {
		return $this->fieldsString;
	}


	function setHaving($value) {
		$this->having  = $value;
	}


	function getHaving() {
		return $this->having;
	}


	function setResult($result) {
		$this->result = $result;
	}


	function setFields($fields) {
		$this->fields = $fields;
	}


	function getResult() {
		return $this->result;
	}


	function getFields() {
		return $this->fields;
	}


	function setLimit($limit) {
		$this->limit = $limit;
	}


	function setOrder($order) {
		$this->order = $order;
	}


	function setGroupby($groupby) {
		$this->groupby = $groupby;
	}


	function setCondition($condition) {
		$this->condition = $condition;
	}


	function getLimit() {
		return $this->limit;
	}


	function getGroupby() {
		return $this->groupby;
	}


	function getOrder() {
		return $this->order;
	}


	function getCondition() {
		return $this->condition;
	}


	function setPrefixField($prefixField) {
		$this->prefixField = $prefixField;
	}


	function getPrefixField() {
		return $this->prefixField;
	}


	function setArrayObj($arrayObj) {
		$this->arrayObj = $arrayObj;
	}


	function getArrayObj() {
		return $this->arrayObj;
	}

	function getListIds() {
		return implode(',',array_keys($this->arrayObj));
	}


        function showStatusInfo($home = 0){
            global $bw, $vsLang;
            if($home)
                return '
                <table cellspacing="1" cellpadding="1" id="objListInfo" width="100%">
                                             <tbody>
                                                    <tr align="left">
                <span style="padding-left: 10px;line-height:16px;"><img src="'.$bw->vars['img_url'].'/enable.png" /> '.$vsLang->getWords('global_status_enable', 'Enable').'</span>
                <span style="padding-left: 10px;line-height:16px;"><img src="'.$bw->vars['img_url'].'/disabled.png" /> '.$vsLang->getWords('global_status_disabled', 'Disable').'</span>
                <span style="padding-left: 10px;line-height:16px;"><img src="'.$bw->vars['img_url'].'/home.png" /> '.$vsLang->getWords('global_status_ishome', 'Show on home page').'</span>
                                                    </tr>
                                             </tbody>
                                        </table>
                ';
            else
                 return '
                <table cellspacing="1" cellpadding="1" id="objListInfo" width="100%">
                                             <tbody>
                                                    <tr align="left">
                <span style="padding-left: 10px;line-height:16px;"><img src="'.$bw->vars['img_url'].'/enable.png" /> '.$vsLang->getWords('global_status_enable', 'Enable').'</span>
                <span style="padding-left: 10px;line-height:16px;"><img src="'.$bw->vars['img_url'].'/disabled.png" /> '.$vsLang->getWords('global_status_disabled', 'Disable').'</span>

                                                    </tr>
                                             </tbody>
                                        </table>
                ';
        }


        function createSearchCondition($searchContent, $searchType, $moduleName){
            $result = null;
            $moduleName = current(str_split($moduleName, strlen($moduleName)-1));
            if($searchType==1) $result = $moduleName.'Id='.$searchContent;
            else
                $result = $moduleName.'ClearSearch LIKE '.'"%'.$searchContent.'%"';
            return $result;
        }

}