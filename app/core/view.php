<?
class View {
	public $application;

	function __construct($application)
	{
		$this->application = $application;
	}

	function generate($contentView, $templateView = 'baseView.php', $data = null)
	{
		include 'app/views/'.$templateView;
	}
}