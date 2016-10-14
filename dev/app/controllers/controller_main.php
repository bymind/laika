<?php

class Controller_Main extends Controller
{

	function __construct()
	{
		$this->model = new Model_Main();
		$this->view = new View();
	}
	
	public function action_index()
	{
		$pageData = $this->model->getData('main_page');
		echo $pageData['text'],"<br>";
		return 0;
	}
}