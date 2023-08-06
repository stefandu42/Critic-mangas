<?php

class ExplorationController{
    private $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function run(){
        if(empty($_SESSION['connected'])){
            header("Location: index.php");
            die();
        }

        $notification = '';
        $notificationVote = '';

        ################################
        #             Comment          #
        ################################

        #Post a comment
        if(!empty($_POST['form_comment'])){
            $notification = $this->commentForm();
        }

        ################################
        #             Vote             #
        ################################


        #Vote function when clicking on the button
        if(!empty($_POST['button_vote'])){
            $notification = $this->vote();
        }

        ################################
        #             Filter           #
        ################################

        #Limit dropdown selection

        $popularSelected = '';
        $unpopularSelected = '';
        $recentDate = '';
        $oldDate = '';

        #Keep the choice
        if(empty($_POST['sort']))$popularSelected = 'selected'; #Default
        else{
            if($_POST['sort']=='unpopular')
                $unpopularSelected = 'selected';
            if($_POST['sort']=='recentDate')
                $recentDate = 'selected';
            if($_POST['sort']=='oldDate')
                $oldDate = 'selected';
        }


        if(!empty($_POST['status_form']) && $_POST['status_form'] != 'all'){
            # Get the filtered table
            $tabIdea = $this->_db->selectIdeas($_POST['status_form']);
        }else if(!empty($_POST['limit'])){
            # Get the limit and sorted table
            $tabIdea = $this->_db->selectIdeasLimit($_POST['sort'],$_POST['limit']);
        }else{
            # Get the basic table
            $tabIdea =  $this->_db->selectIdeasLimit('popular',3);
        }

        include(VIEWS_PATH.'exploration.php');
    }

    private function vote(){
        $member = $_SESSION['user'];
        $idea = $this->_db->selectIdea($_POST['button_vote']);
        if($idea->isClosed()){
            return "Vous ne pouvez pas voter pour un sujet fermé !";
        }else if($this->_db->hasVoted($member->getId(),$idea->getIdIdea())){
            return "Vous avez déjà voter pour le sujet !";
        }else if($idea->ownIdea($member->getId())){
            return "Vous ne pouvez pas voter pour votre propre sujet !";
        }else{
            $this->_db->vote($member->getId(),$idea->getIdIdea());
        }
    }

    private function commentForm(){
        if(empty($_POST['text']) && empty($_POST['title'])){
            return "Veuillez écrire une idée et un titre";
        }else if(empty($_POST['text'])){
            return "Veuillez écrire une idée";
        }else if (empty($_POST['title'])){
            return "Veuillez specifier un titre";
        }else if(strlen($_POST['title'])>60){
            return "Le titre est trop long !";
        }
        else{
            $this->_db->submitIdea($_SESSION['user']->getId(),$_POST['text'],$_POST['title']);
            return "Votre idée à été transmise ! 😄";
        }
    }

    public function colorNotification($notification){
        if ($notification == 'Votre idée à été transmise ! 😄') return "alert-success";
        else return "alert-danger";
    }


}