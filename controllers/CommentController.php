<?php


class CommentController{

    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        if(empty($_SESSION['connected'])){
            header("Location: index.php?action=accueil");
            die();
        }

        if(empty($_GET['id_idea']) || !$this->_db->existIdea($_GET['id_idea'])){
            header("Location: index.php?action=exploration");
            die();
        }
        $idea = $this->_db->selectIdea($_GET['id_idea']);

        ################################
        #          Answer Form         #
        ################################

        $notificationComment = '';
        if(!empty($_POST['form_answer'])){
            $notificationComment = $this->answer();
        }

        ################################
        #             Vote             #
        ################################

        $notification= '';
        if(!empty($_POST['button_vote'])){
            $notification = $this->vote($idea);
        }

        ################################
        #         Delete Comment       #
        ################################

        if(!empty($_POST['delete_comment'])){
            $notification = 'Votre commentaire a bien été supprimé !';
            $this->_db->deleteComment($_POST['delete_comment']);
        }



        $comments = $this->_db->selectComments($idea->getIdIdea());
        include(VIEWS_PATH.'comment.php');
    }

    private function answer(){
        if(empty($_POST['text'])){
            return "Veuillez remplir du texte !";
        }else{
            $this->_db->submitComment($_GET['id_idea'],$_SESSION['user']->getId(),$_POST['text']);
            return 'Votre réponse à été transmise ! 😄';
        }
    }

    private function vote($idea){
        $member = $_SESSION['user'];
        if($idea->isClosed()){
            return "Vous ne pouvez pas voter pour un sujet fermé !";
        }else if($this->_db->hasVoted($member->getId(),$_GET['id_idea'])){
            return "Vous avez déjà voter pour le sujet !";
        }else if($idea->ownIdea($member->getId())){
            return "Vous ne pouvez pas voter pour votre propre sujet !";
        }else{
            $this->_db->vote($member->getId(),$_GET['id_idea']);
        }
    }

    public function colorNotification($notification){
        if ($notification == 'Votre réponse à été transmise ! 😄') return "alert-success";
        else if($notification == 'Veuillez remplir du texte !') return "alert-danger";
        else if($notification == "Ce sujet n'existe pas !") return "alert-warning";
        else if($notification == "Vous ne pouvez pas voter pour un sujet fermé !") return "alert-danger";
        else if($notification == "Vous avez déjà voter pour le sujet !") return "alert-danger";
        else if($notification == "Vous ne pouvez pas voter pour votre propre sujet !") return "alert-danger";
        else if($notification == "Votre commentaire a bien été supprimé !") return "alert-warning";
    }

}