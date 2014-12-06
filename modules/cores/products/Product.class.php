<?php 

class Product extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->catId ) ? ($dbobj ['catId'] = $this->catId) : '';
		isset ( $this->label ) ? ($dbobj ['label'] = $this->label) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->intro ) ? ($dbobj ['intro'] = $this->intro) : '';
		isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
		isset ( $this->price ) ? ($dbobj ['price'] = $this->price) : '';
		isset ( $this->promotionPrice ) ? ($dbobj ['promotionPrice'] = $this->promotionPrice) : '';
		isset ( $this->shipping ) ? ($dbobj ['shipping'] = $this->shipping) : '';
		isset ( $this->manufacturer ) ? ($dbobj ['manufacturer'] = $this->manufacturer) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->dateStart ) ? ($dbobj ['dateStart'] = $this->dateStart) : '';
		isset ( $this->dateEnd ) ? ($dbobj ['dateEnd'] = $this->dateEnd) : '';
		isset ( $this->detail ) ? ($dbobj ['detail'] = $this->detail) : '';
		isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
		isset ( $this->removedText ) ? ($dbobj ['removedText'] = $this->removedText) : '';
		isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
		isset ( $this->index ) ? ($dbobj ['index'] = $this->index) : '';
		isset ( $this->code ) ? ($dbobj ['code'] = $this->code) : '';
		isset ( $this->vote ) ? ($dbobj ['vote'] = $this->vote) : '';
		isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
		isset ( $this->style ) ? ($dbobj ['style'] = $this->style) : '';
		isset ( $this->group ) ? ($dbobj ['group'] = $this->group) : '';
		isset ( $this->brand ) ? ($dbobj ['brand'] = $this->brand) : '';
		isset ( $this->hot ) ? ($dbobj ['hot'] = $this->hot) : '';
		isset ( $this->mTitle ) ? ($dbobj ['mTitle'] = $this->mTitle) : '';
		isset ( $this->mIntro ) ? ($dbobj ['mIntro'] = $this->mIntro) : '';
		isset ( $this->mKeyword ) ? ($dbobj ['mKeyword'] = $this->mKeyword) : '';
		isset ( $this->mUrl ) ? ($dbobj ['mUrl'] = $this->mUrl) : '';
		isset ( $this->info ) ? ($dbobj ['info'] = $this->info) : '';
		isset ( $this->typetea ) ? ($dbobj ['typetea'] = $this->typetea) : '';
		isset ( $this->warranty ) ? ($dbobj ['warranty'] = $this->warranty) : '';
		isset ( $this->video ) ? ($dbobj ['video'] = $this->video) : '';
		isset ( $this->avata ) ? ($dbobj ['avata'] = $this->avata) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['catId'] ) ? $this->setCatId ( $object ['catId'] ) : '';
		isset ( $object ['label'] ) ? $this->setLabel ( $object ['label'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['intro'] ) ? $this->setIntro ( $object ['intro'] ) : '';
		isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
		isset ( $object ['price'] ) ? $this->setPrice ( $object ['price'] ) : '';
		isset ( $object ['promotionPrice'] ) ? $this->setPromotionPrice ( $object ['promotionPrice'] ) : '';
		isset ( $object ['shipping'] ) ? $this->setShipping ( $object ['shipping'] ) : '';
		isset ( $object ['manufacturer'] ) ? $this->setManufacturer ( $object ['manufacturer'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['dateStart'] ) ? $this->setDateStart ( $object ['dateStart'] ) : '';
		isset ( $object ['dateEnd'] ) ? $this->setDateEnd ( $object ['dateEnd'] ) : '';
		isset ( $object ['detail'] ) ? $this->setDetail ( $object ['detail'] ) : '';
		isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
		isset ( $object ['removedText'] ) ? $this->setRemovedText ( $object ['removedText'] ) : '';
		isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
		isset ( $object ['index'] ) ? $this->setIndex ( $object ['index'] ) : '';
		isset ( $object ['code'] ) ? $this->setCode ( $object ['code'] ) : '';
		isset ( $object ['vote'] ) ? $this->setVote ( $object ['vote'] ) : '';
		isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
		isset ( $object ['style'] ) ? $this->setStyle ( $object ['style'] ) : '';
		isset ( $object ['group'] ) ? $this->setGroup ( $object ['group'] ) : '';
		isset ( $object ['brand'] ) ? $this->setBrand ( $object ['brand'] ) : '';
		isset ( $object ['hot'] ) ? $this->setHot ( $object ['hot'] ) : '';
		isset ( $object ['mTitle'] ) ? $this->setMTitle ( $object ['mTitle'] ) : '';
		isset ( $object ['mIntro'] ) ? $this->setMIntro ( $object ['mIntro'] ) : '';
		isset ( $object ['mKeyword'] ) ? $this->setMKeyword ( $object ['mKeyword'] ) : '';
		isset ( $object ['mUrl'] ) ? $this->setMUrl ( $object ['mUrl'] ) : '';
		isset ( $object ['info'] ) ? $this->setInfo ( $object ['info'] ) : '';
		isset ( $object ['typetea'] ) ? $this->setTypetea ( $object ['typetea'] ) : '';
		isset ( $object ['module'] ) ? $this->setModule ( $object ['module'] ) : '';
		isset ( $object ['warranty'] ) ? $this->setWarranty ( $object ['warranty'] ) : '';
		isset ( $object ['video'] ) ? $this->setVideo ( $object ['video'] ) : '';
		isset ( $object ['avata'] ) ? $this->setAvata( $object ['avata'] ) : '';

	}


	var 	$avata;

	

	public function getAvata() {
		return $this->avata;
	}

	/**
	 * @param field_type $avata
	 */
	public function setAvata($avata) {
		$this->avata = $avata;
	}


	
	/**
	 * @return the $module
	 */
	/**
	 * @return the $warranty
	 */
	/**
	 * @return the $video
	 */
	public function getVideo() {
		return $this->video;
	}

	/**
	 * @param field_type $video
	 */
	public function setVideo($video) {
		$this->video = $video;
	}

	public function getWarranty() {
		return $this->warranty;
	}

	/**
	 * @param field_type $warranty
	 */
	public function setWarranty($warranty) {
		$this->warranty = $warranty;
	}

	public function getModule() {
		return $this->module;
	}

	/**
	 * @param field_type $module
	 */
	public function setModule($module) {
		$this->module = $module;
	}

	function getId(){
		return $this->id;
	}



	function getCatId(){
		return $this->catId;
	}



	function getLabel(){
		return $this->label;
	}



	function getTitle(){
		return $this->title;
	}



	function getIntro(){
		return $this->intro;
	}



	function getContent(){
		return $this->content;
	}



	function getPrice(){
		return $this->price;
	}



	function getPromotionPrice(){
		return $this->promotionPrice;
	}



	function getShipping(){
		return $this->shipping;
	}



	function getManufacturer(){
		return $this->manufacturer;
	}



	function getPostDate(){
		return $this->postDate;
	}



	function getDateStart(){
		return $this->dateStart;
	}



	function getDateEnd(){
		return $this->dateEnd;
	}



	function getDetail(){
		return $this->detail;
	}



	function getStatus(){
		return $this->status;
	}



	function getRemovedText(){
		return $this->removedText;
	}



	function getImage(){
		return $this->image;
	}



	function getIndex(){
		return $this->index;
	}



	function getCode(){
		return $this->code;
	}



	function getVote(){
		return $this->vote;
	}



	function getType(){
		return $this->type;
	}



	function getStyle(){
		return $this->style;
	}



	function getGroup(){
		return $this->group;
	}



	function getBrand(){
		return $this->brand;
	}



	function getHot(){
		return $this->hot;
	}



	function getMTitle(){
		return $this->mTitle;
	}



	function getMIntro(){
		return $this->mIntro;
	}



	function getMKeyword(){
		return $this->mKeyword;
	}



	function getMUrl(){
		return $this->mUrl;
	}



	function getInfo(){
		return $this->info;
	}



	function setId($id){
		$this->id=$id;
	}




	function setCatId($catId){
		$this->catId=$catId;
	}




	function setLabel($label){
		$this->label=$label;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setIntro($intro){
		$this->intro=$intro;
	}




	function setContent($content){
		$this->content=$content;
	}




	function setPrice($price){
		$this->price=$price;
	}




	function setPromotionPrice($promotionPrice){
		$this->promotionPrice=$promotionPrice;
	}




	function setShipping($shipping){
		$this->shipping=$shipping;
	}




	function setManufacturer($manufacturer){
		$this->manufacturer=$manufacturer;
	}




	function setPostDate($postDate){
		$this->postDate=$postDate;
	}




	function setDateStart($dateStart){
		$this->dateStart=$dateStart;
	}




	function setDateEnd($dateEnd){
		$this->dateEnd=$dateEnd;
	}




	function setDetail($detail){
		$this->detail=$detail;
	}




	function setStatus($status){
		$this->status=$status;
	}




	function setRemovedText($removedText){
		$this->removedText=$removedText;
	}




	function setImage($image){
		$this->image=$image;
	}




	function setIndex($index){
		$this->index=$index;
	}




	function setCode($code){
		$this->code=$code;
	}




	function setVote($vote){
		$this->vote=$vote;
	}




	function setType($type){
		$this->type=$type;
	}




	function setStyle($style){
		$this->style=$style;
	}




	function setGroup($group){
		$this->group=$group;
	}




	function setBrand($brand){
		$this->brand=$brand;
	}




	function setHot($hot){
		$this->hot=$hot;
	}




	function setMTitle($mTitle){
		$this->mTitle=$mTitle;
	}




	function setMIntro($mIntro){
		$this->mIntro=$mIntro;
	}




	function setMKeyword($mKeyword){
		$this->mKeyword=$mKeyword;
	}




	function setMUrl($mUrl){
		$this->mUrl=$mUrl;
	}




	function setInfo($info){
		$this->info=$info;
	}



		var		$id;

		var		$catId;

		var		$label;

		var		$title;

		var		$intro;

		var		$content;

		var		$price;

		var		$promotionPrice;

		var		$shipping;

		var		$manufacturer;

		var		$postDate;

		var		$dateStart;

		var		$dateEnd;

		var		$detail;

		var		$status;

		var		$removedText;

		var		$image;

		var		$index;

		var		$code;

		var		$vote;

		var		$type;

		var		$style;

		var		$group;

		var		$brand;

		var		$hot;

		var		$mTitle;

		var		$mIntro;

		var		$mKeyword;

		var		$mUrl;

		var		$info;
		
		var		$typetea;

		var		$module;
		
		var 	$warranty;
		
		var		$video;
	/**
	*List fields in table
	**/
	var		$fields=array('id','catId','label','title','intro','content','price','promotionPrice','shipping','manufacturer','postDate','dateStart','dateEnd','detail','status','removedText','image','index','code','vote','type','style','group','brand','hot','mTitle','mIntro','mKeyword','mUrl','info',);
	/**
	 * @return the $typetea
	 */
	public function getTypetea() {
		return $this->typetea;
	}

	/**
	 * @param field_type $typetea
	 */
	public function setTypetea($typetea) {
		$this->typetea = $typetea;
	}

}
