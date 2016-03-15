<?php
class VSFImage {
	public $desiredWidth = 0;
	public $desiredHeight = 0;

	public $thumbnailWidth = 0;
	public $thumbnailHeight = 0;

	public $stretchImage = true;

	public $imageSrc = "";
	public $imageDst = "";

	public $result = array();

	function __construct($desiredWidth=0, $desiredHeight=0) {
		$this->desiredHeight = $desiredHeight;
		$this->desiredWidth = $desiredWidth;
	}

	/**
	 * Creating image function
	 * @return unknown_type
	 */
	function createImage() {
		global $vsLang;

		$this->result['status'] = true;
		$this->result['message'] = $vsLang->getWords('global_create_image_success', "Creating image successfully!");

		$imageDim = $this->getImageDimension($this->imageSrc);

		// If source dimension lower than desired dimension, just copy it
		if($imageDim['width'] <= $this->desiredWidth && $imageDim['height'] <= $this->desiredHeight) {
			if(!copy($this->imageSrc, $this->imageDst)) {
				$this->result['status'] = false;
				$this->result['message'] = $vsLang->getWords('global_img_copy_fail', "There was an error while copying image!");
			}
			return;
		}
		// If the image needed to scale
		$scaledDim = $this->getScaledSize($this->imageSrc, $imageDim);

		$function_img = array(
           						'image/gif' => array('imagecreatefromgif','imagegif'),
					            'image/jpeg' => array('imagecreatefromjpeg','imagejpeg'),
					            'image/png' => array('imagecreatefrompng','imagepng')
		);

		if(!$function_img[$imageDim['mime']]) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_no_support', "The system does not support this image type!");
			return;
		}
		 
		// Check if the function for creating image exist
		if(!function_exists($function_img[$imageDim['mime']][0])){
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_no_create_function', "There is no function ").$function_img[$scaledDim['mime']][0];
			return;
		}

		if(!function_exists($function_img[$imageDim['mime']][1])) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_no_create_function', "There is no function ").$function_img[$scaledDim['mime']][1];
			return;
		}

		if(!$image_tmp = call_user_func($function_img[$imageDim['mime']][0],$this->imageSrc)) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_call_function_error', "There is an error while calling function ").$function_img[$img_size['mine']][0];
			return;
		}
		 
		if(!$image_dst = imagecreatetruecolor($scaledDim['width'],$scaledDim['height'])) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_error_create_truecolor', "There is an error while creating true color image");
			return;
		}

		if(!imagecopyresized($image_dst, $image_tmp,0,0,0,0,$scaledDim['width'],$scaledDim['height'],$imageDim['width'],$imageDim['height'])) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_error_copy_resize', "There is an error while copy and resize image!");
			return;
		}

		if(!call_user_func_array($function_img[$imageDim['mime']][1],array($image_dst,$this->imageDst,100))) {
			$this->result['status'] = false;
			$this->result['message'] = $vsLang->getWords('global_img_call_function_error', "There is an error while calling function ").$function_img[$img_size['mine']][1];
			return;
		}

		chmod( $this->imageDst, 0644 );
		imagedestroy( $image_dst );
		imagedestroy( $image_tmp );
		return true;
	}

	function getScaledSize($fileName, $imageDim=array()) {

		if($imageDim) {
			$imageDim = $this->getImageDimension($fileName);
		}

		if($this->desiredWidth==0 && $this->desiredHeight==0) {
			// not scale return origin dimension
			return $imageDim;
		}

		// Only scale by Height
		if($this->desiredWidth==0) {
			return $this->scaleByHeight($imageDim);
		}

		// Only scale by Width
		if($this->desiredHeight==0) {
			return $this->scaleByWidth($imageDim);
		}

		// Scale by both width and height
		return $this->scaleByWidthHeight($imageDim);
	}

	function scaleByWidthHeight($imageDim = array()) {
		if($imageDim['width'] <= $this->desiredWidth
		&& $imageDim['height'] <= $this->desiredWidth
		&& !$this->stretchImage )
		return $imageDim;
			
		$percentWidth = $this->desiredWidth/$imageDim['width'];
		$percentHeight = $this->desiredHeight/$imageDim['height'];

		if($percentWidth < $percentHeight) {
			$scaledDim['width'] = $this->desiredWidth;
			$scaledDim['height'] = round($percentWidth*$imageDim['height']);
		}
		elseif($percentWidth > $percentHeight) {
			$scaledDim['width'] = round($percentHeight*$imageDim['width']);
			$scaledDim['height'] = $this->desiredHeight;
		}
		else {
			$scaledDim['width'] = $this->desiredWidth;
			$scaledDim['height'] = $this->desiredHeight;
		}

		$scaledDim['mime'] = $imageDim['mime'];

		return $scaledDim;
	}

	function scaleByWidth($imageDim=array()) {
		if($imageDim['width'] <= $this->desiredWidth && !$this->stretchImage) {
			return $imageDim;
		}

		$resizePercent = $imageDim['width']/$this->desiredWidth;

		$scaledDim['width'] = $this->desiredWidth;
		$scaledDim['height']= round($resizePercent*$imageDim['height']);
		$scaledDim['mime'] 	= $imageDim['mime'];

		return $scaledDim;
	}

	function scaleByHeight($imageDim=array()) {
		if($imageDim['height'] <= $this->desiredHeight && !$this->stretchImage) {
			return $imageDim;
		}

		$resizePercent = $imageDim['height']/$this->desiredHeight;

		$scaledDim['height']= $this->desiredHeight;
		$scaledDim['width'] = round($resizePercent*$imageDim['width']);
		$scaledDim['mime'] 	= $imageDim['mime'];

		return $scaledDim;
	}

	function getImageDimension($fileName) {
		$imageDim = getimagesize($fileName);

		$returnDim = array(	'width'		=> $imageDim[0],
							'height'	=> $imageDim[1],
							'mime'		=> $imageDim['mime']
		);

		return $returnDim;
	}
}