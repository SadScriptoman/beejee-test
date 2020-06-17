<?
class View {
	
	function generate($contentView, $templateView = 'baseView.php', $data = null)
	{
		include 'app/views/'.$templateView;
	}
}