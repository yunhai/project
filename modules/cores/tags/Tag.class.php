<?php 

class Tag extends BasicObject {

	public	function convertToDB(){
			isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
		isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
		isset ( $this->trimText ) ? ($dbobj ['trimText'] = $this->trimText) : '';
		isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
		isset ( $this->count ) ? ($dbobj ['count'] = $this->count) : '';
		return $dbobj;

	}





	public	function convertToObject($object = array()){
			isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
		isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
		isset ( $object ['trimText'] ) ? $this->setTrimText ( $object ['trimText'] ) : '';
		isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
		isset ( $object ['count'] ) ? $this->setCount ( $object ['count'] ) : '';

	}





	function getId(){
		return $this->id;
	}



	function getTitle(){
		return $this->title;
	}



	function getTrimText(){
		return $this->trimText;
	}



	function getPostDate(){
		return $this->postDate;
	}



	function getCount(){
		return $this->count;
	}



	function setId($id){
		$this->id=$id;
	}




	function setTitle($title){
		$this->title=$title;
	}




	function setTrimText($trimText){
		$this->trimText=$trimText;
	}




	function setPostDate($postDate){
		$this->postDate=$postDate;
	}




	function setCount($count){
		$this->count=$count;
	}



		var		$id;

		var		$title;

		var		$trimText;

		var		$postDate;

		var		$count;
}
