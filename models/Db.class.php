<?php
class Db
{
    private static $instance = null;
    private $_connection;

    private function __construct()
    {
        try {
            $this->_connection = new PDO('mysql:host=localhost;port=3307;dbname=metakritikdb;charset=utf8','root','');
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

	# Singleton Pattern
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    /**
     * Select all the members
     * @return array of all the members
     */
    public function selectMembers(){
        $query = 'SELECT * FROM members';
        $ps = $this->_connection->prepare($query);
        $ps->execute();

        $tab = array();

        while($row = $ps->fetch()){
            $tab[] = new Member($row->id_member,$row->username,$row->email,$row->status,$row->disabled);
        }

        return $tab;
    }

    /**
     * Select the idea which has the ID of the parameter
     * @param $id_idea
     * @return Idea
     */
    public function selectIdea($id_idea){
        $query = 'SELECT * FROM ideas WHERE id_idea = :id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        $row = $ps->fetch();
        return new Idea($row->id_idea,$this->selectMember($row->id_member_author),$row->title,$row->text,$row->status,
            $row->timestamp_submitted,$row->timestamp_closed, $row->timestamp_accepted,$row->timestamp_refused,
            $this->getCommentsNumber($row->id_idea),$this->getVotesNumber($row->id_idea));
    }

    /**
     * Select all the ideas, or only ideas with a certain statuts
     * @param null $status
     * @return array of all ideas
     */
    public function selectIdeas($status=null){
        if($status==null){
            $query = 'SELECT * FROM ideas';
        }else{
            $query = 'SELECT * FROM ideas WHERE status = :status';
        }
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':status',$status);
        $ps->execute();

        return $this->tabReturnIdeas($ps);
    }

    private function tabReturnIdeas($ps){
        $tab = array();

        while($row = $ps->fetch()){
            $tab[] = new Idea($row->id_idea,$this->selectMember($row->id_member_author),$row->title,$row->text,$row->status,$row->timestamp_submitted,$row->timestamp_closed,$row->timestamp_accepted,$row->timestamp_refused,$this->getCommentsNumber($row->id_idea),$this->getVotesNumber($row->id_idea));
        }

        return $tab;
    }

    public function selectMember($id_member){
        $query = 'SELECT m.* FROM members m WHERE m.id_member=:id_member';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();

        $row = $ps->fetch();
        return new Member($row->id_member,$row->username,$row->email,$row->status,$row->disabled);
    }

    /**
     * Select all the ideas of the member which has the email of the parameter
     * @param $email
     * @return array of ideas to the member
     */
    public function selectIdeasOf($email){
        # évitons les subqueries pour le moment, utilisez plutot les jointures 
        $query = 'SELECT i.* FROM ideas i,members m WHERE m.id_member=i.id_member_author AND m.email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        return $this->tabReturnIdeas($ps);
    }

    /**
     * Select all the votes of the member which has the email of the parameter
     * @param $email
     * @return array of votes to the member
     */
    public function selectVotesOf($email){
        $query = 'SELECT v.* FROM votes v,members m WHERE m.id_member=v.id_member AND m.email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        $tab = array();
        while($row = $ps->fetch()){
            $tab[] = new Vote($row->id_member,$this->selectIdea($row->id_idea));
        }
        return $tab;
    }

    /**
     * Select all popular ideas
     * @param $number
     * @return array of popular ideas
     */
    public function selectIdeasLimit($filter,$number){

        if($filter=='popular'){
            if($number!='all'){
                $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.id_idea = votes.id_idea GROUP BY ideas.id_idea ORDER BY count(votes.id_idea) DESC LIMIT :number';
            }else{
                $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.id_idea = votes.id_idea GROUP BY ideas.id_idea ORDER BY count(votes.id_idea) DESC';
            }
        }else if($filter=='unpopular'){
            if($number!='all'){
                $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.id_idea = votes.id_idea GROUP BY ideas.id_idea ORDER BY count(votes.id_idea) ASC LIMIT :number';
            }else{
                $query = 'SELECT ideas.* FROM ideas LEFT JOIN votes ON ideas.id_idea = votes.id_idea GROUP BY ideas.id_idea ORDER BY count(votes.id_idea) ASC';
            }
        }else if($filter=='recentDate'){
            if($number!='all'){
                $query = 'SELECT ideas.* FROM ideas ORDER BY timestamp_submitted DESC LIMIT :number';
            }else{
                $query = 'SELECT ideas.* FROM ideas ORDER BY timestamp_submitted DESC';
            }
        }else if($filter=='oldDate'){
            if($number!='all'){
                $query = 'SELECT ideas.* FROM ideas ORDER BY timestamp_submitted ASC LIMIT :number';
            }else{
                $query = 'SELECT ideas.* FROM ideas ORDER BY timestamp_submitted ASC';
            }
        }

        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':number',$number,PDO::PARAM_INT);
        $ps->execute();

        return $this->tabReturnIdeas($ps);
    }

    /**
     * Select all the comments of the idea that has the ID of the parameter
     * @param $id_idea
     * @return array of ideas
     */
    public function selectComments($id_idea){
        $query = 'SELECT * FROM comments WHERE id_idea = :id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();

        $tab = array();

        while($row = $ps->fetch()){
            $tab[] = new Comment($row->id_comment,$row->id_idea,$this->selectMember($row->id_member),$row->timestamp_comment,$row->text,$row->deleted);
        }

        return $tab;
    }

