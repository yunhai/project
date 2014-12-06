<?php
class Admin extends BasicObject {

	public function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
		isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
		isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
		isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
		isset ( $this->password ) ? ($dbobj ['password'] = $this->password) : '';
		isset ( $this->lastLogin ) ? ($dbobj ['lastLogin'] = $this->lastLogin) : '';
		isset ( $this->joinDate ) ? ($dbobj ['joinDate'] = $this->joinDate) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		return $dbobj;
	}

	public function convertToObject($object = array()) {
		isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
		isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
		isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
		isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
		isset ( $object ['password'] ) ? $this->setPassword ( $object ['password'] ) : '';
		isset ( $object ['lastLogin'] ) ? $this->setLastLogin ( $object ['lastLogin'] ) : '';
		isset ( $object ['joinDate'] ) ? $this->setJoinDate ( $object ['joinDate'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
	}

	function getId() {
		return $this->id;
	}

	function getName() {
		return $this->name;
	}

	function getAddress() {
		return $this->address;
	}

	function getEmail() {
		return $this->email;
	}

	function getPhone() {
		return $this->phone;
	}

	function getPassword() {
		return $this->password;
	}

	function getLastLogin() {
		return $this->lastLogin;
	}

	function getJoinDate() {
		return $this->joinDate;
	}

	function getIndex() {
		return $this->index;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setAddress($address) {
		$this->address = $address;
	}

	function setEmail($email) {
		$this->email = $email;
	}

	function setPhone($phone) {
		$this->phone = $phone;
	}

	function setPassword($password) {
		$this->password = $password;
	}

	function setLastLogin($lastLogin) {
		$this->lastLogin = $lastLogin;
	}

	function setJoinDate($joinDate) {
		$this->joinDate = $joinDate;
	}

	function setStatus($status) {
		$this->status = $status;
	}

	function setIndex($index) {
		$this->index = $index;
	}

	/**
	 *
	 * @return the $title
	 */
	public function getTitle() {
		return $this->name;
	}

	/**
	 *
	 * @param field_type $title        	
	 */
	public function setTitle($title) {
		$this->name = $title;
	}

	function validate() {
		return true;
	}

	function getGroups() {
		return array ();
	}

	function addGroup() {
		return array ();
	}

	function checkPermission($permissionName) {
		global $bw;
		$groups = $this->getGroupList ();
		if ($groups [$bw->vars ['root_admin_groups']])
			return 1;
		$this->getPerList ();
		if ($this->perlist [$permissionName])
			return true;
		return false;
	}
	private $perlist = NULL;

	function getPerList() {
		if ($this->perlist === NULL) {
			$this->perlist = array ();
			$admins = new admins ();
			$gs = $admins->getGroupForAdmin ( $this->getId () );
			foreach ( $gs as $g ) {
				$groups = new admingroups ();
				$this->perlist = array_merge ( $this->perlist, $groups->getPermissionForGroup ( $g->getId () ) );
			}
			unset ( $groups );
			unset ( $admins );
		}
		return $this->perlist;
	}
	private $group = NULL;

	function getGroupList() {
		if ($this->group === NULL) {
			$admins = new admins ();
			$this->group = $admins->getGroupForAdmin ( $this->getId () );
		}
		return $this->group;
	}

	function __destruct() {
		unset ( $this );
	}
	var $id;
	var $name;
	var $address;
	var $email;
	var $phone;
	var $password;
	var $lastLogin;
	var $joinDate;
	var $status;
	var $index;
}
