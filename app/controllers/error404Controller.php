<?
class error404Controller extends Controller
{
	function indexAction()
	{	
		$this->view->generate('error404View.php');
	}
}