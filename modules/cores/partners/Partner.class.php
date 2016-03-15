<?php
class Partner extends BasicObject{
	private $address 	= NULL;
	private $expTime 	= NULL;
    private $begTime 	= NULL;
	
	private $website 	= NULL;
	private $hits 		= NULL;
	private $position	= NULL;
	public $message 	= NULL;
        public $clearsearch 	= NULL;
        private $fileId         = NULL;

	public function convertToDB() {
                $dbobj = parent::convertToDB('partner');
		isset ( $this->website ) 		? ($dbobj ['partnerWebsite'] 	= $this->website) 			: '';
		isset ( $this->expTime ) 		? ($dbobj ['partnerExpTime']	= $this->expTime) 			: '';
                isset ( $this->begTime ) 		? ($dbobj ['partnerBeginTime']	= $this->begTime) 			: '';
		isset ( $this->address ) 		? ($dbobj ['partnerAddress']	= $this->address) 			: '';
		isset ( $this->hits ) 			? ($dbobj ['partnerHits'] 		= $this->hits) 				: '';
		isset ( $this->price ) 			? ($dbobj ['partnerPrice'] 		= $this->price) 			: '';
                isset ( $this->position ) 			? ($dbobj ['partnerPosition'] 		= $this->position) 			: '';
                if(isset ( $this->intro ) || isset($this->content) || isset ( $this->title )){
			$cleanContent = VSFTextCode::removeAccent($this->title)." ";
			$cleanContent .= VSFTextCode::removeAccent(strip_tags($this->getIntro()))." ";
			$cleanContent.= VSFTextCode::removeAccent(strip_tags($this->getContent()));
			$dbobj ['partnerClearSearch'] = $cleanContent;
		}
		return $dbobj;
	}

	function convertToObject($object) {
                parent::convertToObject($object,'partner');
		isset ( $object ['partnerWebsite'] ) 	? $this->setWebsite( $object ['partnerWebsite'] ) 		: '';
		isset ( $object ['partnerAddress'] ) 	? $this->setAddress ( $object ['partnerAddress'] ) 		: '';
		isset ( $object ['partnerPrice'] ) 	? $this->setPrice ( $object ['partnerPrice'] ) 			: '';
		isset ( $object ['partnerExpTime'] ) 	? $this->setExpTime ( $object ['partnerExpTime'] ) 		: '';
                isset ( $object ['partnerBeginTime'] ) 	? $this->setBeginTime ( $object ['partnerBeginTime'] ) 		: '';
		isset ( $object ['partnerFileId'] ) 	? $this->setFileId ( $object ['partnerFileId'] ) 		: '';
		isset ( $object ['partnerHits'] ) 	? $this->setHits ( $object ['partnerHits'] ) 			: '';
		isset ( $object ['partnerPosition'] ) 	? $this->setPosition ( $object ['partnerPosition'] ) 	: '';
                isset ( $object ['partnerClearSearch'] )? $this->setClearSearch ( $object ['partnerClearSearch'] ) 	: '';
                


	}
	
	/**
	 * @return unknown
	 */
	public function getPosition() {
		return $this->position;
	}

        public function getFileId() {
		return $this->fileId;
	}

        public function setFileId($position) {
		$this->fileId = $position;
	}

	/**
	 * @param unknown_type $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	public function getAddress() {
		return $this->address;
	}

	/**
	 * @param $address the $address to set
	 */
	public function setAddress($address) {
		$this->address = $address;
	}

	function __construct() {
		parent::__construct();
	}

	function __destruct() {
		unset ( $this );
	}

	/**
	 * @param $hits the $hits to set
	 */
	public function setHits($hits) {
		$this->hits = $hits;
	}

        public function setClearSearch($clear) {
		$this->clearsearch = $clear;
	}

	/**
	 * @return the $hits
	 */
	public function getHits() {
		return $this->hits;
	}

	/**
	 * @return the $expTime
	 */
	public function getExpTime($format = NULL) {
		if($format&& $this->expTime){
			$datetime= new VSFDateTime();
			return $datetime->getDate($this->expTime, $format);
		}
	}

        public function getBeginTime($format = NULL) {
		if($format&& $this->begTime){
			$datetime= new VSFDateTime();
			return $datetime->getDate($this->begTime, $format);
		}
	}

	/**
	 * @return the $price
	 */
	public function getPrice() {
		return $this->price;
	}



	/**
	 * @return the $website
	 */
	public function getWebsite() {
		
		return "http://".str_replace("http://","",$this->website);
	}

	/**
	 * @param $expTime the $expTime to set
	 */
	public function setExpTime($expTime) {
		$this->expTime = $expTime;
	}
        public function setBeginTime($begTime) {
		$this->begTime = $begTime;
	}

	/**
	 * @param $price the $price to set
	 */
	public function setPrice($price) {
		$this->price = $price;
	}

	/**
	 * @param $website the $website to set
	 */
	public function setWebsite($website) {
		$this->website = $website;
	}

        public function createNoImage(){
            return '<img src="utils/timthumb.php?src=images/noimage.jpg&amp;w=250&amp;h=150&amp;zc=0" alt="no-image">';
        }
        
        function showImagePartner( $width=100, $height=100,$type=0, $ishref=1, $noimage=0){
            global $vsFile, $bw,$vsStd;
           $RET ="";
            if($this->file && file_exists ( $this->file->getPathView (0) ))
                    if($ishref){
            $RET .= <<<EOF
                <a href="{$this->getUrl('partners')}" title="{$this->title}">
                                    {$this->createImageCache($this->file, $width, $height, $type, $noimage)}
                </a>
                {$enddiv}
EOF;
            }else{
                        return $this->createImageCache($this->file, $width, $height, $type, $noimage);
            }

                                    return $RET;
        }

}