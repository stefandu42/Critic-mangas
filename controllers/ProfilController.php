<?php


class ProfilController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        if(empty($_SESSION['connected'])){
            header('Location: index.php');
            die();
        }

        $button='';
        $displayTable =false;
        if(!empty($_POST)) {
            $displayTable = true;
            if (!empty($_POST['ideas']))
                $button = 'ideas';
            else if (!empty($_POST['comments']))
                $button = 'comments';
            else if (!empty($_POST['delete'])) {
                $this->_db->deleteComment($_POST['delete']);
                $button = 'comments';
            } else
                $button = 'votes';
        }

        $tabIdeas = $this->_db->selectIdeasOf(EMAIL);
        $tabComments = $this->_db->selectCommentsOf(EMAIL);
        $tabVotes = $this->_db->selectVotesOf(EMAIL);
        include(VIEWS_PATH.'profil.php');
    }


}