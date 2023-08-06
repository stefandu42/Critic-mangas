<?php
    function loadClass($className) {
        require_once('models/' . $className . '.class.php');
    }
    spl_autoload_register('loadClass');

    session_start();
    date_default_timezone_set("Europe/Brussels");

	define('VIEWS_PATH','views/');
	if(!empty($_SESSION['connected'])){
	    $user = $_SESSION['user'];
        define('USERNAME',$user->getHtmlUsername());
        define('EMAIL',$user->getHtmlEmail());
        define('STATUS',$user->displayStatus());
        define('IMAGE',$user->getImage());
    }

    $db=Db::getInstance();

	include(VIEWS_PATH . 'header.php');

    if (empty($_GET['action'])) {
        $_GET['action'] = 'accueil';
    }

    $action = $_GET['action'];

switch ($_GET['action']) {
    case 'comment':
        require_once('controllers/CommentController.php');
        $controller = new CommentController($db);
        break;
    case 'admin':
        require_once('controllers/AdminController.php');
        $controller = new AdminController($db);
        break;
    case 'profil':
        require_once('controllers/ProfilController.php');
        $controller = new ProfilController($db);
        break;
    case 'exploration':  # action=genese
        require_once('controllers/ExplorationController.php');
        $controller = new ExplorationController($db);
        break;
    case 'logout':
        require_once ('controllers/LogoutController.php');
        $controller = new LogoutController();
        break;
    default:        # dans tous les autres cas l'action=accueil
        require_once('controllers/HomeController.php');
        $controller = new HomeController($db);
        break;
}


	$controller->run();

	include(VIEWS_PATH . 'footer.php');
?>