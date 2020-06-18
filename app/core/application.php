<?
class Application {

    private $controllerName = 'index';
    private $controllerFile;
    private $controllerPath;
    private $actionName = 'index';

    private $modelName;
    private $modelFile;
    private $modelPath;

    private $controller;
    private $action;

    private $user;
    private $logged = false;

    function __construct(){

        if (isset($_COOKIE['sessionID'])) { //если в куках есть id сессии
            session_id($_COOKIE['sessionID']);
        }

        session_start();
        
        if (isset($_SESSION['user'])){//если залогинен
            $this->logged = TRUE;
            $this->user = $_SESSION['user'];
        }
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if ( !empty($routes[1]) )
		{	
			$this->controllerName = preg_replace('/\\?.*/', '', $routes[1]);
		}
		
		if ( !empty($routes[2]) )
		{
			$this->actionName = preg_replace('/\\?.*/', '', $routes[2]);
		}

		$this->modelName = $this->controllerName.'Model';
		$this->controllerName = $this->controllerName.'Controller';
        $this->actionName = $this->actionName.'Action';
        
        $this->modelFile = $this->modelName.'.php';
        $this->modelPath = "app/models/".$this->modelFile;
        
        if(file_exists($this->modelPath))
		{
			include $this->modelPath; //модели может и не быть
		}

        $this->controllerFile = $this->controllerName.'.php';
        $this->controllerPath = "app/controllers/".$this->controllerFile;
        
        if(file_exists($this->controllerPath))
		{
            include $this->controllerPath;
        }
		else
		{
			Application::Error404();
		}
		
        $this->controller = new $this->controllerName($this);
		
		if(method_exists($this->controller, $this->actionName))
		{
            $action = $this->actionName;
			$this->controller->$action();
		}
		else
		{
			Application::Error404();
		}
	
    }
    
    public function GetController(){
        return $this->controller;
    }

    public function GetAction(){
        return $this->action;
    }

    public function GetUser(){
        return $this->user;
    }

    public function logged(){
        return $this->logged;
    }
	
	static function Error404()
	{
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
		header("Status: 404 Not Found");
		header('Location:'.$host.'error404');
    }
}