<?php


class AdminController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){

        if(empty($_SESSION['connected'])){
            header('Location: index.php');
            die();
        }
        if(STATUS!='Admin'){
            header('Location: index.php?action=profil');
            die();
        }


        $button='';
        $displayTable =false;
        if(!empty($_POST)) {
            $displayTable = true;
            if (!empty($_POST['disable'])) {
                $this->_db->disableMember($_POST['disable']);
                $button = 'members';
            } else if (!empty($_POST['update'])) {
                $this->_db->makeAdmin($_POST['update']);
                $button = 'members';
            } else if (!empty($_POST['members'])) {
                $button = 'members';
            } else if (!empty($_POST['accept'])) {
                $this->_db->setDateAccepted($_POST['accept']);
                $button = 'ideas';
            } else if (!empty($_POST['refuse'])) {
                $this->_db->setDateRefused($_POST['refuse']);
                $button = 'ideas';
            } else if (!empty($_POST['close'])) {
                $this->_db->setDateClosed($_POST['close']);
                $button = 'ideas';

            } else {
                $button = 'ideas';
            }
        }



        $tabMembers = $this->_db->selectMembers();
        $tabIdeas = $this->_db->selectIdeas();
        include(VIEWS_PATH.'admin.php');
    }


}