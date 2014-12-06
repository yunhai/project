<?php

class widgets_board {
	var $title="None widget";
	
	/**
	 * 
	 * Enter description here ...
	 * @var Widget
	 */
	var $obj=null;
	public function showPublicForm(){
	$html= <<<EOF

	public form here!
EOF;
		return $html;
	}
	public function showAdminForm($obj){
	$html= <<<EOF
public form here!
	
EOF;
		return $html;	
	}
	public function onSubmitForm($form,$option){
		if(is_array($form)){
			foreach ($form as $index=>$value) {
				$option[$index]=$value;
			}
		}
		return $option;
	}
	/**
	 * @return the $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param field_type $title
	 */
	public function setTitle($title) {
		$this->title = $title;
	}
public function getObjTitle() {
		return $this->obj->title?$this->obj->title:$this->title;
	}
	
	
}

?>