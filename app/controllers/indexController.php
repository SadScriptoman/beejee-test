<?
class indexController extends Controller
{
	function __construct()
	{
		$this->model = new indexModel();
		$this->view = new View();
	}

	function indexAction()
	{	
		$data['items'] = $this->model->getData();

		if ($_GET){
			if($_GET['page']){
				$data['page'] = $_GET['page'];
			}
			if($_GET['search']){
				$data['search'] = $_GET['search'];
			}
		}else{
			$data['page'] = 1;
			$data['search'] = '';
		}

		
		$this->view->generate('indexView.php', 'baseView.php', $data);
	}
}