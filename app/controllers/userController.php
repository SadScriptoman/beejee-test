<?
class userController extends Controller
{
	function __construct($application)
	{
		$this->model = new userModel($application);
		parent::__construct($application);
	}

	function indexAction()
	{	

		$data = Array();

		if($_SERVER['REQUEST_METHOD'] === 'POST'){ //авторизация
			if(isset($_POST['login']) && isset($_POST['password'])){

				if (!$this->model->authorize($_POST['login'], $_POST['password'])){
					$data['errorMessage'] = 'Неверный логин или пароль!';
				}else{
					header('Location: index');
				}

			}
		}elseif(isset($_GET['logout'])){
			$this->model->logout();
			header('Location: index');
		}

		$this->view->generate('userView.php', 'baseView.php', $data);
	}
}