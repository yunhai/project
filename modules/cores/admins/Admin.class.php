<?php
class Admin extends BasicObject{

	private $name 		= NULL;
	private $password 	= NULL;
	private $lastLogin 	= NULL;
	private $joinDate 	= NULL;
	private $groups 	= NULL;
        private $email          = NULL;

	function __construct() {
		parent::__construct();
	}

	function __destruct() {
		parent::__destruct();
		unset($this->name);
		unset($this->password);
		unset($this->lastLogin);
		unset($this->joinDate);
                unset($this->email);
	}

	public function addGroup($group) {
		if(!is_object($group)) throw new Exception("Parameter is not an Group object!");

		$this->groups[$group->getId()] = $group;
	}
	/**
	 * get array Groups object of GroupAdmin class
	 * @return array object $this->groups of Admin class
	 */
	public function getGroups() {
		return $this->groups;
	}
        public function getEmail() {
		return $this->email;
	}

	public function getMainGroup() {
		if(!count($this->groups))
		return new GroupAdmin();
		return current($this->groups);
	}

	/**
	 * set Groups for Admin
	 * @param array object of GroupAdmin class
	 */
	public function setGroups($groups=array()) {
		$this->groups = $groups;
	}
        
        public function setEmail($email="") {
		$this->email = $email;
	}

	public function getName() {
		return $this->name;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getLastLogin($isInt=true,$format="SHORT") {
		if($isInt)
		return $this->lastLogin;
		return VSFDateTime::GetDate($this->lastLogin,$format);
	}

	public function getJoinDate($isInt=true,$format='SHORT') {
		global $vsDateTime;
		if($isInt)
		return $this->joinDate;
		return VSFDateTime::getDate($this->joinDate,$format);
	}

	public function setName($name="") {
		$this->name = $name;
	}

	public function setPassword($password) {
		$this->password = md5($password);
	}
	public function setPasswordMd5($password) {
		$this->password = $password;
	}

	public function setLastLogin($lastLogin=0) {
		$this->lastLogin = $lastLogin;
	}

	public function setJoinDate($joinDate=0) {
		$this->joinDate = $joinDate;
	}



	function convertRelToDB($group) {
		$dbobj = array(	'adminId'	=> $this->id,
						'groupId'	=> $group->getId()
		);
		return $dbobj;
	}

	/**
	 * change Admin object to array to insert database
	 * @return array $dbobj
	 *
	 */
	function convertToDB() {
		isset ( $this->id ) 		? ($dbobj ['adminId'] 			= $this->id) 		: '';
		isset ( $this->password ) 	? ($dbobj ['adminPassword'] 	= $this->password) 	: '';
		isset ( $this->name ) 		? ($dbobj ['adminName'] 		= $this->name) 		: '';
		isset ( $this->lastLogin)	? ($dbobj ['adminLastLogin'] 	= $this->lastLogin) : '';
		isset ( $this->joinDate ) 	? ($dbobj ['adminJoinDate'] 	= $this->joinDate) 	: '';
		isset ( $this->status )		? ($dbobj ['adminStatus'] 		= $this->status) 	: '';
		isset ( $this->index ) 		? ($dbobj ['adminIndex'] 		= $this->index) 	: '';
                isset ( $this->email ) 		? ($dbobj ['adminEmail'] 		= $this->email) 	: '';
		return $dbobj;
	}
	/**
	 * change Admin from database object to Admin object
	 * @param array $dbobj Database object
	 * @return void
	 *
	 */
	function convertToObject($object) {
		isset ( $object ['adminId'] ) 			? $this->setId ( $object ['adminId'] ) 				: '';
		isset ( $object ['adminName'] ) 		? $this->setName ( $object ['adminName'] ) 			: '';
		isset ( $object ['adminPassword'] ) 	? $this->password	= $object['adminPassword']		: '';
		isset ( $object ['adminLastLogin'] ) 	? $this->setLastLogin ( $object ['adminLastLogin'] ): '';
		isset ( $object ['adminJoinDate'] ) 	? $this->setJoinDate ( $object ['adminJoinDate'] ) 	: '';
		isset ( $object ['adminStatus'] )		? $this->setStatus ( $object ['adminStatus'] ) 		: '';
		isset ( $object ['adminIndex'] )		? $this->setIndex( $object ['adminIndex'] ) 		: '';
                isset ( $object ['adminEmail'] )		? $this->setEmail( $object ['adminEmail'] ) 		: '';
	}
	
	function validate() {
	  $status = true;
	  if ($this->name == "") {
	   $this->message .= " title can not be blank!";
	   $status = false;
	  }
	  return $status;
	 }
}

?>