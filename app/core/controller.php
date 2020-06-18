<?
class Controller {
	
	public $model;
	public $view;
	public $application;
	
	function __construct($application)
	{
		$this->application = $application;
		$this->view = new View($application);
	}
	
	function indexAction()
	{
	}
}