    /**
     * Select all the comments of the member that has the email of the parameter
     * @param $email
     * @return array of comments to the member
     */
    public function selectCommentsOf($email){
        $query = 'SELECT c.* FROM comments c,members m WHERE m.id_member=c.id_member AND m.email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();

        $tab = array();

        while($row = $ps->fetch()){
            $tab[] = new Comment($row->id_comment,$this->selectIdea($row->id_idea),$this->selectMember($row->id_member),$row->timestamp_comment,$row->text,$row->deleted);
        }

        return $tab;
    }

    /**
     * Check if the member which has the ID of the parameter, has voted the idea which has the ID of the parameter
     * @param $id_member
     * @param $id_idea
     * @return true if the member has voted the idea, false otherwise
     */
    public function hasVoted($id_member,$id_idea){
        $query = 'SELECT * from votes WHERE id_idea=:id_idea AND id_member=:id_member';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':id_member',$id_member);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    /**
     * The member, which has the ID of the parameter, votes the idea, which has the ID of the parameter
     * @param $id_member
     * @param $id_idea
     */
    public function vote($id_member,$id_idea){
        $query = 'INSERT INTO votes (id_member,id_idea) values (:id_member,:id_idea)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }

    public function selectMemberFromEmail($email){
        $query = 'SELECT * from members WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        $row = $ps->fetch();
        return new Member($row->id_member,$row->username,$row->email,$row->status,$row->disabled);
    }

    /**
     * Submit an idea
     * @param $memberID
     * @param $text
     * @param $title
     */
    public function submitIdea($memberID,$text,$title){
        $query = 'INSERT INTO ideas (id_member_author,title,text) values (:id_member_author,:title,:text)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member_author',$memberID);
        $ps->bindValue(':title',$title);
        $ps->bindValue(':text',$text);
        $ps->execute();
    }

    /**
     * Submit a comment
     * @param $id_idea
     * @param $id_member
     * @param $text
     */
    public function submitComment($id_idea,$id_member,$text){
        $query = 'INSERT INTO comments (id_member,id_idea,text) values (:id_member,:id_idea,:text)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_member',$id_member);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->bindValue(':text',$text);
        $ps->execute();
    }

    /**
     * Get how many votes has the idea which has the ID of the parameter
     * @param $id_idea
     * @return int
     */
    public function getVotesNumber($id_idea){
        $query = 'SELECT count(id_idea) as "vote" FROM votes WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        return $ps->fetch()->vote;
    }

    /**
     * Delete the comment which has the ID of the parameter
     * @param $id_comment
     */
    public function deleteComment($id_comment){
        $query = "UPDATE comments SET deleted=1 WHERE id_comment=:id_comment";
        $ps = $this->_connection->prepare($query);
        $ps->bindValue('id_comment',$id_comment);
        $ps->execute();
    }

    /**
     * Get how many comments has the idea which has the ID of the parameter
     * @param $id_idea
     * @return int
     */
    public function getCommentsNumber($id_idea){
        $query = 'SELECT count(id_idea) as "numberComments" FROM comments WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        return $ps->fetch()->numberComments;
    }

    /**
     * Check if the idea which has the ID of the parameter exists
     * @param $id_idea
     * @return true if the idea exists, false otherwise
     */
    public function existIdea($id_idea){
        $query = 'SELECT * from ideas WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    /**
     * Check if the email which has the ID of the parameter exists
     * @param $email
     * @return true if the email exists, false otherwise
     */
    public function existEmail($email){
        $query = 'SELECT * from members WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    /**
     * Check if the username which has the ID of the parameter exists
     * @param $username
     * @return true if the username exists, false otherwise
     */
    public function existUsername($username){
        $query = 'SELECT * from members WHERE username=:username';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->execute();
        return ($ps->rowcount() != 0);
    }

    /**
     * Register a new member as a simple member
     * @param $email
     * @param $username
     * @param $passwordHashed
     */
    public function register($email,$username,$passwordHashed){
        $query = 'INSERT INTO members (username,email,password) values (:username,:email,:password)';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':password',$passwordHashed);
        $ps->execute();
    }

    /**
     * Check if the email matches with the password
     * @param $email
     * @param $password
     * @return true if match, false otherwise
     */
    public function login($email,$password) {
        $query = 'SELECT password from members WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
        if ($ps->rowcount() == 0)
            return false;
        $hash = $ps->fetch()->password;
        return password_verify($password, $hash);
    }
    public function disableMember($email){
        $query = 'UPDATE members SET disabled=1 WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
    }
    public function makeAdmin($email){
        $query = 'UPDATE members SET status=\'Admin\' WHERE email=:email';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':email',$email);
        $ps->execute();
    }

    /**
     * Set the acceptedTime at the currentime
     * @param $id_idea
     */
    public function setDateAccepted($id_idea){
        $query = 'UPDATE ideas SET timestamp_accepted=current_timestamp,status=\'Accepted\' WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }

    /**
     * Set the refusedTime at the currentime
     * @param $id_idea
     */
    public function setDateRefused($id_idea){
        $query = 'UPDATE ideas SET timestamp_refused=current_timestamp,status=\'Refused\'  WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }
    /**
     * Set the closedTime at the currentime
     * @param $id_idea
     */
    public function setDateClosed($id_idea){
        $query = 'UPDATE ideas SET timestamp_closed=current_timestamp,status=\'Closed\' WHERE id_idea=:id_idea';
        $ps = $this->_connection->prepare($query);
        $ps->bindValue(':id_idea',$id_idea);
        $ps->execute();
    }


}
