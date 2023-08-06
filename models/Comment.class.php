<?php


class Comment{

    private $_id_comment;
    private $_id_idea;
    private $_author;
    private $_timestamp_comment;
    private $_text;
    private $_deleted;

    /**
     * Comment constructor.
     * @param $_id_comment
     * @param $_idea
     * @param $_author
     * @param $_timestamp_comment
     * @param $_text
     * @param $_deleted
     */
    public function __construct($_id_comment, $_idea, $author, $_timestamp_comment, $_text, $_deleted)
    {
        $this->_id_comment = $_id_comment;
        $this->_idea = $_idea;
        $this->_author = $author;
        $this->_timestamp_comment = $_timestamp_comment;
        $this->_text = $_text;
        $this->_deleted = $_deleted;
    }

    /**
     * @return mixed
     */
    public function getIdComment()
    {
        return $this->_id_comment;
    }

    /**
     * @return mixed
     */
    public function getIdea()
    {
        return $this->_idea;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->_author;
    }

    /**
     * @return mixed
     */
    public function getTimestampComment()
    {
        return $this->_timestamp_comment;
    }

    public function getTimestampDisplay(){
        return date("d/m/Y H\hi", strtotime($this->_timestamp_comment));
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->_text;
    }

    public function getHtmlText()
    {
        return ($this->isDeleted())? "Ce commentaire à été supprimé":htmlspecialchars($this->_text);
    }

    public function isAfterClosedDate($closedDate){
        if($closedDate!=null){
            return $this->getTimestampComment()>$closedDate;
        }
        return false;
    }

    /**
     * @return mixed
     */
    public function isDeleted()
    {
        return $this->_deleted;
    }




}

?>