<?php
/*
 +-----------------------------------------------------------------------------
 |   VS FRAMEWORK 3.0.0
 |	Author: BabyWolf
 |	Homepage: http://vietsol.net
 |	If you use this code, please don't delete these comment line!
 |	Start Date: 21/09/2004
 |	Finish Date: 22/09/2004
 |	Version 2.0.0 Start Date: 07/02/2007
 |	Version 3.0.0 Start Date: 03/29/2009
 |	Modify Date: 10/10/2009
 +-----------------------------------------------------------------------------
 */
if (! defined ( 'IN_VSF' )) {
    print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
    exit ();
}
global $vsStd;

class home_public extends VSControl{
    /**
     *
     * Enter description here ...
     * @var skin_home
     */
    private $html = "";

    public $partner = null;
    public function __construct(){
        global $vsTemplate, $vsStd;
        $this->html =  $vsTemplate->load_template('skin_home' );

    }
    function auto_run() {
        global $bw;

        switch ($bw->input[1]){
            case 'order' :
                $this->getOrder ();
                break;
            default:

                $this->loadDefault();
        }

    }


    function loadDefault(){
        global $vsStd, $vsPrint,$vsCom,$bw,$DB;

        $vsPrint->mainTitle = $vsPrint->pageTitle = VSFactory::getLangs()->getWords('pageTitle',' HỆ THỐNG BÁN LẺ DTĐĐ VÀ MÁY TÍNH BẢNG CHÍNH HÃNG');
        if($text=VSFactory::getSettings()->getSystemKey('home_title','','seos')){
            $vsCom->SEO->basicObject->setTitle($text);
            unset($text);
        }
        if($text=VSFactory::getSettings()->getSystemKey('home_description','','seos')){
            $vsCom->SEO->basicObject->setIntro($text);
            unset($text);
        }
        if($text=VSFactory::getSettings()->getSystemKey('home_keywords','','seos')){
            $vsCom->SEO->basicObject->setKeyword($text);
            unset($text);
        }


        $option['services']=Object::getObjModule('pages', 'services', '=2', '3', '');
        $option['projects']=Object::getObjModule('pages', 'projects', '=2', '', '');
        $option['count']=count($option['projects']);


        return $this->output = $this->html->loadDefault($option);
    }

    public function getHtml() {
        return $this->html;
    }

    public function getOutput() {
        return $this->output;
    }

    public function setHtml($html) {
        $this->html = $html;
    }

    public function setOutput($output) {
        $this->output = $output;
    }

}
?>