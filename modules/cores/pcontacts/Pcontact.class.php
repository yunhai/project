<?php
class Pcontact extends BasicObject {
	private $address = NULL;
	private $addressview = NULL;
	private $email = NULL;
	private $longitude = 0;
	private $latitude = 0;
	private $sname = NULL;
	
	/**
	 * @return the $address
	 */
	public function getAddress() {
		return $this->address;
	}
	public function getAddressview() {
		return $this->addressview;
	}
	//	public function getAddressGoogle() {
	//		$parser = new PostParser ();
	//		$parser->pp_do_html = 1;
	//		$parser->pp_nl2br = 0;
	//		$address = $parser->post_db_parse($this->address);
	//		return $address;
	//	}
	function getAddressGoogle($size = 0, $br = 0, $tags = "") {
		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = $br;
		$intro = $parser->post_db_parse ( $this->address );
		if ($size) {
			if ($tags)
				$intro = strip_tags ( $intro, $tags );
			else
				$intro = strip_tags ( $intro );
			return VSFTextCode::cutString ( $intro, $size );
		}
		return $intro;
	}
	/**
	 * @return the $email
	 */
	public function getEmail() {
		return $this->email;
	}
	
	/**
	 * @return the $longitude
	 */
	public function getLongitude() {
		return $this->longitude;
	}
	
	/**
	 * @return the $latitude
	 */
	public function getLatitude() {
		return $this->latitude;
	}
	
	/**
	 * @return the $sname
	 */
	public function getSname() {
		return $this->sname;
	}
	
	/**
	 * @param field_type $address
	 */
	public function setAddress($address) {
		$this->address = $address;
	}
	public function setAddressview($address) {
		$this->addressview = $address;
	}
	/**
	 * @param field_type $email
	 */
	public function setEmail($email) {
		$this->email = $email;
	}
	
	/**
	 * @param field_type $longitude
	 */
	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}
	
	/**
	 * @param field_type $latitude
	 */
	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}
	
	/**
	 * @param field_type $sname
	 */
	public function setSname($sname) {
		$this->sname = $sname;
	}
	
	function __construct() {
		parent::__construct ();
	}
	
	function __destruct() {
		parent::__destruct ();
		unset ( $this );
	
	}
	public function convertToDB() {
		$dbobj = parent::convertToDB ( 'pcontact' );
		isset ( $this->address ) ? ($dbobj ['pcontactAddress'] = $this->address) : '';
		isset ( $this->addressview ) ? ($dbobj ['pcontactAddressview'] = $this->addressview) : '';
		isset ( $this->email ) ? ($dbobj ['pcontactEmail'] = $this->email) : '';
		isset ( $this->longitude ) ? ($dbobj ['pcontactLongitude'] = $this->longitude) : '';
		isset ( $this->latitude ) ? ($dbobj ['pcontactLatitude'] = $this->latitude) : '';
		isset ( $this->sname ) ? ($dbobj ['pcontactSname'] = $this->sname) : '';
		return $dbobj;
	}
	function convertToObject($object) {
		global $vsMenu;
		parent::convertToObject ( $object, 'pcontact' );
		isset ( $object ['pcontactAddress'] ) ? $this->setAddress ( $object ['pcontactAddress'] ) : '';
		isset ( $object ['pcontactAddressview'] ) ? $this->setAddressview ( $object ['pcontactAddressview'] ) : '';
		isset ( $object ['pcontactEmail'] ) ? $this->setEmail ( $object ['pcontactEmail'] ) : '';
		isset ( $object ['pcontactLongitude'] ) ? $this->setLongitude ( $object ['pcontactLongitude'] ) : '';
		isset ( $object ['pcontactLatitude'] ) ? $this->setLatitude ( $object ['pcontactLatitude'] ) : '';
		isset ( $object ['pcontactSname'] ) ? $this->setSname ( $object ['pcontactSname'] ) : '';
	}

}