<?php

class Contact extends BasicObject {

    public function convertToDB(){
        isset ( $this->id ) ? ($dbobj ['id'] = $this->id) : '';
        isset ( $this->name ) ? ($dbobj ['name'] = $this->name) : '';
        isset ( $this->profile ) ? ($dbobj ['profile'] = $this->profile) : '';
        isset ( $this->phone ) ? ($dbobj ['phone'] = $this->phone) : '';
        isset ( $this->email ) ? ($dbobj ['email'] = $this->email) : '';
        isset ( $this->title ) ? ($dbobj ['title'] = $this->title) : '';
        isset ( $this->address ) ? ($dbobj ['address'] = $this->address) : '';
        isset ( $this->status ) ? ($dbobj ['status'] = $this->status) : '';
        isset ( $this->reply ) ? ($dbobj ['reply'] = $this->reply) : '';
        isset ( $this->type ) ? ($dbobj ['type'] = $this->type) : '';
        isset ( $this->content ) ? ($dbobj ['content'] = $this->content) : '';
        isset ( $this->postDate ) ? ($dbobj ['postDate'] = $this->postDate) : '';
        isset ( $this->company ) ? ($dbobj ['company'] = $this->company) : '';
        isset ( $this->image ) ? ($dbobj ['image'] = $this->image) : '';
        return $dbobj;

    }





    public	function convertToObject($object = array()){
            isset ( $object ['id'] ) ? $this->setId ( $object ['id'] ) : '';
        isset ( $object ['name'] ) ? $this->setName ( $object ['name'] ) : '';
        isset ( $object ['profile'] ) ? $this->setProfile ( $object ['profile'] ) : '';
        isset ( $object ['phone'] ) ? $this->setPhone ( $object ['phone'] ) : '';
        isset ( $object ['email'] ) ? $this->setEmail ( $object ['email'] ) : '';
        isset ( $object ['title'] ) ? $this->setTitle ( $object ['title'] ) : '';
        isset ( $object ['address'] ) ? $this->setAddress ( $object ['address'] ) : '';
        isset ( $object ['status'] ) ? $this->setStatus ( $object ['status'] ) : '';
        isset ( $object ['reply'] ) ? $this->setReply ( $object ['reply'] ) : '';
        isset ( $object ['type'] ) ? $this->setType ( $object ['type'] ) : '';
        isset ( $object ['content'] ) ? $this->setContent ( $object ['content'] ) : '';
        isset ( $object ['postDate'] ) ? $this->setPostDate ( $object ['postDate'] ) : '';
        isset ( $object ['image'] ) ? $this->setImage ( $object ['image'] ) : '';
        isset ( $object ['company'] ) ? $this->setCompany( $object ['company'] ) : '';

    }





    function getId(){
        return $this->id;
    }



    function getName(){
        return $this->name;
    }



    function getProfile(){
        return $this->profile;
    }



    function getPhone(){
        return $this->phone;
    }



    function getEmail(){
        return $this->email;
    }



    function getTitle(){
        return $this->title;
    }



    function getAddress(){
        return $this->address;
    }



    function getStatus(){
        return $this->status;
    }



    function getReply(){
        return $this->reply;
    }



    function getType(){
        return $this->type;
    }



    function getContent($nl2br = true) {
        $parser = VSFactory::getPostParser();
        $parser->pp_do_html = 1;
        $parser->pp_nl2br = 1;

        if (empty($nl2br)) {
            return $parser->post_db_parse($this->content);
        }

        return nl2br($parser->post_db_parse($this->content));
    }


    function getPostDate(){
        return $this->postDate;
    }



    function getImage(){
        return $this->image;
    }



    function setId($id){
        $this->id=$id;
    }




    function setName($name){
        $this->name=$name;
    }




    function setProfile($profile){
        $this->profile=$profile;
    }




    function setPhone($phone){
        $this->phone=$phone;
    }




    function setEmail($email){
        $this->email=$email;
    }




    function setTitle($title){
        $this->title=$title;
    }




    function setAddress($address){
        $this->address=$address;
    }




    function setStatus($status){
        $this->status=$status;
    }




    function setReply($reply){
        $this->reply=$reply;
    }




    function setType($type){
        $this->type=$type;
    }




    function setContent($content){
        $this->content=$content;
    }




    function setPostDate($postDate){
        $this->postDate=$postDate;
    }




    function setImage($image){
        $this->image=$image;
    }



    function geCompany(){
        return $this->company;
    }



    function setCompany($company){
        $this->company=$company;
    }



        var		$id;

        var		$name;

        var		$profile;

        var		$phone;

        var		$email;

        var		$title;

        var		$address;

        var		$status;

        var		$reply;

        var		$type;

        var		$content;

        var		$postDate;

        var		$image;

        var 	$company;
}
