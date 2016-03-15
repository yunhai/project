<?php
class Support extends BasicObject {
	private $nick = null;
	private $type = null;
	private $profile = null;
	private $imageOffline = null;
	private $imageOnline = null;
	private $avatar = null;
	private $name			= null;
	private $phone			= null;
	
	function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['supportId'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['supportCatId'] = $this->catId) : '';
		isset ( $this->nick ) ? ($dbobj ['supportNick'] = $this->nick) : '';
		isset ( $this->avatar ) ? ($dbobj ['supportAvatar'] = $this->avatar) : '';
		isset ( $this->type ) ? ($dbobj ['supportType'] = $this->type) : '';
		isset ( $this->imageOffline ) ? ($dbobj ['supportImageOffline'] = $this->imageOffline) : '';
		isset ( $this->imageOnline ) ? ($dbobj ['supportImageOnline'] = $this->imageOnline) : '';
		isset ( $this->index ) ? ($dbobj ['supportIndex'] = $this->index) : '';
		isset ( $this->status ) ? ($dbobj ['supportStatus'] = $this->status) : '';
		isset ( $this->profile ) ? ($dbobj ['supportProfile'] = serialize ( $this->profile )) : '';
		isset ( $this->name )	? ($dbobj ['supportName']		= $this->name ) : '';
		isset ( $this->phone )	? ($dbobj ['supportPhone']		= $this->phone ) : '';
	
