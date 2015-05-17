<?php
require_once(CORE_PATH.'contacts/contacts.php');

class contacts_controler extends VSControl_admin {

        function __construct($modelName){
            global $vsTemplate,$bw;//		$this->html=$vsTemplate->load_template("skin_contacts");
        parent::__construct($modelName,"skin_contacts","contact");
        $this->model->categoryName="contacts";
    }

function auto_run() {
        global $bw, $vsSettings;

        switch ($bw->input ['action']) {
            case $this->modelName.'_display_tab' :
                $this->displayObjTab ();
                break;
            case $this->modelName.'_search' :
                $this->displaySearch();
                break;
            case $this->modelName.'_visible_checked' :
                $this->checkShowAll(1);
                break;

            case $this->modelName.'_hide_checked' :
                $this->checkShowAll(0);
                break;

            case $this->modelName.'_display_list' :
                $this->getObjList ( $bw->input [2], $this->model->result ['message'] );
                break;

            case $this->modelName.'_read':
                $this->readContact ( $bw->input [2] );
                break;


            case $this->modelName.'_delete' :
                $this->deleteObj($bw->input[2]);
                break;

            case $this->modelName.'_reply':
                $this->replyContact($bw->input[2]);
                break;
            default :
                $this->loadDefault ();
                break;
        }
    }

    function replyContact($contactId){
        global $bw;

        if($bw->input['contacts']['isubmit']) return $this->replyProcess($bw->input[2]);

        $obj = $this->model->getObjectById($contactId);
        $this->output = $this->html->replyContactForm($obj);
    }

    function replyProcess($contactId, $contactType=0) {
        global $bw, $vsStd;

        $this->vsLang = VSFactory::getLangs();
        $vsStd->requireFile ( LIBS_PATH . "Email.class.php", true );
        $this->email = new Emailer ();

        $message = $bw->input['contacts']['content'];

        $recipient = $bw->input['contacts']['email'];
        $recipientAlias = $this->model->obj->getTitle();

        $from = VSFactory::getSettings ()->getSystemKey ( "email_admin", "mclchuang@gmail.com", "configs" );
        $fromName = VSFactory::getSettings()->getSystemKey('global_websitename', 'Weicovina', 'global', 1, 1);

        $subject = $this->vsLang->getWords("title_email_reply", "Hồi đáp ý kiến của khách hàng");

        $sendMailFlag =$this->sendEmail(compact('message', 'recipient', 'recipientAlias', 'from', 'fromName', 'subject'));

        if(empty($sendMailFlag)) {
            $this->model->obj = $this->model->getObjectById($contactId);
            $this->model->obj->setReply(1);
            $this->model->updateObjectById($this->model->obj);

            $option['message'] = VSFactory::getLangs()->getWords('contact_send_success', 'You have successfully send mail');
        }

        $this->getObjList($bw->input[2], $this->model->result['message']);
    }


    function readContact($contactId){
        global $bw;
        $contact = $this->model->getObjectById($contactId);
        $contactProfile	= unserialize($contact->getProfile());

        $bw->input[2] = 1;
        if($bw->input['pageIndex']) $bw->input[2] = $bw->input['pageIndex'];
        $this->output = $this->html->readContact($contact);
    }


    function getObjList($catId = '', $message = "") {
        global $bw;
        $option['message']=str_replace(array("'","\n"),array("\\'","\\n"), $message) ;
        $catId=intval($catId);
        if($_REQUEST['vdata']){
            $vdata=json_decode($_REQUEST['vdata'],true);
        }

        if($vdata['search']){//last query search
            $bw->input['search']=$vdata['search'];
            $option['table']=$this->displaySearch();
        }else{
            if($bw->input['pageIndex']) $bw->input[2]=$bw->input['pageIndex'];

            $size = VSFactory::getSettings()->getSystemKey("{$this->modelName}_paging_limit",20);
            $url = $bw->input [0]."/{$this->modelName}_display_tab/";
            $option = array_merge($option,
                $this->model->getPageList($url, 2, $size, 1, "vs_panel_{$this->modelName}")
                    );
            $bw->input['pageIndex'] = $bw->input[2];
            $option['table']=$this->html->getListItemTable ($this->model->getArrayObj (), $option );
        }
        return $this->output = $this->html->objListHtml ( $option );
    }



    function getHtml(){
        return $this->html;
    }



    function getOutput(){
        return $this->output;
    }



    function setHtml($html){
        $this->html=$html;
    }




    function setOutput($output){
        $this->output=$output;
    }




    /**
    *Skins for contact ...
    *@var skin_contacts
    **/
    var		$html;


    /**
    *String code return to browser
    **/
    var		$output;
}
