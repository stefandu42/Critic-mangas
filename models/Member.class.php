<?php


class Member{
    private $_id;
    private $_username;
    private $_email;
    private $_status;
    private $_disabled;

    public function __construct($id,$username,$email,$status,$disabled){
        $this->_id = $id;
        $this->_username = $username;
        $this->_email = $email;
        $this->_status = $status;
        $this->_disabled = $disabled;
    }

    /**
     * @return mixed
     */
    public function isDisabled()
    {
        return ($this->_disabled)? true : false;
    }

    /**
     * @return mixed
     */
    public function isMember()
    {
        if($this->_status=='Member')
            return true;
        else
            return false;
    }

    /**
     * @return mixed
     */
    public function getHtmlEmail()
    {
        return htmlspecialchars($this->_email);
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }
    public function displayStatus()
    {
        if($this->_status=='Member')
            return 'Membre';
        return 'Admin';
    }

    public function getColorStatus(){
        return($this->_status== 'Admin')? 'text-warning':'text-white';
    }

    public function getHtmlStatus(){
        return htmlspecialchars($this->_status);
    }

    /**
     * @return mixed
     */
    public function getHtmlUsername()
    {
        return htmlspecialchars($this->_username);
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    public function getImage(){
        return ($this->_status=='Admin')?VIEWS_PATH.'images/admin.jpg':VIEWS_PATH.'images/member.png';
    }





}
?>