<?php


class Vote
{
    private $_id_member;
    private $_idea;
    public function __construct($id_member,$idea){
        $this->_id_member=$id_member;
        $this->_idea=$idea;
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
    public function getIdMember()
    {
        return $this->_id_member;
    }
}

?>