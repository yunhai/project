<?php
class Lang extends BasicObject {

	public function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->key ) ? ($dbobj ['key'] = $this->key) : '';
		isset ( $this->en ) ? ($dbobj ['en'] = $this->en) : '';
		isset ( $this->vi ) ? ($dbobj ['vi'] = $this->vi) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->module ) ? ($dbobj ['module'] = $this->module) : '';
		isset ( $this->root ) ? ($dbobj ['root'] = $this->root) : '';
		return $dbobj;
	}

	public function convertToObject($object = array()) {
		foreach ( $object as $index => $value ) {
			$this->$index = $value;
		}
	}

	function getId() {
		return $this->id;
	}

	function getKey() {
		return $this->key;
	}

	function getEn() {
		return $this->en;
	}

	function getVi() {
		return $this->vi;
	}

	function getType() {
		return $this->type;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setKey($key) {
		$this->key = $key;
	}

	function setEn($en) {
		$this->en = $en;
	}

	function setVi($vi) {
		$this->vi = $vi;
	}

	function getModule() {
		if (! $this->module)
			return 'global';
		return $this->module;
	}

	function setModule($module) {
		$this->module = $module;
	}

	function setType($type) {
		$this->type = $type;
	}

	function validate() {
		$status = true;
		if ($this->key == "") {
			$this->message .= " key can not be blank!";
			$status = false;
		}
		return $status;
	}
	var $id;
	var $key;
	var $en;
	var $vi;
	var $type;
	var $module;
	var $root;

	public function getRoot($format = '') {
		if ($format == 'checked') {
			if ($this->root)
				return 'checked';
			return '';
		}
		if ($format == "image") {
			global $bw;
			$imgArray = array ('disabled.png', 'enable.png', 'home.png', 'hot.png' );
			return "<img src='{$bw->vars ['img_url']}/{$imgArray[$this->root]}' alt='{$this->root}' />";
		}
		return $this->root;
	}

	public function setRoot($root) {
		$this->root = $root;
	}
}
