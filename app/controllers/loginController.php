<?
class loginController extends Controller
{
	function __construct()
	{
		$this->model = new loginModel();
		$this->view = new View();
	}

	function indexAction()
	{	
		$this->view->generate('loginView.php', 'baseView.php');
	}
}