		return $dbobj;
	
	}
	
	function convertToObject($object) {
                parent::convertToObject($object);
		isset ( $object ['supportId'] ) ? $this->setId ( $object ['supportId'] ) : '';
		isset ( $object ['supportCatId'] ) ? $this->setCatId ( $object ['supportCatId'] ) : '';
		isset ( $object ['supportType'] ) ? $this->setType ( $object ['supportType'] ) : '';
		isset ( $object ['supportAvatar'] ) ? $this->setAvatar ( $object ['supportAvatar'] ) : '';
		isset ( $object ['supportNick'] ) ? $this->setNick ( $object ['supportNick'] ) : '';
		isset ( $object ['supportProfile'] ) ? $this->setProfile ( unserialize ( $object ['supportProfile'] ) ) : '';
		isset ( $object ['supportStatus'] ) ? $this->setStatus ( $object ['supportStatus'] ) : '';
		isset ( $object ['supportIndex'] ) ? $this->setIndex ( $object ['supportIndex'] ) : '';
		isset ( $object ['supportImageOffline'] ) ? $this->setImageOffline ( $object ['supportImageOffline'] ) : '';
		isset ( $object ['supportImageOnline'] ) ? $this->setImageOnline ( $object ['supportImageOnline'] ) : '';
		isset ( $object ['supportName'] ) ? $this->setName ( $object ['supportName'] ) : '';
		isset ( $object ['supportPhone'] ) ? $this->setPhone ( $object ['supportPhone'] ) : '';
		isset ( $object ['supportIntro'] ) ? $this->setIntro ( $object ['supportIntro'] ) : '';
		isset ( $object ['supportPosition'] ) ? $this->setPosition ( $object ['supportPosition'] ) : '';
	}
	
	/**
	 * change new to array modules to Template
	 * @return array $dbobj
	 */
	function validate() {
		global $vsLang;
		$status = true;
		if ($this->getNick () == "") {
			$this->message .= $vsLang->getWords ( "support_InformationError", "* Information cannot be blank!" );
			$status = false;
		}
		return $status;
	}
	function __construct() {
		parent::__construct ();
	}
	/**
	 * @return unknown
	 */
	/**
	 * @return the $avatar
	 */
	public function getAvatar() {
		return $this->avatar;
	}
	
	/**
	 * @param $avatar the $avatar to set
	 */
	public function setAvatar($avatar) {
		$this->avatar = $avatar;
	}
	
	/**
	 * @return unknown
	 */
	public function getNick() {
		if (strpos ( $this->nick, '@' ))
			return substr ( $this->nick, 0, strpos ( $this->nick, '@' ) - 1 );
		return $this->nick;
	}
	/**
	 * @return unknown
	 */
	public function getProfile() {
		return $this->profile;
	}
	
	/**
	 * @return unknown
	 */
	public function getImageOnline() {
		global $bw;
		return $this->imageOnline;
	}
	
	/**
	 * @return unknown
	 */
	public function getImageOffline() {
		global $bw;
		return $this->imageOffline;
	}
	/**
	 * @return unknown
	 */
	public function getType() {
		return $this->type;
	}
	
	/**
	 * @return unknown
	 */
	public function getUrl($default = true) {
		if ($default)
			return $this->status;
		return $this->status;
	
	}
	
	/**
	 * @param unknown_type $supportNick
	 */
	public function setNick($nick) {
		$this->nick = $nick;
	}
	
	public function setDepartment($department) {
		$this->department = $department;
	}
	/**
	 * @return unknown
	 */
	public function setImageOnline($image) {
		$this->imageOnline = $image;
	}
	/**
	 * @return unknown
	 */
	public function setImageOffline($image) {
		$this->imageOffline = $image;
	}
	/**
	 * @param unknown_type $Profile
	 */
	public function setProfile($profile) {
		$this->profile = $profile;
	}
	/**
	 * @param unknown_type $supportStatus
	 */
	public function setStatus($status) {
		$this->status = $status;
	}
	/**
	 * @param unknown_type $supportType
	 */
	public function setType($type) {
		$this->type = $type;
	}
	/**
	 *
	 * @return array object $this->groups of User class
	 */
	public function getName() {
		
		return $this->profile ['supportName'];
	
	}
	public function getIntro() {
		
		$parser = new PostParser ();
		$parser->pp_do_html = 1;
		$parser->pp_nl2br = 0;
		
		return $parser->post_db_parse ( $this->profile ['supportIntro'] );
	}
	
	public function getPhone() {
		
		return $this->profile ['supportPhone'];
	
	}
	/**
	 *
	 * @param int $id
	 */
	public function setIntro($value = '') {
		$this->profile ['supportIntro'] = $value;
	}
	/**
	 *
	 * @param int $id
	 */
	public function setName($value = '') {
		$this->profile ['supportName'] = $value;
	}
	public function setPhone($value = '') {
		$this->profile ['supportPhone'] = $value;
	}
	/**
	 *
	 * @return array object $this->groups of User class
	 */
	public function getPosition() {
		return $this->profile ['supportPosition'];
	}
	/**
	 *
	 * @param int $id
	 */
	public function setPosition($value = '') {
		$this->profile ['supportPosition'] = $value;
	}
	
	function showYahoo() {
		global $bw, $vsMenu, $vsPrint,$gloablnickol;
		
		$rand = str_replace ( ".", "", $this->getNick () . rand ( 1, 100 ) );
		$BWHTML .= <<<EOF
			<a  href="ymsgr:sendIM?{$this->getNick()}" title="{$this->getNick()}" rel="nofollow">
				<img id='yahooimagenick{$rand}'  style='vertical-align:middle;border:none;' alt="" /></a>			
EOF;
		$gloablnickol .= <<<EOF
			<a  href="ymsgr:sendIM?{$this->getNick()}" title="{$this->getNick()}" rel="nofollow">
				<img id='yahooimagenick1{$rand}'  style='vertical-align:middle;border:none;' alt="" /></a>			
EOF;
		if ($this->fileOnl) {
//			$image = $vsMenu->getCategoryById ( $this->imageOnline );
			
			$imageOnlinepath = $this->getCacheImagePathByFile ( $this->fileOnl, 78, '',1,1 );
		} else
			$imageOnlinepath = $this->defaulImageYahooOnline;
		if ($this->fileOff) {
//			$image = $vsMenu->getCategoryById ( $this->imageOffline );
			$imageOfflinepath = $this->getCacheImagePathByFile ( $this->fileOff, 78, '',1 ,1);
		} else
			$imageOfflinepath = $this->defaulImageYahooOffLine;
			$vsPrint->addJavaScriptString ( "yahoo_{$this->getNick()}{$rand}", "
			$(window).ready(function() {
				$.get('{$bw->vars['board_url']}/utils/CheckOnline.Api.php',{typecheck:'yahoo',nick:'{$this->getNick()}'},function(data){
						if(data == 1){
							$('#yahooimagenick{$rand}').attr({ 
								  src:  \"{$imageOnlinepath}\"
								});
							$('#yahooimagenick1{$rand}').attr({ 
								  src:  \"{$imageOnlinepath}\"
								});
						}
						else{
							$('#yahooimagenick{$rand}').attr({ 
								  src:  \"{$imageOfflinepath}\"
								});
							$('#yahooimagenick1{$rand}').attr({ 
								  src:  \"{$imageOfflinepath}\"
								});
						}
					});
			
			});
    		" );
		return $BWHTML;
	}
	
	function showSkype() {
		global $bw, $vsMenu, $vsPrint,$gloablnickol;
		$rand = $this->getNick () . rand ( 1, 100 );
		$rand = str_replace ( ".", "", $rand );
		$BWHTML .= <<<EOF
		<a  href="skype:{$this->getNick()}?chat" title="{$this->getNick()}" rel="nofollow">
				<img id='skypeimagenick{$rand}'  style='vertical-align:middle;border:none;' alt="" />{$this->getName()}</a>				
EOF;
		$gloablnickol .= <<<EOF
		<a  href="skype:{$this->getNick()}?chat" title="{$this->getNick()}" rel="nofollow">
				<img id='skypeimagenick1{$rand}'  style='vertical-align:middle;border:none;' alt="" />{$this->getName()}</a>				
EOF;
		if ($this->fileOnl) {
//			$image = $vsMenu->getCategoryById ( $this->imageOnline );
			$imageOnlinepath = $this->getCacheImagePathByFile ( $this->fileOnl, 78, 18 ,1,1);
		} else
			$imageOnlinepath = $this->defaulImageSkype;
		if ($this->fileOff) {
//			$image = $vsMenu->getCategoryById ( $this->imageOffline );
			$imageOfflinepath = $this->getCacheImagePathByFile ( $this->fileOff, 78, 18 ,1,1);
		} else
			$imageOfflinepath = $this->defaulImageSkype;
			$vsPrint->addJavaScriptString ( "skype_{$this->getNick()}{$rand}", "
				$(window).ready(function() {
					$.get('{$bw->vars['board_url']}/utils/CheckOnline.Api.php',{typecheck:'skype',nick:'{$this->getNick()}'},function(data){
								if(data == 1)
						 		{
									$('#skypeimagenick{$rand}').attr({ 
										  src: \"{$imageOnlinepath}\"
										});
									$('#skypeimagenick1{$rand}').attr({ 
										  src: \"{$imageOnlinepath}\"
										});
								}
								else
								{
									$('#skypeimagenick{$rand}').attr({ 
										  src: \"{$imageOfflinepath}\"
										});
									$('#skypeimagenick1{$rand}').attr({ 
										  src: \"{$imageOfflinepath}\"
										});
								}
							});
				});
	    	" );
		return $BWHTML;
	}
	

	
	function showPhone($srcImage) {
		if (file_exists ( $srcImage ))
			$image = "<img src='{$this->arrayStyle['image_phone']}' style='vertical-align:middle;border:none;' alt='{$vsLang->getWords('support_SupportImgAlt','Online Support')}'/>	";
		return "<span>{$this->getNick()}</span>
		{$image}
			";
	}
	function CheckSkyOnline($skyid) {
		$status = trim ( @file_get_contents ( "http://mystatus.skype.com/" . urlencode ( $skyid ) . ".num" ) );
		if ($status > 1)
			return true;
		return false;
	}
	
	/**
	 * @param unknown_type $supportStatus
	 */
	public function show() {
		global $vsStd;
		if ($this->type == 2) {
			return $this->showYahoo ();
		}
		if ($this->type == 1) {
			return $this->showSkype ();
		}
		
		return $this->showPhone ();
	}
	
	
	function __destruct() {
		unset ( $this->id );
		unset ( $this->nick );
		unset ( $this->profile );
		unset ( $this->status );
	}
}

?>