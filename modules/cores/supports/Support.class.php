<?php
class Support extends BasicObject {
	private $nick = null;
	private $type = null;
	private $profile = null;
	private $imageOffline = null;
	private $imageOnline = null;
	private $avatar = null;
	
	function convertToDB() {
		isset ( $this->id ) ? ($dbobj ['supportId'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['supportCatId'] = $this->catId) : '';
		isset ( $this->nick ) ? ($dbobj ['supportNick'] = $this->nick) : '';
		isset ( $this->title ) ? ($dbobj ['supportTitle'] = $this->title) : '';
		isset ( $this->type ) ? ($dbobj ['supportType'] = $this->type) : '';
		isset ( $this->imageOffline ) ? ($dbobj ['supportImageOffline'] = $this->imageOffline) : '';
		isset ( $this->imageOnline ) ? ($dbobj ['supportImageOnline'] = $this->imageOnline) : '';
		isset ( $this->index ) ? ($dbobj ['supportIndex'] = $this->index) : '';
		isset ( $this->status ) ? ($dbobj ['supportStatus'] = $this->status) : '';
		return $dbobj;
	}
	
	function convertToObject($object) {
		parent::convertToObject($object);
		isset ( $object ['supportId'] ) ? $this->setId ( $object ['supportId'] ) : '';
		isset ( $object ['supportCatId'] ) ? $this->setCatId ( $object ['supportCatId'] ) : '';
		isset ( $object ['supportType'] ) ? $this->setType ( $object ['supportType'] ) : '';
		isset ( $object ['supportTitle'] ) ? $this->setTitle ( $object ['supportTitle'] ) : '';
		isset ( $object ['supportNick'] ) ? $this->setNick ( $object ['supportNick'] ) : '';
		isset ( $object ['supportStatus'] ) ? $this->setStatus ( $object ['supportStatus'] ) : '';
		isset ( $object ['supportIndex'] ) ? $this->setIndex ( $object ['supportIndex'] ) : '';
		isset ( $object ['supportImageOffline'] ) ? $this->setImageOffline ( $object ['supportImageOffline'] ) : '';
		isset ( $object ['supportImageOnline'] ) ? $this->setImageOnline ( $object ['supportImageOnline'] ) : '';
	}
	
	
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
	
	public function getNick() {
		if (strpos ( $this->nick, '@' ))
			return substr ( $this->nick, 0, strpos ( $this->nick, '@' ) - 1 );
		return $this->nick;
	}

	public function getImageOnline() {
		global $bw;
		return $this->imageOnline;
	}
	
	
	public function getImageOffline() {
		global $bw;
		return $this->imageOffline;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function getUrl($default = true) {
		if ($default)
			return $this->status;
		return $this->status;
	
	}
	
	
	public function setNick($nick) {
		$this->nick = $nick;
	}
	
	public function setImageOnline($image) {
		$this->imageOnline = $image;
	}
	
	public function setImageOffline($image) {
		$this->imageOffline = $image;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}

	public function setType($type) {
		$this->type = $type;
	}
	

	function showYahoo() {
		global $bw, $vsMenu, $vsPrint;
		
		$BWHTML .= <<<EOF
			<a href="ymsgr:sendIM?{$this->getNick()}" title="{$this->getTitle()}" rel="nofollow">
				<img class='yahoo' style='vertical-align:middle; border:none; height: 16px;' alt="{$this->getNick()}" src='http://opi.yahoo.com/online?u={$this->getNick()}&m=g&t=5' />
			</a>			
EOF;
		return $BWHTML;
	}
	
	function showYahooAdvance(){
		global $bw, $vsPrint;
		
		$rand = str_replace ( ".", "", $this->getNick () . rand ( 1, 100 ) );
		$BWHTML .= <<<EOF
			<a href="ymsgr:sendIM?{$this->getNick()}" title="{$this->getTitle()}" rel="nofollow">
				<img id='yahooimagenick{$rand}' style='vertical-align:middle;border:none;' alt="" /></a>			
EOF;

		if ($this->fileOnl) {
			$imageOnlinepath = $this->getCacheImagePathByFile ( $this->fileOnl, 78, '',1,1 );
		} else
			$imageOnlinepath = $this->defaulImageYahooOnline;
		if ($this->fileOff) {
			$imageOfflinepath = $this->getCacheImagePathByFile ( $this->fileOff, 78, '',1 ,1);
		} else
			$imageOfflinepath = $this->defaulImageYahooOffLine;
			$vsPrint->addJavaScriptString ( "yahoo_{$this->getNick()}", "
			$(window).ready(function() {
				$.get('{$bw->vars['board_url']}/utils/checkonline.php',{typecheck:'yahoo',nick:'{$this->getNick()}'},function(data){
						if(data == 1){
							$('#yahooimagenick{$rand}').attr({ 
								src:  \"{$imageOnlinepath}\"
								});
						}
						else{
							$('#yahooimagenick{$rand}').attr({ 
								  src:  \"{$imageOfflinepath}\"
								});
						}
					});
			
			});
    		" );
		return $BWHTML;
	}
	
	function showSkypeAdvance() {
		global $bw, $vsPrint;
		
		$BWHTML .= <<<EOF
		<a href="skype:{$this->getNick()}?chat" title="{$this->getTitle()}" rel="nofollow">
			<img class='skype' style='vertical-align:middle; border:none;' alt="{$this->getNick()}" />
		</a>				
EOF;
		$imageOnlinepath = $this->defaulImageSkype;
		if($this->fileOnl)
			$imageOnlinepath = $this->getCacheImagePathByFile ( $this->fileOnl, 78, 18 ,1,1);
			
		
		if($this->fileOff) $imageOfflinepath = $this->getCacheImagePathByFile ( $this->fileOff, 78, 18 ,1,1);
		else
			$imageOfflinepath = $this->defaulImageSkype;
			$vsPrint->addJavaScriptString("skype_{$this->getNick()}", "
				$(window).ready(function() {
					$.get('{$bw->vars['board_url']}/utils/checkonline.php',{typecheck:'skype',nick:'{$this->getNick()}'},function(data){
								if(data == 1){
									$('.skype').attr({ 
										  src: '{$imageOnlinepath}'
										});
								}
								else{
									$('.skype').attr({ 
										  src: '{$imageOfflinepath}'
										});
								}
							});
				});
	    	" );
		return $BWHTML;
	}
	
	
	function showSkype() {
		global $bw, $vsPrint;
		
		$BWHTML .= <<<EOF
		<a href="skype:{$this->getNick()}?chat" title="{$this->getTitle()}" rel="nofollow">
			<img class='skype' style='vertical-align:middle; border:none;' alt="{$this->getNick()}" />
		</a>				
EOF;
		$imageOnlinepath = $this->defaulImageSkype;
		if($this->fileOnl)
			$imageOnlinepath = $this->getCacheImagePathByFile ( $this->fileOnl, 78, 18 ,1,1);
			
		
		if($this->fileOff) $imageOfflinepath = $this->getCacheImagePathByFile ( $this->fileOff, 78, 18 ,1,1);
		else
			$imageOfflinepath = $this->defaulImageSkype;
			$vsPrint->addJavaScriptString("skype_{$this->getNick()}", "
				$(window).ready(function() {
					$.get('{$bw->vars['board_url']}/utils/checkonline.php',{typecheck:'skype',nick:'{$this->getNick()}'},function(data){
								if(data == 1){
									$('.skype').attr({ 
										  src: '{$imageOnlinepath}'
										});
								}
								else{
									$('.skype').attr({ 
										  src: '{$imageOfflinepath}'
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
	
	function show() {
		if ($this->type == 1) return $this->showSkype();
		if ($this->type == 2) return $this->showYahoo();
		
		return '';
	}
	
	function showAdvance() {
		if ($this->type == 1) return $this->showSkypeAdvance();
		if ($this->type == 2) return $this->showYahooAdvance();
	}
	
	function __destruct() {
		unset ( $this->id );
		unset ( $this->nick );
		unset ( $this->profile );
		unset ( $this->status );
	}
}

?>