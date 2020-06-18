<?
class indexController extends Controller
{
	function __construct($application)
	{	
		$this->model = new indexModel($application);
		parent::__construct($application);
	}

	function indexAction()
	{	
		
		$data = Array();
		$data['limit'] = 3;
		$data['page'] = 1;
		$data['search'] = '';

		if(isset($_GET['page'])){
			$data['page'] = (int) $_GET['page']; //меняем страницу в data, если задана
		}

		if($_SERVER['REQUEST_METHOD'] === 'POST'){ //поиск и добавление
			if(isset($_POST['search'])){
				if($_POST['search']){
					setcookie('search', $_POST['search'], time()+3600); //сохраняем поиск
				}else{
					setcookie('search', NULL, time()-3600, '/'); //удаляем поиск
				}
				header('Location: index?page='.$data['page']);
			}
			
			if(isset($_POST['action'])){
				switch($_POST['action']){
					case 'add/edit'://обработка добавления/редактирования эл-та
						if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['text']) && isset($_POST['id'])){
							$item = [
								'name' => $_POST['name'],
								'email' => $_POST['email'],
								'text' => $_POST['text']
							];
							if($_POST['id'] > 0){
								$item['id'] = (int) $_POST['id'];
								$this->model->editItem($item);
								header('Location: index?page='.$data['page']);
							}else{
								$this->model->addItem($item);
								header('Location: index?page=1');
							}
						}
					break;
					case 'delete'://обработка удаления эл-та
						if(isset($_POST['id'])){
							if($_POST['id'] > 0){
								$id = (int) $_POST['id'];
								$this->model->deleteItem($id);
								header('Location: index?page='.$data['page']);
							}
						}
					break;
					case 'switchStates'://обработка смены отметки 
						if(isset($_POST['id'])){
							if($_POST['id'] > 0){
								$id = (int) $_POST['id'];
								$this->model->switchStates($id);
								header('Location: index?page='.$data['page']);
							}
						}
					break;
				}
			}
		}

		if(isset($_COOKIE['search'])) {
			$data['search'] = $_COOKIE['search'];
		}

		if($data['search']){
			$count = $this->model->getCount($data['search'], 0, 0); //если есть строка поиска считаем количество найденных
		}else{
			$count = $this->model->getCount(NULL, 0, 0); //если нет, то общее кол-во записей
		}

		$data['count'] = (int) $count[0]['COUNT(id)'];
		$data['pages'] = ceil($data['count']/$data['limit']); //общее количество страниц

		$data['items'] = $this->model->getData($data['search'], $data['page'], $data['limit']);
		
		$this->view->generate('indexView.php', 'baseView.php', $data);
	}
}