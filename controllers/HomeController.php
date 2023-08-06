<?php 
class HomeController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){
	    if(!empty($_SESSION['connected'])){
            header("Location: index.php?action=exploration");
	        die();
        }


		$notification = '';

		################################
        #           Register           #
        ################################

        $username = '';
        $email = '';

        if(!empty($_POST['registerForm'])){
            if($notification = $this->handleRegister()){
                #Keep the information in case of error
                $email = $_POST['email'];
                $username = $_POST['username'];
            }else{
                $passwordHashed = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $this->_db->register($_POST['email'],$_POST['username'],$passwordHashed);
                $_SESSION['connected'] = true;
                $_SESSION['user'] = $this->_db->selectMemberFromEmail($_POST['email']);
                header("Location: index.php?action=exploration");
                die();
            }
        }


        ################################
        #             Login            #
        ################################

        $emailLogin = '';

		if(!empty($_POST['loginForm'])){
            if($notification = $this->handleLogin()){
                #Keep the information in case of error
                $emailLogin = $_POST['email'];
            }else{
                $_SESSION['connected'] = true;
                $_SESSION['user'] = $this->_db->selectMemberFromEmail($_POST['email']);
                header("Location: index.php?action=exploration");
                die();
            }
        }

		include(VIEWS_PATH.'home.php');
	}

	private function handleLogin(){
	    $errorsTable = array('Veuillez introduire une adresse email et un mot de passe',
            'Veuillez introduire une adresse email','Veuillez introduire un mot de passe',
            'Adresse email trop longue','Adresse email incorrecte ou vous n\'êtes pas inscrit !',
            'Mot de passe incorrect !','Votre compte est désactivé');

        if(empty($_POST['email']) && empty($_POST['password']))return $errorsTable[0];
        else{
            if(empty($_POST['email']))return $errorsTable[1];
            if(empty($_POST['password'])) return $errorsTable[2];
        }
        if(strlen($_POST['email'] > 60)){
            $longueur = strlen($_POST['email']);
            return $errorsTable[3]." | Longueur : $longueur";
        }
        if(!$this->_db->existEmail($_POST['email'])) return $errorsTable[4];
        if(!$this->_db->login($_POST['email'],$_POST['password'])) return $errorsTable[5];

        $user = $this->_db->selectMemberFromEmail($_POST['email']);
        if($user->isDisabled())return $errorsTable[6];

        return false;
    }

    private function handleRegister(){

	    $errorsTable = array('Veuillez remplir le formulaire','Veuillez introduire une adresse email et un nom d\'utilisateur',
            'Veuillez introduire une adresse email et un mot de passe','Veuillez introduire un nom d\'utilisateur et un mot de passe',
            'Veuillez introduire un nom d\'utilisateur','Veuillez introduire un mot de passe','Veuillez introduire une adresse email',
            'Adresse email incorrecte !','Adresse email trop longue','Pseudonyme trop long',' L\'adresse email est déjà utilisée !',
            'Le nom d\'utilisateur est déjà utilisé !');

        if(empty($_POST['email']) && empty($_POST['username']) && empty($_POST['password']))
            return $errorsTable[0];
        else if(empty($_POST['email']) && empty($_POST['username']))
            return $errorsTable[1];
        else if(empty($_POST['email']) && empty(($_POST['password'])))
            return $errorsTable[2];
        else if(empty($_POST['username']) && empty($_POST['password']))
            return $errorsTable[3];
        else if(empty($_POST['username']))
            return $errorsTable[4];
        else if(empty($_POST['password']))
            return $errorsTable[5];
        else if(empty($_POST['email']))
            return $errorsTable[6];

        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) return $errorsTable[7];

        if(strlen($_POST['email']) > 60){
            $longueur = strlen($_POST['email']);
            return $errorsTable[8]." | Longueur : $longueur";
        }

        if(strlen($_POST['username'])>20){
            $longueur = strlen($_POST['username']);
            return $errorsTable[9]." | Longueur : $longueur";
        }
        if($this->_db->existEmail($_POST['email']))return $errorsTable[10];
        if($this->_db->existUsername($_POST['username']))return $errorsTable[11];

	    return false;
    }

}
?>
