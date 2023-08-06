<?php


class Idea{

    private $_id_idea;
    private $_author;
    private $_title;
    private $_text;
    private $_status;
    private $_timestamp_submitted;
    private $_timestamp_closed;
    private $_timestamp_accepted;
    private $_timestamp_refused;
    private $_numberOfComments;
    private $_numberOfVotes;


    # The 3 last timestamp are setted to null value because they aren't mandatory, they can be setted later.
    public function __construct($id_idea,$author,$title,$text,$status,$timestamp_submitted,
                                $timestamp_closed=null,$timestamp_accepted=null,$timestamp_refused=null,$numberOfComments,$numberOfVotes){
        $this->_id_idea = $id_idea;
        $this->_author = $author;
        $this->_title = $title;
        $this->_text = $text;
        $this->_status = $status;
        $this->_timestamp_submitted = $timestamp_submitted;
        $this->_timestamp_closed = $timestamp_closed;
        $this->_timestamp_accepted = $timestamp_accepted;
        $this->_timestamp_refused = $timestamp_refused;
        $this->_numberOfComments = $numberOfComments;
        $this->_numberOfVotes = $numberOfVotes;
    }

    public function isClosed(){
        return ($this->_status=='Closed');
    }

    public function isSubmitted(){
        return ($this->_status=='Submitted');
    }

    public function isAccepted(){
        return ($this->_status=='Accepted');
    }

    public function isRefused(){
        return ($this->_status=='Refused');
    }

    public function ownIdea($id_author){
        return $this->_author->getId() == $id_author;
    }

    /**
     * @return mixed
     */
    public function getNumberOfComments()
    {
        return $this->_numberOfComments;
    }

    /**
     * @return mixed
     */
    public function getNumberOfVotes()
    {
        return $this->_numberOfVotes;
    }

    /**
     * @return mixed
     */
    public function color()
    {
        $color='';
        if($this->_status=='Accepted')
            $color='green fw-bold';
        else if ($this->_status=='Refused')
            $color='red fw-bold';
        else if ($this->_status=='Closed')
            $color='purple fw-bold';
        else
            $color='grey fw-bold';
        return $color;
    }

    /**
     * @return mixed
     */
    public function statusDisplay()
    {
        $status='';
        if($this->_status=='Accepted')
            $status='Validé';
        else if ($this->_status=='Refused')
            $status='Refusé';
        else if ($this->_status=='Closed')
            $status='Fermé';
        else
            $status='Soumis';
        return $status;
    }

    /**
     * @return mixed
     */
    public function dateClosedDisplay()
    {
        if(is_null($this->_timestamp_closed))
            return '/';
        else
            return date("d/m/Y H\hi", strtotime($this->_timestamp_closed));
    }

    public function dateSubmittedDisplay(){
        return date("d/m/Y H\hi", strtotime($this->_timestamp_submitted));
    }


    /**
     * @return mixed
     */
    public function getMaxDateBetweenRefusedAndAccepted()
    {
        if(is_null($this->_timestamp_accepted) && is_null($this->_timestamp_refused))
            return '/';

        else if(!is_null($this->_timestamp_accepted) && is_null($this->_timestamp_refused))
            return date("d/m/Y H\hi", strtotime($this->_timestamp_accepted));

        else if(is_null($this->_timestamp_accepted) && !is_null($this->_timestamp_refused))
            return date("d/m/Y H\hi", strtotime($this->_timestamp_refused));

        else if(strtotime($this->_timestamp_accepted) > strtotime($this->_timestamp_refused))
            return date("d/m/Y H\hi", strtotime($this->_timestamp_accepted));

        else
            return date("d/m/Y H\hi", strtotime($this->_timestamp_refused));
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @return mixed
     */
    public function getIdIdea()
    {
        return $this->_id_idea;
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
    public function getText()
    {
        return $this->_text;
    }

    public function getTextPreview(){
        if(strlen($this->_text)<=60)return $this->getHtmlText();
        return htmlspecialchars(substr($this->getHtmlText(),0,60).' ... ');
    }

    public function getHtmlText()
    {
        return htmlspecialchars($this->_text);
    }

    /**
     * @return mixed
     */
    public function getTimestampAccepted()
    {
        return $this->_timestamp_accepted;
    }

    /**
     * @return mixed
     */
    public function getTimestampSubmitted()
    {
        return $this->_timestamp_submitted;
    }

    /**
     * @return mixed
     */
    public function getTimestampClosed()
    {
        return $this->_timestamp_closed;
    }

    /**
     * @return mixed
     */
    public function getTimestampRefused()
    {
        return $this->_timestamp_refused;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }


    public function getHtmlTitle()
    {
        return htmlspecialchars($this->_title);
    }
}

?>